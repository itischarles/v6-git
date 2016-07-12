<?php

class Product_provider extends MY_Controller {

    private $userDetails;
    protected $auth_lib;
    
    
    /**
     * $moduleName
     * specify the name of this module
     * @var string 
     */
    private $moduleName = 'Product';
    
    /**
     * $moduleKey
     * specify the module unique key
     * @var string 
     */
    private $moduleKey = 'product-module';


    function __construct() {
        parent::__construct();

        $this->auth_lib = new Auth_lib();
        $this->auth_lib->is_authenticated();
        // make sure this user has read access to this module
        $this->auth_lib->has_readAccess_orRedirect($this->moduleKey);

        $this->load->module('template');

        $this->load->model('products_model');
    }

    /*
     * functtion to list all data
     * @params null
     * @returns null 
     */

    function index() {

        $data['page_header'] = "Manage Product Provider";
        $data['content_view'] = "product/product_provider_list";
       // $data['sidebar_view'] = "user/admin_sidebar";
        $data['product_provider'] = $this->products_model->getAllProductProvider();
        $data['page_title'] = "manage product provider";
        $data['mode'] = "edit";
         $data['module'] = $this->moduleName;

           // add breadcrumbs
	$this->breadcrumbs->push('Product Providers', '/product/provider');
	$this->breadcrumbs->push('Overview', '/');
        
        $this->template->callDefaultTemplate($data);
    }

    /*
     * Function to goto add form / create a new user
     * @params null
     * @returns null
     */

    function create() {

        if ($this->input->post('add_product_provider')) {

      
            $this->form_validation->set_rules('productProviderName', 'Provider Name', 'trim|required');
            $this->form_validation->set_rules('productProviderAddressLine1', 'AddressLine1', 'trim|required');
            $this->form_validation->set_rules('productProviderAddressLine2', 'AddressLine2', 'trim|required');
            $this->form_validation->set_rules('productProviderAddressLine3', 'AddressLine3', 'trim|required');
            $this->form_validation->set_rules('productProviderCity', 'City', 'trim|required');
            $this->form_validation->set_rules('productProviderPostcode', 'Postcode', 'trim|required');
            $this->form_validation->set_rules('productProviderEmail', 'Email', 'trim|required');
            $this->form_validation->set_rules('productProviderTel', 'Telephone', 'trim|required');
           

            if ($this->form_validation->run()) {
                            
                //add
              
                $data['productProviderName'] = $this->input->post('productProviderName');
                $data['productProviderAddressLine1'] = $this->input->post('productProviderAddressLine1');
                $data['productProviderAddressLine2'] = $this->input->post('productProviderAddressLine2');
                $data['productProviderAddressLine3'] = $this->input->post('productProviderAddressLine3');
                $data['productProviderCity'] = $this->input->post('productProviderCity');
                $data['productProviderPostcode'] = $this->input->post('productProviderPostcode');
                $data['productProviderEmail'] = $this->input->post('productProviderEmail');
                $data['productProviderTel'] = $this->input->post('productProviderTel');
              

                if ($this->products_model->addNewProductProvider($data)) {

                    $this->session->set_flashdata('message', 'Product provider Added Successfully');
                    $this->session->set_flashdata('type', 'flash_success');
                } else {
                    $this->session->set_flashdata('message', 'Product provider Added Failed');
                    $this->session->set_flashdata('type', 'flash_error');
                }
                redirect(base_url('product/provider'));
            }
        }

        $data['page_title'] = "manage product provider - Add";
        $data['page_header'] = "Manage Product Provider - Add";
        $data['content_view'] = "product/product_provider_form";
         $data['module'] = $this->moduleName;
     //   $data['sidebar_view'] = "user/admin_sidebar";
        $data['mode'] = "New";
        
          // add breadcrumbs
	$this->breadcrumbs->push('Product Providers', '/product/provider');
	$this->breadcrumbs->push('Add New', '/');
        
        $this->template->callDefaultTemplate($data);
    }

