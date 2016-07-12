<?php

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of user_model
 *
 * @author trblap
 */
class Products_model extends CI_Model {

    /**
     *
     * @var string $products_tbl
     * defines the products databse table 
     */
    private $products_tbl = 'products';
    private $product_type_tbl = 'product_type';
    private $product_provider_tbl = 'product_provider';

    function __construct() {
        parent::__construct();
    }

    /*
     * function to getAll records
     * @params null
     * @returns array of object
     */

    public function getAll() {

        return $this->db->get($this->products_tbl)->result();
    }

    /*
     * function to get data by id
     * @params id
     * @returns object 
     */

    function getProductByID($id) {
        return $this->db->where(array('productID' => (int) $id))
                        ->get($this->products_tbl)
                        ->row();
    }

    /*
     * function to update data
     * @params content and where
     * returns object
     */

    function updateProduct($content, $where) {
        $this->db->where($where);
        $this->db->update($this->products_tbl, $content);

        return $this->db->affected_rows();
    }

    /*
     * function to add data
     * @params content
     * @returns object
     */

    function addNewProduct($content) {

        $this->db->insert($this->products_tbl, $content);
        return $this->db->insert_id();
    }

    /*
     * function to delete data
     * @params id
     * @returns objecdt
     */

    function deleteProduct($id) {
        $this->db->where('productID', $id);
        return $this->db->delete($this->products_tbl);
    }

    /*
     * ===============================================================================
     */

    /*
     * Start product_type and its model
     */

    /*
     * function to getAll records
     * @params null
     * @returns array of object
     */

    public function getAllProductType() {

        return $this->db->get($this->product_type_tbl)->result();
    }

    /*
     * function to delete data
     * @params id
     * @returns objecdt
     */

    function deleteProductType($id) {
        $this->db->where('productTypeID', $id);
        return $this->db->delete($this->product_type_tbl);
    }

    /*
     * function to add data
     * @params content
     * @returns object
     */

    function addNewProductType($content) {

        $this->db->insert($this->product_type_tbl, $content);
        return $this->db->insert_id();
    }

    /*
     * function to update data
     * @params content and where
     * returns object
     */

    function updateProductType($content, $where) {
        $this->db->where($where);
        $this->db->update($this->product_type_tbl, $content);

        return $this->db->affected_rows();
    }

    /*
     * function to get data by id
     * @params id
     * @returns object
     */

    function getProductTypeByID($id) {
        return $this->db->where(array('productTypeID' => (int) $id))
                        ->get($this->product_type_tbl)
                        ->row();
    }

    /*
     * End product_type and its model
     */

    /*
     * ===============================================================================
     */
    /*
     * Start product_provider and its model
     */

    /*
     * function to getAll records
     * @params null
     * @returns array of object
     */

    public function getAllProductProvider() {

        return $this->db->get($this->product_provider_tbl)->result();
    }

    /*
     * function to delete data
     * @params id
     * @returns objecdt
     */

    function deleteProductProvider($id) {
        $this->db->where('productProviderID', $id);
        return $this->db->delete($this->product_provider_tbl);
    }

    /*
     * function to add data
     * @params content
     * @returns object
     */

    function addNewProductProvider($content) {

        $this->db->insert($this->product_provider_tbl, $content);
        return $this->db->insert_id();
    }

    /*
     * function to update data
     * @params content and where
     * returns object
     */

    function updateProductProvider($content, $where) {
        $this->db->where($where);
        $this->db->update($this->product_provider_tbl, $content);

        return $this->db->affected_rows();
    }

    /*
     * function to get data by id
     * @params id
     * @returns object
     */

    function getProductProviderByID($id) {
        return $this->db->where(array('productProviderID' => (int) $id))
                        ->get($this->product_provider_tbl)
                        ->row();
    }

    /*
     * End product_provider and its model
     */

    /*
     * ===============================================================================
     */


    /*
     * product_options and its model
     */

    /*
     * function to getAll records
     * @params pro_id
     * @returns array of object
     */

    public function getAllProductOptions($pro_id) {

        return $this->db->get($this->products_tbl)->result();
    }

    /*
     * function to get data by id
     * @params id
     * @returns object
     */

    function getProductOptionsByID($id) {
        return $this->db->where(array('productOptionID' => (int) $id))
                        ->get($this->product_options_tbl)
                        ->row();
    }

    /*
     * function to delete data
     * @params id
     * @returns object
     */

    function deleteProductOptions($id) {
        $this->db->where('productOptionID', $id);
        return $this->db->delete($this->product_options_tbl);
    }

    /*
     * function to update data
     * @params content and where
     * returns object
     */

    function updateProductOptions($content, $where) {
        $this->db->where($where);
        $this->db->update($this->product_options_tbl, $content);

        return $this->db->affected_rows();
    }

    /*
     * function to add data
     * @params content
     * @returns object
     */

    function addNewProductOptions($content) {

        $this->db->insert($this->product_options_tbl, $content);
        return $this->db->insert_id();
    }

    /*
     * function to get data
     * @params null
     * @returns object
     */

    function getTypeProviderData() {
        return $this->db->query(' SELECT pa . * , pt.type_name, pp.productProviderName
                FROM products pa
                JOIN product_type pt ON pa.productTypeID = pt.productTypeID
                JOIN product_provider pp ON pa.productProviderID = pp.productProviderID
                 ')->result();
    }

    /*
     * function to get all data
     * @params id
     * @returns object
     */

    function getAllProviderData($id) {



        return $this->db->query('SELECT pa. * , pt.type_name, pp.productProviderName
                                    FROM products pa
                                    JOIN product_type pt ON pa.productTypeID = pt.productTypeID
                                    JOIN product_provider pp ON pa.productProviderID = pp.productProviderID
                                    WHERE pa.productID = '.$id )->row();
                     }

}
