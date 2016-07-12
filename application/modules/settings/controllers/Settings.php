<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Settings
 *
 * @author itischarles
 */
class Settings extends MY_Controller{
    
    private $userDetails;
    protected $template;
     protected $auth_lib;
            
    function __construct() {
        parent::__construct();
        
        $this->auth_lib = new Auth_lib();
        $this->auth_lib->is_authenticated();
                
        $this->template = new Template();
      //  $this->user_accessor = new Users_Model();
    }
    
    
    /**
     * load the system setting page
     */
    function index(){
        
        
        $data['content_view'] = "settings/overview";
       // $data['sidebar_view'] = "user/admin_sidebar";
       // $data['userDetails'] = $this->userDetails;
        $data['page_title'] = "Settings";
        
        $this->template->callDefaultTemplate($data);
    }
}
