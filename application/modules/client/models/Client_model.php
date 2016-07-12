<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Client_model
 *
 * @author itischarles
 */
class Client_model  extends CI_Model{
    //put your code here
     private $clients_tbl = 'clients';
     private  $current_userID;
     
    function __construct() {
        parent::__construct();
        
         $this->current_userID = $this->session->userdata('userID');
        
    }
    
    
    
    
    
    function addNew($content){
        
        $this->db->insert($this->clients_tbl,$content);
        return $this->db->insert_id();
    }
    
    function updateClient($content, $where){
        $this->db->where($where);
        $this->db->update($this->clients_tbl, $content);
        return $this->db->affected_rows();
    }
    
    function getByUrl($clientUrl){	
        $this->db->where(array('clientUrl'=>$clientUrl));
        return $this->db->get($this->clients_tbl)->row();
    }
    
    
    function getByReference($reference){	
        $this->db->where(array('client_reference'=>$reference));
        return $this->db->get($this->clients_tbl)->row();
    }
    
    
    function getClientByID($clientID){
        $this->db->where(array('clientID'=>(int)$clientID));
        return $this->db->get($this->clients_tbl)->row();
    }
    
 
    
     function getClientDetailsByWhere($where = false){      

        if($where !== false):
            $this->db->where($where);
        endif;
        
        return $this->db->get($this->clients_tbl)->row();
    }
    
    
    function listClientByWhere($where = false){  

        if($where !== false):
            $this->db->where($where);
        endif;
        
        return $this->db->get($this->clients_tbl)->result();
    }
    
    
    function checkClientIsUnique($where){
	$this->db->or_where($where); 
	return $this->db->count_all_results($this->clients_tbl);
    }
    
    
    
    /**
     * get the client details and allows for pagination
     * @param array $where
     * @param int $limit
     * @param int $offset
     * @param bol $count if true, it means we want the num_rows
     * @return type
     */
    function searchClient($limit = 0, $offset=0, $count=false){
     
        $this->load->model('adviser/Adviser_model', 'adviser_model_accessor');

        $client_name  = ($this->input->get_post('client_name') ? $this->input->get_post('client_name') : '');
	$client_ref  = ($this->input->get_post('client_ref') ? $this->input->get_post('client_ref') : '');
	$postcode  = ($this->input->get_post('postcode') ? $this->input->get_post('postcode') : '');
	$client_ni  = ($this->input->get_post('client_ni') ? $this->input->get_post('client_ni') : '');
      
        $where_search = array();
	
	if(!empty($client_name)){
	    // it is possible foirst name and last name is supplied
	     $names = explode(' ', $client_name);

	     $name_part1 = $name_part2= '';

	     $name_part1 = "(clients.client_fname like '{$names[0]}%' OR "
			. "clients.client_lname like '{$names[0]}%' )";
	    if(isset($names[1])){
		  $name_part2 = "AND (clients.client_fname like '{$names[1]}%' OR "
			. "clients.client_lname like '{$names[1]}%' )";
            }
            
	    $where_search[] = "$name_part1 $name_part2";
        }
    
	if(!empty($client_ref)){
	     $where_search[] = "(clients.client_reference like '$client_ref%')";
        }
	if(!empty($postcode)){
	     $where_search[] = "(clients.client_postcode like '$postcode%')";
        }
	if(!empty($client_ni)){
	     $where_search[] = "(clients.client_NI like '$client_ni%')";
        }
      
        /// check if the currently logged in user is an adviser
        /**
         * if an adviser
         *      then check if super adviser
         *          if usuper adviser : get the clients in this firm
         *          else : get the client for this adviser only
         * 
         * else
         *      get the list of clients
         */
        
        $adviser = $this->adviser_model_accessor->getAdviserByUserID($this->current_userID);
        if(!empty($adviser)):
            
            $superAdmin = $this->adviser_model_accessor->is_superAdviser($adviser->ifaID);
            
            $this->db->join('ifa i2', "{$this->clients_tbl}.adviser_adviserID = i2.ifaID", 'LEFT');
            $this->db->join('ifa_firm if2', 'i2.ifaID = if2.firmID', 'LEFT');
            $this->db->join("ifa_client ic2", "ic2.ifaID = i2.ifaID", 'LEFT');
            
            if($superAdmin){
                $where_search[] = "(if2.firmID = {$adviser->firmID})";
            }
        
            else{               
                
                $where_search[] = "(ic2.ifaID = {$adviser->ifaID})";
            }
        endif;
        
          
	if(empty($where_search)):
	    return false;
	endif;
	
	$filter = implode(" AND ", $where_search);

	$this->db->where($filter);
	
	if($count === true):	
	    return $this->db->count_all_results($this->clients_tbl);
	endif; 
        
	$this->db->group_by('clients.clientID');
        $this->db->limit( $limit,$offset);
        return $this->db->get($this->clients_tbl)->result();
    }
    
    

      /**
     * get the client details for a given firm.
     * This uses all advisers of the firm and then find their clients.
     * @param int $firmID 
     * @return all clients of the firm (if all adversers of the firm)
     */
    function getClientsOfFirm($firmID, $limit = 0, $offset = 0, $count = false) {
        ///for data
        $this->db->select('clients.*');
      //  $this->db->select('titles.titleName');
        $this->db->select('users.user_fname, user_lname');

        
       // $this->db->join('titles', 'clients.titleID = titles.titleID', 'LEFT');
        $this->db->join('ifa i2', 'clients.adviser_adviserID = i2.ifaID', 'LEFT');
        $this->db->join('users', 'i2.userID = users.userID', 'LEFT');
        
        //joins for query / filtering
        $this->db->join('ifa', 'clients.adviser_adviserID = ifa.ifaID', 'LEFT');

        $this->db->where("ifa.firmID = $firmID");

       if ($count === true){
            return $this->db->count_all_results($this->clients_tbl);
        }

        $this->db->group_by('clients.clientID');
        $this->db->limit($limit, $offset);
        
        
        return $this->db->get($this->clients_tbl)->result();
    }
    
    
    
    
    
    function export_clients($file_path, $where = false, $limit = false){
       
        $query = "
        SELECT       
          'Ref', 'Account No', 'First Name', 'Last Name', 'Address Line 1', 'Address Line 2',
          'Address Line 3', 'Town/City', 'County', 'Postcode', 'Country', 'IFA/Company ID',
          'Invoice Name', 'Invoice Addresss Line 1', 'Invoice Addresss Line 2', 'Invoice Addresss Line 3',
          'Invoie Town/City', 'Invoice County/State', 'Invoice Postcode/Zip', 'Invoice Country'         
        
       UNION ALL
        SELECT 
         client_reference, client_accountNo, client_fname, client_lname, client_address_1, client_address_2,
         client_address_3, client_town, client_county, client_postcode, client_country, client_company_companyID,
         invoice_name, invoice_address_line1, invoice_address_line2, invoice_address_line3,
         invoice_town_city,invoice_county, invoice_postcode, invoice_country
         
        INTO OUTFILE '$file_path'
        FIELDS TERMINATED BY ','
        ENCLOSED BY '\"'
        ESCAPED BY ' ' 
        LINES TERMINATED BY '\n'
       
        FROM clients ";        
          
      
        if($where !== false):
           $query.=$where;
        endif; 
        
      $query.= "  GROUP BY clients.clientID  ";
      
      if($limit !== false):
            $query.= " limit $limit";
        endif; 

      $this->db->query($query);
     
    }
}

