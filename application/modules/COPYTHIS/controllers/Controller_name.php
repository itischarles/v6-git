<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of COPYTHIS
 *
 * @author itischarles
 */
class Controller_name extends MY_Controller {
   
    
    /**
     *  $userDetails
     * the details of the currently logged on user
     * @var object 
     */
    private $userDetails;
    
    
    /**
     * $auth_lib
     * an instance of the auth library.. used to access the auth module
     * @var object 
     */
    protected $auth_lib;
    
     /**
     * $moduleName
     * specify the name of this module
     * @var string 
     */
    private $moduleName = 'nameOfModule';
    
    /**
     * $moduleKey
     * specify the module unique key
     * @var string 
     */
    private $moduleKey = 'UniqueModuleKey';

            
    
    
    function __construct() {
        parent::__construct();

      $this->auth_lib = new Auth_lib();
      $this->auth_lib->is_authenticated();
       $this->userDetails = $this->getCurrentUserDetails();
      
      $this->load->module('template');
      
      
      /** if the module is admin ONLY module**/
      /* if(!$this->auth_lib->is_admin()){
           $this->session->set_flashdata('message', 'Access denined!!!');
           $this->session->set_flashdata('type', 'flash_error');
           redirect($_SERVER['HTTP_REFERER']); 
       }
       */

    }
    
    
    
    
    /**
     * 
     * please give comments
     */
    
    function someFunctions(){
        
        // please refere to the template module to know what is requred here
        
        
        $data['page_header'] = '';
        $data['content_view'] = $this->moduleName."/dashboard";
        $data['sidebar_view'] = $this->moduleName."/sidebar"; // exists
       // $data['userDetails'] = $this->userDetails; if you have to 
        $data['page_title'] = "";
        $data['mod_js'] = $this->getModule_js();
        
        // add breadcrumbs
	$this->breadcrumbs->push('User', '/user/'.$userLink);
	$this->breadcrumbs->push('Profile', '/');
        
       // echo Modules::run('template/callDefaultTemplate', $data);
        $this->template->callDefaultTemplate($data);
    }
    
    
    
    function SomeFunctionWithParam($param){
        
       // get if this param exist
         $a = '' ;//some get from model function
         if(empty($a)){
             $this->session->set_flashdata('message', 'error message');
             $this->session->set_flashdata('type', 'flash_error');
             redirect($_SERVER['HTTP_REFERER']); 
         }
        
        $data['page_header'] = '';
        $data['content_view'] = $this->moduleName."/dashboard";
        $data['sidebar_view'] = $this->moduleName."/sidebar"; // exists
       // $data['userDetails'] = $this->userDetails; if you have to 
        $data['page_title'] = "";
        $data['mod_js'] = $this->getModule_js();
        
        // add breadcrumbs
	$this->breadcrumbs->push('User', '/user/'.$userLink);
	$this->breadcrumbs->push('Profile', '/');
        
       // echo Modules::run('template/callDefaultTemplate', $data);
        $this->template->callDefaultTemplate($data);
    }
    
    
    
    /**
     * some function to create recrod
     */
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
                     
                $this->session->set_flashdata('message', 'Client Added Successfully');
                $this->session->set_flashdata('type', 'flash_success');
                redirect(base_url('client/'.$clientUrl)); 

            }
              
        }
         
         $data['mode'] = "New";

	 $data['mod_js'] = $this->getModule_js();
        $data['page_header'] = "Client Details";
        $data['content_view'] = "client/form";
        $data['sidebar_view'] = "user/display_sidebar";
        $data['userDetails'] = $this->userDetails;
        $data['page_title'] = "Search Users";
        
        // add breadcrumbs
	$this->breadcrumbs->push('User', '/user/'.$userLink);
	$this->breadcrumbs->push('Profile', '/');
        
       // echo Modules::run('template/callDefaultTemplate', $data);
        $this->template->callDefaultTemplate($data);
    }
    
    
    
    /*
     * some function to update record
     */
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
                     redirect(base_url('client/'.$clientUrl));  
           
                   
            }
              
        }
         
         
         $data['mode'] = "Edit";
      
	// $data['titles'] = $this->title_accessor->listTitleActiveTitles();
	// $data['countries'] = $this->country_accessor->listCountriesByWhere();
	 $data['mod_js'] = $this->getModule_js();
        $data['page_header'] = "Client Details";
        $data['content_view'] = "client/form";
        $data['sidebar_view'] = "client/client_sidebar";
        $data['userDetails'] = $this->userDetails;
        $data['page_title'] = "Search Users";
        
        // add breadcrumbs
	$this->breadcrumbs->push('User', '/user/'.$userLink);
	$this->breadcrumbs->push('Profile', '/');
        
       // echo Modules::run('template/callDefaultTemplate', $data);
        $this->template->callDefaultTemplate($data);
    }
    
    
    
    
    /**
     * some function to create a widget
     * another module may request this widget.. say you want to show users prfile on different
     * module, you bascially have to call this module by supplying the userLink/ID
     * notice how the widget loads the view but not the whole template
     * @param type $userLink
     */
    function profile_form_widget($userLink = ''){
        $userLink = (!empty($userLink) ? $userLink : $this->userLink);
        $this->userDetails  = $this->user_accessor->getUserByUserLink($userLink);

         $this->load->view('user/profile-form-widget', $data);
    }
    
    
    
    
     /**
     * get the module specific javascription file link
     */
    function getModule_js(){
        return base_url('module_assets/'.$this->moduleName.'/moduleName-module.js');
    }
    
    
}
