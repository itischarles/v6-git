<?php


/**
 * Description of Portfolio_model
 *
 * @author itischarles
 */
class Portfolio_model extends CI_Model {
    
    private $table_tbl = 'unit_portfolios';
    
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
    

//    function getByID($id){
//        $this->db->where(array('id'=>(int)$id));
//        return $this->db->get($this->title_tbl)->row();
//    }
    
    
     /**
     * insert a batch
     * @param multidimensional-array $content
     */
    function addInBatch($content){
	$this->db->insert_batch($this->table_tbl, $content); 
    }
    

    
    function getByURL($purl){
	
        $this->db->where(array('portfolioURL'=>$purl));
         return $this->db->get($this->table_tbl)->row();
    }
    
    
     function getByReference($pRef){	
        $this->db->where(array('portfolioReference'=>$pRef));
         return $this->db->get($this->table_tbl)->row();
    }
    
    
    
           /**
     * 
     * 
     * @param int $limit
     * @param int $offset
     * @param bol $count if true, it means we want the num_rows
     * @return type
     */
    function searchPortfolios($limit = 0, $offset=0, $count=false){

        
	$name  = ($this->input->get('name') ? $this->input->get('name') : '');
	$ref  = ($this->input->get('ref') ? $this->input->get('ref') : '');
	$showAll  = ($this->input->get('show-all') && ($this->input->get('show-all') == true) ? true : false);
	
	$where_search = array();
	if(!empty($name)):	 
	     $where_search[] = "(portfolioName like '$name%')";
	endif;
    
	if(!empty($ref)):
	     $where_search[] = "(portfolioReference like '$ref%')";
	endif;
	
	if($showAll === true):
	    unset($where_search); // clear the search param and do this alone
	
	     $where_search[] = "(portfolioID > 0)";
	endif;
        
        
          
	if(empty($where_search)):
	    return false;
	endif;
	
	$filter = implode(" AND ", $where_search);

	$this->db->where($filter);
	
	if($count === true):	
	    return  $this->db->count_all_results($this->table_tbl);
	endif;   
        
	$this->db->group_by($this->table_tbl.".portfolioID");
        $this->db->limit( $limit,$offset);
        return $this->db->get($this->table_tbl)->result();
    }
    
}
