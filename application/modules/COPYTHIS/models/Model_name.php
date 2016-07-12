<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_name
 *
 * @author itischarles
 */
class Model_name extends CI_Model {
    
    private $table_tbl = 'tablename';
    
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
        $this->db->where(array('id'=>(int)$id));
        return $this->db->get($this->title_tbl)->row();
    }
    
    
    
}
