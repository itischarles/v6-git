<?php



/**
 * Description of Permissions
 *
 * @author itischarles
 */
class Permissions extends MY_Controller{
    
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
    private $permissions_accessor;
    
    
    /**
     * $func_responses
     * we shall store all the reponses - errorand success for the different private 
     * processing functions
     * @var array 
     */
    private $func_responses;

            
    
    
    function __construct() {
        parent::__construct();

      $this->auth_lib = new Auth_lib();
      $this->auth_lib->is_authenticated();
      $this->userDetails = $this->getCurrentUserDetails();
      
      $this->load->module('template');
      $this->load->model('Permissions_model');
      $this->permissions_accessor = new Permissions_model();
      
      
      /** if the module is admin ONLY module**/
      /* if(!$this->auth_lib->is_admin()){
           $this->session->set_flashdata('message', 'Access denined!!!');
           $this->session->set_flashdata('type', 'flash_error');
           redirect($_SERVER['HTTP_REFERER']); 
       }
       */

    }
    
    
    
    
    function listAllPermissions_widget(){
        
         $data['permissions'] = $this->permissions_accessor->getAll();
         $this->load->view('roles/list_permissions', $data);
        
    }
    
    

}
