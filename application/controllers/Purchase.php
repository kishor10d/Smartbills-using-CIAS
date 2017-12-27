<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Purchase (PurchaseController)
 * User Class to control all purchase related things
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 27 December 2017
 */
class Purchase extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_model', 'purchase');
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
            
            $count = $this->purchase->purchaseListingCount($searchText);
			$returns = $this->paginationCompress("purchase/", $count, 5 );
            
            $data['purchaseRecords'] = $this->purchase->purchaseListing($searchText, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = 'SmartCIAS : Purchase Bills';
            
            $this->loadViews("purchase/index", $this->global, $data, NULL);
        }
    }

}