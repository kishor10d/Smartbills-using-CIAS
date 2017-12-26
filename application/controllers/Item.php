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

    /**
     * This function used to insert new item in list
     */
    function addNewItem()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('itemname','Item Name','trim|required|max_length[50]');
            $this->form_validation->set_rules('itemprice','Price','trim|required|numeric');
            $this->form_validation->set_rules('itemlabour','Labour','trim|required|numeric');
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }
            else
            {                
                $itemInfo = array('item_name'=>$this->input->post("itemname"),
                                    'item_price'=>$this->input->post("itemprice"),
                                    'item_labour'=>$this->input->post("itemlabour"));

                $result = $this->item->addNewItem($itemInfo);

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New item created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Item creation failed');
                }
                
                redirect('item');
            }
        }
    }

    /**
     * This function used to insert new item in list
     */
    function editItem()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('itemname','Item Name','trim|required|max_length[50]');
            $this->form_validation->set_rules('itemprice','Price','trim|required|numeric');
            $this->form_validation->set_rules('itemlabour','Labour','trim|required|numeric');
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }
            else
            {                
                $itemInfo = array('item_name'=>$this->input->post("itemname"),
                                    'item_price'=>$this->input->post("itemprice"),
                                    'item_labour'=>$this->input->post("itemlabour"));

                $result = $this->item->editItem($itemInfo, $this->input->post("itemno"));

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New item updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Item updation failed');
                }
                
                redirect('item');
            }
        }
    }
}