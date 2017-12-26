<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Item_model 
 * User model to handle database operations related to item list
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Item_model extends CI_Model
{
	/**
     * This function is used to get the worker listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function itemListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.srno, BaseTbl.item_name, BaseTbl.item_price, BaseTbl.item_labour');
        $this->db->from('item_list as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.item_name LIKE '%".$searchText."%')";
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
    function itemListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.srno, BaseTbl.item_name, BaseTbl.item_price, BaseTbl.item_labour');
        $this->db->from('item_list as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.item_name LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();

        return $result;
    }

    /**
     * This function is used to add new item to system
     * @param array $itemList : This is item info
     * @return number $insert_id : This is last inserted id
     */
    function addNewItem($itemList)
    {
        $this->db->trans_start();
        $this->db->insert('item_list', $itemList);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to edit item details
     * @param array $itemInfo : This is item info
     * @param number $itemId : This is item id
     * @return number $insert_id : This is last inserted id
     */
    function editItem($itemInfo, $itemId)
    {
        $this->db->where("srno", $itemId);
        $this->db->update('item_list', $itemInfo);
        
        return 1;
    }
}