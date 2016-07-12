<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Adviser_model
 *
 * @author itischarles
 */
class Adviser_model extends CI_Model{
    //put your code here
    
//    function __construct() {
//        parent::__construct();
//    }
    
    
   protected $mod = "AdviserModel";
    private $ifa_table = 'ifa';

    // Constructor =========================================================================================================
    function __construct() {
        parent::__construct();
        
    }

    // addNewAdviser function  ==================================================================
    function addNewAdviser($content) {
        $func = 'addNewAdviser($content)';

        try {
            $ret["success"] = false;

            $this->db->insert($this->ifa_table, $content);

            $ret["success"] = true;
            $ret["data"] = $this->db->insert_id();

            return (object) $ret;
        } catch (Exception $exp) {
            $ret["success"] = false;
            $ret["data"] = null;
            $ret["userMessage"] = "Exception occured in " . $this->mod . "->" . $func . ".";
            $ret["systemMessage"] = "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage();
            log_message('error', "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage());
            return (object) $ret;
        }
    }

    // updateCode($adviserID) function  ==================================================================
    function updateCode($adviserID) {
        $func = 'updateCode($adviserID)';

        try {
            $ret["success"] = false;

            $date = date_create();
            $unhashed = '' . $adviserID . '' . date_timestamp_get($date);
            $code = md5($unhashed);

            $content['ifaCode'] = $code;

            $this->db->where(" ifaID = " . $adviserID);
            $this->db->update($this->ifa_table, $content);

            $ret["success"] = true;
            $ret["data"] = $this->db->affected_rows();

            return (object) $ret;
        } catch (Exception $exp) {
            $ret["success"] = false;
            $ret["data"] = null;
            $ret["userMessage"] = "Exception occured in " . $this->mod . "->" . $func . ".";
            $ret["systemMessage"] = "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage();
            log_message('error', "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage());
            return (object) $ret;
        }
    }
    
    
    
    
    
    function getAdviserByUserID($user_id) {
        return $this->db
        ->where(array('userID' => (int) $user_id))
        ->get($this->ifa_table)
        ->row();
    }
    
   
    
     /**
     * get the list of available advisers for the firm.--------------------------------
     * This will use the user and ifa to find the records
     * @param int $firmID
     * @return all advisers  in the firm
     */
    function getAdvisersOfFirm($firmID, $limit = 0, $offset = 0, $count = false) {
        //for data
        $this->db->select('ifa.*');
        $this->db->select('users.user_fname, users.user_lname, users.user_username');
        
         //for query / filtering
        $this->db->join('users', 'ifa.userID = users.userID', 'LEFT');
        $this->db->join('ifa_ifa_role', 'ifa.ifaID = ifa_ifa_role.ifaID', 'LEFT');
        $this->db->join('ifa_role', 'ifa_role.ifaRoleID = ifa_ifa_role.ifaRoleID', 'LEFT');
      
        $this->db->where("ifa.firmID = $firmID" );

        if ($count === true){
            return $this->db->count_all_results($this->ifa_table);
        }        
        
        $this->db->group_by('ifa.ifaID');
        $this->db->limit($limit, $offset);
        
        return $this->db->get($this->ifa_table)->result();
    }
    
     
    /**
     * get the list of available typed adviser Ex. para-planners for the firm.-------------
     * This will use the ifa_role , ifa_ifa_role and ifa to find the records
     * @param int $firmID
     * @param int $roleCode 
     * @return all clients assigned to the given adiviser
     */
    function getAdvisersOfTypeForFirm($firmID, $roleCode , $limit = 0, $offset = 0, $count = false) {
        //for data
        
        $this->db->select('ifa_role.ifaRoleCode, ifa.*, users.user_fname,users.user_lname');
    
         //for query / filtering 
        $this->db->join('ifa_role', 'ifa_role.ifaRoleID = ifa_ifa_role.ifaRoleID', 'LEFT');
        $this->db->join('ifa', 'ifa_ifa_role.ifaID = ifa.ifaID', 'LEFT');
        $this->db->join('users', 'ifa.userID = users.userID', 'LEFT');
      
        $this->db->where("ifa.firmID = $firmID AND ifa_role.ifaRoleCode = '$roleCode'" );
        

        if ($count === true){
            return $this->db->count_all_results('ifa_ifa_role');
        }        
        
        $this->db->group_by('ifa.ifaID');
        $this->db->limit($limit, $offset);
        
        return $this->db->get('ifa_ifa_role')->result();
    }
    
    
    /**
     * Check if the Client is assigned to adviser.--------------------------------------
     * param $clicnetURL
     * param $adviserID (ifaID)
     * return 1 if assigned 0 otherwise
     */
    function isClientAssignedToAdviser($clientUrl, $ifaID  ){
        
        $this->db->select('count(ifa_client.ifaClientID) as rec_count');
        
         //for query / filtering 
        $this->db->join('ifa', 'ifa.ifaID = ifa_client.ifaID', 'LEFT');
        $this->db->join('clients', 'clients.clientID = ifa_client.clientID', 'LEFT');
        $this->db->where("ifa.ifaID = $ifaID AND clients.clientUrl = '$clientUrl'" );
       
        $rowCount = $this->db->get('ifa_client')->row()->rec_count;
        
        if ( $rowCount>0){return 1;}else{return 0;}
    }
     
     
    
    /**
     * Get Adviser record when the code is given.--------------------------------
     * Also join user record so we can show name etc.
     * @param string $adviserCode
     * @return single adviser matching the code
     */
    function getAdviserByCode($adviserCode) {
        //for data
        $this->db->select('ifa.*');
        $this->db->select('users.user_fname, users.user_lname, users.user_username');
        
         //for query / filtering
        $this->db->join('users', 'ifa.userID = users.userID', 'LEFT');

        $this->db->where("ifa.ifaCode = '$adviserCode'" );

        return $this->db->get($this->ifa_table)->row();
    }
    
    
    
    /**
     * Get all roles associated with an Adviser. ------------------------------
     * By joining ifa_ifa_role table.
     * And the ifa_role table.
     * 
     */
     function getAdviserRoles($adviserID) {
        //for data
        $this->db->select('ifa_role.*');
       
        //for query / filtering
        $this->db->join('ifa_ifa_role', 'ifa_role.ifaRoleID = ifa_ifa_role.ifaRoleID', 'LEFT');

        //where filter
        $this->db->where("ifa_ifa_role.ifaID = $adviserID" );

        return $this->db->get('ifa_role')->result();
    }
    
    
  
    /**
     * is_superAdviser
     * check if this adviser has a role of super adviser
     * @param int $adviserID
     * @return boolean
     */
    function is_superAdviser($adviserID){
        $adviserRoles = $this->getAdviserRoles($adviserID);
        $resp = array();
        
        if(!empty($adviserRoles)){
            foreach($adviserRoles as $key=>$adviserRole){
                if(strtoupper($adviserRole->ifaRoleCode) == "AS"){
                    $resp[] = 1;
                }
            }
        }
        
        if(count($resp) > 0){
            return true;
        }
        
        return false;
           
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
