<?php

class Product_type extends MY_Controller {

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

        $data['page_header'] = "Manage Product Type";
        $data['content_view'] = "product/product_type_list";
      //  $data['sidebar_view'] = "user/admin_sidebar";
        $data['product_type'] = $this->products_model->getAllProductType();
        $data['page_title'] = "manage product type";
        $data['mode'] = "edit";
         $data['module'] = $this->moduleName;
         
           // add breadcrumbs
	$this->breadcrumbs->push('Product Types', '/product/type');
        
	$this->breadcrumbs->push('Overview', '/');

        $this->template->callDefaultTemplate($data);
    }

    /*
     * Function to goto add form / create a new user
     * @params null
     * @returns null
     */

    function create() {

        if ($this->input->post('add_product_type')) {

            $this->form_validation->set_rules('type_name', 'Type name', 'trim|required');
            $this->form_validation->set_rules('default_growth_rate_low', 'Default growth rate low', 'trim|required');
            $this->form_validation->set_rules('default_growth_rate_mid', 'Default growth rate mid', 'trim|required');
            $this->form_validation->set_rules('default_growth_rate_high', 'Default growth rate high', 'trim|required');
            $this->form_validation->set_rules('max_mid_growth_rate', 'Max mid growth rate', 'trim|required');

            if ($this->form_validation->run()) {
                //add
                $data['type_name'] = $this->input->post('type_name');
                $data['default_growth_rate_low'] = $this->input->post('default_growth_rate_low');
                $data['default_growth_rate_mid'] = $this->input->post('default_growth_rate_mid');
                $data['default_growth_rate_high'] = $this->input->post('default_growth_rate_high');
                $data['max_mid_growth_rate'] = $this->input->post('max_mid_growth_rate');

                if ($this->products_model->addNewProductType($data)) {

                    $this->session->set_flashdata('message', 'Product type Added Successfully');
                    $this->session->set_flashdata('type', 'flash_success');
                } else {
                    $this->session->set_flashdata('message', 'Product type Added Failed');
                    $this->session->set_flashdata('type', 'flash_error');
                }
                redirect(base_url('product/type'));
            }
        }

        $data['page_title'] = "manage product typ - Add";
        $data['page_header'] = "Manage Product Type - Add";
        $data['content_view'] = "product/product_type_form";
       // $data['sidebar_view'] = "user/admin_sidebar";
        $data['mode'] = "New";
         $data['module'] = $this->moduleName;
         
         // add breadcrums
        $this->breadcrumbs->push('Product Types', '/product/type');        
	$this->breadcrumbs->push('Add New', '/');

        $this->template->callDefaultTemplate($data);
    }

    /*
     * Function to goto edit form / update a record
     * @params id
     * @returns null
     */

    function update($id) {
        
        $prod = $this->products_model->getProductTypeByID($id);
        
        if (empty($prod)) {
            $this->session->set_flashdata('message', 'Something went wrong please try again');
            $this->session->set_flashdata('type', 'flash_error');
            redirect(base_url('product/type'));
        } 

        if ($this->input->post('edit_product_type')) {

            $this->form_validation->set_rules('type_name', 'Type name', 'trim|required');
            $this->form_validation->set_rules('default_growth_rate_low', 'Default growth rate low', 'trim|required');
            $this->form_validation->set_rules('default_growth_rate_mid', 'Default growth rate mid', 'trim|required');
            $this->form_validation->set_rules('default_growth_rate_high', 'Default growth rate high', 'trim|required');
            $this->form_validation->set_rules('max_mid_growth_rate', 'Max mid growth rate', 'trim|required');

            if ($this->form_validation->run()) {
                $data['type_name'] = $this->input->post('type_name');
                $data['default_growth_rate_low'] = $this->input->post('default_growth_rate_low');
                $data['default_growth_rate_mid'] = $this->input->post('default_growth_rate_mid');
                $data['default_growth_rate_high'] = $this->input->post('default_growth_rate_high');
                $data['max_mid_growth_rate'] = $this->input->post('max_mid_growth_rate');
                $w_data['productTypeID'] = $id;


                if ($this->products_model->updateProductType($data, $w_data)) {
                    $this->session->set_flashdata('message', 'Product type updated Successfully');
                    $this->session->set_flashdata('type', 'flash_success');
                }
                 else {
                    $this->session->set_flashdata('message', 'Product type updated Failed');
                    $this->session->set_flashdata('type', 'flash_error');
                 }
                redirect(base_url('product/type'));
            }// end if run

        }// end if posted/submitted
        
        
        
        $data['product_type'] = $prod;
        $data['page_title'] = "manage product type - edit";
        $data['page_header'] = "Manage Product Type - Edit";
        $data['content_view'] = "product/product_type_form";
       // $data['sidebar_view'] = "user/admin_sidebar";
        $data['mode'] = "Edit";
         $data['module'] = $this->moduleName;
         
        $this->breadcrumbs->push('Product Types', '/product/type');
        $this->breadcrumbs->push($prod->type_name, '/product/type/'.$prod->productTypeID.'/view');
	$this->breadcrumbs->push('Update', '/');

        $this->template->callDefaultTemplate($data);
    }

    /*
     * Function to delete a row of data
     * @params id
     * @returns null
     */

    function delete($id) {

        if ($id) {

            if ($data = $this->products_model->deleteProductType($id)) {

                $this->session->set_flashdata('message', 'Product Type Deleted Successfully');
                $this->session->set_flashdata('type', 'flash_success');
                redirect(base_url('product/type'));
            } else {
                $this->session->set_flashdata('message', 'Product Type Deleted Failed');
                $this->session->set_flashdata('type', 'flash_error');
            }
        } else {
            $this->session->set_flashdata('message', 'Something went wrong please try again');
            $this->session->set_flashdata('type', 'flash_error');
            redirect(base_url('product/type'));
        }
    }

}
