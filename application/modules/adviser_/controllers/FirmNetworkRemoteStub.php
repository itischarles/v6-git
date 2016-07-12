<?php

/**
 * Description: 
 *
 * @author Wajira Weerasinghe
 */
ini_set('html_errors', false);

class FirmNetworkRemoteStub extends MY_Controller 
{
	protected $mod = "FirmNetworkRemoteStub";
	
    var $user_accessor =''; // to access the user model
     
     var $current_userID;
     var $current_userBaseUrl;
  
	// Constructor ===========================================================================================================
    function __construct() 
	{
        parent::__construct();
		
		$this->NetworkAdapter = new FirmNetworkModel();
		
		try
		{
			$this->user_accessor = new Users_Model();        

			//If you need to be authenticated to view this controller at contoller level, otherwise put this in function level
			//But since this call is made in the public interface we may not need this validation.
			/*
			if( ! $this->user_accessor->authenticateServiceAccess($this->session->userdata('userID')))
			{
				$ret = '[{"label":"' . "User not authenticated !" . '","value":"' . "_ERROR_" . '"}]' ;
				echo($ret);
				exit;
			}
			*/
			
			$this->current_userID = $this->session->userdata('userID');
		}
		catch (Exception $exp)
		{
			$ret = '[{"label":"' . "Error occured in " . $this->mod . "->Constructor()." . '","value":"' . "" . "" . "" . '"}]' ;
			log_message( "Error occured in " . $this->mod . "->Constructor(): " . $exp->message);
			echo($ret);
			exit;
		}

	}
    
	
	// Get Networks List for AJAX call. ======================================================================================
    function searchNetworks()
	{
		$func= 'searchNetworks()';
		
		try
		{
			$txt = $this->input->get('txt');

			$results = $this->NetworkAdapter->searchByName($txt);

			if($results->success)	
			{
				$data=$results->data;
				
				$ret = '' ;		
				
				if(!empty($data))
				{ 	
					$ret .= '[' ;
					
					//Each one is a jason object to fill the data for lists
					foreach ($data as $key=>$network)
					{
						$ret .= '{"label":"' . $network->networkName . '","value":"' . $network->networkID . '"},' ;
					}
					
					$ret = rtrim( $ret , ",");
					
					$ret .= ']' ;
				}
				else
				{
					//If not found create and item with a different id asking want to add it.
					$ret = '[{"label":"' . "Network not found !, click here to add (" . $txt . ") as a new network" . '","value":"' . "_NEW_" . '"}]' ;
				}
				
				echo($ret);
				exit;
			}
			else
			{
				$ret = '[{"label":"' . 'Error occured in '. $this->mod . '->' . $func . '"' . ',"value":"_ERROR_"}]' ;
				log_message( 'error',  "Exception at " . $this->mod . "->" . $func . ": " . $results->systemMessage );
				echo($ret);
				exit;
			}
		}
		catch (Exception $exp)
		{
			$ret = '[{"label":"' . 'Error occured in '. $this->mod . '->'. $func .'.","value":"' . "_ERROR_" . '"}]' ;
			log_message('error',  "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage() );
			echo($ret);
			exit;
		}
    }//end function 

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    
    
    
}//end class



