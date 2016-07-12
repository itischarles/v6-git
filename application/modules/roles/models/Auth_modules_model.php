<?php



/**
 * Description of Permissions_model
 *
 * @author itischarles
 */
class Auth_modules_model extends CI_Model{
    //put your code here
  
    
     private $table_tbl = 'auth_modules';
    
     function __construct() {
        parent::__construct();
    }
    
    
    
    /*
    function addNew($content){
        
        $this->db->insert($this->table_tbl, $content);
        return $this->db->insert_id();
    }
     * *
     */
    
    function update($content, $where){
        $this->db->where($where);
        $this->db->update($this->table_tbl, $content);
        return $this->db->affected_rows();
    }
    

    function getByID($id){
        $this->db->where(array('moduleID'=>(int)$id));
        return $this->db->get($this->table_tbl)->row();
    }
    
    function getAll(){
        return $this->db->get($this->table_tbl)->result(); 
    }
    
    
     function getByKey($moduleKey){
        $this->db->where(array('moduleKey'=> $moduleKey));
        return $this->db->get($this->table_tbl)->row();
    }
}
