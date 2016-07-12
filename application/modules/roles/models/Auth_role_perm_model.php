<?php



/**
 * Description of Permissions_model
 *
 * @author itischarles
 */
class Auth_role_perm_model extends CI_Model{
    //put your code here
  
    
     private $table_tbl = 'auth_role_perm';
    
     function __construct() {
        parent::__construct();
    }
    
    
    

    function addNew($content){
        
        $this->db->insert($this->table_tbl, $content);
        return $this->db->insert_id();
    }
    
    
    function update($content, $where){
        $this->db->where($where);
        $this->db->update($this->table_tbl, $content);
        return $this->db->affected_rows();
    }
    

    function getByID($id){
        $this->db->where(array('rolePermID'=>(int)$id));
        return $this->db->get($this->table_tbl)->row();
    }
    
    function getBy_roleModPermID($roleID,$permID,$moduleID){
        $this->db->where('roleID',(int)$roleID);
        $this->db->where('permID',(int)$permID);
        $this->db->where('moduleID',(int)$moduleID);
        return $this->db->get($this->table_tbl)->row();
    }
    
    /**
     * listBy_roleModPermID
     * list by roleID, moduleID , perm ID
     * @param int $roleID rolesID
     * @param int $moduleID modulesID (optional)
     * @param int $permID permissionID (options)
     * @return object
     */
    function listBy_roleModPermID($roleID,$moduleID = false, $permID = false){
        $this->db->where('roleID',(int)$roleID);
        if($moduleID !== false):
            $this->db->where('moduleID',(int)$moduleID);
        endif;
        if($permID !== false):
              $this->db->where('permID',(int)$permID);
        endif;
      
        
        return $this->db->get($this->table_tbl)->result();
    }
    
    
    function deleteRolePermissions_byRoleID($roleID){
        $this->db->where(array('roleID'=>(int)$roleID));
         $this->db->delete($this->table_tbl);
        return $this->db->affected_rows();
    }
    
     function deleteRolePermissions_byModuleID($roleID, $moduleID){
        $this->db->where(array('roleID'=>(int)$roleID));
         $this->db->where(array('moduleID'=>(int)$moduleID));
         $this->db->delete($this->table_tbl);
        return $this->db->affected_rows();
    }
}
