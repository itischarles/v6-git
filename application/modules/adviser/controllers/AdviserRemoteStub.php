<?php

/**
 * Adviser Stub Code for AJAX calls
 *
 * @author Wajira
 *
 *
 * 
 */
class AdviserRemoteStub extends MY_Controller {

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

        //Create adapters to access the data
        $this->load->model('AdviserModel', 'adviser_accessor');
        $this->load->model('FirmModel', 'firm_accessor');
        $this->load->model('FirmNetworkModel', 'firm_network_accessor');
        $this->load->model('AdviserRoleModel', 'adviser_role_accessor');
        $this->load->model('AdviserAdviserRoleModel', 'adviser_adviser_role_accessor');
        $this->load->model('client/Client_model', 'client_accessor');
        
        $curUserID = $this->session->userdata('userID');
        
        if( (!isset($curUserID) ) || $curUserID <= 0   )
        {
            echo('You must be authenticated to use this service');
            exit;
        }
        
    }

    
    /**
     * Default method calls the Dashboard for Advisers -------------
     * Default Method
     * Calls to show the Adviser Dashboard
     */
    function index() {
        
        $this->auth_lib = new Auth_lib();
        $this->auth_lib->is_authenticated();

        $this->load->module('template');

        $data['page_title'] = "Adviser Dashboard";
        $data['page_header'] = "Adviser Dashboard";
        $data['sidebar_view'] = "adviser/adviser_sidebar";
        $data['content_view'] = "adviser/dashboard";

        $this->template->callDefaultTemplate($data);
    }
   
    
    
    /**
     * Return full list of advisers -------------
     * Of the firm
     * Also this return if the client is assigned to adiviser. (to show in the box with tick mark)
     */
    function getAllAdvisersForFirm() {
         
        $firmID = $this->input->post('firmID');
        $roleCode = $this->input->post('ifaRoleCode');
        $clientUrl = $this->input->post('clientUrl');
       
        $advisers = $this->adviser_accessor-> getAdvisersOfTypeForFirm( $firmID , trim($roleCode) );

        $ret = '[';

        if (!empty($advisers)) {
            foreach ($advisers as $key => $adviser) {
                
                $assigned = $this->adviser_accessor->isClientAssignedToAdviser($clientUrl, $adviser->ifaID  );
                $ret .= ' { "ifaID":"' . $adviser->ifaID . '","ifaName":"' . $adviser->user_fname . ' ' . $adviser->user_lname . '","assigned":"' . $assigned  . '"},';
            }

            $ret = rtrim($ret, ",");
        }

        $ret .= ']';

        echo($ret);
        
    }
    
    
    
    /**
     * Assigns Adviers to clients  -------------
     * add a record to intermediate ifa_client table.
     * 
     */
     function assignClientsToAdvisers() {
         
        $adviserIDs = $this->input->post('adviserIDs');

        $adviserIDs = trim( $adviserIDs, '"');
        
        $clientUrl = $this->input->post('clientUrl');
      
        $theClient = $this->client_accessor->getByUrl(trim($clientUrl,'"'));
        $clientID = 0;
        
        if($theClient != null)
        {
            $clientID = $theClient->clientID;
        }

        $i =0 ;
        
        if( $clientID > 0 )
        {
            $adviserList = explode(',' , $adviserIDs);
            
            foreach($adviserList as $adviserID)
            {
                if( $adviserID != null && $adviserID != '')
                {
                    $content["clientID"] = $clientID ;
                    $content["ifaID"] = $adviserID;
                    
                    $this->db->insert('ifa_client', $content);
                    $i +=1; 
                }
            }
        }
        

        echo('Assignment successful, ' .  $i . 'advisers assigned.');

    }

  
    
    /**
     * get the module specific javascription file link
     */
    function getModule_js() {
        return base_url('module_assets/' . $this->moduleName . '/adviser-module.js');
    }

}

// end class



