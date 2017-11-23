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
            
            $this->loadViews("reminder", $this->global, $data, NULL);
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
}