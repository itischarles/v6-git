<?php

/**
 * Description of Adviser
 *
 * @author Wajira
 *
 *
 * IMPORTANT NOTE: This module is seperated as we do not need authentication (logged-in) to perform the task.
 * all other Financial Advisor functions are written seperately in an authenticated context.
 */

 class Adviser extends MY_Controller{

     /**
     * $moduleName
     * specify the name of this module
     * @var string 
     */
    private $moduleName = 'adviser';
    
    /**
     * $moduleKey
     * specify the module unique key
     * @var string 
     */
    private $moduleKey = 'adviser';

         
     
    function __construct(){
        parent::__construct();
		
        //Create adapters to access the data
        $this->load->model('AdviserModel','adviser_accessor');
        $this->load->model('FirmModel','firm_accessor');     				
        $this->load->model('FirmNetworkModel','firm_network_accessor');
        $this->load->model('AdviserRoleModel','adviser_role_accessor');
//		$this->user_accessor = new Users_Model();

        $this->load->module('template');
    }

    
    function pass_check() 
    {
        if (trim($p1) == trim($p2))
        {
                return TRUE;
        }
        else
        {
                $this->form_validation->set_message('pass_check', 'Both password fields must match');
                return FALSE;
        }
    }

	 function index()
	 {
		 echo("Adviser Self Registration");
		 exit;
	 }
    
	
	// Self Register IFA ---------------------------------------------------
    function selfRegister()
    {
		 
		if($this->input->post('faSelfRegister'))
		{
			$allErrors = "" ;
			$msg="";
			
			//Write the save code here.
			$firmID = $this->input->post('hFirmID');
			$networkID = $this->input->post('hNetworkID');
			
			//First we add the firm network if its set -------------
			if( trim($networkID) == '_NEW_' && trim($firmID) == '_NEW_') 
			{
				//Validate the Network input---
				$this->form_validation->set_rules('networkSearcher', 'Firm Netwrok Name', 'trim|required');
				$this->form_validation->set_rules('networkFCANo', 'Firm Netwrok FCA Ref. Number', 'trim|required|is_unique[im_ifa_firm_network.fcaNumber]');
				$this->form_validation->set_rules('networkEmail', 'Firm Netwrok Eamil', 'trim|required|valid_email');
				$this->form_validation->set_rules('networkTelephone', 'Firm Netwrok Telephone (Fixed)', 'trim|required');
				$this->form_validation->set_rules('networkContact', 'Firm Netwrok Contact Person', 'trim|required');
			}
			
			//Add the Firm now if its set -------------
			if( trim($firmID) == '_NEW_') 
			{
				//Validate the Network input ---
				$this->form_validation->set_rules('firmSeacher', 'Firm Name', 'trim|required');
				$this->form_validation->set_rules('firmFCANo', 'Firm FCA Ref. Number', 'trim|required|is_unique[im_ifa_firm.fcaNumber]');
				$this->form_validation->set_rules('firmEmail', 'Firm Eamil', 'trim|required|valid_email');
				$this->form_validation->set_rules('firmTelephone', 'Firm Telephone (Fixed)', 'trim|required');
				$this->form_validation->set_rules('firmContact', 'Firm Contact Person', 'trim|required');
			}
			
			//Validate the Advisor Personal data input ---
			$this->form_validation->set_rules('individualFcaNumber', 'Personal FCA Ref. Number', 'trim|required|is_unique[im_ifa.individualFcaNumber]');
			$this->form_validation->set_rules('firstName', 'Firm Name', 'trim|required');
			$this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');
			
			$this->form_validation->set_rules('address1', 'Address Line 1', 'trim|required');
			$this->form_validation->set_rules('postalCode', 'Postal Code', 'trim|required');
			$this->form_validation->set_rules('city', 'City', 'trim|required');
			
			$this->form_validation->set_rules('email', 'Personal Eamil', 'trim|required|valid_email|is_unique[users.user_username]');
			$this->form_validation->set_rules('telephone', 'Telephone (Fixed)', 'trim|required');
			$this->form_validation->set_rules('mobile', 'Personal Mobile', 'trim|required');
			
			$this->form_validation->set_rules('userPass', 'Password', 'trim|required');
			$this->form_validation->set_rules('userRePass', 'Re-enter Password', 'trim|required');

			//TODO: Below customer callback does not work with HMVC, we have to check why
			//$this->form_validation->set_rules('userRePass', 'Re-enter Password', 'trim|required|callback_pass_check'); 
			
			$validForm = $this->form_validation->run();

			if($validForm)
			{
				//validate passwords..
				$p1 =  $this->input->post('userPass');
				$p2 =  $this->input->post('userRePass');

				if (trim($p1) != trim($p2))
				{
					$allErrors .= "Passwords does not match each other.";
					$validForm = false;
				}
			}
			
			//OK we are done with the vaildations.. we can proceed....
			if( $validForm)
			{
				//First we add the firm network if its set -------------
				if( trim($networkID) == '_NEW_' && trim($firmID) == '_NEW_') 
				{
					$ncontent['networkName']  = $this->input->post('networkSearcher');
					$ncontent['fcaNumber'] = $this->input->post('networkFCANo');
					$ncontent['addressLine1'] = $this->input->post('networkAddress1');
					$ncontent['addressLine2'] = $this->input->post('networkAddress2');
					$ncontent['addressLine3'] = $this->input->post('networkAddress3');
					$ncontent['postCode'] = $this->input->post('networkPostalCode');
					$ncontent['city'] = $this->input->post('networkCity');
					$ncontent['email'] = $this->input->post('networkEmail');
					$ncontent['telephone'] = $this->input->post('networkTelephone');
					$ncontent['mobile'] = $this->input->post('networkMobile');
					$ncontent['contactPerson'] = $this->input->post('networkContact');
					$ncontent['webAddress'] = $this->input->post('networkWebAddress');

					//Ddatabase Wirte (Firm Network ) -----
					$retVal = $this->firm_network_accessor->addFirmNetwork($ncontent);
					
					if($retVal->success )
					{
						$networkID = $retVal->data;
						
						//Now create and update the network code ---
						$retVal = $this->firm_network_accessor->updateCode($networkID);
						if(! $retVal->success )
						{
							$allErrors .= ' Error generating firm network code.' . $retval->systemMessage ;
						}
					}
					else
					{
						$allErrors .= ' Error adding firm network.' . $retval->systemMessage ;
					}
					
				} 

				//Add the Firm now if its set -------------
				if( trim($firmID) == '_NEW_') 
				{
					$fcontent['firmName']  = $this->input->post('firmSeacher');
					$fcontent['fcaNumber'] = $this->input->post('firmFCANo');
					$fcontent['addressLine1'] = $this->input->post('firmAddress1');
					$fcontent['addressLine2'] = $this->input->post('firmAddress2');
					$fcontent['addressLine3'] = $this->input->post('firmAddress3');
					$fcontent['postCode'] = $this->input->post('firmPostalCode');
					$fcontent['city'] = $this->input->post('firmCity');
					$fcontent['email'] = $this->input->post('firmEmail');
					$fcontent['telephone'] = $this->input->post('firmTelephone');
					$fcontent['mobile'] = $this->input->post('firmMobile');
					$fcontent['contactPerson'] = $this->input->post('firmContact');
					$fcontent['webAddress'] = $this->input->post('firmWebAddress');
					
					if(  ( trim( $networkID) != '') && ( trim( $networkID)!= '_NEW_' ) )
					{
						$fcontent['firmNetworkID'] = $networkID;
					}

					//Ddatabase Wirte (Firm)-----
					$retVal = $this->firm_accessor->addFirm($fcontent);
					
					if($retVal->success )
					{
						$firmID = $retVal->data;
						
						//Now create and update the network code ---
						$retVal = $this->firm_accessor->updateCode($firmID);
						if(! $retVal->success )
						{
							$allErrors .= ' Error generating firm code.' . $retval->systemMessage  ;
						}
					}
					else
					{
						$allErrors .= ' Error adding firm.' . $retval->systemMessage ;
					}
				} 
				
				//Now save the user record.
				$ucontent['user_fname'] = $this->input->post('firstName');
				$ucontent['user_lname'] = $this->input->post('lastName');
				$ucontent['user_username'] = $this->input->post('email');
				$ucontent['user_password'] = $this->user_accessor->_prep_password( $this->input->post('userPass'));
				$ucontent['user_isActive'] = 1;
				$ucontent['user_regDate'] = changeDateFormat('now', "Y-m-d");
				$ucontent['user_userLink'] = $this->generateElementURL('user');
				
				/*
				//TODO: IMPORTANT NOTE: These fields must be incorporated to the user table.
				//Current user table does not have them and I will create them after checking with Charles.
				
				$ucontent['address1'] = $this->input->post('address1');
				$ucontent['address2'] = $this->input->post('address2');
				$ucontent['address3'] = $this->input->post('address3');
				$ucontent['postalCode'] = $this->input->post('postalCode');
				$ucontent['city'] = $this->input->post('city');
				$ucontent['email'] = $this->input->post('email');
				$ucontent['telephone'] = $this->input->post('telephone');
				$ucontent['mobile'] = $this->input->post('mobile');
				*/

				//Create the User Record -----
				$newUserID = $this->user_accessor->addNewUser($ucontent);
				
				$acontent['userID'] = $newUserID ;
				$acontent['individualFcaNumber']  = $this->input->post('individualFcaNumber');
				
				//if we have a existing or newly created firm we just set it
				if( ( $firmID > 0 )  && (trim($firmID) != '_NEW_' ) &&  (trim($firmID) != '' ) )
				{
					$acontent['firmID'] = $firmID ;
				}

				//Get the appropriate role id from role table by giving a code
				$roleRet = $this->adviser_role_accessor->getIDfromCode('AN');
				if( $roleRet->success )
				{
					$acontent['ifaRoleID'] = $roleRet->data ;   
				}
				else
				{
					$allErrors .= ' Error reading adviser id from code.' . $retval->systemMessage  ;
				}
				
				//Now add the adviser to the db table.
				$retVal =  $this->adviser_accessor->addNewAdviser($acontent);

				if($retVal->success )
				{
					$newAdviserID = $retVal->data;
					//And update the code as well ...
					$retVal = $this->adviser_accessor->updateCode($newAdviserID);
					if(! $retVal->success )
					{
						$allErrors .= ' Error generating adviser code.' . $retval->systemMessage  ;
					}
				}
				else
				{
					$allErrors .= ' Error adding adviser.' . $retval->systemMessage ;
				}
			}
			
			//At this point all must be happily completed. (if allErrors variable is empty :) )

			if( $validForm && trim($allErrors) == '') //Excellent ... all gone as plannned.... 
			{
				$this->session->set_flashdata('message', 'Adviser self registration successful.'. $msg );
				$this->session->set_flashdata('type', 'flash_success');
				redirect(current_url()); // If we need a fresh page again
				//redirect(base_url("login")); // Or we just can send to the login screen as well....
				
			}
			else// Oh we have errors... let us show...
			{
				$this->session->set_flashdata('message', $allErrors);
				$this->session->set_flashdata('type', 'flash_error');
			}

		}//if post data recieved
	
	
        // Fresh call to form so we show the form  
        $data['firmsList'] = $this->searchFirms();
        $data['networksList'] = $this->searchNetworks();

        $data['page_header'] = "Register Financial Adviser";
        $data['content_view'] = "adviser/register";
        $data['page_title'] = "Register as a Financial Advisor";
	$data['page_style_name'] = "register-page";
        $data['mod_js'] = $this->getModule_js();
      
        $this->template->callLoginTemplate($data);
        //$this->template->callAdviserRegistrationTemplate($data);
    }
	
	
	
		
    // Search Firms  ======================================================================================
    function searchFirms()
    {
            $func= 'searchFirms()';

            try
            {
                    $txt = $this->input->get('txt');

                    $results = $this->firm_accessor->searchByName( $txt);

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
			
				return $ret;
				
			}
			else
			{
				$ret = '[{"label":"' . 'Error occured in '. $this->mod . '->' . $func . '"' . ',"value":"_ERROR_"}]' ;
				log_message( 'error',  "Exception at " . $this->mod . "->" . $func . ": " . $results->systemMessage );
				return $ret;
				
			}
			
		}
		catch (Exception $exp)
		{
			$ret = '[{"label":"' . 'Error occured in '. $this->mod . '->'. $func .'.","value":"' . "_ERROR_" . '"}]' ;
			log_message('error',  "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage() );
			return $ret;
			
		}
    }//end function
	
	
// Search Networks  ======================================================================================
    function searchNetworks()
    {
        $func= 'searchNetworks()';

        try
        {
                $txt = $this->input->get('txt');

                $results = $this->firm_network_accessor->searchByName($txt);

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

                        return $ret;

                }
                else
                {
                        $ret = '[{"label":"' . 'Error occured in '. $this->mod . '->' . $func . '"' . ',"value":"_ERROR_"}]' ;
                        log_message( 'error',  "Exception at " . $this->mod . "->" . $func . ": " . $results->systemMessage );
                        return $ret;
                }
        }
        catch (Exception $exp)
        {
                $ret = '[{"label":"' . 'Error occured in '. $this->mod . '->'. $func .'.","value":"' . "_ERROR_" . '"}]' ;
                log_message('error',  "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage() );
                return $ret;
        }
    }//end function 

	

	
	
     /**
     * get the module specific javascription file link
     */
    function getModule_js(){
        return base_url('module_assets/'.$this->moduleName.'/adviser-module.js');
    }
    
	
} // end class



