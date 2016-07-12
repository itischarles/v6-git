<?php

/**
 * Description of Auth_user_role
 *
 * @author itischarles
 */
class Auth_user_role extends MY_Controller {
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
    private $Auth_user_role_accessor;
    
    
    
    
    
    function __construct() {
        parent::__construct();

      $this->auth_lib = new Auth_lib();
      $this->auth_lib->is_authenticated();
      $this->userDetails = $this->getCurrentUserDetails();
      
      $this->load->module('template');
      $this->load->model('Auth_user_role_model');
      $this->Auth_user_role_accessor = new Auth_user_role_model();
      
      

    }
    
    
    
    function updateUsersRoles($userLink = ''){
    
        // only user admin is allowed to add roles to users
        if(! $this->auth_lib->is_superAdmin()):
            return false;
         endif;
        
     
        $user = $this->user_accessor->getUserByUserLink($userLink);
            
        if($this->input->post('updateUserRoles') && (!empty($user))){
           
            $this->form_validation->set_rules('tkn', 'ktn', 'valid_token');
            
            
            
            if($this->form_validation->run()){
              
                $roles = $this->input->post('roles');
                // we remove all the roles for this user and re-add them
                $this->Auth_user_role_accessor->deleteUserRoles_byUserID($user->userID);
                
                if(!empty($roles)){
                    foreach ($roles as $roleID) {
                        $content['userID'] = $user->userID;
                        $content['roleID'] = $roleID;
                        $this->Auth_user_role_accessor->addNew($content);
                        
                        $response['error']= 0;
                        $response['message']= 'Update was successful';
                    }
                }
            } // end if run
           
            
            
            
            if($this->input->is_ajax_request() )
            {
                if($this->form_validation->run() === false){
                   $response['error']= 1;
                   $response['message']= validation_errors(); 
                }                
                
	     $this->output->set_content_type('application/json');
             $this->output->set_output( json_encode($response) );
            }
            
        } // end if post
    }
 
    
  
    
    /**
     * getUsersRoles
     * list th roles this user has
     * this roleIDs can then b plug into roles module to get the role names
     * @param int $userID
     * @return normal arrays
     * 
     * DONO DELETE. method is used outside this controller - auth/libries/aut_lib
     */
    
    function getUserRoles($userID){
        
       $usersRoles =  $this->Auth_user_role_accessor->getUserRoles_byUserID($userID);
      
       $this->load->model('Roles_model', 'roles_model_accessor');
      
       $userRolesDetails = array();
       
         // lets add the role names to the roles
       if(!empty($usersRoles)){
       
           foreach($usersRoles as $key=>$usersRole){
              
               $role = $this->roles_model_accessor->getByID($usersRole->roleID);
               
               // if not empty
               if(!empty($role)):
                   $eachRoleDetails = array(
                        'userID'=>$userID, 
                        'roleID'=>$usersRole->roleID, 
                        'roleName'=>$role->roleName,
                        'roleReference'=>$role->roleReference);
               
                     $userRolesDetails[$usersRole->roleID] = (object)$eachRoleDetails;
               endif;
               
           }
       }
     
       
       
       $obj = (object)$userRolesDetails;
        return $obj;
           
    }
    
    
     /**
     * displayUsersRoles_widget
     * this widget will display the users' roles for view purposes
     * @param int $userID
     */
    function displayUserRoles_widget($userID){
        // first get the roles of this user and get the names of the roles
        
        $usersRoles = $this->getUserRoles($userID);
      //  print_r($usersRoles);
        $rolesName = "";
        if(!empty($usersRoles)){
            foreach ($usersRoles as $key=>$userRole){
                
                $rolesName .=  "<p>".$userRole->roleName ."</p>" ;
            }
        }
        
        
        $html = "<div>".
                    "<div>ROLE</div>".
                    "<div>".$rolesName."</div>".
                "</div>";
        
        echo $html;
        
    }
  
    
    /**
     * AddRolesToUser_widget
     * here we are assinging roles to the given user. 
     * we only want to display this widget if the currently logged in person has a super admin role
     * @param int $userID
     */
    function addRolesToUser_widget($userID){      
      
          // only user admin is allowed to add roles to users
        if(! $this->auth_lib->is_superAdmin()):
            
            return false;        
         endif;
        
       $this->load->model('Roles_model', 'roles_accessor');

       //$data['user'] = $this->user_accessor->getUserByID($userID);
       $data['roles'] = $this->roles_accessor->getAll();
       $data['user_roles'] = $this->getUserRoles($userID);

       $this->load->view('roles/addRolesToUser_widget', $data);
        
    }
    
    
    
    
}
