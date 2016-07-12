<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Form_validation extends CI_Form_validation
{
    public function __construct($rules = array()) {
        parent::__construct($rules);

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
   
   
   
   
   /**
    * valid_token
    * 
    * all forms must have the token hidden field sent and validated.
    * every user has ajax token displayed on the forms. when this forms are submitted
    * we validate against the session ajax token
    * @param string $postedToken
    * @return boolean
    */
   function valid_token($postedToken) {
        $this->set_message('valid_token', "Invalid Request!"); 
         
        if( $postedToken !== $this->session->userdata('Ajax_token')){
           // $this->form_validation->set_message('validateBankSortCode', "Invalid Sort Code: format MUST be 12-34-56");
          
            return false;
        }else{
            return true;
        }	
   }
   
   
   
   /**valid_CSV_fileType
    * we want to validate the file uploaded is a csv
    * 
    * @param string $postedFileType
    * @return boolean
    */
   function valid_CSV_fileType($postedFileType){
       
       echo"<pre>";
        print_r($postedFileType);
        echo "</pre>";
       
       $this->set_message('valid_CSV_fileType', "Invalid file uploaded!"); 
         
       $fileType = $_FILES[$postedFileType]['type'];
       $parts = explode('/', $fileType);
       if($parts[1] !== 'csv'){
          // return false;
       }
       
      // return true;
   }
    
}