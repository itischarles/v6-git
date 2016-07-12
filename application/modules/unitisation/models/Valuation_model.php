<?php


/**
 * Description of Valuation_model
 *
 * @author itischarles
 */
class Valuation_model extends CI_Model {
    
    private $table_tbl = 'unit_portfolio_valuation';
    
     function __construct() {
        parent::__construct();
    }
    
    
    
    
    function addNew($content){
        
        $this->db->insert($this->table_tbl, $content);
        return $this->db->insert_id();
    }
    
   
    
     /**
     * insert a batch
     * @param multidimensional-array $content
     */
    function addInBatch($content){
	$this->db->insert_batch($this->table_tbl, $content); 
    }
    

    /**
     * list portfolio valuation by date
     */
    function listValuation_byDate($portfolioValuationDate, $portfolioID = false){
	
	if($portfolioID !== false):
	    $this->db->where("portfolioID = '$portfolioID'");
	endif;
	
	$portfolioValuationDate = changeDateFormat($portfolioValuationDate, 'Y-m-d');
	$this->db->where("portfolioValuationDate = '$portfolioValuationDate'");
	return $this->db->get($this->table_tbl)->result();
    }
    
    
    /**
     * get portfolio valuation by date
     */
    function getValuation_byDate($portfolioValuationDate, $portfolioID = false){
	
	$portfolioValuationDate = changeDateFormat($portfolioValuationDate, 'Y-m-d');
	
        if($portfolioID !== false):
	    $this->db->where("portfolioID = '$portfolioID'");
	endif;
	
	$this->db->where("portfolioValuationDate = '$portfolioValuationDate'");
	return $this->db->get($this->table_tbl)->row();
    }
    
    
    
        /**
     * get the date of last uploaded entry
     */
    function getValuation_lastUpload(){
	
	$this->db->limit(1);
	$this->db->order_by('portfolioValuationID', 'DESC');
	return $this->db->get($this->table_tbl)->row();
    }
    
    
       /**
     * list portfolio valuation by date
     */
    function getRecentValuation_byPortfolioID($portfolioID = 0){

	$this->db->where("portfolioID = $portfolioID");
	$this->db->order_by('portfolioValuationDate', 'DESC');
	return $this->db->get($this->table_tbl)->row();
    }
    


}
