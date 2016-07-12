<?php

class Products extends MY_Controller {

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

        $data['page_header'] = "Manage Products";
        $data['content_view'] = "product/product_list";
      //  $data['sidebar_view'] = "user/admin_sidebar";
       // $data['products'] = $this->products_model->getAll();
        $data['products'] = $this->products_model->getTypeProviderData();
        $data['page_title'] = "manage products";
        $data['module'] = $this->moduleName;
      

         // add breadcrumbs
	$this->breadcrumbs->push('Products', '/product/');
	$this->breadcrumbs->push('Overview', '/');
        
        $this->template->callDefaultTemplate($data);
    }

    /*
     * Function to goto add form / create a new user
     * @params null
     * @returns null
     */

    function create() {

        if ($this->input->post('add_product')) {

           $this->form_validation->set_rules('name', 'Product Name', 'trim|required');
            $this->form_validation->set_rules('active', 'Product Active', 'trim|required');
            $this->form_validation->set_rules('productTypeID', 'Product Type ID', 'trim|required');
            $this->form_validation->set_rules('productProviderID', 'Product Provider ID', 'trim|required');
            $this->form_validation->set_rules('reference', 'Product Reference', 'trim|required');
            $this->form_validation->set_rules('initialChargePercentage', 'Product Initial Charge Percentage', 'trim|required');
            $this->form_validation->set_rules('initialChargeFixed', 'Product Initial Charge Fixed', 'trim|required');
            $this->form_validation->set_rules('annualChargePercentage', 'Product annual Charge Percentage', 'trim|required');
            $this->form_validation->set_rules('annualChargePercentageCap', 'Product annual Charge Percentage Cap', 'trim|required');
            $this->form_validation->set_rules('annualChargeFixed', 'Product annual Charge Fixed', 'trim|required');
            $this->form_validation->set_rules('keyFeaturesPath', 'Product key Features Path', 'trim|required');
            $this->form_validation->set_rules('illustrationTitle', 'Product illustration Title', 'trim|required');
            $this->form_validation->set_rules('applicationForm', 'Product application Form', 'trim|required');

            if ($this->form_validation->run()) {
                //add
                $data['name'] = $this->input->post('name');
                $data['active'] = $this->input->post('active');
                $data['productTypeID'] = $this->input->post('productTypeID');
                $data['productProviderID'] = $this->input->post('productProviderID');
                $data['reference'] = $this->input->post('reference');
                $data['initialChargePercentage'] = $this->input->post('initialChargePercentage');
                $data['initialChargeFixed'] = $this->input->post('initialChargeFixed');
                $data['annualChargePercentage'] = $this->input->post('annualChargePercentage');
                $data['annualChargePercentageCap'] = $this->input->post('annualChargePercentageCap');
                $data['annualChargeFixed'] = $this->input->post('annualChargeFixed');
                $data['keyFeaturesPath'] = $this->input->post('keyFeaturesPath');
                $data['illustrationTitle'] = $this->input->post('illustrationTitle');
                $data['applicationForm'] = $this->input->post('applicationForm');

                if ($this->products_model->addNewProduct($data)) {

                    $this->session->set_flashdata('message', 'Product Added Successfully');
                    $this->session->set_flashdata('type', 'flash_success');
                } else {
                    $this->session->set_flashdata('message', 'Product Added Failed');
                    $this->session->set_flashdata('type', 'flash_error');
                }
                redirect(base_url('product'));
            }
        }

        $data['page_title'] = "manage products - Add";
        $data['page_header'] = "Manage Products - Add";
        $data['product_types'] = $this->products_model->getAllProductType();
        $data['product_providers'] = $this->products_model->getAllProductProvider();
        $data['content_view'] = "product/product_form";
       // $data['sidebar_view'] = "user/admin_sidebar";
        $data['mode'] = "New";
         $data['module'] = $this->moduleName;
         
          // add breadcrumbs
	$this->breadcrumbs->push('Products', '/product/');
	$this->breadcrumbs->push('New', '/');
        
        $this->template->callDefaultTemplate($data);
    }

    /*
     * Function to goto edit form / update a record
     * @params id
     * @returns null
     */

    function update($id) {
        // always check first be fore anything happens
        $data['product'] = $prod = $this->products_model->getProductByID($id);
        
        if(empty($prod)){
            $this->session->set_flashdata('message', 'Illegal Operation detected');
            $this->session->set_flashdata('type', 'flash_error');
            redirect(base_url('product'));
            exit();
        }
        
        
        if ($this->input->post('edit_product')) {

            $this->form_validation->set_rules('name', 'Product Name', 'trim|required');
            $this->form_validation->set_rules('active', 'Product Active', 'trim|required');
            $this->form_validation->set_rules('productTypeID', 'Product Type ID', 'trim|required');
            $this->form_validation->set_rules('productProviderID', 'Product Provider ID', 'trim|required');
            $this->form_validation->set_rules('reference', 'Product Reference', 'trim|required');
            $this->form_validation->set_rules('initialChargePercentage', 'Product Initial Charge Percentage', 'trim|required');
            $this->form_validation->set_rules('initialChargeFixed', 'Product Initial Charge Fixed', 'trim|required');
            $this->form_validation->set_rules('annualChargePercentage', 'Product annual Charge Percentage', 'trim|required');
            $this->form_validation->set_rules('annualChargePercentageCap', 'Product annual Charge Percentage Cap', 'trim|required');
            $this->form_validation->set_rules('annualChargeFixed', 'Product annual Charge Fixed', 'trim|required');
            $this->form_validation->set_rules('keyFeaturesPath', 'Product key Features Path', 'trim|required');
            $this->form_validation->set_rules('illustrationTitle', 'Product illustration Title', 'trim|required');
            $this->form_validation->set_rules('applicationForm', 'Product application Form', 'trim|required');
 
           if ($this->form_validation->run()) {
                $content['name'] = $this->input->post('name');
                $content['active'] = $this->input->post('active');
                $content['productTypeID'] = $this->input->post('productTypeID');
                $content['productProviderID'] = $this->input->post('productProviderID');
                $content['reference'] = $this->input->post('reference');
                $content['initialChargePercentage'] = $this->input->post('initialChargePercentage');
                $content['initialChargeFixed'] = $this->input->post('initialChargeFixed');
                $content['annualChargePercentage'] = $this->input->post('annualChargePercentage');
                $content['annualChargePercentageCap'] = $this->input->post('annualChargePercentageCap');
                $content['annualChargeFixed'] = $this->input->post('annualChargeFixed');
                $content['keyFeaturesPath'] = $this->input->post('keyFeaturesPath');
                $content['illustrationTitle'] = $this->input->post('illustrationTitle');
                $content['applicationForm'] = $this->input->post('applicationForm');
               
            
                if ($this->products_model->updateProduct($content, array('productID'=>$id))) {

                    $this->session->set_flashdata('message', 'Product updated Successfully');
                    $this->session->set_flashdata('type', 'flash_success');
                }
                else {                
                    $this->session->set_flashdata('message', 'Product updated Failed');
                    $this->session->set_flashdata('type', 'flash_error');
                }
                redirect(base_url('product'));

           }// if run 
       
        }// end if posted/submitted

        $data['page_title'] = "manage products - edit";
        $data['page_header'] = "Manage Products - Edit";
        $data['product_types'] = $this->products_model->getAllProductType();
        $data['product_providers'] = $this->products_model->getAllProductProvider();
        $data['content_view'] = "product/product_form";
       // $data['sidebar_view'] = "user/admin_sidebar";
        $data['module'] = $this->moduleName;
        $data['mode'] = "Edit";
        
         // add breadcrumbs
        
	$this->breadcrumbs->push('Products', '/product/');
	$this->breadcrumbs->push($prod->name, '/product/'.$prod->productID.'/view');
        $this->breadcrumbs->push('Edit', '/');

        $this->template->callDefaultTemplate($data);
    }

    /*
     * Function to delete a row of data
     * @params id
     * @returns null
     */

    function delete($id) {

        if($id){

            if ($data = $this->products_model->deleteProduct($id)) {

                $this->session->set_flashdata('message', 'Product Deleted Successfully');
                $this->session->set_flashdata('type', 'flash_success');
                redirect(base_url('product'));
            } else {
                $this->session->set_flashdata('message', 'Product Deleted Failed');
                $this->session->set_flashdata('type', 'flash_error');
            }
        } else {
            $this->session->set_flashdata('message', 'Something went wrong please try again');
            $this->session->set_flashdata('type', 'flash_error');
            redirect(base_url('product'));
        }
    }
     /*
     * functtion to list all data
     * @params id
     * @returns null 
     */

    function view($id) {

        $data['page_header'] = "Manage Products";
        $data['content_view'] = "product/product_ovreview_list";
      //  $data['sidebar_view'] = "user/admin_sidebar";
        $data['products'] = $this->products_model->getAllProviderData($id);
        $data['page_title'] = "manage products";
         $data['module'] = $this->moduleName;
       

        $this->template->callDefaultTemplate($data);
    }
    
    
    
    
     /**
     * get the module specific javascription file link
     */
    function getModule_js(){
        return base_url('module_assets/'.$this->moduleName.'product-module.js');
    }
    
    
    
    
    
    function chooseProduct($clientURL){
        //get client from client module
        //use adviserID to get adviserFirm from adviser module
    }
    

}
