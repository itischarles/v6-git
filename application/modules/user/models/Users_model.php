<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Description of user_model
 *
 * @author trblap
 */
class Users_Model extends CI_Model{
 
    /**
     *
     * @var string $users_tbl
     * defines the users databse table 
     */
    private $users_tbl = 'users';
    
    function __construct() {
        parent::__construct();
    }
    
 
    
//    function getUser_customWhere($where){
//       // $this->db->cache_on();
//        $this->db->where(array('user_isActive'=>1));
//       //  $this->db->where('clientID >',0);
//        return $this->db->where($where)
//                ->get($this->users_tbl)
//                ->row();
//    }
    
//    function listUsers_customWhere($where, $limit = false){
//       
//         $this->db->where(array('user_isActive'=>1));
//        // $this->db->where('clientID >',0);
//         $this->db->group_by('userID');
//         
//         if($limit !== false):
//            $this->db->limit($limit);
//         endif;
//         
//        return $this->db->where($where)
//                ->get($this->users_tbl)
//                ->result();
//    }
    
    
    function getUserByID($user_id){
       return  $this->db->where(array('userID' => (int)$user_id,                               
                                   'user_isActive'=>1))
                ->get($this->users_tbl)
                ->row(); 
    }
    
    function getUserByUserLink($userLink){
       return  $this->db->where(array('user_userLink' => $userLink,                               
                                   'user_isActive'=>1))
                ->get($this->users_tbl)
                ->row(); 
    }
    
    
    function updateUser($content, $where){
        $this->db->where($where);
        $this->db->update($this->users_tbl,$content);
        
        return $this->db->affected_rows();
    }
   
     
    function addNewUser($content){
      
        $this->db->insert($this->users_tbl,$content);
        return $this->db->insert_id();
     
    }
    
    
    /**
     * logig and check if the user exist.
     * get the user by email since email/username is unique and verify the password 
     * e use password_hash function and password_verify function  - - both php functions
     * @param string $username
     * @param string $password
     * @return array
     */
     function verify_login_detail($username, $password){
        // echo $this->_prep_password('precious');
      
            $this->db->where(array('user_username' => $username,                                 
                                   'user_isActive'=>1));

            $user_details = $this->db->get($this->users_tbl, 1)->row();           
            
            
            if($user_details):               
                //if user does not have code kdon't login  
                if(empty($user_details->user_userLink)):                   
                    return false;
                
                elseif(password_verify($password, $user_details->user_password)):
                    
                    $this->session->set_userdata('userID', $user_details->userID);                  
                    $this->session->set_userdata('user_userLink', $user_details->user_userLink);
                    $this->session->set_userdata('Ajax_token', md5(changeDateFormat('now','jS-m-Y',true).$user_details->userID));
                    return true;
                else:
                    return false;                    
                endif;                 
               
            endif;      
         
            return false;
        }

   
        
//  function authenticate($userID = 0){
////      echo "<pre>";print_r($this->uri);
////      echo "</pre>";
//         $user_id = (!$userID) ? $this->session->userdata('userID') : $userID;
//         
//         $session_user_details = $this->getUserByID($user_id);
//         
//           if(empty($session_user_details)){
//                $this->session->set_userdata('uri_string', uri_string());
//		//echo base_url();
//		//return false;
//                redirect(base_url('login'));
//                //return false;
//                exit();
//            }
//
//            return true;
//    }
//    
    
    
        /**
     * get the client details and allows for pagination
     * @param array $where
     * @param int $limit
     * @param int $offset
     * @param bol $count if true, it means we want the num_rows
     * @return type
     */
    function searchUsers($where, $limit = 0, $offset=0, $count=false){
     
      
        $this->db->where($where);
	
	if($count === true):	
	    return $this->db->count_all_results("users");
	endif;   
	$this->db->group_by('users.userID');
        $this->db->limit( $limit,$offset);
        return $this->db->get($this->users_tbl)->result();
    }
    
    
    

    
    /**
     * logout user out without re-directing
     */
//    function logout_no_redirect(){
//        $this->session->unset_userdata('userID');
//        $this->session->unset_userdata('userCode');
//        $this->session->unset_userdata('fname');
//        $this->session->unset_userdata('lname');
//       // $this->session->unset_userdata('uri_string');
//    }
    

    
    /**
     * return a hash of the password
     * @param string $password
     * @return hash
     */
    function _prep_password($password){
        
        return  password_hash($password,PASSWORD_DEFAULT);
              
    }
    
  
    
    
    /*********LOGIN HISTRY********/
    function getLoginHistory($where){
         $this->db->cache_on();
         $this->db->limit(5);
        
        return $this->db->where($where)
                ->get('audit_logins')
                ->result();
        
    }
    
    
    function addLoginHistory($content){
        $this->db->inser('audit_logins',$content);
        return $this->db->inser_id();
    }
}