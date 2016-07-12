<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('html_errors', false);

/**
 * Adviser Model class
 *
 * @author Wajira Weerasinghe
 */
class AdviserModel extends CI_Model 
{
    protected $mod="AdviserModel";
    
	// Constructor =========================================================================================================
    function __construct() 
	{
        parent::__construct();
    }
     
	// addNewAdviser function  ==================================================================
	function addNewAdviser($content)
	{
		$func = 'addNewAdviser($content)';
		
		try
		{
			$ret["success"] = false;

			$this->db->insert('im_ifa',$content);
			
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
	
	// updateCode($adviserID) function  ==================================================================
	function updateCode($adviserID)
	{
		$func = 'updateCode($adviserID)';
		
		try
		{
			$ret["success"] = false;
			
			$date = date_create(); 
			$unhashed = '' . $adviserID . '' . date_timestamp_get($date);
			$code = md5($unhashed);
			
			$content['ifaCode'] = $code ;
			
			$this->db->where(" ifaID = " . $adviserID );
			$this->db->update('im_ifa' , $content);
			
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
	
	
	
	
	
	
    

    
}// end of class
