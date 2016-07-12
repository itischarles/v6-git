<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Email_libirary
 *
 * @author itischarles
 */
class Email_libirary extends CI_Email{
   
    /**
     *
     * @$invoice_details array 
     * store the details of the given given on which we want to send email
     */
    private $invoice_details;
    
    
    
	    
    function __construct() {

	/*
	 * SMTP option
	$config['protocol'] = 'smtp';
	$config['smtp_host'] = 'ssl://smtp.googlemail.com';
	$config['smtp_port'] = '465';
	$config['smtp_user'] = 'm';
	$config['smtp_pass'] = '';
	$config['smtp_timeout'] = '4';
	*/
	
	//SENDmail option
	$config['protocol'] = 'sendmail';
	$config['mailpath'] = '/usr/sbin/sendmail';
	
	
	$config['mailtype'] = 'html';	
	$config['charset'] = 'iso-8859-1';
	$config['wordwrap'] = TRUE;
	
	parent::__construct($config);
	
	
	
    }
    
    
    
    /**
     * Set Recipients
     *
     * @param	string
     * @return	CI_Email
     */
    public function to($to)
    {
	$to = $this->_replaceMessageShortCode($to);
	
	$to = $this->_str_to_array($to);
	$to = $this->clean_email($to);

	if ($this->validate)
	{
		$this->validate_email($to);
	}

	if ($this->_get_protocol() !== 'mail')
	{
		$this->set_header('To', implode(', ', $to));
	}

	$this->_recipients = $to;

	return $this;
    }
    
    
    /**
    * Set Email Subject
    *
    * @param	string
    * @return	CI_Email
    */
   public function subject($subject)
   {
        $subject = $this->_replaceMessageShortCode($subject);
	
	$subject = $this->_prep_q_encoding($subject);

	$this->set_header('Subject', $subject);
	
	   return $this;
   }

   	/**
	 * Set Body
	 *
	 * @param	string
	 * @return	CI_Email
	 */
	public function message($body)
	{
	    $body = $this->_replaceMessageShortCode($body);
	    
	    $this->_body = rtrim(str_replace("\r", '', $body));

	    /* strip slashes only if magic quotes is ON
	       if we do it with magic quotes OFF, it strips real, user-inputted chars.

	       NOTE: In PHP 5.4 get_magic_quotes_gpc() will always return 0 and
		     it will probably not exist in future versions at all.
	    */
	    if ( ! is_php('5.4') && get_magic_quotes_gpc())
	    {
		    $this->_body = stripslashes($this->_body);
	    }

	    return $this;
	}
     
   
   
	
	
	/**
	 * replace email shortcode in a given string
	 * @$string string string
	 * @return string
	 */
   private function _replaceMessageShortCode($string) {


       $string = str_replace("[invoice_reference]"  , prefixZeroToNumbers($this->invoice_details->invoiceID), $string);
       $string = str_replace("[invoice_total_value]", number_format($this->invoice_details->invoice_ground_total,2), $string);       
       $string = str_replace("[contact_title]"	    , $this->invoice_details->client_title, $string);
       $string = str_replace("[contact_first_name]" , $this->invoice_details->client_fname, $string);
       $string = str_replace("[contact_last_name]"  , $this->invoice_details->client_lname, $string);
       $string = str_replace("[contact_email]"	    , $this->invoice_details->client_email, $string);
       $string = str_replace("[product_provider]"   , $this->invoice_details->product_provider, $string);
       $string = str_replace("[provider_reference]" , $this->invoice_details->product_ref, $string);
       
       $string = str_replace("[provider_email]"	    , $this->invoice_details->product_provider_email, $string);
       $string = str_replace("[invoice_date]"	    , changeDateFormat($this->invoice_details->invoice_date,'jS F Y'), $string);
       $string = str_replace("[payment_due_date]"   , changeDateFormat($this->invoice_details->invoice_payment_due_date,'jS F Y'), $string);
       
       return $string;
   }
    
    
   
   /**
    * get the invoice details
    * @$invoiceID type int
    */
   function _getInvoice_details($invoiceID){
        
       $INV =& get_instance();
       $INV->load->model('Invoices_model');
       $invoice_model = new Invoices_model();
       
       $this->invoice_details = $invoice_model->getInvoiceDetailsByWhere(array('invoices.invoiceID'=>$invoiceID));
   
   }
}

   
/**
 * [invoiceID] => 1
    [users_userID] => 1
    [clients_clientID] => 1
    [invoice_date_created] => 2016-02-03
    [invoice_date] => 2016-02-03
    [invoice_payment_due_date] => 2016-03-04
    [invoice_paid_date] => 
    [invoice_date_completed] => 
    [invoice_additional_text] => Some additional texts
    [status_statusID] => 1
    [products_details_archive] => 
    [products_productID] => 1
    [invoice_ground_total] => 170.00
    [invoices_parent_invoiceID] => 
    [invoice_is_reoccuring] => 0
    [invoice_total_amount_paid] => 
    [clientID] => 1
    [client_title] => Mr.
    [client_fname] => charles
    [client_lname] => Okhuevbie
    [client_address_1] => 13, Charles Avenue
    [client_address_2] => 
    [client_address_3] => 
    [client_town] => My town
    [client_county] => My County
    [client_country] => United Kingdom
    [client_postcode] => CH1 1AR
    [client_isActive] => 1
    [client_reference] => 
    [clientUrl] => cfcd208495d565ef66e7dff9f98764da
    [client_bank_number] => 12345678
    [client_bank_sortcode] => 223344
    [client_bank_balance] => 1000.00
    [client_create_method] => web
    [client_date_created] => 2016-02-03
    [statusID] => 1
    [status_name] => Draft
    [status_isActive] => 
 * 
    [productID] => 1
    [product_name] => IM Optimum Growth
    [product_ref] => IMOPG1
    [product_provider] => Intelligent Money
    [productUrl] => cfcd208495d565ef66e7dff9f98764da
    [product_isActive] => 1
    [product_provider_address1] => The Shire Hall
    [product_provider_address2] => 
    [product_provider_address3] => 
    [product_provider_town] => Notts
    [product_provider_county] => Notts
    [product_provider_country] => UK
)
 */