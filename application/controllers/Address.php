<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Reminder (ReminderController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Address extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('address_model', 'address');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the address
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
            
            $count = $this->address->AddressListingCount($searchText);
			$returns = $this->paginationCompress("address/", $count, 5 );
            
            $data['addressRecords'] = $this->address->addressListing($searchText, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = 'SmartCIAS : Address';
            
            $this->loadViews("address", $this->global, $data, NULL);
        }
    }
    /**
     * This function used to add address
     */
    function addNewAddress()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('company','Company Text','trim|required|max_length[250]');
            $this->form_validation->set_rules('address','Address','trim|required|max_length[2500]');
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }
            else
            { 
                $companyName = $this->input->post('company');
                $address = $this->input->post('address');
                
                $addressInfo = array('companyname'=>$companyName,
                    'address'=>$address, 'creationdate'=>date('Y-m-d H:i:sa'));

                $result = $this->address->addNewAddress($addressInfo);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Address created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Address creation failed');
                }
                
                redirect('Address');
            }
        }
    }

    /**
     * This function is used to edit the address information
     */
    function updateAddress()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $addrId = $this->input->post('srno');
            
            $this->form_validation->set_rules('company','Company Text','trim|required|max_length[250]');
            $this->form_validation->set_rules('address','Address','trim|required|max_length[2500]');
            
            if($this->form_validation->run() == True)
            {
                               
                $companyName = $this->input->post('company');
                $address = $this->input->post('address');
                
                $addressInfo = array();
                
                if(!empty($companyName) || !empty($address) )
                {
                    $addressInfo = array('companyName'=>$companyName, 'address'=>$address);
                }
              
                $result = $this->address->updateAddressData($addressInfo, $addrId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Address updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Address updation failed');
                }
                
                redirect('address');
            }
        }
    }



}
