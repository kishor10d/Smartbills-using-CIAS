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
        
        return empty($result) ? "" : $result->WLamount;
    }

    function workerLoanPaidById($workerId)
    {
        $this->db->select('SUM(amount) as WLPamount');
        $this->db->where("workersrno", $workerId);
        $this->db->group_by("workersrno");
        $query = $this->db->get("workerloanpaid");

        $result = $query->row(); 
        
        return empty($result) ? "" : $result->WLPamount;
    }

    function workerSalaryPaidById($workerId)
    {
        $this->db->select('SUM(totalsalary) as SGamount');
        $this->db->where("workerno", $workerId);
        $this->db->group_by("workerno");
        $query = $this->db->get("salarygiven");

        $result = $query->row(); 
        
        return empty($result) ? 0 : $result->SGamount;
    }

    /**
     * This function is used to add new worker to system
     * @param array $workerInfo : This is worker info
     * @return number $insert_id : This is last inserted id
     */
    function addNewWorker($workerInfo)
    {
        $this->db->trans_start();
        $this->db->insert('worker', $workerInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to add new worker to system
     * @param array $workerInfo : This is worker info
     * @return number $insert_id : This is last inserted id
     */
    function editWorker($workerInfo, $workerId)
    {
        $this->db->where("srno", $workerId);
        $this->db->update('worker', $workerInfo);
        
        return 1;
    }

    /**
     * This function is used to add salary for worker to system
     * @param array $workerInfo : This is worker info
     * @return number $insert_id : This is last inserted id
     */
    function paySalary($workerInfo)
    {
        $this->db->trans_start();
        $this->db->insert('salarygiven', $workerInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to add laon for worker to system
     * @param array $workerInfo : This is worker info
     * @return number $insert_id : This is last inserted id
     */
    function loanTaken($workerInfo)
    {
        $this->db->trans_start();
        $this->db->insert('workerloan', $workerInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        
        return $insert_id;
    }
}