<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('html_errors', false);

/**
 * Firm Model class
 *
 * @author Wajira Weerasinghe
 */
class FirmModel extends CI_Model 
{
    protected $mod="FirmModel";
    
	// Constructor =========================================================================================================
    function __construct() 
	{
        parent::__construct();
    }
    
	// Get Serach By Network Nmae function for AJAX call. ==================================================================
	function searchByName($txt)
	{
		$func = 'searchByName( $txt)';

		try
		{
			$ret["success"] = false;

			$where = "firmName LIKE '%" . $txt . "%'";
			$this->db->where($where);
			
			$ret["success"] = true;
			$ret["data"] =  $this->db->get('ifa_firm')->result();

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
    
	// addFirm function  ==================================================================
	function addFirm($content)
	{
		$func = 'addFirm($content)';
		
		try
		{
			$ret["success"] = false;

			$this->db->insert('ifa_firm',$content);
			
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
	
	// updateCode($firmID) function  ==================================================================
	function updateCode($firmID)
	{
		$func = 'updateCode($firmID)';
		
		try
		{
			$ret["success"] = false;
			
			$date = date_create(); 
			$unhashed = '' . $firmID . '' . date_timestamp_get($date);
			$code = md5($unhashed);
			
			$content['firmCode'] = $code ;
			
			$this->db->where(" firmID = " . $firmID );
			$this->db->update('ifa_firm' , $content);
			
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
	
	function getIfaFirmDetails($firmID)
	{
            $where = "firmID = $firmID";
            $this->db->where($where);
            return $this->db->get('ifa_firm')->row();
	}	
	
	
	
	
    

    
}// end of class
