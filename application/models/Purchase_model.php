<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Purchase_model 
 * Reminder model used to handle the operations related to purchase
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 27 December 2017
 */
class Purchase_model extends CI_Model
{
    protected $tableName = '';

    function __construct()
    {
        parent::__construct();
        $this->tableName = $this->session->userdata ( 'type' );
    }

    /**
     * This function is used to get the purchase bills listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function purchaseListingCount($searchText = '')
    {
        $this->db->select("BaseTbl.srno, BaseTbl.bill_no, BaseTbl.pur_date, BaseTbl.party_name, BaseTbl.total, BaseTbl.tax, BaseTbl.othercharges, BaseTbl.grand_total, BaseTbl.paid, BaseTbl.cheque_no");
        $this->db->from('purchase_'.$this->tableName.' as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.bill_no  LIKE '%".$searchText."%' 
                            OR  BaseTbl.party_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.cheque_no  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the purchase bills listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function purchaseListing($searchText = '', $page, $segment)
    {
        $this->db->select("BaseTbl.srno, BaseTbl.bill_no, BaseTbl.pur_date, BaseTbl.party_name, BaseTbl.total, BaseTbl.tax, BaseTbl.othercharges, BaseTbl.grand_total, BaseTbl.paid, BaseTbl.cheque_no");
        $this->db->from('purchase_'.$this->tableName.' as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.bill_no  LIKE '%".$searchText."%' 
                            OR  BaseTbl.party_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.cheque_no  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by("BaseTbl.srno", "DESC");
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to add new purchase to system
     * @param array $purchaseInfo : This is purchase info
     * @return number $insert_id : This is last inserted id
     */
    function addNewPurchase($purchaseInfo)
    {
        $this->db->trans_start();
        $this->db->insert('purchase_'.$this->tableName, $purchaseInfo);        
        $insert_id = $this->db->insert_id();        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to update the purchase details
     * @param array $userInfo : This is purchase updated information
     * @param number $purchaseId : This is purchase id
     */
    function updatePurchase($purchaseInfo, $purchaseId)
    {
        $this->db->where('srno', $purchaseId);
        $this->db->update('purchase_'.$this->tableName, $purchaseInfo);
        
        return TRUE;
    }

    /**
     * This function used to record purchase payments
     * @param array $paidInfo : This is purchase payment info
     * @param number $srno : This is sr no
     */
    function purchasePaid($purchasePaidInfo, $srNoPurchase)
    {
        $purchasePaidInfo["srnoofpurchase_".$this->tableName] = $srNoPurchase;

        $this->db->trans_start();
        $this->db->insert('purchase_'.$this->tableName.'_paid', $purchasePaidInfo);        
        $insert_id = $this->db->insert_id();        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    function getPurchasePaid($srNoPurchase)
    {
        $this->db->select("SUM(BaseTbl.paid_amount) as amount");
        $this->db->from('purchase_'.$this->tableName.'_paid as BaseTbl');
        $this->db->group_by("BaseTbl.srnoofpurchase_".$this->tableName);
        $this->db->where("BaseTbl.srnoofpurchase_".$this->tableName, $srNoPurchase);
        $query = $this->db->get();
        
        $result = $query->row();
        
        return empty($result) ? 0 : $result->amount;
    }

    function deletePurchase($srId)
    {
        $this->db->where('srno', $srId);
        $this->db->delete('purchase_'.$this->tableName);

        return $this->db->affected_rows();
    }
}