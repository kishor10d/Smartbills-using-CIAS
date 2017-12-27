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
            
            $data['purchaseRecords'] = $this->purchase->purchaseListing($searchText, $returns["page"], $returns["segment"]);
            $data['addresses'] = $this->address->getAddresses();
            $this->global['pageTitle'] = 'SmartCIAS : Purchase Bills';
            
            $this->loadViews("purchase/index", $this->global, $data, NULL);
        }
    }

    function addNewPurchase()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            // pre($this->input->post());
            // die;

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
                pre($post);
                $purchaseInfo = array('bill_no'=>$post["billno"],
                                    'pur_date'=>date('Y-m-d', strtotime($post["date"])),
                                    'party_name'=>$post["sellersname"],
                                    'total'=>$post["amount"],
                                    'tax'=>$post["vat"],
                                    'othercharges'=>$post["othercharges"],
                                    'grand_total'=>$post["totalamount"]);

                $result = $this->purchase->addNewPurchase($purchaseInfo);

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Purchase details created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Purchase details creation failed');
                }

                redirect('purchase');
            }
        }
    }

}