<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css" />
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Purchase Bills
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-10">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xs-12 text-right">
                <div class="form-group">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i>  Add Purchase Details</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Purchase List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>purchase" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Bill No</th>
                      <th>Date</th>
                      <th>Sellers Name</th>
                      <th class="text-center">Amount</th>
                      <th class="text-center">Vat</th>
                      <th class="text-center">Other Charges</th>
                      <th class="text-center">Grand Total</th>
                      <th class="text-center">Paid</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($purchaseRecords))
                    {
                        foreach($purchaseRecords as $record)
                        {
                    ?>
                    <tr>
                        <td><?= $record->bill_no ?></td>
                        <td><?= $record->pur_date ?></td>
                        <td><?= $record->party_name ?></td>
                        <td class="text-center"><?= $record->total ?></td>
                        <td class="text-center"><?= $record->tax ?></td>
                        <td class="text-center"><?= $record->othercharges ?></td>
                        <td class="text-center"><?= $record->grand_total ?></td>
                        <td class="text-center"><?= $record->payment ?>
                            <br />
                            <button class="btn btn-sm btn-warning" onclick="openmodal(<?=$record->srno ?>)">Add Payment</button>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal<?= $record->srno ?>"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                            <button data-srno="<?= $record->srno ?>" class="deletePurchase btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div>
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>


<div id="myModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= base_url() ?>purchase/addNewPurchase">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Purchase Details</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="billno">Bill No:</label>
                            <input type="text" class="form-control" id="billno" name="billno" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="date">Date:</label>
                            <input type="text" class="form-control datepicker" id="date" name="date" value="<?=date('d-m-Y')?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sellersname">Sellers Name:</label>
                        <select class="form-control" id="sellersname" name="sellersname" required>
                            <option value="">Select seller</option>
                        <?php
                        foreach($addresses as $rec)
                        {?>
                            <option value="<?= $rec->companyname ?>"><?= $rec->companyname ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="amount">Amount:</label>
                            <input type="number" class="form-control" id="amount" step="any" name="amount" min="1" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="vat">VAT:</label>
                            <input type="number" class="form-control" id="vat" step="any" name="vat" min="0" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="othercharges">Other Charges:</label>
                            <input type="number" class="form-control" id="othercharges" step="any" min="0" name="othercharges" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="totalamount">Total Amount:</label>
                            <input type="number" class="form-control" id="totalamount" step="any" min="0" name="totalamount" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary pull-right" value="Submit" />
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php

if ($purchaseRecords > 0) {
    foreach ($purchaseRecords as $record) { ?>
        <div id="myModal<?= $record->srno ?>" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="<?= base_url() ?>purchase/addNewPurchase">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Purchase Details</h4>
                        </div>
                        <div class="modal-body">
                            <input type="number" class="hidden" name="srno" id="srno" value="<?= $record->srno ?>" required>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="billno">Bill No:</label>
                                    <input type="text" class="form-control" id="billno" name="billno" value="<?=$record->bill_no?>" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="date">Date:</label>
                                    <input type="text" class="form-control datepicker" id="date" name="date" value="<?=date('d-m-Y', strtotime($record->pur_date))?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sellersname">Sellers Name:</label>
                                <select class="form-control" id="sellersname" name="sellersname" required>
                                    <option value="">Select seller</option>
                                    <?php
                                    foreach($addresses as $rec)
                                    {?>
                                        <option <?php if($rec->companyname == $record->party_name) { echo "selected=selected"; } ?> value="<?= $rec->companyname ?>"><?= $rec->companyname ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="amount">Amount:</label>
                                    <input type="number" class="form-control" id="amount" step="any" name="amount" value="<?= $record->total ?>" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="vat">VAT:</label>
                                    <input type="number" class="form-control" id="vat" step="any" name="vat" value="<?= $record->tax ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="othercharges">Other Charges:</label>
                                    <input type="number" class="form-control" id="othercharges" step="any" value="<?= $record->othercharges ?>"
                                        name="othercharges" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="totalamount">Grand Total:</label>
                                    <input type="number" class="form-control" id="totalamount" step="any" name="totalamount" value="<?= $record->grand_total?>"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary pull-right" value="Submit" />
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
}
?>


<div id="myModalpurchase" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= base_url() ?>purchase/purchasePaid">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Paid Details</h4>
                </div>
                <div class="modal-body">
                    <input type="number" class="hidden" name="srnopurchase" id="srnopurchase" required>
                    <div class="form-group">
                        <label for="itemprice">Paid Date:</label>
                        <input type="text" class="form-control datepicker" id="paiddate" name="paiddate" value="<?=date('d-m-Y')?>" required>
                    </div>
                    <div class="form-group">
                        <label for="itemlabour">Paid Amount:</label>
                        <input type="number" class="form-control" id="paidamount" step="any" name="paidamount" required>
                    </div>
                    <div class="form-group">
                        <label for="itemlabour">Payment Details:</label>
                        <input type="text" class="form-control" id="details" name="details" required>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary pull-right" value="Submit" />
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "purchase/" + value);
            jQuery("#searchList").submit();
        });

        jQuery('.datepicker').datepicker({
          autoclose: true,
          format : "dd-mm-yyyy"
        });
    });

    function openmodal(a){
        document.getElementById('srnopurchase').value = a;
        $('#myModalpurchase').modal('show');
    }
</script>