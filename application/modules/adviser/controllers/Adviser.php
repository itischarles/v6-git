<?php

/**
 * Adviser Controller
 * 
 * @author Wajira Weerasinghe
 *
 * All adviser related controller functions goes here.
 * 
 * 
 */
class Adviser extends MY_Controller {

    /**
     * $moduleName
     * specify the name of this module
     * @var string 
     */
    private $moduleName = 'adviser';

    /**
     * $moduleKey
     * specify the module unique key
     * @var string 
     */
    private $moduleKey = 'adviser';

    function __construct() {
        parent::__construct();

        //Create adapters to access the data --------
        $this->load->model('AdviserModel', 'adviser_accessor');
        $this->load->model('FirmModel', 'firm_accessor');
        $this->load->model('FirmNetworkModel', 'firm_network_accessor');
        $this->load->model('AdviserRoleModel', 'adviser_role_accessor');
        $this->load->model('AdviserAdviserRoleModel', 'adviser_adviser_role_accessor');
        $this->load->model('client/Client_model', 'client_accessor');

        $this->load->module('template');
        
        //Get user id then adviser id currently logged in ---
        $this->curUserID = $this->session->userdata('userID');
        $recAdviser = $this->adviser_accessor->getAdviserByUserID($this->curUserID);
        if($recAdviser == null)
        {
            echo("No adviser account found for this user. You must be an adviser to log in to this module.");
            exit;
        }
        //Get adviser id and firm id ---
        $this->curIfaID = $recAdviser->ifaID;
        $this->hisFirmID = $recAdviser->firmID;
        
        $resFirm = $this->firm_accessor->getIfaFirmDetails($this->hisFirmID);
        if($resFirm != null)
        {
            $this->firmName = $resFirm->firmName;
        }

        //Load types of roles available / could be all of these true as many to many ---
        $this->isSuper = $this->adviser_adviser_role_accessor->isAdviserInRole($this->curIfaID,'AS');
        $this->isParaPlanner = $this->adviser_adviser_role_accessor->isAdviserInRole($this->curIfaID,'AP');
        $this->isNormal = $this->adviser_adviser_role_accessor->isAdviserInRole($this->curIfaID,'AN');
      
        
        if($this->isSuper) {        
            $this->can_edit_roles = TRUE;
        }
        else {
            $this->can_edit_roles = FALSE;
        }
    }

    
    /**
     * Default method calls the Dashboard for Advisers -------------------------------------
     * Default Method
     * Calls to show the Adviser Dashboard
     */
    function index() {
        
        $this->auth_lib = new Auth_lib();
        $this->auth_lib->is_authenticated();

        $this->load->module('template');
        
        //get user id then adviser id currently logged in ---
        $curUserID = $this->session->userdata('userID');
        $recAdviser = $this->adviser_accessor->getAdviserByUserID($curUserID);
        if($recAdviser == null)
        {
            echo("No adviser is found for this user. You are in the wrong module.");
            exit;
        }
        
        //Get adviser id and firm id ---
        $curIfaID = $recAdviser->ifaID;
        $hisFirmID = $recAdviser->firmID;
        
        $resFirm = $this->firm_accessor->getIfaFirmDetails($hisFirmID);
        if($resFirm != null)
        {
            $firmName = $resFirm->firmName;
            //Just in case if we need to show the name of the firm
        }
        
        //Get list of all para-planners ---
        $allParaPlanners = $this->adviser_accessor->getAdvisersOfTypeForFirm( $hisFirmID ,'AP');

        //Load types of roles available / could be all of these true as many to many ---
        $isSuper = $this->adviser_adviser_role_accessor->isAdviserInRole($curIfaID,'AS');
        $isParaPlanner = $this->adviser_adviser_role_accessor->isAdviserInRole($curIfaID,'AP');
        $isNormal = $this->adviser_adviser_role_accessor->isAdviserInRole($curIfaID,'AN');
        

        $data['page_title'] = "Adviser Dashboard";
        $data['page_header'] = "Adviser Dashboard";
        $data['is_super'] = $isSuper; 
         
        $data['sidebar_view'] = "adviser/adviser_sidebar";
        $data['content_view'] = "adviser/dashboard";

        $this->template->callDefaultTemplate($data);
    }
    
    
    /**
     * Create a client within Adviser module -------------------------------------------
     * createAdviser (routed from create-client)
     * 
     */
    function createClient(){
       
        if($this->input->post('add_client'))
        {

           $this->form_validation->set_rules('client_reference', 'Reference', 'trim|required|is_unique[clients.client_reference]');
           $this->form_validation->set_rules('title', 'Title', 'trim|required');
           $this->form_validation->set_rules('client_fname', 'First name', 'trim|required');
           $this->form_validation->set_rules('client_lname', 'Last name', 'trim|required');
           $this->form_validation->set_rules('client_address_1', 'Address Line 1', 'trim|required');
           $this->form_validation->set_rules('client_town', 'Town', 'trim|required');
           $this->form_validation->set_rules('client_postcode', 'Postcode', 'trim|required');
           $this->form_validation->set_rules('client_email', 'Eamil', 'required|valid_email');
           
            $this->form_validation->set_rules('client_bank_number', 'Bank Number', 'trim|required|numeric|exact_length[8]|is_unique[clients.client_bank_number]');
             if($this->input->post('client_bank_sortcode')):             
             $this->form_validation->set_rules('client_bank_sortcode', 'Sort Code', 'trim|required|numeric|exact_length[6]');
            endif;
            
            $this->form_validation->set_error_delimiters( '<em class="error_text">','</em>' );
            
            if($this->form_validation->run()){

                $client['titleID'] =($this->input->post('title'));
                $client['client_fname'] = $this->input->post('client_fname');
                $client['client_lname'] = $this->input->post('client_lname');
                $client['client_email'] = $this->input->post('client_email');
                $client['client_address_1'] = $this->input->post('client_address_1');
                $client['client_address_2'] = $this->input->post('client_address_2');
                $client['client_address_3'] = $this->input->post('client_address_3');

                $client['client_town'] = $this->input->post('client_town');
                $client['client_county'] = $this->input->post('client_county');
                $client['client_postcode'] = $this->input->post('client_postcode');
                $client['countryAlpha2'] = (($this->input->post('country')) ? $this->input->post('country'): 'gb' );

                // lets use client ID instead
                $client['client_reference'] = $this->input->post('client_reference');
                $client['client_bank_number'] = $this->input->post('client_bank_number'); 
                $client['client_bank_sortcode'] = $this->input->post('client_bank_sortcode');
                $client['client_bank_balance'] = price_format_DB($this->input->post('client_bank_balance'));         

                $client['adviser_adviserID'] = $this->curIfaID ;
                
                $client['client_date_created'] = changeDateFormat('now', "Y-m-d");
                $client['client_createdBy'] = $this->curUserID;

                $client['clientUrl'] =  $clientUrl = $this->generateElementURL('client');

                $clientID = $this->client_accessor->addNew($client);
                     
                $this->session->set_flashdata('message', 'Client Added Successfully');
                $this->session->set_flashdata('type', 'flash_success');
                redirect(base_url('adviser/clients')); 

            }
              
        }
        
        $data['page_title'] = "Create a New Client";
        $data['page_header'] = "Create a New Client";
        
        $data['mode'] = "New";
        $data['is_super'] = $this->isSuper;
       
        $data['content_view'] = "client/form";
        $data['sidebar_view'] = "adviser/adviser_sidebar";

        $data['mod_js'] = $this->getModule_js();
     
        $this->breadcrumbs->push('Adviser', '/adviser/');
	$this->breadcrumbs->push('New Client', '/');
        
        $this->template->callDefaultTemplate($data);
        
    }
    
    
    /**
     * List Clients for a givn adviser ------------------------------------------------
     * Listing is based on Roles associated.
     * Routed from adviser/clients 
     * Also own clients are listed.
     */
    function listAdviserClients(){
        
        //setup for paging ---
        $per_page  = ($this->input->get('result_per_page')? $this->input->get('result_per_page') : 200);
	$offset = ($this->input->get('offset')? $this->input->get('offset') : ''); 

        //Get list of all para-planners for the firm this ifa belongs to ---
        $allParaPlanners = $this->adviser_accessor->getAdvisersOfTypeForFirm( $this->hisFirmID ,'AP');

        //if para-planner or noamal we show both assigned and owned ---
        if($this->isSuper  == TRUE)//this is a
        {
            //get all clients of the firm for super advisers
            $clients =  $this->client_accessor->getClientsOfFirm($this->hisFirmID);
            $assignedClients = null;
        }
        else if($this->isParaPlanner  || $this->isNormal )
        {        
            $where_search[] = "(clients.adviser_adviserID = $this->curIfaID )";
            $clients =  $this->client_accessor->searchClients($where_search, $per_page, $offset);	
            $assignedClients = $this->client_accessor->getAssignedClients($this->curIfaID);
        }
    
	
        $data['clients'] =  $clients; 
        $data['assigned_clients'] = $assignedClients ;
        $data['para_planners'] = $allParaPlanners;
        $data['firmID'] = $this->hisFirmID;
         
        $data['can_edit_roles']= $this->can_edit_roles;
        $data['is_super'] = $this->isSuper;

        $data['ajax_url'] =  base_url() . $this->moduleName . "/AdviserRemoteStub/";
                 
        $data['page_title'] = "Clients";
        $data['page_header'] = "Listing of Clients";
       
        $data['content_view'] = "adviser/list_clients";
        $data['sidebar_view'] = "adviser/adviser_sidebar";

        $data['mod_js'] = $this->getModule_js();
     
        $this->breadcrumbs->push('Adviser', '/adviser/');
	$this->breadcrumbs->push('Clients', '/');
        
        $this->template->callDefaultTemplate($data);
     
    }
    
        
    /**
     * List Advisers for a givn Firm ------------------------------------------------
     * Listing is based on firm of the logged in Super Adviser 
     * Routed from adviser/advisers
     * 
     */
    function listAdvisers(){
        
        //setup for paging ---
        $per_page  = ($this->input->get('result_per_page')? $this->input->get('result_per_page') : 200);
	$offset = ($this->input->get('offset')? $this->input->get('offset') : ''); 
        
        if($this->isSuper != TRUE)//this is not a Super Adviser
        {        
            echo('This function is for super advisers only.');
            exit;
        }
        
        $allAdvisers = $this->adviser_accessor->getAdvisersOfFirm($this->hisFirmID);
        
        $data['advisers'] =  $allAdvisers ; 
        
        $data['can_edit_roles']= $this->can_edit_roles;
        $data['is_super'] = $this->isSuper;

        $data['page_title'] = "Advisers";
        $data['page_header'] = "Listing of Advisers for the firm - " . $this->firmName ;
       
        $data['content_view'] = "adviser/list_advisers";
        $data['sidebar_view'] = "adviser/adviser_sidebar";

        $data['mod_js'] = $this->getModule_js();
     
        $this->breadcrumbs->push('Adviser', '/adviser/');
	$this->breadcrumbs->push('Advisers', '/');
        
        $this->template->callDefaultTemplate($data);
     
    }
    

