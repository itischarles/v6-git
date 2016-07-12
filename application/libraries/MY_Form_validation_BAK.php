<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Form_validation extends CI_Form_validation
{
    public function __construct($rules = array()) {
        parent::__construct($rules);

    }
    
    
    
    /**
     * validate date. date has to be in format of dd-mm-YYYY
     * @param string $str
     * @param string $field
     * @return boolean
     */
    function valid_date($date) {
        $CI = get_instance();

        $date_parts = explode('-', $date);
        
        $this->set_message('valid_date', "Invalid date : Format MUST be dd-mm-yyyy");
        
        if(count($date_parts) < 3):
            return false;
        endif;
        
       // print_r($date_parts);
        $day = $date_parts[0];
        $month = $date_parts[1];
        $year = $date_parts[2];

        if(!checkdate($month, $day, $year)):
             return false;
        endif;
        
        return true;
    } 

    
    
    function valid_date_format($str)
    {
        $CI = get_instance();
        $CI->form_validation->set_message('valid_date_format',
                                          '%s is not valid.');

        if($str && (($timestamp = strtotime($str)) === false))
        {
            return false;
        }

        return true;
    }
    
    
    
    function validProduct($productID){
        $CI = get_instance();

        $CI->form_validation->set_message('validProduct',
                                          'Your chosen product does not appear to be valid!');

        $CI->db->where('productID', $productID);
       
        if($CI->db->count_all_results('products') < 1):
            return false;
        endif;
        
        return true;
    }
    
    
    /**
     * check whether the product you are linking to this client is already linked
     * 
     * @return boolean
     */
    //products_productID.$clientID
     function clientProduct_exist($products_productID){
        $CI = get_instance();
	
	$clients_clientID =  $CI->input->post('clients_clientID');
	
        $CI->form_validation->set_message('clientProduct_exist',
                                          'This product has already been linked');

        $CI->db->where('products_productID', $products_productID);
	$CI->db->where('clients_clientID', $clients_clientID);
       
        if($CI->db->count_all_results('clients_products') > 0):
	   // echo $CI->db->count_all_results('clients_products');
            return false;
        endif;
        
        return true;
    }
    
    
    
    
    
    /**
     * the payment made on an invoice, check is equal to the invoice total amount
     */
    function validateAmountPaid(){
	 $CI = get_instance();
	 $invoiceAccessor = new Invoices_model();
	 
	$invoiceID = (int)$CI->input->post('invoiceID');
	$total_amount_paid = price_format_DB($CI->input->post('total_amount_paid'));
	
	$invoiceDetails = $invoiceAccessor->getInvoiceByID($invoiceID);
	
	if(empty($invoiceDetails)):
	    $CI->form_validation->set_message('validateAmountPaid','Some invalid selection detected. Please review and try again'); 
		
	elseif($total_amount_paid > $invoiceDetails->invoice_ground_total):
	     $CI->form_validation->set_message('validateAmountPaid',
                                          'Total amount cannot be more than the outstanding invoice value of £'.  number_format($invoiceDetails->invoice_ground_total,2)); 
	elseif($total_amount_paid < $invoiceDetails->invoice_ground_total):
	     $CI->form_validation->set_message('validateAmountPaid',
                                          'Total amount cannot be less than the outstanding invoice value of £'.  number_format($invoiceDetails->invoice_ground_total,2)); 
	 endif;
	 
       if($total_amount_paid != $invoiceDetails->invoice_ground_total):
	    return false;
       endif;
                
        return true;
	

    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    function valid_birth_date($str, $field)
    {
        $CI = get_instance();
        $CI->form_validation->set_message('valid_birth_date', '%s is not valid.');
        
        $day = (int)$CI->input->post($field . '_day');
        $month = (int)$CI->input->post($field . '_month');
        $year = (int)$CI->input->post($field . '_year');
    
        $today = strtotime(date("Y-m-d"));
        $birthday = strtotime($year.'-'.$month.'-'.$day);
        $year1900 = strtotime('1900-01-01');
        if($birthday!==false && ($today>=$birthday) && ($year1900 < $birthday))
        {
            return true;
        }
    
        return false;
    }
        
    function valid_birth_date_format($str)
    {
        $CI = get_instance();
        $CI->form_validation->set_message('valid_birth_date_format', '%s is not valid.');
        $today = strtotime(date("Y-m-d"));
        $birthday = strtotime($str);
        $year1900 = strtotime('1900-01-01');
        if($birthday!==false && ($today>=$birthday) && ($year1900 < $birthday) )
        {
            return true;
        }
    
        return false;
    }
    function unique($value, $params)
    {
        $CI = get_instance();

        $CI->form_validation->set_message('unique',
                                          '%s is not available.');

        list($table, $field) = explode(".", $params, 2);

        $CI->db->where($field, $value);

        return !$CI->db->count_all_results($table);

    }

    function uniqueUsername($value)
    {
        $CI = get_instance();

        $CI->form_validation->set_message('uniqueUsername',
                                          'That username is not available');

        $ifaPartnerID = $CI->input->post('partnerID');
        $ifaStaffID = $CI->input->post('staffID');

        if($ifaStaffID)
        {
            $CI->db->where('ifaStaffID !=', $ifaStaffID);
        }
   

        $CI->db->where('username', $value);
        //$CI->db->where('ifaPartnerID', $ifaPartnerID);

        return !$CI->db->count_all_results('ifa_staffmember');

    }

    function uniqueEdit($value, $params)
    {
        $CI = get_instance();

        $CI->form_validation->set_message('uniqueEdit',
                                          '%s is not available.');

        list($table, $field) = explode(".", $params, 2);

        $CI->db->where($field, $value);

        $ifPartnerID = $CI->input->post('ifaPartnerID');

        $CI->db->where('ifaPartnerID !=', $ifPartnerID);

        return !$CI->db->count_all_results($table);

    }
    
    
     /**
     * validate bankSortCode as given in the staff atributes
     * sort code must be in the format 12-34-56
     * @param string $sortCode
     * @return boolean
     */
     function valid_SortCode($sortCode){    
         $this->set_message('valid_SortCode', "Invalid Sort Code : Format MUST be 12-34-56"); 
         
        if( !preg_match("/^(\d{2})-(\d{2})-(\d{2})$/", $sortCode)){
           // $CI->form_validation->set_message('validateBankSortCode', "Invalid Sort Code: format MUST be 12-34-56");
          
            return false;
        }else{
            return true;
        }	
    }
}