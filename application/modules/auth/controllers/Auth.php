<?php

/*
 * this is a login module . this module controls the login process
 * and redirects to the portal of the currently looghged user
 */


class Auth extends MY_Controller{
   
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
    private $moduleName = 'auth';
    
    /**
     * $moduleKey
     * specify the module unique key
     * @var string 
     */
    private $moduleKey = 'auth';

  
    function __construct() {
        parent::__construct();
        
        $this->template = new Template();
       
    }
    
    
    

    function index(){
        redirect(base_url());

    }
    
    

    
    
    function login(){
        $data = array();
       
        if($this->input->post('login'))
        {
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_error_delimiters( '<em class="error_text">','</em>' );

            if($this->form_validation->run())
            {
                $username = $this->input->post('email');
                $password = $this->input->post('password');

                if($this->user_accessor->verify_login_detail($username, $password))
                {
//                            // If requested a page that needed login - take them there!
                    $uri_string = $this->session->userdata('uri_string');

                    if($uri_string)
                    {
                       // echo $uri_string;
                        redirect(base_url().$this->session->userdata('uri_string'));
                    }

                   // echo "login";
                    redirect(base_url());

                    exit();

                }
                else
                {
                     $data['login_error'] =  'Invalid Username/Password'; 
                }                  
            }    
        }

        $data['page_title'] = "Login";
        $data['page_style_name'] = "login-page";
        $data['content_view'] = "auth/login";
        $this->template->callLoginTemplate($data);
        
    }
    
  

    
    function logout(){
        $this->session->unset_userdata('userID');
        $this->session->unset_userdata('user_userLink');
        $this->session->unset_userdata('Ajax_token');
//        $this->session->unset_userdata('lname');
       //  $this->session->unset_userdata('uri_string');
        redirect(base_url('auth/login'));
    
    }
    
    
  
    
}
