<?php


/**
 * Description of Valuation_model
 *
 * @author itischarles
 */
class Client_investment_model extends CI_Model {
    
    private $table_tbl = 'unit_client_Investment';
    
     function __construct() {
        parent::__construct();
    }
    
    
    
    function addInBatch($content){
	$this->db->insert_batch($this->table, $content); 
    }
    
    
    function listInvestment_byDate($investmentDate){
	
	$this->db->where("investmentDate = '$investmentDate'");
	return $this->db->get($this->table)->result();
    }
    
    
    /**
     * list portfolio valuation by date
     */
    function getInvestment_byDate($investmentDate, $clientID = false){
	if($clientID !== false):
	   $this->db->where('clientID', (int)$clientID);
	endif;
	
	$investmentDate = changeDateFormat($investmentDate, 'Y-m-d');
	
	$this->db->where("investmentDate = '$investmentDate'");
	return $this->db->get($this->table)->row();
    }
    
    

}
