<?php


/**
 * Description of Applications
 *
 * this module would handle application process
 * @author itischarles
 */
class Applications extends MY_Controller {
   
    
    private $userDetails;
    protected $auth_lib;
            
    function __construct() {
        parent::__construct();

      $this->auth_lib = new Auth_lib();
      $this->auth_lib->is_authenticated();
      
      $this->load->module('template');
  
      $this->userDetails = $this->getCurrentUserDetails();

    }
    
    
    
    /**
     * widget_listApplications
     * list all the applications for this user in a widget
     * @param int $clientID
     */
    function widget_listApplications($clientID){
        
    }
    
    
    
        
    function list_applications($clientUrl){
        
         $data['client'] = $client = $this->client_accessor->getByUrl($clientUrl);
         
         if(empty($client)){
             $this->session->set_flashdata('message', 'Client Not found!!!');
             $this->session->set_flashdata('type', 'flash_error');
             redirect($_SERVER['HTTP_REFERER']); 
         }
  
    }
    
    
    
    
    
}
