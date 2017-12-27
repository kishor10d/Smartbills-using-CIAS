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
            
            $count = $this->purchase->purchaseListingCount($searchText);
            $returns = $this->paginationCompress("purchase/", $count, 5 );
            
            $resultRecords = $this->purchase->purchaseListing($searchText, $returns["page"], $returns["segment"]);

            $purchaseRecords = array();

            foreach($resultRecords as $rec){
                $rec->payment = $this->purchase->getPurchasePaid($rec->srno);
                array_push($purchaseRecords, $rec);
            }
            
            $data['purchaseRecords'] = $purchaseRecords;
            $data['addresses'] = $this->address->getAddresses();
            $this->global['pageTitle'] = 'SmartCIAS : Purchase Bills';
            
            $this->loadViews("purchase/index", $this->global, $data, NULL);
        }
    }

    /**
     * This function used to add new purchase details and update new purchase details
     */
    function addNewPurchase()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('billno','Bill No','trim|required|max_length[20]');
            $this->form_validation->set_rules('date','Date','trim|required|max_length[20]');
            $this->form_validation->set_rules('sellersname','Seller Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('amount','Amount','trim|required|numeric');
            $this->form_validation->set_rules('vat','Vat','trim|required|numeric');
            $this->form_validation->set_rules('othercharges','Other Charges','trim|required|numeric');
            $this->form_validation->set_rules('totalamount','Total Amount','trim|required|numeric');
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }
            else
            {
                $post = $this->input->post();
                $purchaseInfo = array('bill_no'=>$post["billno"],
                                    'pur_date'=>date('Y-m-d', strtotime($post["date"])),
                                    'party_name'=>$post["sellersname"],
                                    'total'=>$post["amount"],
                                    'tax'=>$post["vat"],
                                    'othercharges'=>$post["othercharges"],
                                    'grand_total'=>$post["totalamount"]);                

                if(isset($post["srno"]))
                {
                    $result = $this->purchase->updatePurchase($purchaseInfo, $post["srno"]);

                    if($result > 0) {
                        $this->session->set_flashdata('success', 'Purchase details updated successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Purchase details updation failed');
                    }
                }
                else
                {
                    $result = $this->purchase->addNewPurchase($purchaseInfo);

                    if($result > 0){
                        $this->session->set_flashdata('success', 'Purchase details created successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Purchase details creation failed');
                    }
                }

                redirect('purchase');
            }
        }
    }

    function purchasePaid()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('paiddate','Bill No','trim|required|max_length[20]');
            $this->form_validation->set_rules('paidamount','Date','trim|required|max_length[20]');
            $this->form_validation->set_rules('details','Seller Name','trim|required|max_length[128]');
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }
            else
            {
                $post = $this->input->post();
                $purchasePaidInfo = array('paid_date'=>date('Y-m-d', strtotime($post["paiddate"])),
                                    'paid_amount'=>$post["paidamount"],
                                    'details'=>$post["details"],
                                    'datetime'=>date('Y-m-d H:i:s'));

                $result = $this->purchase->purchasePaid($purchasePaidInfo, $post["srnopurchase"]);

                if($result > 0){
                    $this->session->set_flashdata('success', 'Purchase payment successfully');
                } else {
                    $this->session->set_flashdata('error', 'Purchase payment failed');
                }

                redirect('purchase');
            }
        }
    }

    /**
     * This function is used to delete the purchase entry using id
     * @return boolean $result : TRUE / FALSE
     */
    function deletePurchase()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $srId = $this->input->post('srId');
            $result = $this->purchase->deletePurchase($srId);
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

}