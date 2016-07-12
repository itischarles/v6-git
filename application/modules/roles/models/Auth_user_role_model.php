<?php


/**
 * Description of Auth_user_role_model
 *
 * @author itischarles
 */
class Auth_user_role_model extends CI_Model{
    //put your code here
  
    
     private $table_tbl = 'auth_user_role';
    
     function __construct() {
        parent::__construct();
    }
    
    
    

    function addNew($content){
        
        $this->db->insert($this->table_tbl, $content);
        return $this->db->insert_id();
    }

    function deleteUserRoles_byUserID($userID){
        $this->db->where(array('userID'=>(int)$userID));
         $this->db->delete($this->table_tbl);
        return $this->db->affected_rows();
    }
    
//    function update($content, $where){
//        $this->db->where($where);
//        $this->db->update($this->table_tbl, $content);
//        return $this->db->affected_rows();
//    }
//    
//
//    function getByID($id){
//        $this->db->where(array('roleID'=>(int)$id));
//        return $this->db->get($this->table_tbl)->row();
//    }
//    
    function getUserRoles_byUserID($userID){
        $this->db->where(array('userID'=>(int)$userID));
        return $this->db->get($this->table_tbl)->result(); 
     
       /* 
        $userRoles = array();
        // lets store all the roles for this user in an array
        if(!empty($roles_list)){
            foreach($roles_list as $key=>$uRole){
                $userRoles[] = $uRole->roleID;
            }
        }
        
        return $userRoles;
        * 
        */
    }
}
