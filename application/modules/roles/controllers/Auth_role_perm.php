<?php


/**
 * Description of Modules
 *
 * @author itischarles
 */
class Auth_role_perm extends MY_Controller{
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
    private $authRolePerm_accessor;
    
    
 
            
    
    
    function __construct() {
        parent::__construct();

      $this->auth_lib = new Auth_lib();
      $this->auth_lib->is_authenticated();
      $this->userDetails = $this->getCurrentUserDetails();
      
      $this->load->module('template');
      $this->load->model('Auth_role_perm_model');
      $this->authRolePerm_accessor = new Auth_role_perm_model();
      
 
    }
    
    
    
    
    function displayRolePermission_form($roleID = 0){
        
        $this->load->model('Auth_modules_model','Auth_modules_accessor');
        $this->load->model('Roles_model','roles_accessor');
        $this->load->model('Permissions_model','permissions_accessor');
       
        
        $data['modules']= $modules = $this->Auth_modules_accessor->getAll();
        $data['role'] = $role = $this->roles_accessor->getByID($roleID);
        $data['permissions'] = $role = $this->permissions_accessor->getAll();
       
        
        // lets compose the modules where permissions have already been defined for this role
        
        //foreach of the modules
        //get from db where role is $roleID and module is currentmoduleID
        // build and array with module key and permissions as assoc array
      
        $is_checked = array();
       foreach($modules as $key=>$module):
          
           // get the role permissions for this module
           $rolePerms = $this->authRolePerm_accessor->listBy_roleModPermID($roleID, $module->moduleID);
           
           if(!empty($rolePerms)):
               // build and array of all the permissions for this module
               $tempArray = array();
               foreach($rolePerms as $r=>$rolePerm):
                   $tempArray[$rolePerm->permID] = $rolePerm->permID;
               endforeach;
               $is_checked[$module->moduleID] = $tempArray;
           endif;
           
       endforeach;
        
       // $data['modules'] = $this->authRolePerm_accessor->getAllRolePermissions();
       $data['is_checked'] = $is_checked;
       echo  $this->load->view('roles/manage_role_permissions', $data, true);
    }
    
    
    
    function processRolePermissions($roleID = 0, $modID){
        
         if (!$this->input->is_ajax_request() ):
	     $this->session->set_flashdata('message', 'Invalid request');
             $this->session->set_flashdata('type', 'flash_error');
             redirect(base_url());
	endif;
        
        $this->load->model('Auth_modules_model','Auth_modules_accessor');
        $this->load->model('Roles_model','roles_accessor');
        $this->load->model('Permissions_model','permissions_accessor');
        
        $response = array();
        $response['error'] = 1;
        
        //although there is no difference between moduleID and modID, 
        //the user checks/unckeck moduleID while the system send the modID
        // the module ID would not send when the user unchecks it. this will break if we were to remove a module
        // for a role. but by letting the system send the modID, we always have the moduleID to remove in this case
       
        $moduleID = (int)$this->input->post('moduleID');
       // $modID = (int)$this->input->post('modID'); 
        $ajaxToken = $this->input->post('tkn');
        $permID_array = $this->input->post('permID');
       
        if(!is_array($permID_array)){
            $permID_array = array($permID_array);
        }
        
        $role = $this->roles_accessor->getByID($roleID);
        $module = $this->Auth_modules_accessor->getByID($modID);
         
        if(empty($role) || (empty($module))){
            $response['message'] = $message= "Invalid Illegal operation detected";
            log_message( 'error',  "Exception at " . $this->moduleName . "/Auth_role_perm->_processRolePermission_ajax($roleID): $message" );
        }
        
        
        // valid module and role
        // first remove all the role permissions and add this update only of moduleID is submitted
         if(!empty($role) || (!empty($module))){
            $this->authRolePerm_accessor->deleteRolePermissions_byModuleID($roleID,$modID);
            
            
            if(($moduleID > 0) &&(!empty($permID_array))){
                foreach($permID_array as $permID){
                    $content['roleID'] = $roleID;
                    $content['permID'] = $permID;
                    $content['moduleID'] = $moduleID;
                    
                    $this->authRolePerm_accessor->addNew($content);
                    $response['message'] = "Update was successful";
                    $response['error'] = 0;
                }
                
            }
            
            else{
             $response['message'] = "Module access and permissions cleared";
             $response['error'] = 0;
            }
            
         }// end !empty($role) || (!empty($module)))
         
         
        $this->output->set_content_type('application/json');
	$this->output->set_output( json_encode($response) );

	return false;
        
        
        
        
    }
    
    
    
    private function _processRolePermission_ajax($roleID){
        
        if (!$this->input->is_ajax_request() ):
	     $this->session->set_flashdata('message', 'Invalid request');
             $this->session->set_flashdata('type', 'flash_error');
             redirect($_SERVER['HTTP_REFERER']);
	endif;
        
        
        $this->load->model('Auth_modules_model','Auth_modules_accessor');
        $this->load->model('Roles_model','roles_accessor');
        $this->load->model('Permissions_model','permissions_accessor');
        
        $response = array();
        $response['error'] = 1;
        
        //although there is no difference between moduleID and modID, 
        //the user checks/unckeck moduleID while the system send the modID
        // the module ID would not send when the user unchecks it. this will break if we were to remove a module
        // for a role. but by letting the system send the modID, we always have the moduleID to remove in this case
       
        $moduleID = (int)$this->input->post('moduleID');
        $modID = (int)$this->input->post('modID'); 
        $ajaxToken = $this->input->post('tkn');
        $permID_array = $this->input->post('permID');
       
        if(!is_array($permID_array)){
            $permID_array = array($permID_array);
        }
        
        $role = $this->roles_accessor->getByID($roleID);
        $module = $this->Auth_modules_accessor->getByID($modID);
         
        if(empty($role) || (empty($module))){
            $response['message'] = $message= "Invalid Illegal operation detected";
            log_message( 'error',  "Exception at " . $this->moduleName . "/Auth_role_perm->_processRolePermission_ajax($roleID): $message" );
        }
        
        
        // valid module and role
        // first remove all the role permissions and add this update only of moduleID is submitted
         if(!empty($role) || (!empty($module))){
            $this->authRolePerm_accessor->deleteRolePermissions_byModuleID($roleID,$modID);
            
            
            if(($moduleID > 0) &&(!empty($permID_array))){
                foreach($permID_array as $permID){
                    $content['roleID'] = $roleID;
                    $content['permID'] = $permID;
                    $content['moduleID'] = $moduleID;
                    
                    $this->authRolePerm_accessor->addNew($content);
                    $response['message'] = "Done";
                    $response['error'] = 0;
                }
            }
            
         }// end !empty($role) || (!empty($module)))
         
         
        $this->output->set_content_type('application/json');
	$this->output->set_output( json_encode($response) );

	return false;
    }
    
    
    
    

}
