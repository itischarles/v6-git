<?php

/*
 * this is a login module . this module controls the login process
 * and redirects to the portal of the currently looghged user
 */


class Auth extends MY_Controller{
    
     
    
    function __construct() {
        parent::__construct();
        
        $this->template = new Template();
       
    }
    
    
    
    function index(){
        redirect(base_url());
    }
    
    
    function login(){
        
        $data['page_title'] = 'Login';
        
       
        if($this->input->post('login')):
            
              $this->form_validation->set_rules('email', 'Email', 'required');
              $this->form_validation->set_rules('password', 'Password', 'required');
              $this->form_validation->set_error_delimiters( '<em class="error_text">','</em>' );
              
                if($this->form_validation->run()):
                    $username = $this->input->post('email');
                    $password = $this->input->post('password');
                 
                      if($this->user_accessor->login($username, $password)):
//                            // If requested a page that needed login - take them there!
                            $uri_string = $this->session->userdata('uri_string');
                                          
                            if($uri_string):
                               // echo $uri_string;
                                redirect(base_url().$this->session->userdata('uri_string'));
                            endif;
                            
                            redirect(base_url('home'));
                           
                            exit();
                               
                        else:
                           $data['login_error'] =  'Invalid Username/Password'; 
                       endif;                  
                endif;             
        endif;
        
        
        
      //  print_r($this->template);
        $this->template->callLoginTemplate($data);
        
    }
    
    
    
    
    function register(){
        
    }
    
    
    
    
    function logout(){
        $this->session->unset_userdata('userID');
        $this->session->unset_userdata('user_userLink');
//        $this->session->unset_userdata('fname');
//        $this->session->unset_userdata('lname');
       //  $this->session->unset_userdata('uri_string');
        redirect(base_url('auth/login'));
    
    }
    
    
}
