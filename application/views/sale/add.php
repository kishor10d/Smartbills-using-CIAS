<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css" />
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-money" aria-hidden="true"></i> Sale Bill
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <div class="col-md-12">              
                <div class="box box-primary">
                    <form role="form" id="addBill" action="<?php echo base_url() ?>addNewBill" method="post" role="form">
                        <div class="box-header">
                            <h3 class="box-title">Enter Sale Details</h3>
                        </div>                    
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="billno">Bill No:</label>
                                        <input type="text" class="form-control required" id="billno" name="billno" maxlength="10" autofocus required>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date">Date:</label>
                                        <input type="text" class="form-control required datepicker" value="<?=date('d-m-Y')?>" id="date" name="date" maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="password">Buyers Name:</label>
                                        <select class="form-control" id="buyersname" name="buyersname" required>
                                            <option value="">Select seller</option>
                                            <?php
                                            foreach($addresses as $rec)
                                            {?>
                                                <option value="<?= $rec->companyname ?>"><?= $rec->companyname ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
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
});
</script>