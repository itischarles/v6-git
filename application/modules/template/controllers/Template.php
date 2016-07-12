<?php

/*
 * date: 21/06/2016
 * @author  : charles
 * @description : this template module displays the html template. 
 */


class Template extends MY_Controller {
    //put your code here
    
    /**
     *$data
     * holds the data to send to the view
     * @var array 
     */
    private $data; 
    
    function __construct() {
        parent::__construct();
        
        
    }
    
    
    
    /**
     * lod the registration view
     * @param array $data the data to supply to the view
     * $data['page_title'] = page title;
       $data['page_style_name'] (optional)= css_element name for the page;
     * $data['page_header'] = page header
     * $data['description'] = page description
     * $data['content_view'] = link/to/view
     * $data['sidebar_view'] = link/to/sidebar/view/to/load
     */
    function callDefaultTemplate($data = NULL) {
        $data['page_header'] = (!isset($data['page_header']) ? "" :  $data['page_header'] );
        $data['page_title'] = (!isset($data['page_title']) ? "" :  $data['page_title'] );
        $data['page_style_name'] = (!isset($data['page_style_name']) ? "" :  $data['page_style_name'] );
        $data['description'] = (!isset($data['description']) ? "" :  $data['description'] );
        
        $this->data = $data;
    
        $this->_getCurrentlUserProfile();
      
       
      // echo "<pre>";print_r($this->data);
        $this->load->view('template/header_template', $this->data ); 
        $this->load->view('template/main_nav_template', $this->data );     
        $this->load->view('template/left_sidebar', $this->data );         
        $this->load->view('template/content_template', $this->data );        
        $this->load->view('template/footer_template', $this->data );
         
         
    }
    
   
    
    /**
     * load the login template view
     * @param array $data the data to supply to the view
     * $data['page_header'] = page header
     * $data['description'] = page description
     * $data['content_view'] = link/to/view
     * $data['sidebar_view'] = link/to/sidebar/view/to/load
     */
    function callLoginTemplate($data = NULL) {
        $data['page_header'] = (!isset($data['page_header']) ? "" :  $data['page_header'] );
        $data['page_title'] = (!isset($data['page_title']) ? "" :  $data['page_title'] );
        $data['page_style_name'] = (!isset($data['page_style_name']) ? "" :  $data['page_style_name'] );
        $data['description'] = (!isset($data['description']) ? "" :  $data['description'] );
        
        $this->load->view('template/header_template', $data); 
         $this->load->view('template/login_template', $data);        
         $this->load->view('template/footer_template', $data);
    }
    
    
    	 /**
     * Load the Adviser Registration view
     * @param array $data the data to supply to the view
     * $data['page_title'] = page title;
       $data['page_style_name'] (optional)= css_element name for the page;
     * $data['page_header'] = page header
     * $data['description'] = page description
     * $data['content_view'] = link/to/view
     * $data['sidebar_view'] = link/to/sidebar/view/to/load
     */
	function callAdviserRegistrationTemplate($data = NULL) 
	{
        $data['page_header'] = (!isset($data['page_header']) ? "" :  $data['page_header'] );
        $data['page_title'] = "Register as a new Adviser";
        $data['page_style_name'] = "login";
        $data['description'] = (!isset($data['description']) ? "" :  $data['description'] );
		$data['content_view'] = "adviser/register";
        $this->load->view('template/header_template', $data); 
        $this->load->view('template/adviser_registration_template', $data);        
        $this->load->view('template/footer_template', $data);
    }
    
    
    
    /**
     * get the currently looged user
     */
    // we want to always send the details of currently logged in so we can display the name on
        // the header template
    private function _getCurrentlUserProfile() {
        $this->load->model('users/users_model', 'usersModel_accessor');
        $userprofile =   $this->usersModel_accessor->getUserByID($this->current_userID);
        
        $this->data['userprofile_name'] = '';
        $this->data['userprofile_regDate'] = '';
        $this->data['userprofile_userLink'] = '';
        
        if(!empty($userprofile)):
           // unset($userprofile->user_password);
            
            $this->data['userprofile_name'] = ucwords($userprofile->user_fname." ".$userprofile->user_lname);
            $this->data['userprofile_regDate'] = changeDateFormat($userprofile->user_regDate, 'M. Y');
            $this->data['userprofile_userLink'] = $userprofile->user_userLink;
        endif; 
   
    }
    
}
