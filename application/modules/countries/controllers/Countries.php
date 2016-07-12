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
class Countries extends MY_Controller {
   
    
    private $userDetails;
    protected $auth_lib;
            
    function __construct() {
        parent::__construct();

      $this->auth_lib = new Auth_lib();
      $this->auth_lib->is_authenticated();
      
      $this->load->module('template');
      
      $this->load->model('Country_model','country_accessor');

    }
    
    
    
    /**
     * display_title_widget
     * display a title widget in an html select form. if slected is given that option should be selected
     * 
     * @param string $mark_selected 
     */
    function display_country_widget_select($mark_selected= ''){
       $data['mark_selected'] = $mark_selected;
      
       $data['countries'] = $this->country_accessor->listAll();
       $this->load->view('countries/display-widget-select', $data);
    }
    
    
    
}
