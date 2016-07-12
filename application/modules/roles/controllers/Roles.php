<?php



/**
 * Description of Roles
 * manages roles
 * @author itischarles
 */
class Roles extends MY_Controller {
   
    
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
    private $roles_accessor;
    
    
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
      $this->load->model('Roles_model');
      $this->roles_accessor = new Roles_model();
      
      
      
       

       
       
    }
    
    
    
       
    function index(){
        
        /** this module is super admin ONLY module**/
      
       if(!$this->auth_lib->is_superAdmin()){
           $this->session->set_flashdata('message', 'Access denined!!!');
           $this->session->set_flashdata('type', 'flash_error');
           redirect($_SERVER['HTTP_REFERER']); 
       }
       
        
        if($this->input->post('addRole')):
            $this->addNewRole();
        endif;
        
        
        
        
        $data['mod_js'] = $this->getModule_js();
      
       
        $data['page_header'] = "Manage Roles and Permissions";
        $data['content_view'] = "roles/dashboard";
       // $data['sidebar_view'] = "user/display_sidebar";
       // $data['userDetails'] = $this->userDetails;
        $data['page_title'] = "Manage Roles and Permissions";
        
         $data['roles'] = $this->roles_accessor->getAll();
         
         $data['func_responses'] = $this->func_responses;
        $this->template->callDefaultTemplate($data);
    }
    
    
    
    
    private function addNewRole(){
        
        
        if($this->input->post('addRole')){
           $this->form_validation->set_rules('roleName', 'Role Name', 'trim|required|is_unique[auth_roles.roleName]');
        
            $this->form_validation->set_error_delimiters( '<em class="error_text">','</em>' );
            
            if($this->form_validation->run()){
           
                $content['roleName'] = ($this->input->post('roleName'));
               
                 $this->roles_accessor->addNew($content);
                
                $this->func_responses['roles_func'] = array('message'=>  'Roles Added','type'=>'alert-success');
 
            }else{
                $this->func_responses['roles_func'] = array('message'=>  validation_errors(), 'type'=>'alert-danger');
            }              
        }
        
        
        
    }
    
    
 

    function getModule_js(){
        return base_url('module_assets/'.$this->moduleName.'/roles-module.js');
    }
    
    
}
