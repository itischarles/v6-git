<?php

/*
 * 
 */



//require_once (APPPATH).'controllers/CronJobs.php';

class MY_Controller extends MX_Controller {
    
    // var $updateTime = '';
    // private $_cronAccessor;
     
      /**
      * @var int  $current_userID
      * ID of the currently logged on user
      */
     protected $current_userID = 0;
     
     
     
     /**
      *$current_baseUrl
      * stores the base url of the curent user
      * @var string 
      */
     protected $userLink;


     /**
      *
      * @var object $template returns the template object.
      * usage: call $this->template->method()
      */
    // protected $template;
         
     /**
      *
      * @var object $user_accessor
      * used to access the users_model
      * this model is auto loaded, so just call the method like
      * $this->user_accessor->method()
      */
     public $user_accessor =''; // to access the user model
     
     
     /**
      *$Ajax_token
      * @var string 
      * this will be our token used by the currently looged in user for ajax requests
      * if the token coming from client does not match this session token, request not valid
      */
     protected $Ajax_token = 'no ajax token defined!';
             
     
    
    function __construct() {
        parent::__construct();
        
        date_default_timezone_set('Europe/London');

        /**
         * make the template module available to all the modules extending this class so they can load it
         */
	$this->load->module('template');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->libraries(array('breadcrumbs'));
        
     
        
        $this->user_accessor = new Users_Model();
        
         
	// set the userID if available
	$this->setCurrentUserID();
        $this->setCurrentUserLink();
        $this->getAjax_token();
	
	//run cron job
	//$this->_cronAccessor = new CronJobs();
	
    }
    
    
   
    
        /**
     * generate url for elements/tables records. e.g client url
     * @$elementName string $elementName the element generating the URL
     * @return string
     */
    protected function generateElementURL($elementName = " ? "){
	$timenow = date("Y-m-d H:i:s", strtotime('now'));	
	$randomNumber = rand(0, 1000);
	return md5($timenow+$elementName+$randomNumber);
    }
    
    
    
    private function setCurrentUserID() {
        
	if($this->session->userdata('userID')):
	    $this->current_userID = $this->session->userdata('userID');
	endif;
	
    }
    
    
    private function setCurrentUserLink() {
        
	if($this->session->userdata('user_userLink')):
	    $this->userLink = $this->session->userdata('user_userLink');
	endif;
	
    }
    
    
    /**
     * return the details of the current user
     * @return object
     */
    public function getCurrentUserDetails() {
        return $this->user_accessor->getUserByID($this->current_userID);
    }
    
    
    /**
     * we want to be able to secure our ajax activities
     * always pas the Ajax_token to client and expect it back. 
     * if it doesn't match our session ajax_token, request not valid
     */
    public function getAjax_token() {
        
        if($this->session->userdata('Ajax_token')){
            $this->Ajax_token = $this->session->userdata('Ajax_token');
        }
    }
    
    
    
   
    
}