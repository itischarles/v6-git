<?php


/**
 * Description of Title_model
 * manage the title table
 * @author itischarles
 */
class Title_model extends CI_Model {
    
    private $titles_tbl = 'titles';
    
     function __construct() {
        parent::__construct();
    }
    
    
    
    
    
    function addNewTitle($content){
        
        $this->db->insert($this->titles_tbl, $content);
        return $this->db->insert_id();
    }
    
    function updateTitle($content, $where){
        $this->db->where($where);
        $this->db->update($this->titles_tbl, $content);
        return $this->db->affected_rows();
    }
    
    function getTitleByWhere($where){
        $this->db->where($where);
        return $this->db->get($this->titles_tbl)->row();
    }
    
    
    function getTitleByID($titleID){
        $this->db->where(array('titleID'=>(int)$titleID));
        return $this->db->get($this->titles_tbl)->row();
    }

    function getTitleID_byName($titleName){
	$titleName = trim($titleName);
	//lets remove dot if included
	$titleRemoveDot = explode('.', $titleName);
	$title = ucfirst(strtolower($titleRemoveDot[0]));
	
        $this->db->where("titleName like '$title%'");
        $record =  $this->db->get($this->titles_tbl)->row();
	return (!empty($record) ? $record->titleID : "");
    }
    
    
    function listTitleByWhere($where = false){       
        if($where !== false):
            $this->db->where($where);
        endif;
        
        return $this->db->get($this->titles_tbl)->result();
    }
    
    
    function listTitleActiveTitles(){       
        $this->db->where(array('titleIsActive'=>1));
        
        return $this->db->get($this->titles_tbl)->result();
    }
    
}