    /**
     * Edit Adviser Information  ------------------------------------------------
     * Super Advisers also can access this link
     * They can change roles etc.
     * Other advisers only can see their profile only
     * Routed from adviser/eidt/url
     * 
     */
    function eidtAdviser($adviserCode = '')
    {
        if($this->input->post('faUpdate')){
    
            $thisAdviserID = $this->input->post('hIfaID');
            echo('This IFA ID is:' . $thisAdviserID);
            
            echo('Check normal :' .  $this->input->post('chkNormal'));
            echo('Check pp :' .  $this->input->post('chkParaPlanner'));
            echo('Check super :' .  $this->input->post('chkSuper'));

            $this->adviser_adviser_role_accessor->setAdviserRoles($thisAdviserID,$this->input->post('chkNormal'),$this->input->post('chkParaPlanner'), $this->input->post('chkSuper') );
        
            $this->session->set_flashdata('message', 'Adviser roles updated successfully.');
            $this->session->set_flashdata('type', 'flash_success');
       
        }
        
        $theAdviser = $this->adviser_accessor->getAdviserByCode($adviserCode);
         
         if($theAdviser == null)
         {
             echo('Adviser not found');
             exit;
         }
         
         if( (! $this->isSuper) && ($theAdviser->ifaID !=  $this->curIfaID)   )
         {
            echo("This record only can be edited by its owner or a super adviser.");
            exit;
         }
         
         $roles = $this->adviser_accessor->getAdviserRoles($theAdviser->ifaID);
       
         foreach($roles as $key=>$val)
         {
             if($val->ifaRoleCode == 'AN')      { $data['has_normal'] = true ;}
             else if($val->ifaRoleCode == 'AP') { $data['has_para'] = true ;}
             else if($val->ifaRoleCode == 'AS')      { $data['has_super'] = true ;}
         }
         
   
                  
        $data['adviser'] = $theAdviser ;
        $data['hIfaID'] = $theAdviser->ifaID;
        
        $data['can_edit_roles']= $this->can_edit_roles;
        $data['is_super'] = $this->isSuper;
        
        $data['page_title'] = "Edit Adviser";
        $data['page_header'] = "Edit Adviser - " . $theAdviser->user_fname . ' ' . $theAdviser->user_lname ;
        
        $data['content_view'] = "adviser/form";
        $data['sidebar_view'] = "adviser/adviser_sidebar";

        $data['mod_js'] = $this->getModule_js();
     
        $this->breadcrumbs->push('Adviser', '/adviser/');
	$this->breadcrumbs->push('Advisers', '/');
        
        $this->template->callDefaultTemplate($data);

    }
 
    /**
     * get the module specific javascription file link
     */
    function getModule_js() {
        return base_url('module_assets/' . $this->moduleName . '/adviser-module.js');
    }

}

// end class



