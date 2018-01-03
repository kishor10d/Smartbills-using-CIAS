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
        $data["purchaseParties"] = $this->purchase->getPurchaseParties();
        $data["selected"] = $partyName;
        $data["selected2"] = urldecode($partyNameEncoded);

        $data["purchasePartyReport"] = $this->purchase->getPurchasePartiesReport(urldecode($partyNameEncoded));

        $this->global['pageTitle'] = 'SmartCIAS : Purchase Report';
        
            
        $this->loadViews("report/purchase", $this->global, $data, NULL);
    }
}