    /*
     * Function to goto edit form / update a record
     * @params null
     * @returns null
     */

    function update($id) {
        // always check first
         $prod = $this->products_model->getProductProviderByID($id);
         
        if(empty($prod)){
            $this->session->set_flashdata('message', 'Illegal oeperation detected');
            $this->session->set_flashdata('type', 'flash_error');
            redirect(base_url('product/provider'));
        }
        
        
      
        if ($this->input->post('edit_product_provider')) {

           
             $this->form_validation->set_rules('productProviderName', 'Provider Name', 'trim|required');
            $this->form_validation->set_rules('productProviderAddressLine1', 'AddressLine1', 'trim|required');
            $this->form_validation->set_rules('productProviderAddressLine2', 'AddressLine2', 'trim|required');
            $this->form_validation->set_rules('productProviderAddressLine3', 'AddressLine3', 'trim|required');
            $this->form_validation->set_rules('productProviderCity', 'City', 'trim|required');
            $this->form_validation->set_rules('productProviderPostcode', 'Postcode', 'trim|required');
            $this->form_validation->set_rules('productProviderEmail', 'Email', 'trim|required');
            $this->form_validation->set_rules('productProviderTel', 'Telephone', 'trim|required');

           
            
             if ($this->form_validation->run()) {
                $content['productProviderName'] = $this->input->post('productProviderName');
                $content['productProviderAddressLine1'] = $this->input->post('productProviderAddressLine1');
                $content['productProviderAddressLine2'] = $this->input->post('productProviderAddressLine2');
                $content['productProviderAddressLine3'] = $this->input->post('productProviderAddressLine3');
                $content['productProviderCity'] = $this->input->post('productProviderCity');
                $content['productProviderPostcode'] = $this->input->post('productProviderPostcode');
                $content['productProviderEmail'] = $this->input->post('productProviderEmail');
                $content['productProviderTel'] = $this->input->post('productProviderTel');
                $w_data['productProviderID'] = $id;


                if ($this->products_model->updateProductProvider($content, $w_data)) {

                    $this->session->set_flashdata('message', 'Product provider updated Successfully');
                    $this->session->set_flashdata('type', 'flash_success');
                }
                else {

                    $this->session->set_flashdata('message', 'Product provider updated Failed');
                    $this->session->set_flashdata('type', 'flash_error');
                }
            redirect(base_url('product/provider'));
            
             }// end if run
        }  // end if posted/submitted

      
        $data['product_provider'] = $prod;
        $data['page_title'] = "manage product provider - edit";
        $data['page_header'] = "Manage Product Provider - Edit";
        $data['content_view'] = "product/product_provider_form";
         $data['module'] = $this->moduleName;
     //   $data['sidebar_view'] = "user/admin_sidebar";
        $data['mode'] = "Edit";
        
          // add breadcrumbs
	$this->breadcrumbs->push('Product Providers', '/product/provider');
        $this->breadcrumbs->push($prod->productProviderName, '/product/provider/'.$prod->productProviderID.'/view');
	$this->breadcrumbs->push('Update', '/');

        $this->template->callDefaultTemplate($data);
    }

    /*
     * Function to delete a row of data
     * @params id
     * @returns null
     */

    function delete($id) {

        if($id){

            if ($data = $this->products_model->deleteProductProvider($id)) {

                $this->session->set_flashdata('message', 'Product Provider Deleted Successfully');
                $this->session->set_flashdata('type', 'flash_success');
                redirect(base_url('product/provider'));
            } else {
                $this->session->set_flashdata('message', 'Product Provider Deleted Failed');
                $this->session->set_flashdata('type', 'flash_error');
            }
        } else {
            $this->session->set_flashdata('message', 'Something went wrong please try again');
            $this->session->set_flashdata('type', 'flash_error');
            redirect(base_url('product/provider'));
        }
    }

}
