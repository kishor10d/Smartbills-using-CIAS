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
            $this->load->model('item_model', 'item');
            $data['addresses'] = $this->address->getAddresses();
            $data['items'] = $this->item->getItems();
            $data['billNumber'] = generateBillNumber();
            $this->global['pageTitle'] = 'SmartCIAS : Add New Sale';

            $this->loadViews("sale/add", $this->global, $data, NULL);
        }
    }

    function addItemToBill()
    {
        $postData = $this->input->post();

        $this->load->model('item_model', 'item');
        $itemData = $this->item->getItemByName($postData["itemname"]);

        $itemData = array("billno"=>$postData["billno"],
                            "item_name"=>$postData["itemname"],
                            "quantity"=>$postData["quantity"],
                            "weight"=>$postData["weight"],
                            "item_rate"=>$itemData->item_price,
                            "labour"=>$itemData->item_labour,
                            "creation_date"=>date('Y-m-d H:i:s'));

        $this->sale->insertBillItem($itemData);

        $this->getRefresh($postData["billno"]);
    }

    function getRefresh($billNo)
    {
        $itemData = $this->sale->getBillItemData($billNo);

        if(!empty($itemData))
        {
            $itemTotal = 0;
            foreach($itemData as $it){
                $itemTotal = $itemTotal + ($it->quantity * $it->item_rate);
            }
            echo(json_encode(array("html"=>$this->load->view("sale/_itemlist", array("itemData"=>$itemData), TRUE), "itemTotal"=>$itemTotal)));
        }
        else
        {
            echo(json_encode(array("html"=>'<p style="padding-top: 10px; text-align: center; color: red">No Details added yet</p>', "itemTotal"=>0)));
        }
    }

    function deleteItemFromBill()
    {
        $postData = $this->input->post();

        $this->sale->deleteItemFromBill($postData["srno"]);

        $this->getRefresh($postData["billno"]);
    }

    function recordTotalSale()
    {
        $postData = $this->input->post();

        $this->load->model('address_model', 'address');
        $companyData = $this->address->getAddressByCompanyName($postData["buyersname"]);

        $saleData = array("bill_no"=>$postData["hBillno"],
                            "buyer_name"=>$postData["buyersname"],
                            "buyer_address"=>$companyData->address,
                            "amount"=>$postData["amount"],
                            "vat"=>$postData["vat"], 
                            "other_charges"=>$postData["othercharges"],
                            "sell_date"=>date('Y-m-d', strtotime($postData['date'])),
                            "creation_date"=>date('Y-m-d H:i:s'));
        
        $prevBillNumber = $postData["hBillno"]. "-" .date('d-m-Y', strtotime($postData['date']));
        
        $result = $this->sale->recordTotalSale($saleData);

        if($result > 0){
            $this->session->set_flashdata('success', 'Sale recorded successfully');
            $this->sale->updateBillNumber($postData["hBillno"], $prevBillNumber);
        } else {
            $this->session->set_flashdata('error', 'Sale record failed');
        }

        redirect('sale');
    }

    /**
     * This function is used to load the add new form
     */
    function editOld($billNo)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('item_model', 'item');
            $data['addresses'] = $this->address->getAddresses();
            $data['items'] = $this->item->getItems();

            $billData = $this->sale->getBillData($billNo);

            $billItemData = $this->sale->getBillItemData($billData->bill_no);

            $data["billData"] = $billData;
            $data["itemData"] = $billItemData;

            $this->global['pageTitle'] = 'SmartCIAS : Add New Sale';

            $this->loadViews("sale/edit", $this->global, $data, NULL);
        }
    }

    function updateTotalSale()
    {
        $postData = $this->input->post();   

        $this->load->model('address_model', 'address');
        $companyData = $this->address->getAddressByCompanyName($postData["buyersname"]);

        $saleData = array("buyer_name"=>$postData["buyersname"],
                            "buyer_address"=>$companyData->address,
                            "amount"=>$postData["amount"],
                            "vat"=>$postData["vat"], 
                            "other_charges"=>$postData["othercharges"],
                            "sell_date"=>date('Y-m-d', strtotime($postData['date'])));
        
        $result = $this->sale->updateTotalSale($saleData, $postData["hSrno"]);

        if($result > 0){
            $this->session->set_flashdata('success', 'Sale updated successfully');
        } else {
            $this->session->set_flashdata('warning', 'Either nothing changed Or sale updation failed');
        }

        redirect('sale');
    }

    

}