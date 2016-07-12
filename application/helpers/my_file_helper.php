<?php




    /**
     * prepare a csv docment from arrays and save them to csv to a file. return the link
     * @param arrayarray $content
     * @param type $heading
     * @return link
     */
    function fileHelp_writeToCSV( $content, $fileName = "file-csv"){
      ini_set('memory_limit', '128M');      
     
        
        $file_path =  fileHelp_mkdir('downloads'); // create the downloads directory
        
        $file_link =  $file_path.DIRECTORY_SEPARATOR.$fileName.".csv";
    
        $fp = fopen($file_link,"w");
    
        foreach ($content as $fields=>$field_val) {
        
           $field_val = array_map('trim', $field_val);
           
           //fputcsv($fp, $field_val, ',',' ');
           fputcsv($fp, $field_val);
        }
        
        fclose($fp);
        unset($content); // free memory used
        
        return base_url("downloads/$fileName.csv");
    }
    
    
    
    /**
     * permission problems for files already created by user. lets allows php to create its own file
     * @param type $dir_name
     */
    function fileHelp_mkdir($dir_name){
        $dir_name =  realpath('.').DIRECTORY_SEPARATOR. $dir_name;
       
         if (file_exists($dir_name)) {            
             // do nothing
        } else {
            $oldmask = umask(0);  // helpful when used in linux server  
            mkdir($dir_name, 0777);  
            umask($oldmask);
           
        }

        return $dir_name;
    }
    
  
    
    
    /**
     * unlink file
     * @param string $filepath path to file
     */
    function fileHelp_unlink_file($filepath){
        if(file_exists($filepath)):
              unlink($filepath);
          endif;
    }
    
    

     
      /**
     * save failed uploads to csv 
       * combine csv and write to file. return th link to the file
     * @param array $failedUpload
     */
    function fileHelp_saveFailedUpload($header, $failed_upload){
        
        if(empty($failed_upload)):            
            return false;
        endif;
        
        $acutal_csv_array[] = $header;
       $combineArray = array_merge($acutal_csv_array,$failed_upload);

       $link =  fileHelp_writeToCSV($combineArray);
       return $link;
         
    } 
    
    
    
    
      /**
     * save failed uploads to csv
     * @param array $failedUpload
     */
    function fileHelp_buildCsvFromArray($csv_header, $csv_body){
        
        if(empty($csv_body)):            
            return false;
        endif;
//        
//        $acutal_csv_array[] = array('Title', 'First Name', 'Last Name', 'Address Line 1', 'Address Line 2', 'Address Line 3', 
//      'Town','County', 'Postcode', 'Country', 'Bank Account Number', 'Bank Sortcode', 'Account Balance','IProduct ID','Invoicing Date',);

	$header[] = $csv_header; 
       $combineArray = array_merge($header,$csv_body);
//       echo "<pre>";
//       print_r($combineArray);
//       echo "</pre>";
       $link =  fileHelp_writeToCSV($combineArray);
       return $link;
         
    }
?>