<?php

/*
 * this controller manages users except advisers
 * the index will display the dashboard of the curreently logged in user
 */

/**
 * Description of Users
 *
 * @author itischarles
 */
class User extends MY_Controller{
    //put your code here
    
    private $userDetails;

    protected $auth_lib;
            
    function __construct() {
        parent::__construct();

      //  $this->user_accessor = new Users_Model();
      $this->auth_lib = new Auth_lib();
      $this->auth_lib->is_authenticated();
      
      $this->load->module('template');
      

     
    }
    
    
    
    function index($userLink = ''){
        
        $userLink = (!empty($userLink) ? $userLink : $this->userLink);
        $this->userDetails  = $this->user_accessor->getUserByUserLink($userLink);

        $data['page_header'] = "Users Profile";
        $data['content_view'] = "user/profile";
       // $data['sidebar_view'] = "user/display_sidebar";
        $data['user'] = $this->userDetails;
        $data['page_title'] = "Search Users";
       
        // we load the roles javascript so we can use ajax to update users' roles
        $data['mod_js'][] = Modules::run('roles/getModule_js');
        
    
	// add breadcrumbs
	$this->breadcrumbs->push('User', '/user/'.$userLink);
	$this->breadcrumbs->push('Profile', '/');
 
        $this->template->callDefaultTemplate($data);
    }
    
    
    
    
    function profile_form_widget($userLink = ''){
        $userLink = (!empty($userLink) ? $userLink : $this->userLink);
        $this->userDetails  = $this->user_accessor->getUserByUserLink($userLink);
       
         $data['mode'] = "edit";
         $this->load->view('user/profile-form-widget', $data);
 
    }
    
    
    
    function update($userLink = ''){  
        
        $this->userDetails  = $this->user_accessor->getUserByUserLink($userLink);
//        if(empty($this->userDetails )){
//            return false;
//        } 
        
     
//        if (!$this->input->is_ajax_request() ):
//	     $this->session->set_flashdata('message', 'Invalid request');
//             $this->session->set_flashdata('type', 'flash_error');
//             redirect($_SERVER['HTTP_REFERER']);
//	endif;
      
        if($this->input->post('edit_user') && (!empty($this->userDetails))){
	  
            $this->form_validation->set_rules('fname', 'First name', 'trim|required');
            $this->form_validation->set_rules('lname', 'Last name', 'trim|required');
       
           // $this->form_validation->set_rules('user_password', 'Town', 'trim|required');
            
          //  $this->form_validation->set_rules('user_username', 'Username', 'trim|required|is_unique[users.user_username]');
         
             if($this->form_validation->run()){
                $content['user_fname'] = $this->input->post('fname');
                $content['user_lname'] = $this->input->post('lname');
                
                $content['user_title'] = $this->input->post('user_title');
                $content['user_aboutMe'] = $this->input->post('user_aboutMe');
               // $content['user_regDate'] = changeDateFormat('now', "Y-m-d");
                   
                //$page_from = $this->input->post('page');
                   
                $user_password = trim($this->input->post('user_password'));
                if(!empty($user_password)):
                    $content['user_password'] = $this->user_accessor->_prep_password($user_password);
                endif;

                echo $this->user_accessor->updateUser($content, array('userID'=>$this->userDetails->userID));
           
                
                $this->session->set_flashdata('validation_message', 'user updated Successfully');
                $this->session->set_flashdata('type', 'validation_success');
               
            }else{
                
               $this->session->set_flashdata('validation_message', validation_errors('<p>','</p>'));
               $this->session->set_flashdata('type', 'validation_error');
              
            }
        }
        
       
        redirect($this->input->post('page')); 
         
        
    }
    
    
 
    
    
    
    
    
    
    
    
