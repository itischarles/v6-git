<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




function writeStatus($statusID){
    
    if((int)$statusID == 1):
        return "Active";
    elseif($statusID == 0):
        return "Inactive";
    endif;
}


/**
 * re write title.
 * add . to the end if not exist, and make change case to ucFirst
 * @param string $title
 */
function writeTitle($title){
    
    if(empty($title)):
        return "";
    endif;
    $title = strtolower($title);
    $title = trim($title);
    
    $whereIsDot = substr($title, -1);
    if($whereIsDot != "."):
        $title = $title.".";
    endif;
    
    return ucfirst($title);
}



/**
 * return a yes or a no depending on the status given
 * status 1 == yes
 * statusn 0 = no
 * @param int $status
 */
function yesOrNo($status){
    if((int)$status == 1):
        return "Yes";
    elseif($status == 0):
        return "No";
    endif;
}


/**
 * for any number given if less than 10, show 00number
 * if more than 9 and less than 99 show 0number
 * if greater than 99, return the number
 */
function prefixZeroToNumbers($number){
    $number = trim($number);
    if(strlen($number) > 2):
	return $number;
    endif;
    
    if($number < 10):
	return '00'.$number;
   elseif(($number < 100)&& ($number > 9)):
	return "0".$number;
   else:
       return $number;
    endif;
}



/**
 * write invoice status
 * if status  is 1 -just return draft, else if the invoice has passed draft stage chck
 * for overdue or paid date
 * @param int $statuID
 * @param date $dateAdded
 * @param date $dateDue
 * @param date $dateCompleted
 */
function writeInvoiceStatus($statusID, $dateDue,$dateCompleted){
    
    if($statusID == 1):
	return "Draft";
    endif;
    
    $dateCompleted = changeDateFormat($dateCompleted, "d M y");
    if(!empty($dateCompleted)):
	return "Paid on - $dateCompleted";
    endif;
    
    $date_diff = getDiffBetweenDates($dateDue, date('Y-m-d', strtotime('now')));
//    echo "<pre>";
//     print_r($date_diff);
//    echo "</pre>";
    if(($date_diff->invert == 0) && ($date_diff->days ==0)):
	return "open - due today";
     elseif($date_diff->invert == 0):
	return "overdue - due {$date_diff->days} day(s) ago";
	
    elseif($date_diff->invert == 1):
	return "open - due in {$date_diff->days} day(s)";
   
    endif;
   
    
}


/**
 * pagination text showing Page ".$cur_page." of ".$totalNumberOfPages;
 * $cur_page int cur_page
 * $per_page int number of items per page
 * $total_rows type total number of db rows
 * @return string of text
 */

  function show_pagination_text($cur_page, $per_page, $total_rows){
     $entriesUpToThisPage = $cur_page * $per_page;
     $totalNumberOfPages = ceil($total_rows/$per_page);
    
        if($entriesUpToThisPage > $total_rows){
            $entriesUpToThisPage = $total_rows;
        }
        elseif($entriesUpToThisPage == 0){
            $entriesUpToThisPage = $total_rows;
        }
        // display is : showing 23 of 400
    // return  "Showing ".( $entriesUpToThisPage)." of ". $total_rows." total results";
        
        // display page 3 of 4
        if($cur_page == 0):
            $cur_page = 1;
        endif;
        if($totalNumberOfPages == 0):
             $totalNumberOfPages = 1;
        endif;
      
        return "showing Page ".$cur_page." of ".$totalNumberOfPages;
    
    }
    
    
    
    function RecurringFrequency_toText($frequency){
	
    switch ($frequency) {
	case 1:
	    $period = "Yearly";
	    break;
	case 2:
	    $period = "Half yearly";
	    break;
	case 4:
	    $period = "Quarterly";
	    break;
	case 12:
	    $period = "Monthly";
	    break;
	default :
	    $period = "";
	    break;
    }
    
 
    return $period;
    }
    
    
    
    /**
     * convert a csv upload to multidimentional array.
     * take a csv file and convert it to multi-dimesioanl array
     */
    function convert_csvToMultiArray($csvFile){
        
	
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
    
    

?>