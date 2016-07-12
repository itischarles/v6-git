<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author itischarles
 */
class Auth_lib {
    
   /**
    * caching of users and their groups
    *
    * @var array
    * $_cache_user_in_group
    * stores the user's group in a cache so we don run the query to many times
    **/
   public $_cache_user_in_group;

   
   /**
    *$session_userID
    * holds current userID
    * @var int 
    */
   private $session_userID;
   
   /**
    *$currentDateTime
    * hold current date and time
    * @var string 
    */
   private $currentDateTime;
   
   
   
   
   function __construct() {
        
        $this->session_userID = $this->session->userdata('userID');
        $this->currentDateTime = changeDateFormat('now', 'd-m-Y', true);
    }
    
    
    /**
    * __get
    *
    * Enables the use of CI super-global without having to define an extra variable.
    *
    * I can't remember where I first saw this, so thank you if you are the original author. -Militis
    *
    * @access	public
    * @param	$var
    * @return	mixed
    */
   public function __get($var)
   {
           return get_instance()->$var;
   }
    
    
    
    /**
      * logged_in
      *
      * @return bool
      * @author charles
     *  return a 1 for logged in and 0 if not logged in
      **/
     public function is_logged_in()
     {
         return (bool) $this->session_userID;
     }
     
     
     /**
      * is_authenticated
      * authenticate this user. if the user is not logged in, redirect to login page
      * @return boolean
      */
    public function is_authenticated() 
    {
         if(!$this->is_logged_in()){
             redirect(base_url('auth/login'));
             return false;
         }
         
         return true;
     } 
     
     /**
    * logged_in
    *
    * @return integer
    * @author charles
    **/
    public function get_userId()
    {
            $user_id =  $this->session_userID;
            if (!empty($user_id))
            {
                    return $user_id;
            }
            return null;
    }

    
    /**
    * is_admin
    *
    * @return bool
    * @author charles
    **/
    public function is_superAdmin($userID = false)
    {
        return $this->has_role_reference_of('super-admin', $userID);
    }
    
    
     
    /**
    * is_adviser
    *
    * @return bool
    * @author charles
    **/
    public function is_adviser($userID=false)
    {
        return $this->has_role_reference_of('adviser', $userID);
    }
    
    
    
    
    /**
     * has_readAccess
     * check if the given user has access to read stuff from this module
     * @param int $userID  user ID
     * @param string $moduleKey mdule key
     * @return type
     */
    public function has_readAccess($userID=false, $moduleKey = '') {
        return $this->has_permission($userID, 'Read', $moduleKey);
    }
    
    
    
    /**
     * has_readAccess_orRedirect
     * redirect if the user does not have access to read this module
     * @param tystringpe $moduleKey the module you wish to read
     */
    public function has_readAccess_orRedirect($moduleKey = '') {
        $resp = $this->has_readAccess($this->session_userID, $moduleKey);
      
        if(!$resp){
          $this->session->set_flashdata('message', 'Illegal Operation Detected');
          $this->session->set_flashdata('type', 'flash_error');
          $message = " tries to view the module: key=>".$moduleKey.". PERSSION DENIED";
          $this->createLogMessage('info', $message);
          
         redirect($_SERVER['HTTP_REFERER']); 
        }
    }
    
    
    /**
     * has_writeAccess
     * check if the given user has access to write - ccreate/update stuff from this module
     * @param int $userID  user ID
     * @param string $moduleKey mdule key
     * @return type
     */
    public function has_writeAccess($userID=false, $moduleKey = '') {
        return $this->has_permission($userID, 'Write', $moduleKey);
    }
    
    
    
    /**
     * has_readAccess_orRedirect
     * redirect if the user does not have access to read this module
     * @param tystringpe $moduleKey the module you wish to read
     */
    public function has_writeAccess_orRedirect($moduleKey = '') {
        $resp = $this->has_permission($this->session_userID, 'Write', $moduleKey);
        
        if(!$resp){
          $this->session->set_flashdata('message', 'Illegal Operation Detected');
          $this->session->set_flashdata('type', 'flash_error');
          $message = " tries to Write to the module: key=>".$moduleKey.". Access Denied ";
          $this->createLogMessage('info', $message);
          
          redirect($_SERVER['HTTP_REFERER']); 
        }
    }
    
    
    
