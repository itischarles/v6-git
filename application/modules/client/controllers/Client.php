<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Client
 *
 * @author itischarles
 */
class Client extends MY_Controller{
    //put your code here
    private $userDetails;
    private $client_accessor;
    protected $auth_lib;
    
    /**
     * $moduleName
     * specify the name of this module
     * @var string 
     */
    private $moduleName = 'client';
    
    /**
     * $moduleKey
     * specify the module unique key
     * @var string 
     */
    private $moduleKey = 'client-module';

            
    function __construct() {
        parent::__construct();

     
      $this->auth_lib = new Auth_lib();      
      $this->auth_lib->is_authenticated();
      // make sure this user has read access to this module
      $this->auth_lib->has_readAccess_orRedirect($this->moduleKey);
          
      
       

      $this->load->module('template');
      $this->load->model('Client_model');
      $this->client_accessor = new Client_model();
   
      $this->userDetails = $this->getCurrentUserDetails();
      
    }
    
    
    
    
     function index(){         
        
	
	$offset = ($this->input->get('offset')? $this->input->get('offset') : ''); 
	$per_page  = ($this->input->get('result_per_page')? $this->input->get('result_per_page') : 200);
		
	$config['base_url'] = base_url('client');
	$config['total_rows'] = $data['db_total_rows'] = $this->client_accessor->searchClient(false, false,true);	
	$config['per_page']         = $per_page;
        $config['num_links']	    = 10; 
        $config['next_link']        = 'Next';
	$config['prev_link']        = 'Prev';
        $config['next_tag_open']    = '<li class="nextPage">';
        $config['next_tag_close']   = '</li>';
        
        $config['prev_tag_open']    = '<li class="prevPage">';
        $config['prev_tag_close']   = '</li>';
        $config['cur_tag_open']     = "<li class='active'><a>";
        $config['cur_tag_close']    = "</a></li>";	
	$config['full_tag_open']    =  '<ul class="pagination">';
	$config['full_tag_close']    = '</ul>';
	$config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['page_query_string'] = TRUE;
	$config['query_string_segment'] = "offset";
	$config['reuse_query_string']  = TRUE;
	
	
        $this->pagination->initialize($config); 
	
	$data['page_title'] = "Clients Overview";      
	$data['link_title'] = "client";          
       
       
	$data['clients'] = $this->client_accessor->searchClient($per_page, $offset);
         
         
        $data['page_header'] = "Search Details";
        $data['content_view'] = "client/search";
        $data['sidebar_view'] = "client/client_sidebar";
     //   $data['userDetails'] = $this->userDetails;
        $data['page_title'] = "Search Client";
        
        // add breadcrumbs
	$this->breadcrumbs->push('Client Overview', '/');
	
        
       // echo Modules::run('template/callDefaultTemplate', $data);
        $this->template->callDefaultTemplate($data);
    }
    
    
    
    
    
    function view($clientUrl) {

        $data['client'] = $client =  $this->client_accessor->getByUrl($clientUrl);
        
        if(empty($client)):
             $this->session->set_flashdata('message', 'Client Not found!!!');
             $this->session->set_flashdata('type', 'flash_error');
             redirect($_SERVER['HTTP_REFERER']); 
        endif;
        
        $clientFullNames = ucwords($client->client_fname." ".$client->client_lname); 
        $data['page_header'] = $clientFullNames." - ".$client->client_reference; 
        $data['content_view'] = "client/dashboard";
        $data['sidebar_view'] = "client/client_sidebar";
      //  $data['userDetails'] = $this->userDetails;
        $data['page_title'] = $clientFullNames." : Profile";
        $data['extra_js'] = $this->getModule_js();
        
        
        
        $this->breadcrumbs->push('Clients', '/client/');
	$this->breadcrumbs->push($clientFullNames, '/client/'.$clientUrl."/view");
        $this->breadcrumbs->push('View', '/');
        
        $this->template->callDefaultTemplate($data);

    }
    
    
    
    
    
    
    
    function create()
    {
          
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
          
	   // $this->form_validation->set_rules('s_advserURL', 'Sort Code', 'trim|required');
            
            $this->form_validation->set_error_delimiters( '<em class="error_text">','</em>' );
            
            if($this->form_validation->run()){
               // $client['users_userID'] =  $this->current_userID; 


                $client['title'] = ($this->input->post('title'));
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

                $client['client_date_created'] = changeDateFormat('now', "Y-m-d");
                $client['client_createdBy'] = $this->current_userID;
                

                $client['clientUrl'] =  $clientUrl = $this->generateElementURL('client');


                $clientID = $this->client_accessor->addNew($client);
                
            
                /*============================================
                 * the adviser that created this client will have the client associated with it
                 * we check if user adding this client is an adviser
                 *================================================*/
                
                $this->_updateAdviserID($clientID);
                
                     
                $this->session->set_flashdata('message', 'Client Added Successfully');
                $this->session->set_flashdata('type', 'flash_success');
                redirect(base_url('client/'.$clientUrl.'/view')); 

            }
              
        }
         
         $data['mode'] = "New";

