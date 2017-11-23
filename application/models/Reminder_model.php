<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Reminder_model 
 * Reminder model used to handle the operations related to reminders
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 23 November 2017
 */
class Reminder_model extends CI_Model
{
    /**
     * This function is used to get the reminder listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function remListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.srno, BaseTbl.period, BaseTbl.remindertext, BaseTbl.date, BaseTbl.datetime');
        $this->db->from('reminder as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.remindertext  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return count($query->result());
    }
    
    /**
     * This function is used to get the reminder listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function remListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.srno, BaseTbl.period, BaseTbl.remindertext, BaseTbl.date, BaseTbl.datetime');
        $this->db->from('reminder as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.remindertext  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to delete the reminder information
     * @param number $srId : This is reminder id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteReminder($srId)
    {
        $this->db->delete('reminder', array('srno' => $srId));
        return $this->db->affected_rows();
    }
}