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
class Country_model extends CI_Model {
    
    private $table_tbl = 'countries';
    
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
    

    function getByID($countryID){
        $this->db->where(array('countryID'=>(int)$countryID));
        return $this->db->get($this->table_tbl)->row();
    }
    
    
     function getByAlpha2($Alpha2){
        $this->db->where(array('countryAlpha2'=>$Alpha2));
        return $this->db->get($this->table_tbl)->row();
    }
    
    
    function listAll(){       
       return $this->db->get($this->table_tbl)->result();
    }
   
    
}
