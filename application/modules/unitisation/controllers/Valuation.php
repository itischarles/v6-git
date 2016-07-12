
<?php


/**
 * Description of Valuation
 * manages Valuation uploads

 * @author itischarles
 */
class Valuation extends MY_Controller{
    //put your code here
    private $userDetails;
    private $client_accessor;
    protected $auth_lib;
    private $unitisationLib_accessor;
    
    /**
     * $moduleName
     * specify the name of this module
     * @var string 
     */
    private $moduleName = 'Unitisation';
    
    /**
     * $moduleKey
     * specify the module unique key
     * @var string 
     */
    private $moduleKey = 'unitisation-module';
    
    
    
    /**
     *$errorMessage
     * holds error messages. useful for methods colling themselves. get al the errors in one place
     * do not proceed in the called method in error
     * @var array 
     */
    private $errorMessage = array();
    
   
    
    /**
     * $valuationDate
     * store valuationDate menat to pass to other methods
     * @var string 
     */
    private $valuationDate = '';
    
    private $portfolios ; //stores the portfolios object
    private $today = '';
    
                        
    function __construct() {
        parent::__construct();

     
      $this->auth_lib = new Auth_lib();      
      $this->auth_lib->is_authenticated();
      // make sure this user has read access to this module
      $this->auth_lib->has_readAccess_orRedirect($this->moduleKey);
          
      $this->today= changeDateFormat('now', 'Y-m-d');
       

      $this->load->module('template');
      $this->load->model('Portfolio_model', 'portfolio_accessor'); 
      $this->load->model('Valuation_model', 'valuation_accessor'); 
      $this->load->model('Client_investment_model', 'client_investment_accessor'); 
      
      
     $this->load->library('unitisation/Unitisation_lib');
     $this->unitisationLib_accessor = new Unitisation_lib();
        
      
    }
    
    
    
   
    
    function index (){
        redirect('unitisation');
    }
   
  
      
     /**
      * upload portfolio valuation
      */
    function uploadPortfolioValuation(){
	
	 // prepare for batch insert of portfolio
	    $batchInsertPortfolio = array();
	    $batchInsertInvestment = array();
  
        if($this->input->post('upload_valuation')):   

            $this->form_validation->set_rules('file_ref2', 'Ref', 'required');
	
            if(empty($_FILES['upload_pVal']['name'])):
                $this->form_validation->set_rules('upload_pVal', 'Valuation File', 'required');
            endif;
         
	    
	    //validate if we check the box to add investment upload
	    if($this->input->post('include_investment') && empty($_FILES['upload_cInvst']['name'])): 
		$this->form_validation->set_rules('upload_cInvst', 'Investment File', 'required');
	    endif;            
	    
            $this->form_validation->set_error_delimiters( '<em class="error_text">','</em>' );
            
	    
            if($this->form_validation->run()):
                   
		$valuationArray =   $this->unitisationLib_accessor->unit_csvToMultiArray($_FILES['upload_pVal']['tmp_name']); 
		
		if(empty($valuationArray)):
		    $this->session->set_flashdata('message', 'The content of your valuation file could not be retrieved');
		    $this->session->set_flashdata('type', 'flash_error');
		    redirect(base_url('unitisation/portfolio/upload-valuation'));
		    return false;
		endif;
               
                // now we have a multitidamentioanl array from csv in part.
                //part one would the arraydata, and part 2 = head
		$content_array = $valuationArray['arrayData'];
		$head   = $valuationArray['head'];
                // get the first record
		$this->valuationDate = $content_array[0]['Valuation Date'];

		
		// validate the csv header
		$expectedHeader =  array('Client Code','Valuation Date','Portfolio Value','Price Ccy');
		if($head !== $expectedHeader):
		    $this->errorMessage[] = "Invalid file uploaded. Column names do not match";			
		endif;

		//stop upload if date is same as the last upload
		$fileAlreadyUploaded = $this->valuation_accessor->getValuation_byDate($this->valuationDate);

		if(!empty($fileAlreadyUploaded)):
		     $this->errorMessage[] = "It seems this valuation file has already been uploaded";			     
		endif;

		
		//use the multi-dimentioanl to create insert for portfolio
		if(!empty($content_array) && (empty($this->errorMessage))):		   

		    foreach ($content_array as $key=>$val):                     
			 // Client Code ,Valuation Date  Portfolio Value
			$reference= $val['Client Code'];
			$valuationDate= $val['Valuation Date'];			
			$portfolioValue =  $val['Portfolio Value'];


			$portfolioRecord =  $this->portfolio_accessor->getByReference($reference);

			//stop upload is any of the reference does not exist in the portfolio table
			if(empty($portfolioRecord)):
			   $this->errorMessage[] = "Portfolio reference $reference does not exist";			     
			endif;

			// stop processing if date in any of the record does not match the first record
			if($valuationDate != $this->valuationDate):
			    $this->errorMessage[] = "Portfolio reference $reference has an invalid date";			     
			endif;

			$content['actionByUserID'] =  $this->current_userID;
			$content['dateOfAction'] = changeDateFormat('now', "Y-m-d", true);

			$content['portfolioReference'] = $reference;
			$content['portfolioValuationValue'] = price_format_DB($portfolioValue);
			$content['portfolioValuationDate'] = changeDateFormat($valuationDate, "Y-m-d");

			// set to 0 if portfolio does not exist. the process will not go though anywayy
			$content['portfolioID'] = (!empty($portfolioRecord)?$portfolioRecord->portfolioID : 0); 		 


			$batchInsertPortfolio[] = $content;			   
		    endforeach; 

		endif; // end create batch insert for portfolio
		 
		
		
		///prepare batch insert for investment
		 if($this->input->post('include_investment')):
		     $clientInvestmentBatch = $this->_prepareClientInvestmentUpload();
		 endif;
		
		
		
		  
		// insert the data only if there was no error
		if(empty($this->errorMessage) && (!empty($batchInsertPortfolio))):

		    $this->valuation_accessor->addInBatch($batchInsertPortfolio);

		    // upload client investment
		    if(!empty($clientInvestmentBatch)):
			 $this->member_investment_accessor->addInBatch($clientInvestmentBatch);
		    endif;
		   

		    
		    // CREATE TRANSACTIONs
		   ## $this->_createTransactions();
		    
		
		   $this->session->set_flashdata('message', 'file processed Successfully');
		   $this->session->set_flashdata('type', 'flash_success');
		   redirect(base_url('unitisation/valuation/upload'));

		endif; // end batch insert		

		
		
            endif; // end if run
              
        endif;// end if posted
	
	       
        
         $data['page_title'] = "Upload Portfolio Valuation";  
	$data['page_header'] = "Upload Portfolio Valuation";
        $data['content_view'] = "unitisation/valuation-upload";
        //$data['sidebar_view'] = "unitisation/unitisation_sidebar";
       
        $data['module'] = $this->moduleName;
        $data['errorMessage'] = $this->errorMessage;
        
        //$this->breadcrumbs->push('Portfolios', '/unitisation/portfolio');
        $this->breadcrumbs->push('Upload Valuation', '/');
	
        
        $this->template->callDefaultTemplate($data);
        
        
	
    }
    
    
    
    
    
