<?php


/**
 * Description of Auth_model
 *  handles all authentication models
 * @author itischarles
 */
class Auth_model_OLD extends CI_Model {
    
    //put your code here
    
    private $auth_roles = 'auth_roles';
    private $auth_user_role = 'auth_user_role';
            
    function __construct() {
        parent::__construct();
    }
    
    
    
    
    /**
    * get_user_groups
    *
    * @return array
    * @author charles
    **/
    public function get_user_groups($userID = false)
    {

    // if no id was passed use the current users id
    $userID || $userID = $this->session->userdata('user_id');

     return $this->db->select('roleName,'.$this->auth_roles.'.roleID')             
                    ->where($this->auth_user_role.'.userID', $userID)
                    ->join($this->auth_user_role, $this->auth_user_role.'.roleID'.'='.$this->auth_roles.'.roleID')
                    ->get($this->auth_roles);

    }
    
    
}
