<?php
$totalAmount = $billData->amount + $billData->other_charges +  ((($billData->amount + $billData->other_charges) * $billData->vat)/100);
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css" />
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-money" aria-hidden="true"></i> Sales Bill
        <small>Edit sale bill</small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-md-12 form-group">
                <button class="btn btn-primary btn-sm pull-right" onclick="window.history.back()"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">              
                <div class="box box-primary">
                    <form role="form" id="editBill" action="<?php echo base_url() ?>sale/updateTotalSale" method="post" role="form">
                        <div class="box-header">
                            <h3 class="box-title">Enter Sale Details</h3>
                        </div>                    
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="billno">Bill No:</label>
                                        <input type="hidden" id="hSrno" name="hSrno" value="<?= $billData->srno ?>" />
                                        <input type="hidden" id="hBillno" name="hBillno" value="<?= $billData->bill_no ?>" />
                                        <input type="text" class="form-control required" id="billno" value="<?= $billData->bill_no ?>" name="billno" maxlength="10" autofocus disabled>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date">Date:</label>
                                        <input type="text" class="form-control required datepicker" value="<?= date('d-m-Y', strtotime($billData->sell_date)) ?>" id="date" name="date" maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="password">Buyers Name:</label>
                                        <select class="form-control" id="buyersname" name="buyersname" required>
                                            <?php
                                            foreach($addresses as $rec)
                                            {?>
                                                <option value="<?= $rec->companyname ?>" <?= ($billData->buyer_name == $rec->companyname) ? "selected" : NULL ?>><?= $rec->companyname ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="itemname">Item Name:</label>
                                        <select class="form-control" id="itemname" name="itemname" required>
                                            <?php
                                            foreach($items as $it)
                                            {?>
                                                <option value="<?= $it->item_name ?>"><?= $it->item_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" min="0" value="0" class="form-control" id="quantity" step="any" name="quantity">                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="weight">Weight:</label>
                                        <input type="number" min="0" value="0" class="form-control" id="weight" step="any" name="weight">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button id="btnAddItem" class="btn btn-success btn-block" style="margin-top: 24px">Add Item</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div style="margin-bottom: 50px" id="description">
                                <?php $this->load->view("sale/_itemlist", array("itemData"=>$itemData)); ?>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="amount">Amount:</label>
                                        <input type="number" class="form-control" id="amount" step="any" name="amount" value="<?= $billData->amount ?>" min="0" readonly required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="othercharges">Other Charges:</label>
                                        <input type="number" class="form-control" min="0" value="<?=$billData->other_charges ?>" id="othercharges" step="any" name="othercharges" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="vat">VAT in %age:</label>
                                        <input type="number" class="form-control" min="0" value="<?=$billData->vat?>" id="vat" step="any" name="vat" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="totalamount">Total Amount:</label>
                                        <input type="number" class="form-control" min="0" value="<?= $totalAmount ?>" id="totalamount" step="any" readonly name="totalamount" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </section>
    
</div>

<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy"
    });
    

    var calculate = function() {
        var amount = parseFloat($("#amount").val()),
            othercharges = parseFloat($("#othercharges").val()),
            vat = parseFloat($("#vat").val());
        $("#totalamount").val(amount+othercharges+ ( (amount + othercharges)*(vat)/100 ));
    };

    jQuery("#vat").change(calculate);
    jQuery("#othercharges").change(calculate);
    jQuery("#amount").change(calculate);

    jQuery('#btnAddItem').click(function(e){
        e.preventDefault();

        var readyData = { billno : $("#hBillno").val(),
            quantity : parseInt($("#quantity").val()),
            weight : parseFloat($("#weight").val()),
            itemname : $("#itemname").val(),
            sell_date : $("#date").val()
        };
        var hitURL = baseURL + "sale/addItemToBill";

        jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : readyData 
        }).done(function(data){
            $("#description").html(data.html);
            $("#amount").val(data.itemTotal);
            $("#amount").trigger("change");
        });
    });

    jQuery(document).on("click", ".itemDelete", function(e){
        e.preventDefault();

        var readyData = {
            billno : $("#hBillno").val(),
            srno : $(this).data("srno")
        };
        var hitURL = baseURL + "sale/deleteItemFromBill";

        jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : readyData 
        }).done(function(data){
            $("#description").html(data.html);
            $("#amount").val(data.itemTotal);
            $("#amount").trigger("change");
        });
    });   
    
});

</script>