<?php

/* 
 * this will deal with foramating any monetary figures
 */






/**
 * 
 * @param float $amount moneytary value
 * @return float
 */

function price_format_DB($amount){
  return floatval(preg_replace('/[,£]/', '', $amount));

}



/**
 * we supply th time e.g 1:30 and price per hour. 
 * return the total charge for the time
 * @param string $time_qty
 * @param flaot $pricePerHour
 * @return float
 */
function getPriceForWorkDone($time_qty, $pricePerHour){
    $time_qty = str_replace('.', '', $time_qty);

    $timeParts = explode(":", $time_qty);
    $hour = ($timeParts[0] ? $timeParts[0] : 0);
    $minute =($timeParts[1] ?  $timeParts[1] : 0);
    
    $totalHours =  ($hour + ($minute/60));

    return ($totalHours * $pricePerHour);
}


?>