    /**
     * upload client investment
     * at this point the this file does not tell us what portfolio this client has
     * so relay on the use to create a split screen: where the user is called up and manually
     * assigned a portfolio. the user also defines a percentage split. th total number of portfolio
     * a client has, the percentage split must be equal to 100%
     * this upload would fail if a client mentioned here doesn't already has this split
     * once the upload is complete, the system creats a transsaction automatcially - createTransaction(data)
     */
    
    private function _prepareClientInvestmentUpload() {
	
	$investmentArray =  $this->unitisationLib_accessor->unit_csvToMultiArray($_FILES['upload_cInvst']['tmp_name']); 

	if($this->input->post('include_investment') && empty($investmentArray)): 
	
	    $this->errorMessage[] = "Please upload investment file";
	    return false;
	endif;            
	   
	/**
	 * @todo work out what happens when there is not investment upload
	 */

	$head = $investmentArray['head'];
	$content_array = $investmentArray['arrayData'];
	
	
	// we also want to make sure all the dates are the same. 
	// take the first record and compare against others
	//$firstRow = $investmentArray[0]['Valuation Date'];
	$firstRowInvestmentDate = $content_array[0]['Valuation Date'];
	
	// validate the csv header
	$expectedHeader =  array('Reference','Member','Amount','Valuation Date');
	if($head !== $expectedHeader):
	    $this->errorMessage[] = "The Column names do not match on the investment file";			     
	endif;


	if($firstRowInvestmentDate != $this->valuationDate):
	     $this->errorMessage[] = "The dates on the investment file does not match the valuation date";
	endif;

		    
	//stop upload if date on this investment file is same as the last upload
	$fileAlreadyUploaded = $this->client_investment_accessor->getInvestment_byDate($firstRowInvestmentDate);
	if(!empty($fileAlreadyUploaded)):
	    $this->errorMessage[] = "You may have already uploaded the investment file. please check date";			     
	endif;



	// prepare for batch insert
	  $batchInsert= array();
	
	//use the multi-dimentioanl to create insert if no errors
	if(!empty($content_array) && empty($this->errorMessage)):

	    foreach ($content_array as $key=>$val):                     

		$memberReference= $val['Reference'];
		$memberName= $val['Member'];
		$investmentdate = $val['Valuation Date'];
		$amount =  $val['Amount'];
			    
		$clientRecord =  $this->client_accessor->getByReference($memberReference);
		$clientID = (!empty($clientRecord) ? $clientRecord->clientID : 0);


		//stop upload is any of the reference does not exist in the portfolio table
		if(empty($clientRecord)):
		    $this->errorMessage[] = "Client - $memberName with reference $memberReference does not exist";			     

		endif;

		 //stop upload if the client does not have portfolio at all - clientHasPortfolio table

		if($this->portfolio_accessor->checkClientHasPortfolio($clientID) < 1):
		    $this->errorMessage[] = "Client- $memberName with reference $memberReference does not have portfolio set";			     

		endif;

		//stop upload if date mismatch
		if($investmentdate != $firstRowInvestmentDate):
		     $this->errorMessage[] = "Client - $memberName with reference $memberReference has an invalid valuation date";			     

		endif;	
                
                
                // if the amount is less than zero, check if the client has defined a portfolio for disinvestment/withdrawals
                if(($amount < 0) && ($this->portfolio_accessor->checkClientHasPortfolio($clientID, 'disinvestment') < 1)):
                     $this->errorMessage[] = "Client - $memberName with reference $memberReference has not defined a portfolio for disinvestments";			     

                endif;
                
                
			    
		$content['actionByUserID'] =  $this->current_userID;
		$content['dateOfAction'] = changeDateFormat('now', "Y-m-d", true);

		$content['clientReference'] = $memberReference;
		$content['amount'] = price_format_DB($amount);
		$content['investmentDate'] =  changeDateFormat($investmentdate, "Y-m-d");

		$content['clientID'] = $clientID;	   

		$batchInsert[] = $content;			   
	    endforeach; 

	endif;

	return $batchInsert;

	 
    }
    
      
   
    
    
