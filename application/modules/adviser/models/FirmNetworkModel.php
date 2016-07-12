<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('html_errors', false);

/**
 * Firm Network Model class
 *
 * @author Wajira Weerasinghe
 */
class FirmNetworkModel extends CI_Model 
{
	protected $mod = "FirmNetworkModel";	
    
	// Constructor =========================================================================================================
    function __construct() 
	{
        parent::__construct();
    }
	
	// Get Serach By Network Nmae function ==================================================================
	function searchByName($name)
	{
		$func = 'searchByName($name)';
		
		try
		{
			$ret["success"] = false;

			$where = "networkName LIKE '%" . $name . "%'";
			$this->db->where($where);

			$ret["data"] =  $this->db->get('ifa_firm_network')->result(); 
			
			$ret["success"] = true;
			return (object) $ret; 
		}
		catch (Exception $exp)
		{
			$ret["success"] = false;
			$ret["data"] =  null ;
			$ret["userMessage"] =  "Exception occured in " .  $this->mod . "->" . $func . "." ;
			$ret["systemMessage"] =  "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage();
			log_message('error',  "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage() );
			return (object) $ret;
		}
		 
	}
    
	// addFirmNetowrk function  ==================================================================
	function addFirmNetwork($content)
	{
		$func = 'addFirmNetwork($content)';
		
		try
		{
			$ret["success"] = false;

			$this->db->insert('ifa_firm_network',$content);
			
			$ret["success"] = true;
			$ret["data"] =  $this->db->insert_id();

			return (object) $ret; 
		}
		catch (Exception $exp)
		{
			$ret["success"] = false;
			$ret["data"] =  null ;
			$ret["userMessage"] =  "Exception occured in " .  $this->mod . "->" . $func . "." ;
			$ret["systemMessage"] =  "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage();
			log_message('error',  "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage() );
			return (object) $ret;
		}
		 
	}
	
	// updateCode($networkID) function  ==================================================================
	function updateCode($networkID)
	{
		$func = 'updateCode($networkID)';
		
		try
		{
			$ret["success"] = false;
			
			$date = date_create(); 
			$unhashed = '' . $networkID . '' . date_timestamp_get($date);
			$code = md5($unhashed);
			
			$content['networkCode'] = $code ;
			
			$this->db->where(" networkID = " . $networkID );
			$this->db->update('ifa_firm_network' , $content);
			
			$ret["success"] = true;
			$ret["data"] = $this->db->affected_rows();  

			return (object) $ret; 
		}
		catch (Exception $exp)
		{
			$ret["success"] = false;
			$ret["data"] =  null ;
			$ret["userMessage"] =  "Exception occured in " .  $this->mod . "->" . $func . "." ;
			$ret["systemMessage"] =  "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage();
			log_message('error',  "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage() );
			return (object) $ret;
		}
		 
	}
	
	
	
	
    

    
} //end class
