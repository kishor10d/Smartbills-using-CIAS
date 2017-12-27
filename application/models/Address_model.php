<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Reminder_model 
 * Reminder model used to handle the operations related to reminders
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 23 November 2017
 */
class Address_model extends CI_Model
{

     /**
     * This function is used to get the address listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function addressListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.srno, BaseTbl.companyname, BaseTbl.address, BaseTbl.creationdate');
        $this->db->from('address as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.address LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return count($query->result());
    }

    /**
     * This function is used to get the address listing 
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function addressListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.srno, BaseTbl.companyname, BaseTbl.address, BaseTbl.creationdate');
        $this->db->from('address as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.address LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to add new address to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewAddress($addressInfo)
    {
        $this->db->trans_start();
        $this->db->insert('address', $addressInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
     * This function is used to update address data.
     */
    function updateAddressData($addrInfo, $addId)
    {
        $this->db->where('srno', $addId);
        $this->db->update('address', $addrInfo);
        
        return TRUE;
    }

    /**
     * This function is use to get addresses
     */
    function getAddresses()
    {
        $this->db->select('BaseTbl.srno, BaseTbl.companyname, BaseTbl.address, BaseTbl.creationdate');
        $this->db->from('address as BaseTbl');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
}