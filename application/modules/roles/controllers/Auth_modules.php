<?php


/**
 * Description of Modules
 *
 * @author itischarles
 */
class Auth_modules extends MY_Controller{
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
    private $moduleName = 'roles';
    
    /**
     * $moduleKey
     * specify the module unique key
     * @var string 
     */
    private $moduleKey = 'roles';
    
    /**
     * $roles_accessor
     * access the roles model
     * @var object 
     */
    private $Auth_modules_accessor;
    
    
 
            
    
    
    function __construct() {
        parent::__construct();

      $this->auth_lib = new Auth_lib();
      $this->auth_lib->is_authenticated();
      $this->userDetails = $this->getCurrentUserDetails();
      
      $this->load->module('template');
      $this->load->model('Auth_modules_model');
      $this->Auth_modules_accessor = new Auth_modules_model();
      
      
      /** if the module is admin ONLY module**/
      /* if(!$this->auth_lib->is_admin()){
           $this->session->set_flashdata('message', 'Access denined!!!');
           $this->session->set_flashdata('type', 'flash_error');
           redirect($_SERVER['HTTP_REFERER']); 
       }
       */

    }
    
    
    
    
    function listAllModules_widget(){
        
         $data['modules'] = $this->Auth_modules_accessor->getAll();
         $this->load->view('roles/list_modules', $data);
        
    }
    
    
    
    /**
     * getModule_byKey
     * get a module details (name, ID) by key
     * @param string $moduleKey
     * @return object
     */
//    function getModule_byKey($moduleKey){
//        return $this->Auth_modules_accessor->getByKey($moduleKey);
//    }
//    
}
