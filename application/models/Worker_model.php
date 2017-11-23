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
     * This function is used to get the reminder listing count
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
        
        return count($query->result());
    }
    
    /**
     * This function is used to get the reminder listing count
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
    }
}