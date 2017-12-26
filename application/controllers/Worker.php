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
     * This function is used to delete the worker using id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteWorker()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $srId = $this->input->post('srId');
            $result = $this->worker->deleteWorker($srId);
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
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

    /**
     * This function used to insert new workder data
     */
    function editWorker()
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

                $result = $this->worker->editWorker($workerInfo, $this->input->post("srno"));

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Worker updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Worker updation failed');
                }
                
                redirect('worker');
            }
        }
    }

    /**
     * This function used to update the salary given details to worker
     */
    function paySalary()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('salarypaiddate','Salary paid date','trim|required');
            $this->form_validation->set_rules('perdaysal','Per day salary','trim|required|numeric');
            $this->form_validation->set_rules('daysfilled','Days filled','trim|required|numeric');
            $this->form_validation->set_rules('totalsal','Total salary','required|numeric');
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }
            else
            {                
                $workerInfo = array('date'=>date('Y-m-d', strtotime($this->input->post("salarypaiddate")) ),
                                    'perdaysal'=>$this->input->post("perdaysal"),
                                    'nodaysfilled'=>$this->input->post("daysfilled"),
                                    'totalsalary'=>$this->input->post("totalsal"),
                                    'datetime'=>date('Y-m-d H:i:sa'),
                                    'workerno'=> $this->input->post("workerid")
                                );

                $result = $this->worker->paySalary($workerInfo);

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Worker salary paid successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Salary updation failed');
                }
                
                redirect('worker');
            }
        }
    }

    /**
     * This function used to insert loan taken details
     */
    function loanTaken()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            // pre($this->input->post());
            // die;

            $this->form_validation->set_rules('dateloan','Loan date','trim|required');
            $this->form_validation->set_rules('loanamount','Loan amount','trim|required|numeric');
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }
            else
            {                
                $workerInfo = array('date'=>date('Y-m-d', strtotime($this->input->post("dateloan")) ),
                                    'amount'=>$this->input->post("loanamount"),                                    
                                    'workersrno'=> $this->input->post("workerid"),
                                    'datetime'=>date('Y-m-d H:i:sa')
                                );

                $result = $this->worker->loanTaken($workerInfo);

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Worker loan disbursed successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Loan disbursment failed');
                }
                
                redirect('worker');
            }
        }
    }

    /**
     * This function used to insert loan taken details
     */
    function loanPayOff()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            // pre($this->input->post());
            // die;

            $this->form_validation->set_rules('paiddate','Loan date','trim|required');
            $this->form_validation->set_rules('paidamount','Loan amount','trim|required|numeric');
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }
            else
            {                
                $workerInfo = array('date'=>date('Y-m-d', strtotime($this->input->post("paiddate")) ),
                                    'amount'=>$this->input->post("paidamount"),                                    
                                    'workersrno'=> $this->input->post("workersrno"),
                                    'datetime'=>date('Y-m-d H:i:sa')
                                );

                $result = $this->worker->loanPayOff($workerInfo);

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Worker loan paid successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Loan payment failed');
                }
                
                redirect('worker');
            }
        }
    }
}