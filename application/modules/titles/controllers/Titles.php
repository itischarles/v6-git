<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of COPYTHIS
 *
 * @author itischarles
 */
class Titles extends MY_Controller {
   
    
   
    protected $auth_lib;
            
    function __construct() {
        parent::__construct();

      $this->auth_lib = new Auth_lib();
      $this->auth_lib->is_authenticated();
      
     // $this->load->module('template');
      $this->load->model('Title_model','titles_accessor');
      
      /** if the module is admin ONLY module**/
      /* if(!$this->auth_lib->is_admin()){
           $this->session->set_flashdata('message', 'Access denined!!!');
           $this->session->set_flashdata('type', 'flash_error');
           redirect($_SERVER['HTTP_REFERER']); 
       }
       */

    }
    
    
    
    /**
     * display_title_widget
     * display a title widget in an html select form. if slected is given that option should be selected
     * 
     * @param string $mark_selected 
     */
    function display_title_widget_select($mark_selected= ''){
       $data['mark_selected'] = $mark_selected;
      
       $data['titles'] = $this->titles_accessor->listTitleActiveTitles();
       $this->load->view('titles/display-title-widget-select', $data);
    }
    
    
}
