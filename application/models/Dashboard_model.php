<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Dashboard_model 
 * Dashboard model used to handle the operations related to dashboard 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 23 November 2017
 */
class Dashboard_model extends CI_Model
{
    public function getReminderCount()
    {
        $this->db->select("*");
        $this->db->from("reminder");
        $this->db->where("date", date("Y-m-d"));
        $this->db->or_where("period", "d");
        $query = $this->db->get();
        return $query->num_rows();
    }
}