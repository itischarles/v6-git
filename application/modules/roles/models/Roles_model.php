<?php



/**
 * Description of Roles_model
 *
 * @author itischarles
 */
class Roles_model extends CI_Model{
    //put your code here
  
    
     private $table_tbl = 'auth_roles';
    
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
        $this->db->where(array('roleID'=>(int)$id));
        return $this->db->get($this->table_tbl)->row();
    }
    
    function getAll(){
        return $this->db->get($this->table_tbl)->result(); 
    }
}
