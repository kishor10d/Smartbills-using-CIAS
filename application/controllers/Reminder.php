<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Reminder (ReminderController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Reminder extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reminder_model', 'reminder');
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
            
            $count = $this->reminder->remListingCount($searchText);

			$returns = $this->paginationCompress ( "reminder/", $count, 5 );
            
            $data['remRecords'] = $this->reminder->remListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'SmartCIAS : Reminders';
            
            $this->loadViews("reminder/reminder", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to delete the reminder using id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteReminder()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $srId = $this->input->post('srId');            
            $result = $this->reminder->deleteReminder($srId);
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

    function addNewReminder()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('date','Date','trim|required|max_length[20]');
            $this->form_validation->set_rules('reminderText','Reminder Text','trim|required|max_length[128]');
            $this->form_validation->set_rules('period','Period','required|max_length[2]');
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }
            else
            {
                $date = $this->input->post('date');
                $reminderText = $this->input->post('reminderText');
                $period = $this->input->post('period');
                
                $reminderInfo = array('date'=>date('Y-m-d', strtotime($date)),
                    'remindertext'=>$reminderText,
                    'period'=>$period, 'datetime'=>date('Y-m-d H:i:sa'));

                $result = $this->reminder->addNewReminder($reminderInfo);

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Reminder created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Reminder creation failed');
                }
                
                redirect('reminder');
            }
        }
    }
}