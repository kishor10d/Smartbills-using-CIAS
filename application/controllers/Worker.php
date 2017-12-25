<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Worker (WorkerController)
 * Worker Class to control all Worker related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Worker extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('worker_model', 'worker');
        $this->isLoggedIn();   
    }

    /**
     * This function used to load the first screen of the user
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
            
            $count = $this->worker->workerListingCount($searchText);

			$returns = $this->paginationCompress ( "worker/", $count, 5 );

            $result = $this->worker->workerListing($searchText, $returns["page"], $returns["segment"]);

            $workerRecords = array();

            foreach ($result as $rec)
            {
                $rec->WLamount = $this->worker->workerLoanById($rec->srno);
                $rec->WLPamount = $this->worker->workerLoanPaidById($rec->srno);
                $rec->SGamount = $this->worker->workerSalaryPaidById($rec->srno);
                array_push($workerRecords, $rec);
            }
            
            $data['workerRecords'] = $workerRecords;
            
            $this->global['pageTitle'] = 'SmartCIAS : Workers';

            $this->loadViews("worker/index", $this->global, $data, NULL);
        }
    }

    /**
     * This function used to insert new workder data
     */
    function addNewWorker()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('name','Worker Name','trim|required|max_length[50]');
            $this->form_validation->set_rules('phone','Phone','trim|required|numeric|max_length[15]');
            $this->form_validation->set_rules('address','Address','trim|required|max_length[128]');
            $this->form_validation->set_rules('salary','Salary','required|numeric');
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }
            else
            {                
                $workerInfo = array('worker_name'=>$this->input->post("name"),
                                    'phone'=>$this->input->post("phone"),
                                    'address'=>$this->input->post("address"),
                                    'datetime'=>date('Y-m-d H:i:sa'),
                                    'salary'=>$this->input->post("salary"));

                $result = $this->worker->addNewWorker($workerInfo);

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Worker created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Worker creation failed');
                }
                
                redirect('worker');
            }
        }
    }
}