<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Worker (WorkerController)
 * Worker Class to control all Worker related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Item extends BaseController
{
	/**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('item_model', 'item');
        $this->isLoggedIn();   
    }

    /**
     * This function used to load item list
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
            
            $count = $this->item->itemListingCount($searchText);

			$returns = $this->paginationCompress ( "item/", $count, 5 );

            $data['itemRecords'] = $this->item->itemListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'SmartCIAS : Item List';

            $this->loadViews("item/index", $this->global, $data, NULL);
        }
    }
}