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
    **/
   public $_cache_user_in_group;

   
   /**
    * access the auth model
    * @param object 
    * @return mixed
    */
    private $auth_model_accessor ;
    
    function __construct() 
    {
        
        $this->load->model('auth/Auth_model');
        $this->auth_model_accessor = new Auth_model();
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
         return (bool) $this->session->userdata('userID');
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
            $user_id =  $this->session->userdata('userID');
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
    public function is_admin($id=false)
    {
        return $this->in_group('Administrator', $id);
    }
    
    
    /**
     * has_readAccess
     * check if the given user has access to read stuff from this module
     * @param int $id  user ID
     * @param string $moduleKey mdule key
     * @return type
     */
    public function has_readAccess($id=false, $moduleKey = '') {
        return $this->has_accessType($id, 'Read', $moduleKey);
    }
    
    
    /**
     * has_writeAccess
     * check if the given user has access to write - ccreate/update stuff from this module
     * @param int $id  user ID
     * @param string $moduleKey mdule key
     * @return type
     */
    public function has_writeAccess($id=false, $moduleKey = '') {
        return $this->has_accessType($id, 'Write', $moduleKey);
    }
    
    /**
     * has_deleteAccess
     * check if the given user has access to delete - stuff from this module
     * @param int $id  user ID
     * @param string $moduleKey mdule key
     * @return type
     */
     public function has_deleteAccess($id=false, $moduleKey = '') {
        return $this->has_accessType($id, 'Delete', $moduleKey);
    }
    
    /**
    * is_admin
    *
    * @return bool
    * @author charles
    **/
    public function is_adviser($id=false)
    {
        return $this->in_group('Adviser', $id);
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
    public function in_group($check_group, $userID =false, $check_all = false)
    {

        $userID || $userID = $this->session->userdata('userID');

        if (!is_array($check_group))
        {
                $check_group = array($check_group);
        }

        if (isset($this->_cache_user_in_group[$userID]))
        {
                $groups_array = $this->_cache_user_in_group[$userID];
        }


        else
        {
            $users_groups = $this->auth_model_accessor->get_user_groups($userID)->result();
            $groups_array = array();
          
            foreach ($users_groups as $group)
            {
                    $groups_array[$group->roleID] = $group->roleName;
            }
            $this->_cache_user_in_group[$userID] = $groups_array;
        }

        foreach ($check_group as $key => $value)
        {
                $groups = (is_string($value)) ? $groups_array : array_keys($groups_array);

                /**
                 * if !all (default), in_array
                 * if all, !in_array
                 */
                if (in_array($value, $groups) xor $check_all)
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
    
    
    
    public function has_accessType($userID = false, $accessType = false, $moduleKey = false) {
        
        $userID || $userID = $this->session->userdata('userID');

        if (!is_array($check_group))
        {
                $check_group = array($check_group);
        }

        if (isset($this->_cache_user_in_group[$userID]))
        {
                $groups_array = $this->_cache_user_in_group[$userID];
        }

    }
    
    
    
    
    

}
