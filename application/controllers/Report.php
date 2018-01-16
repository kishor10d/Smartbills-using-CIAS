<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Report (ReportController)
 * User Class to control all report related operations
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 28 Dec 2017
 */
class Report extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_model', 'purchase');
        $this->isLoggedIn();   
    }
    
    public function purchaseIndex($partyName = "", $partyNameEncoded = "")
    {
        $purchaseParties = $this->purchase->getPurchaseParties();
        $data["purchaseParties"] = $purchaseParties;
        $data["selected"] = $partyName;
        $data["selected2"] = urldecode($partyNameEncoded);

        $purchasePartiesResult = array();

        if(!empty($partyName) && !empty($partyNameEncoded)){ $purchasePartiesResult = $this->purchase->getPurchaseParties(urldecode($partyNameEncoded)); }
        else { $purchasePartiesResult = $this->purchase->getPurchaseParties(); }

        $data["grabbed"] = $this->grabData($purchasePartiesResult);        

        $this->global['pageTitle'] = 'SmartCIAS : Purchase Report';
        
        $this->loadViews("report/purchase", $this->global, $data, NULL);
    }

    function grabData($purchasePartiesResult)
    {
        $grabbed = array();
        $allTotal = 0;
        $allPaidTotal = 0;

        foreach ($purchasePartiesResult as $par)
        {
            $perParty = array();
            $perPartyRow = array();
            $companyTotal = 0;
            $companyPaidTotal = 0;
            $startDate = $this->purchase->getDateByPartyName($par->party_name, "ASC");
            $endDate = $this->purchase->getDateByPartyName($par->party_name, "DESC");
            
            $begin = new DateTime($startDate);
            $end = new DateTime($endDate);

            while ($begin <= $end)
            {
                $startday = $begin->format('Y-m')."-01";
                $endday = date("Y-m-t", strtotime($startday));

                $resultStartEnd = $this->purchase->selectBetweenStartEnd($par->party_name, $startday, $endday);

                $newResultSet = array();
                $monthly_total = 0;
                $monthly_paid_total = 0;

                foreach($resultStartEnd as $res)
                {
                    $innerResult = $res;
                    $totalPaid = $this->purchase->totalPaid($res->srno);
                    // pre($totalPaid);
                    $total = round((float)$res->total + (float)$res->tax + (float)$res->othercharges);
                    $innerResult->row_total = $total;
                    $innerResult->row_total_paid = $totalPaid;
                    $monthly_total = $monthly_total + $total;
                    $monthly_paid_total = $monthly_paid_total + $totalPaid;
                    $companyTotal = $companyTotal + $total;
                    $companyPaidTotal = $companyPaidTotal + $totalPaid;
                    array_push($newResultSet, $innerResult);
                }
                $newResultSet["count"] = count($newResultSet);
                $newResultSet["monthly_total"] = $monthly_total;
                $newResultSet["monthly_paid_total"] = $monthly_paid_total;
                $newResultSet["month"] = $begin->format('M');
                $newResultSet["year"] = $begin->format('Y');
                if($newResultSet["count"]){
                    array_push($perPartyRow, $newResultSet);
                }
                
                $begin->modify('first day of next month');
            }
            $perParty["row"] = $perPartyRow;
            $perParty["companyTotal"] = $companyTotal;
            $perParty["companyPaidTotal"] = $companyPaidTotal;

            $grabbed[$par->party_name] = $perParty;
            $allTotal = $allTotal + $companyTotal;
            $allPaidTotal = $allPaidTotal + $companyPaidTotal;
            
            
        }
        $grabbed["count"] = count($perParty);
        $grabbed["allTotal"] = $allTotal;
        $grabbed["allPaidTotal"] = $allPaidTotal;

        return $grabbed;
    }
}