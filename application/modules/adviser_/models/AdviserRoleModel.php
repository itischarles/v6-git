<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('html_errors', false);

/**
 * Adviser Adviser Role Model class
 *
 * @author Wajira Weerasinghe
 */
class AdviserRoleModel extends CI_Model 
{
    protected $mod="AdviserRoleModel";
    
	// Constructor =========================================================================================================
    function __construct() 
	{
        parent::__construct();
    }
	
	// Get ID from Code function  ==================================================================
	function getIDfromCode($adviserCode)
	{
		$func = 'getIDfromCode($adviserCode)';
		
		try
		{
			$ret["success"] = false;

			$roleID = $this->db->select('ifaRoleID')
                  ->get_where('im_ifa_role', array('ifaRoleCode' => $adviserCode))
                  ->row()
                  ->ifaRoleID;
			
			$ret["data"] =   $roleID;
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
		 
	}//end function
	
	
	
	
	
	
    

    
}// end of class
