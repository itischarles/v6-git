<?php

/**
 * Description: 
 *
 * @author Wajira Weerasinghe
 */
class FirmRemoteStub extends MY_Controller 
{
	protected $mod = "FirmRemoteStub";
	
    var $user_accessor =''; // to access the user model
     
	var $current_userID;
	var $current_userBaseUrl;
      
	
	// Constructor ===========================================================================================================
    function __construct() 
	{
        parent::__construct();
		
		$this->FirmAdapter = new FirmModel();
    }
    
	
	// Search Firms for AJAX call. ======================================================================================
	function searchFirms()
	{
		$func= 'searchFirms()';
		
		try
		{
			$txt = $this->input->get('txt');
			
			$results = $this->FirmAdapter->searchByName( $txt);
			
			if($results->success)	
			{
				$data=$results->data;

				$ret = '' ;

				if(!empty($data))
				{ 	
					$ret .= '[' ;
			
					//Create a list of json objects to pass so they can be added to the list
					foreach ($data as $key=>$firm)
					{
						$ret .= '{"label":"' . $firm->firmName . '","value":"' . $firm->firmID . '" , "network_id":"' . $firm->firmNetworkID . '" },' ;
					}
					
					$ret = rtrim( $ret , ",");
					
					$ret .= ']' ;
				}
				else
				{
					//If not found create and item with a different id asking want to add it.
					$ret = '[{"label":"' . "Firm not found !, click here to add (" . $txt . ") as a new firm" . '","value":"' . "_NEW_" . '" , "network_id":"" }]' ;
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
    }

    
    
    
	
	
}// end class



