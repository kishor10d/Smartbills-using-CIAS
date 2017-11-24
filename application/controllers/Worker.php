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
            
            $data['workerRecords'] = $this->worker->workerListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'SmartCIAS : Workers';

            // pre($data);
            // pre($this->db->last_query());
            // die;
            // TODO :: Check workerListing query
            
            $this->loadViews("worker", $this->global, $data, NULL);
        }
    }
}