    /**
     * once portfolio valuation have been added for a given date
     * and the client invetment have been added for the same date
     * we want to create transaction entries matching those date.
     * the transaction entres will be : for each of the portfolio, how many clients owe share in it
     * and for each of the split, how many are adding/widthdrawing.
     * 
     */
     //function createTransaction($valuationDate){
    private function _createTransactions(){
        /**
         * get all the portfolios valuation for a givrn date
         * forach of these portfolios, get the clients who have shares in it
         *  foreach of the client
         *      get how much they are investing/disinvesting for the given date above
         *      if this amount is greater that 0 === investing
         *          get from the client's portfolio the portfolio matching this where instruction_type is investing and the split info
         *          work out the transaction
         *      else if the amount is less than 0 === disinvesting
         *          get frm the client portfolio the portfolio matching this  where instruction type is disinvesting and the split info
         *          workout the transaction
         *          
         */
	
	 $valuationDate = changeDateFormat($this->valuationDate, 'Y-m-d');
	
	$portfolioList = $this->p_valuation_accessor->listValuation_byDate($valuationDate);
	
	if(!empty($portfolioList)):
	    foreach($portfolioList as $portKey=>$portVal):
	    
                $portfolioID = $portVal->portfolioID;
                $transactionDate = $portVal->portfolioValuationDate;
                $amountInvesting = floatval(0);
                $amountDisinvesting = floatval(0);


                /**
                 * we are creating two sets of transactions
                 * 1. the total money invested or disinesting on a portfolio
                 * 2. a breakdown of how the individual clients invest or disinvest in a given/each portfolio 
                 * because we would be matching the client transactions records to the portfolio transaction (portfolio) we want to
                 * link it by transaction ID. Now, wether a client is investing or not, whenevver portfolio valuation is uploaded , there
                 * has to be a transaction. so lets create a transaction record first for a given portfolio to get transactionID. 
                 * and if clients activities occur in the later in our calculation, we add the transactionID to the client's transaction
                 * 
                 * for a negative transaction i.e disinvestment/withdrawals, check the end of the script
                 */
                $newPortfolioTranx['transactionDate'] = $transactionDate;
                $newPortfolioTranx['portfolioID'] = $portfolioID;
                $newPortfolioTranx['transactionAmountInvesting'] = $amountInvesting;
                $newPortfolioTranx['transactionAmountDisinvesting'] = $amountDisinvesting;
                $invstTransactionID = $this->transaction_accessor->createPortfolioTransaction($newPortfolioTranx);

                // get the client that has this portfolio
                $clientsHavingPortfolioID = $this->portfolio_accessor->listAllClientsHavingPortfolioID($portVal->portfolioID);
		
         
	    if(!empty($clientsHavingPortfolioID)):
		foreach($clientsHavingPortfolioID as $ckey=>$clientHasPortfolioID):
		    
		    $clientID = $clientHasPortfolioID->clientID;
	    
		    // get amount client invested on this date
		    $clientInvestmentbyDate = $this->member_investment_accessor->getInvestment_byDate($valuationDate, $clientID);
                    

		    $amountInvestingOrDisinvesting = 0;
		    $percentageSplit = 0;

		    if(!empty($clientInvestmentbyDate)):
			$amountInvestingOrDisinvesting = floatval($clientInvestmentbyDate->amount);
		    endif;
                 
                    $newClientTranx = array();
			
                    // create a +ve transaction
                   // for investments, we set the transaction ID to $invstTransactionID 
                    if($amountInvestingOrDisinvesting >=0):
                        // get the portfio the client has chosen to investing in relating to this portfolioID
                        $portfolioInvestingIn = $this->portfolio_accessor->getClientPortfolio_ID($clientID, $portfolioID, 'investment');
                       // print_r($portfolioInvestingIn);
                        $percentageSplit = floatval($portfolioInvestingIn->percentageSplit);
                        $newAmount =    (($percentageSplit/100)*$amountInvestingOrDisinvesting);
                        
                        $newClientTranx['amountInvesting'] = round($newAmount, 10);
                        $newClientTranx['transactionID'] = $invstTransactionID;
                        
                        $amountInvesting += $newAmount;
                    endif;
                    
                    
                    // create a -ve transaction
                  //  for disinvestments, we set the transaction ID to 0 and update 
                    if($amountInvestingOrDisinvesting < 0):
                          // get the portfio the client has chosen to disinvesting in relating to this portfolioID
                        $portfolioDisInvestingIn = $this->portfolio_accessor->getClientPortfolio_ID($clientID, $portfolioID, 'disinvestment');
                        $percentageSplit = floatval($portfolioDisInvestingIn->percentageSplit);
                        $newAmount =    (($percentageSplit/100)*$amountInvestingOrDisinvesting);
                        
                        // lets save absolute value
                        $newClientTranx['amountDisinvesting'] = round(abs($newAmount), 10);
                        $newClientTranx['transactionID'] = 0;
                        
                        // already know this is a -ve value, but we want to be able to add these values
                        $amountDisinvesting += abs($newAmount);
                    endif;
                    
        
		    //create a batch list of client investing on this portfolio
		    $newClientTranx['clientID'] = $clientID;
		    $newClientTranx['portfolioID'] = $portfolioID;		
		    $newClientTranx['transactionDate'] = $transactionDate;
		    $newClientTranx['portfolioPercentSplit'] = $percentageSplit;
		   
                    
		    $this->transaction_accessor->createClientTransaction($newClientTranx);
		   
		endforeach;
	    endif;
		
		
                //now update the transaction record for this with the total amount investing into this portfolio

                $updatePortfolioTranx['transactionAmountInvesting'] = $amountInvesting;
                $updatePortfolioTranx['transactionAmountDisinvesting'] = 0;

                $updateWhere['transactionID'] = $invstTransactionID;
                $this->transaction_accessor->updatePortfolioTransaction($updatePortfolioTranx,$updateWhere);

            

                // create a seperate entry for disinvestment and update client transaction for transactionID =0
                // we are saying greater than 0 because we saved absolute value
                if($amountDisinvesting > 0):
                    $newPortfolioTranx['transactionAmountInvesting'] = 0;
                    $newPortfolioTranx['transactionAmountDisinvesting'] = $amountDisinvesting;

                    $disInvstTransactionID = $this->transaction_accessor->createPortfolioTransaction($newPortfolioTranx);

                    // update client transaction, set trnxID to this tranx ID where trnxID was 0
                    $this->transaction_accessor->updateClientTransaction(
                            array('transactionID'=>$disInvstTransactionID), array('transactionID'=>0));

                endif; // end $amountDisinvesting < 0
	
	    endforeach;
	endif;
	
	
    } 
    
    
 
    
    /**
     * at this time the portfolio valuation have uploaded
     * the member investment have been uploaded
     * we know which portfolio the member is has and what % share they have in each portfolio
     * The trasanction records have been created automatically when the member innvestment was uploaded
     * 
     * now a trasaction is received from fund manager quitter and we want to match what we have 
     * in the system with what fund manager is giving us. after which matching we select which should be added in a
     * caculating the price per unit of the pportfiolio
     */
    
    
    
    
    
    
    
    
}

