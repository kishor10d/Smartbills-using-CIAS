<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Sale_model 
 * Sale model used to handle the operations related to sales
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 16 January 2017
 */
class Sale_model extends CI_Model
{
    protected $tableName = '';

    function __construct()
    {
        parent::__construct();
        $this->tableName = $this->session->userdata ( 'type' );
    }

    /**
     * This function is used to get the bills listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function saleListingCount($searchText = '')
    {
        $this->db->select("BaseTbl.*");
        $this->db->from($this->tableName.'_bill as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.bill_no  LIKE '%".$searchText."%' 
                            OR  BaseTbl.buyer_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.buyer_address  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    /**
     * This function is used to get the bills listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function saleListing($searchText = '', $page, $segment)
    {
        $this->db->select("BaseTbl.*");
        $this->db->from($this->tableName.'_bill as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.bill_no  LIKE '%".$searchText."%' 
                            OR  BaseTbl.buyer_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.buyer_address  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by("BaseTbl.srno", "DESC");
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
}