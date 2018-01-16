<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Sale (SaleController)
 * Sale Class to control all Sale related things
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 16 January 2017
 */
class Sale extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sale_model', 'sale');
        $this->load->model('address_model', 'address');
        $this->isLoggedIn();   
    }

    /**
     * This function used to load the purchase bills
     */
    public function index()
    {        
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->sale->saleListingCount($searchText);
            $returns = $this->paginationCompress("sale/", $count, 5 );
            
            $resultRecords = $this->sale->saleListing($searchText, $returns["page"], $returns["segment"]);
            
            $data['saleRecords'] = $resultRecords;
            $this->global['pageTitle'] = 'SmartCIAS : Sales Bills';
            
            $this->loadViews("sale/index", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $data['addresses'] = $this->address->getAddresses();
            $this->global['pageTitle'] = 'SmartCIAS : Add New Sale';

            $this->loadViews("sale/add", $this->global, $data, NULL);
        }
    }
}