    /**
     * has_deleteAccess
     * check if the given user has access to delete - stuff from this module
     * @param int $userID  user ID
     * @param string $moduleKey mdule key
     * @return type
     */
     public function has_deleteAccess($userID =false, $moduleKey = '') {
        return $this->has_permission($userID, 'Delete', $moduleKey);
    }
    
    
    
    /**
     * has_deleteAccess 
     * redirect if the user does not have access to delete from this module
     * @param tystringpe $moduleKey the module you wish to read
     */
    public function has_deleteAccess_orRedirect($moduleKey = '') {
        $resp = $this->has_permission($this->session_userID, 'Delete', $moduleKey);
        
        if(!$resp){
          $this->session->set_flashdata('message', 'Illegal Operation Detected');
          $this->session->set_flashdata('type', 'flash_error');
          $message = " tries to Delete to the module: key=>".$moduleKey.". Access Denied ";
          $this->createLogMessage('info', $message);
          
          redirect($_SERVER['HTTP_REFERER']); 
        }
    }
    
    
    
    
   
    
    
    function force_logout(){
        
    }
    
    
    /**
    * in_group
    *
    * @param mixed group(s) to check
    * @param bool user id
    * @param bool check if the user is in all groups or any of the groups
    *
    * @return bool
    * @author Phil Sturgeon
    **/
    private function has_role_reference_of($check_role, $userID =false, $check_all = false)
    {

        $userID || $userID = $this->session->userdata('userID');

        if (!is_array($check_role)){
                $check_role = array($check_role);
        }

        if (isset($this->_cache_user_in_group[$userID])){
                $roles_array = $this->_cache_user_in_group[$userID];
        }


        else{
                        
            $users_roles = Modules::run('roles/Auth_user_role/getUserRoles', $userID);
            
            
            $roles_array = array();
          
            if(!empty($users_roles)){
                foreach ($users_roles as $role){
                        $roles_array[$role->roleID] = $role->roleReference;
                }

                $this->_cache_user_in_group[$userID] = $roles_array;
            }
            
        }

        foreach ($check_role as $key => $value)
        {
                $roles = (is_string($value)) ? $roles_array : array_keys($roles_array);

                /**
                 * if !all (default), in_array
                 * if all, !in_array
                 */
                if (in_array($value, $roles) xor $check_all)
                {
                        /**
                         * if !all (default), true
                         * if all, false
                         */
                        return !$check_all;
                }
        }

        /**
         * if !all (default), false
         * if all, true
         */
        return $check_all;
    }
    
    
    
    /**
     * has_permission
     * check a user has acess to a given module
     * @param int $userID  userID
     * @param int $permName permission Name e.g 'Read'
     * @param int $moduleKey module key you wish to check access for
     * @return boolean
     */
    private function has_permission($userID = false, $permName = false, $moduleKey = false) {
        
        $userID || $userID = $this->session_userID;
     
        $permName = ucfirst($permName);
        
        $this->load->model('roles/Permissions_model', 'permissions_model_accessor');
        $this->load->model('roles/Auth_modules_model', 'auth_modules_accessor');
        $this->load->model('roles/Auth_role_perm_model', 'auth_role_perm_model');
        
      
        $permisssion = $this->permissions_model_accessor->getByPermName($permName);
        $module = $this->auth_modules_accessor->getByKey($moduleKey);
         
        $u_roles =   Modules::run('roles/Auth_user_role/getUserRoles', $userID);
                
        
        if(empty($module) || (empty($permisssion)) || (empty($u_roles))){
            return false;
        }
        
     
        // for each of the user's role, lets check if this roles has the
        // given permission type to the given module
        //
        $has_access = array();
     
        
      
        foreach($u_roles as $key=>$u_role){
           
            $roleID = $u_role->roleID;
            $permID = $permisssion->permID;
            $moduleID = $module->moduleID;
  
             $resp = $this->auth_role_perm_model->getBy_roleModPermID($roleID, $permID, $moduleID); 

            if(!empty($resp)){
                $has_access[] = 1;
            }
        }
     
        
        if(count($has_access) > 0){
            return TRUE;
        }
        
        return FALSE;
    }
    
    
    
    
    
     /**
     * createLogMessage
     * this will log message and add more information like user IP, Browser, location, time
     * @param string $type
     * @param string $message
     */
    protected function createLogMessage($level, $message = '') {
        $this->load->helper('ip_helper');
        $message = $message." IP: ".get_ip();
        $message = $message." userID: ".$this->session_userID;
        $message = $message." DateTime: ".$this->currentDateTime;
        log_message($level, $message);
    }
    

}
