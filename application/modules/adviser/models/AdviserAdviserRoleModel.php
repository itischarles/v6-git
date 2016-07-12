<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Adviser to Adviser Role Intermediate Model class
 * (to implement many to many between Adviser and Adviser Role)
 * @author Wajira Weerasinghe
 */
class AdviserAdviserRoleModel extends CI_Model 
{
    protected $mod="AdviserAdviserRoleModel";
    private $ifa_ifa_role_table = 'ifa_ifa_role';
    private $ifa_role_table = 'ifa_role';
    
    
    // Constructor =========================================================================================================
    function __construct(){ 
        
        parent::__construct();
        
        $this->load->model('AdviserRoleModel', 'adviser_role_accessor');
    }
	
    
    /**
     * Add Adviser to a role (Associate by intermidiate table) -----------------
     * add record to ifa_ifa_role table by 
     */
    function addAdviserRole($content)
    {
            $func = 'addAdviserRole($content)';
           

            try
            {
                    $ret["success"] = false;

                    $this->db->insert($this->ifa_ifa_role_table ,$content);

                    $ret["success"] = true;
                    $ret["data"] =  $this->db->insert_id();

                    return (object) $ret; 
            }
            catch (Exception $exp)
            {
                    $ret["success"] = false;
                    $ret["data"] =  null ;
                    $ret["userMessage"] =  "Exception occured in " .  $this->mod . "->" . $func . "." ;
                    $ret["systemMessage"] =  "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage();
                    log_message('error',  "Exception at " . $this->mod . "->" . $func . ": " . $exp->getMessage() );
                    return (object) $ret;
            }

    }
       
    
    
    /**
     * Check if the adviser is in a given role  -----------------
     * adviserID : ID of the adviser to check
     * roleCode: Code of the role to check Ex. Para Planner is 'AP'.
     * returns true if in role.
     */
    function isAdviserInRole($adviserID, $roleCode) {
        
        $this->db->select('`ifa_ifa_role`.`ifaID`');
        $this->db->join($this->ifa_role_table , $this->ifa_ifa_role_table . '.ifaRoleID = ' . $this->ifa_role_table . '.ifaRoleID', 'LEFT');

        $where[]= $this->ifa_ifa_role_table .  ".ifaID = $adviserID";
        $where[]= $this->ifa_role_table . ".ifaRoleCode = '$roleCode'";

        $filter = implode(" AND ", $where);

        $this->db->where($filter);

        $results = $this->db->get($this->ifa_ifa_role_table)->result();

        if(!empty($results))
        {
            return true;
        }else
        {
            return false;
        }
        
    }//end isAdviserInRole
    
	
    /**
    * Get all roles for an Adviser . -----------------------------------
    * adviserID : ID of the adviser to check
    * returns all roles for the adviser.
   */ 
    function getRolesForAdviser($adviserID) {
        
        $this->db->select('ifa_ifa_role.ifaID, ifa_role.*');

        $this->db->join($this->ifa_role_table , $this->ifa_ifa_role_table . '.ifaRoleID = ' . $this->ifa_role_table . '.ifaRoleID', 'LEFT');

        $where[]= $this->ifa_ifa_role_table .  ".ifaID = $adviserID";

        $filter = implode(" AND ", $where);

        $this->db->where($filter);

        $results = $this->db->get($this->ifa_ifa_role_table)->result();

        if(!empty($results))
        {
            return true;
        }else
        {
            return false;
        }
        
    }//end isAdviserInRole
    
		
    /**
     * Set Adviser Roles based on the input.
     * This will add/delete rows from intermediate table.
     * param $adviserID (ifaID)
     * param $isNormal, $isPara, $isSuper
     * returns nothing.
     */
    function setAdviserRoles($ifaID, $isNormal = '1' , $isPara = '0' , $isSuper = '0'  ){
        
        //Get the ids for saving
        $normalID = $this->adviser_role_accessor->getIDfromCode("AN");
        $PPID = $this->adviser_role_accessor->getIDfromCode("AP");
        $SuperID = $this->adviser_role_accessor->getIDfromCode("AS");
        
        //Clean by deleting all records
        $this->db->where('ifaID', $ifaID);
        $this->db->delete('ifa_ifa_role'); 

        //Now add specific roles if set. Adding normal
        $adata["ifaID"] = $ifaID;
        $adata["ifaRoleID"] = $normalID->data; 
        $this->db->insert('ifa_ifa_role', $adata);
        
        if(isset($isPara) && $isPara == '1')
        {
            //Now add specific roles if set. Adding normal
            $adata["ifaRoleID"] = $PPID->data; 
            $this->db->insert('ifa_ifa_role', $adata);
        }

        if(isset($isSuper) && $isSuper == '1')
        {
            //Now add specific roles if set. Adding normal
            $adata["ifaRoleID"] = $SuperID->data; 
            $this->db->insert('ifa_ifa_role', $adata);
        }
        
        return TRUE;
    }	
	
    

    
}// end of class