         // search clients
    function search(){
         
  
	$per_page  = ($this->input->get('result_per_page')? $this->input->get('result_per_page') : 200);
	
	$status_id  = (isset($_GET['status_id'])  ? (int)$_GET['status_id']: 1); 
	    
	$offset = ($this->input->get('offset')? $this->input->get('offset') : ''); 
	
	$where_search = "(users.user_isActive = $status_id)";
	
	
	$config['base_url'] = base_url('users');
	$config['total_rows'] = $this->user_accessor->searchUsers($where_search, 0, 0, $count = true);	
	$config['per_page']         = $per_page;
        $config['num_links']	    = 10; 
        $config['next_link']        = 'Next';
	$config['prev_link']        = 'Prev';
        $config['next_tag_open']    = '<li class="nextPage">';
        $config['next_tag_close']   = '</li>';
        
        $config['prev_tag_open']    = '<li class="prevPage">';
        $config['prev_tag_close']   = '</li>';
        $config['cur_tag_open']     = "<li class='active'><a>";
        $config['cur_tag_close']    = "</a></li>";	
	$config['full_tag_open']    =  '<ul class="pagination">';
	$config['full_tag_close']    = '</ul>';
	$config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['page_query_string'] = TRUE;
	$config['query_string_segment'] = "offset";
	$config['reuse_query_string']  = TRUE;
	
        $this->pagination->initialize($config); 
	
       

	$data['users'] = $this->user_accessor->searchUsers($where_search, $per_page, $offset);
         
        
        $data['page_header'] = "Users Overview";
        $data['content_view'] = "user/list_users";
      //  $data['sidebar_view'] = "user/display_sidebar";
        $data['userDetails'] = $this->userDetails;
        $data['page_title'] = "Search Users";
     
        $this->breadcrumbs->push('User', '/user/');
	$this->breadcrumbs->push('Search', '/');
        
        $this->template->callDefaultTemplate($data);
     
    }
    
    
    
   
    
//    
//    function profile($userLink = ''){
//
//	 $this->userDetails  = $this->user_accessor->getUserByUserLink($userLink);
//
//         if(empty($this->userDetails )):
//             $this->session->set_flashdata('message', 'User Not found!!!');
//             $this->session->set_flashdata('type', 'flash_error');
//             redirect($_SERVER['HTTP_REFERER']); 
//	     return false;
//        endif;
//	
//       
//	$data['page_header'] = "Users Profile";
//        $data['content_view'] = "users/profile";
//        $data['sidebar_view'] = "users/admin_sidebar";
//        $data['user'] = $this->userDetails;
//        $data['page_title'] = "Search Users";
//        $data['mode'] = "edit";
//        
//       // echo Modules::run('template/callDefaultTemplate', $data);
//       $this->template->callDefaultTemplate($data);
//    }
//    
//    
    

    function create(){
        
        if($this->input->post('add_user')):
        
            $this->form_validation->set_rules('fname', 'First name', 'trim|required');
            $this->form_validation->set_rules('lname', 'Last name', 'trim|required');
            $this->form_validation->set_rules('user_title', 'Title', 'trim|required');
       
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            
            $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|is_unique[users.user_username]');
             
            
           // $this->form_validation->set_error_delimiters( '<em class="error_text">','</em>' );
            
             if($this->form_validation->run()):
                    $content['user_title'] = $this->input->post('user_title');
                    $content['user_fname'] = $this->input->post('fname');
                    $content['user_lname'] = $this->input->post('lname');
                    $content['user_aboutMe'] = $this->input->post('aboutMe');
                    $content['user_username'] = $this->input->post('username');
                 
                    $content['user_isActive'] = 1;
                    $content['user_regDate'] = changeDateFormat('now', "Y-m-d");
                   // $content['role_roleID'] = 1;               
                   
                    $content['user_userLink'] =  $user_userLink = $this->generateElementURL('user');
                    $content['user_password'] = $this->user_accessor->_prep_password($this->input->post('password'));
                    
                     
                    $userID = $this->user_accessor->addNewUser($content);
                    
                
                    
                    if($userID):                      
                         $this->session->set_flashdata('message', 'user Added Successfully');
                         $this->session->set_flashdata('type', 'flash_success');
                        redirect(base_url('user/'.$user_userLink)); 
                        
                        
                    else:
                        $data['db_error'] = "There was error adding this client's Details. Please try again";
                        
                    endif;
            endif;
              
        endif;
         
        
        $data['page_header'] = "New Profile";
        $data['content_view'] = "user/new_profile";
      //  $data['sidebar_view'] = "user/display_sidebar";
       // $data['userDetails'] = $this->userDetails;
        $data['page_title'] = "Search Users";
        
       // echo Modules::run('template/callDefaultTemplate', $data);
        $this->template->callDefaultTemplate($data);
        
         
     
    }
    
    

    function deactivate(){
        
    }
    
   
}