	$data['extra_js'] = $this->getModule_js();
        $data['page_header'] = "Client Details";
        $data['content_view'] = "client/form";
       $data['sidebar_view'] = "client/client_sidebar";

        $data['page_title'] = "Search Users";
        
        $this->breadcrumbs->push('Clients', '/client/');
        $this->breadcrumbs->push('Add New Client', '/');
        
       

            
        $this->template->callDefaultTemplate($data);
    }
    
    
    
    
    function update($clientUrl){
        
         $data['client'] = $client = $this->client_accessor->getByUrl($clientUrl);
         
         if(empty($client)){
             
             $this->session->set_flashdata('message', 'Client Not found!!!');
             $this->session->set_flashdata('type', 'flash_error');
             redirect($_SERVER['HTTP_REFERER']); 
        }
    
         
        if($this->input->post('edit_client')){
            
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('client_fname', 'First name', 'required');
            $this->form_validation->set_rules('client_lname', 'Last name', 'required');
            $this->form_validation->set_rules('client_address_1', 'Address Line 1', 'required');
            $this->form_validation->set_rules('client_town', 'Town', 'required');
            $this->form_validation->set_rules('client_postcode', 'Postcode', 'required');
          $this->form_validation->set_rules('client_email', 'Eamil', 'required|valid_email');

            $this->form_validation->set_rules('client_bank_number', 'Bank Number', 'trim|required|numeric|exact_length[8]');
             if($this->input->post('client_bank_sortcode')):
               $this->form_validation->set_rules('client_bank_sortcode', 'Sort Code', 'required|numeric|exact_length[6]');
            endif;
          
	    $ref_isUnique = '';
	    if($client->client_reference != $this->input->post('client_reference')):
		$ref_isUnique = "|is_unique[clients.client_reference]";
	    endif;
	     $this->form_validation->set_rules('client_reference', 'Reference', 'trim|required'.$ref_isUnique);

             
            if($this->form_validation->run()){
                 
                $content['client_reference'] = $this->input->post('client_reference');

              //  $content['users_userID'] =  $this->current_userID;
                $content['title'] = $this->input->post('title');
                $content['client_fname'] = $this->input->post('client_fname');
                $content['client_lname'] = $this->input->post('client_lname');

                $content['client_email'] = $this->input->post('client_email');
                $content['client_address_1'] = $this->input->post('client_address_1');
                $content['client_address_2'] = $this->input->post('client_address_2');
                $content['client_address_3'] = $this->input->post('client_address_3');

                $content['client_town'] = $this->input->post('client_town');
                $content['client_county'] = $this->input->post('client_county');
                $content['client_postcode'] = $this->input->post('client_postcode');
                $content['countryAlpha2'] = (($this->input->post('country')) ? $this->input->post('country'): 'gb' );

                $content['client_bank_number'] = $this->input->post('client_bank_number'); 
                $content['client_bank_sortcode'] = $this->input->post('client_bank_sortcode');
                $content['client_bank_balance'] = price_format_DB($this->input->post('client_bank_balance'));         
                   
                    
                    
                $this->client_accessor->updateClient($content, 
                                        array('clientID'=>$client->clientID, 'clientUrl'=>$client->clientUrl));

            
                     $this->session->set_flashdata('message', 'Client updated successfully');
                     $this->session->set_flashdata('type', 'flash_success');
                     redirect(base_url('client/'.$clientUrl.'/view')); 
           
                   
            }
              
        }
         
         
        $data['mode'] = "Edit";
        $clientFullNames = ucwords($client->client_fname." ".$client->client_lname). " - ".$client->client_reference;  
	$data['extra_js'] = $this->getModule_js();
        $data['page_header'] = $clientFullNames." : Edit Profile";
        $data['content_view'] = "client/form";
        $data['sidebar_view'] = "client/client_sidebar";
       // $data['userDetails'] = $this->userDetails;
        $data['page_title'] = $clientFullNames." : Edit Profile";
       
       // add breadcrumbs
	$this->breadcrumbs->push('Clients', '/client/');
	$this->breadcrumbs->push($clientFullNames, '/client/'.$clientUrl."/view");
        $this->breadcrumbs->push('Edit', '/');
        
        $this->template->callDefaultTemplate($data);
    }
    
    
    
   /**
    * 
    * @param int $clientID id of the client you want to update
    * @param int $userID id of the userID you are updaing in clients' table
    */
    private function _updateAdviserID($clientID, $userID = false) {
         $userID || $userID = $this->session->userdata('userID');
         
         $this->load->model('adviser/Adviser_model', 'adviser_accessor');
         
         $recAdviser = $this->adviser_accessor->getAdviserByUserID($userID);
         if(!empty($recAdviser)):
              $content['adviser_adviserID'] = $recAdviser->ifaID ;
              $this->client_accessor->updateClient($content, array('clientID'=>$clientID));
              return true;
         endif;
        
         return false;
    }
   
    
    /**
     * get the module specific javascription file link
     */
    function getModule_js(){
        return base_url('module_assets/'.$this->moduleName.'client-module.js');
    }
    
}
