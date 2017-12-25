<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Worker_model 
 * Worker model used to handle the operations related to workers
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 23 November 2017
 */
class Worker_model extends CI_Model
{
    /**
     * This function is used to get the worker listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function workerListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.srno, BaseTbl.worker_name, BaseTbl.phone, BaseTbl.address, BaseTbl.salary');
        $this->db->from('worker as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.worker_name LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the worker listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function workerListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.srno, BaseTbl.worker_name, BaseTbl.phone, BaseTbl.address, BaseTbl.salary');
        $this->db->from('worker as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.worker_name LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();

        return $result;
    }

    function workerLoanById($workerId)
    {
        $this->db->select('SUM(amount) as WLamount');
        $this->db->where("workersrno", $workerId);
        $this->db->group_by("workersrno");
        $query = $this->db->get("workerloan");

        $result = $query->row(); 
        // pre($result);
        return empty($result) ? "" : $result->WLamount;
    }

    function workerLoanPaidById($workerId)
    {
        $this->db->select('SUM(amount) as WLPamount');
        $this->db->where("workersrno", $workerId);
        $this->db->group_by("workersrno");
        $query = $this->db->get("workerloanpaid");

        $result = $query->row(); 
        // pre($result);
        return empty($result) ? "" : $result->WLPamount;
    }

    function workerSalaryPaidById($workerId)
    {
        $this->db->select('SUM(totalsalary) as SGamount');
        $this->db->where("workerno", $workerId);
        $this->db->group_by("workerno");
        $query = $this->db->get("salarygiven");

        $result = $query->row(); 
        // pre($result);
        // die;
        return empty($result) ? 0 : $result->SGamount;
    }
}