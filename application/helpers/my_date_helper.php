<?php

/* 
 * format dates how ever you want
 */



/**
 * display now with a given format
 */
/**
 * return date format as dd-mm-yy
 */
function changeDateFormat($date, $format = "d-m-Y", $showTimestamp = false){
    
    if(empty($date)):
        return false;
    endif;
    
    $date = str_replace('/', '-', $date);
    
     $date_temp = date_format(date_create($date),'d-m-Y');
    
     
     if(empty($date_temp) || ($date_temp == "-0001-11-30" ) || ($date_temp == "30-11--0001")):
         return "";
     endif;
     
    if($showTimestamp === false):
        return date_format(date_create($date),"$format");
    endif;
      
   
    return date_format(date_create($date),"$format H:i:s");       
}




/**
 * frequency
 *  1 = annually
    2 = half yarly
    4 = quartely
    12 = monthly
 * submit a date and frequency , generate next reoccuredate
 */
function getInvoiceNextReoccureDate($date, $frequency){
    if(empty($date) || (int)$frequency == 0):
        return false;
    endif;
    
    $date = changeDateFormat($date, 'Y-m-d');
    
    switch ($frequency) {
	case 1:
	    $period = "P12M";
	    break;
	case 2:
	    $period = "P6M";
	    break;
	case 4:
	    $period = "P4M";
	    break;
	case 12:
	    $period = "P1M";
	    break;
	default :
	    $period = "P1M";
	    break;
    }
    
    $date = new DateTime($date);
    $date->add(new DateInterval($period));

    return $date->format('Y-m-d');


}


  /**
     * return the total number of months between two dates
   * lower date as date 1 and higher/bigger date as date 2
   * the invert  == 1 it means you enter the date the other way around. i.e date 1 is bigger than date 2
     * @param date date1 first date == lower date
     * @param date date2 second date == higher date
      * @return object all the possible differences obj->m, obj->y etc
     */

    function getDiffBetweenDates($date1, $date2){
       if(empty($date1) && (!empty($date2))):
            return "";
        endif;
        
       if(($date1 == "1970-01-01") || ( $date2 == "1970-01-01")):          
            return "";           
       endif;
       
       $is_valid_date1= date_create($date1);
         if(empty($is_valid_date1)|| (date_format($is_valid_date1,'Y-m-d') == "-0001-11-30" )):
          return '';
         endif;
         
        $is_valid_date2= date_create($date1);
         if(empty($is_valid_date2)|| (date_format($is_valid_date2,'Y-m-d') == "-0001-11-30" )):
          return '';
         endif;
      
            
        $date1=date_create("$date1");
        $date2=date_create("$date2");
        
        return date_diff($date1,$date2);
    
    }
    
    
    
    /**
     * add days , months or years to a given date
     * @param date $date
     * @param int $days
     * @param int $months
     * @param int $years
     */
    function addToDate($date, $days = 0, $months = 0, $years=0){
	
	$date = changeDateFormat($date, 'Y-m-d');
	$date = new DateTime($date);
	
	$days	=  "P".$days."D";
	$months =  "P".$months."M";
	$years =  "P".$years."Y";
	
	$date->add(new DateInterval($days));
	$date->add(new DateInterval($months));
	$date->add(new DateInterval($years));
	
	return $date->format('Y-m-d');
    }

?>