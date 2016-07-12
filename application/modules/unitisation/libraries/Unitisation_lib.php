<?php



/**
 * Description of Unitisation_lib
 *
 * @author itischarles
 */
class Unitisation_lib {

    private $portfolio_accessor;
     private $unitisation_accessor;
    private $p_valuation_accessor;
     private $client_accessor = "";
    
    function __construct() {
	//parent::__construct();
	
//	$this->load->model('unitisation/portfolio_model');
//	$this->load->model('unitisation/Portfolio_valuation_model');
//	$this->load->model('unitisation/Unitisation_model');
//	
//	$this->portfolio_accessor = new Portfolio_model(); 
//	$this->p_valuation_accessor = new Portfolio_valuation_model();
//	//$this->transaction_accessor = new Transaction_model();
//	$this->client_accessor = new Client_model();
//	
//	$this->unitisation_accessor = new Unitisation_model();
       
    }
    
    
     /**
    * __get
    *
    * Enables the use of CI super-global without having to define an extra variable.
    *
    * I can't remember where I first saw this, so thank you if you are the original author. -Militis
    *
    * @access	public
    * @param	$var
    * @return	mixed
    */
    public function __get($var){
            return get_instance()->$var;
    }
    
    
    function getPortfolioUnitisationDetails($portfolioID =0, $unitisationDate){
	
	$response['portfolioID']    = $portfolioID;
	$response['valuationDate'] = '';
	$response['pricePerUnit']    = '0.00';
	$response['numberOfUnits']    = '0.00';
	$response['valueOnUpload'] ='0.00';
	$response['unitisationValue'] ='0.00';
	//$response['value_basedOnUnits'] ='0.00';
	$response['RunDate']  = '';
	
	//echo $unitisationDate. " == " .addToDate($unitisationDate, 0,0,0)." === ". addToDate($unitisationDate, 1,0,0);
	//echo "<br/>";
	
	$unitisationDate = changeDateFormat($unitisationDate, 'Y-m-d');
	
	// because we are given a definate date, 
	// and our function is actually looking for a date prior to the given, lets add one day to the given date
	$unitisationDate = addToDate($unitisationDate, 1);
        //echo $unitisationDate;
	
	// get the unitisation for portfolio by date and porfolio ID
	$unitisationDetails = $this->unitisation_accessor->getPortfolioUnitisation_byRunDate($portfolioID, $unitisationDate);
//       echo "<pre>";
//       echo $portfolioID." == ". $unitisationDate;
//        print_r($unitisationDetails);
//        echo "</pre>";
//	
//        return $response;
	if(!empty($unitisationDetails)):
	    $response['portfolioID']    = $portfolioID;
	    $response['valuationDate']  = changeDateFormat($unitisationDetails->valuationDate);
	    $response['pricePerUnit']    = number_format($unitisationDetails->pricePerUnit, 5);
	    $response['numberOfUnits']    = number_format($unitisationDetails->numberOfUnits, 5);
	    $response['unitisationValue']    = number_format(($unitisationDetails->numberOfUnits * $unitisationDetails->pricePerUnit), 5);
	    $response['RunDate']  = changeDateFormat($unitisationDetails->unitisationRunDate);
	endif;
	
	// use the valuation date on this unitisation record to fetct the corresponding valuation recrod
	if(!empty($unitisationDetails)):
	    $portfValuationDetails = $this->p_valuation_accessor->getValuation_byDate($unitisationDetails->valuationDate, $portfolioID);
	    
	    $response['valueOnUpload']    = number_format($portfValuationDetails->portfolioValuationValue, 2);
	endif;

	return $response;
    }
    
    
    
    
    
    
    /**
     * this is meant to take a client's ID and return total investments, 
     */
    function getClientUnitisationDetails($clientID, $unitisationDate){
	
	
	$unitisationDate = changeDateFormat($unitisationDate, 'Y-m-d');
	
	// because we are given a definate date, 
	// and our function is actually looking for a date prior to the given, lets add one day to the given date
	$unitisationDate = addToDate($unitisationDate, 1);
	
        /*lets list all the portfolio this client is using for inestments. we don't bother with the onces used for disinvestments        
         * because all disinvestment portfolio MUST be present in the investments portfolios but not are invstments portfolio may be
         * used for diinvestments. i.e the client could be investing in 3 portfolios but choses to widthraw from just one
         */
	$clientPortfs = $this->portfolio_accessor->listClientPortfoliosForInvestment($clientID);

	
	$report = array();
	$client_unitisation_breakdown= array();
	$clientTotalUnits = 0;
        $valuation_date = '';
	
	if(!empty($clientPortfs)):
	    
	    foreach($clientPortfs as $k=>$c_ports):
	    
		$portfolioID = $c_ports->portfolioID;
		
		
		$temp['portfolioReference'] = $portfolioReference = $c_ports->portfolioReference;
		//$temp['portfolioName'] = $c_ports->portfolioName;
		$temp['percentageSplit'] = $percentageSplit = $c_ports->percentageSplit;
		$temp['portfolioID'] = $portfolioID;
		
		// get the unitisation for portfolio by date and porfolio ID
		$c_unitisationDetails = $this->unitisation_accessor->getClientUnitisation_byRunDate($clientID, $portfolioID, $unitisationDate);
		$c_unitPrice = (!empty($c_unitisationDetails)? $c_unitisationDetails->pricePerUnit: 0);
		$c_numOfUnits = (!empty($c_unitisationDetails)? $c_unitisationDetails->numberOfUnits: 0);
		
		//$temp['totalUnitsInPortfolio'] = number_format($p_unitisation_numOfUnits,2);
		$temp['pricePerUnit'] = number_format($c_unitPrice ,5);
		$temp['numOfUnits'] = number_format($c_numOfUnits,5);
		$temp['holdings'] = number_format(($c_unitPrice*$c_numOfUnits),5);
                
                // we can overite it in the loop, it is always the same
                $valuation_date = (!empty($c_unitisationDetails)? changeDateFormat($c_unitisationDetails->valuationDate, 'jS M Y'): '');
		
                $unitisationRunDate = (!empty($c_unitisationDetails)? changeDateFormat($c_unitisationDetails->unitisationRunDate, 'jS M Y'): '');		
		
                 $clientTotalUnits +=$c_numOfUnits ;
		
	
	
		$client_unitisation_breakdown[$portfolioReference] = $temp;
		
	    endforeach;
	    
	    $report['valuationDate'] = $valuation_date;
            $report['unitisationRunDate'] = $unitisationRunDate;
	    $report['clientTotalUnits'] = number_format($clientTotalUnits,5);
	    $report['unitisationDetails'] = $client_unitisation_breakdown;
	    
	endif;
//	
	return $report;
    }
    
    
   
    
    /**
     * convert a csv upload to multidimentional array.
     * take a csv file and convert it to multi-dimesioanl array
     */
    function unit_csvToMultiArray($csvFile){
        
	
	$content_array = array();// store the arrray
	
	$csvData = file_get_contents($csvFile);
	if(empty($csvData)):
	    return $content_array;
	endif;
	
	
	$lines = explode(PHP_EOL, $csvData);
	$head = str_getcsv(array_shift($lines));
	
	//remove empty line
	
	foreach($lines as $key=>$line):	
	   // print_r($line);
	    if(empty($line)):			
		unset($lines[$key]);
	    endif;
	endforeach;  

	//create a multidimentional array
	$arrayData = array();
	foreach ($lines as $line) {
	    $arrayData[] = array_combine($head, str_getcsv($line));
	}
	
	
	$content_array['head'] = $head;
	$content_array['arrayData'] = $arrayData;
	return $content_array;
    }
    
    
    
}
