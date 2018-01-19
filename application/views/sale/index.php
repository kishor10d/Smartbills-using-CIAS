<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-money" aria-hidden="true"></i> Sales Bills
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
                <?php  
                    $warning = $this->session->flashdata('warning');
                    if($warning)
                    {
                ?>
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('warning'); ?>
                </div>
                <?php } ?>
                <?php  
                    $info = $this->session->flashdata('info');
                    if($info)
                    {
                ?>
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('info'); ?>
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
                    <a class="btn btn-primary" href="<?= base_url() ?>sale/addNew"><i class="fa fa-plus" aria-hidden="true"></i> Add Sale Details</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Sale List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>sale" method="POST" id="searchList">
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
                      <th>Buyers Name</th>
                      <th class="text-center">Amount</th>
                      <th class="text-center">Vat</th>
                      <th class="text-center">Other Charges</th>
                      <th class="text-center">Grand Total</th>
                      <th class="text-center">Details</th>
                      <th class="text-center">Delete</th>
                      <th class="text-center">Edit</th>
                      <th class="text-center">Sample</th>
                      <th class="text-center">Challan</th>
                      <th class="text-center">Invoice</th>
                    </tr>
                    <?php
                    if(!empty($saleRecords))
                    {
                        foreach($saleRecords as $record)
                        {
                            $total = 0;
                            $total = (($record->amount + $record->other_charges)*($record->vat/100)) + ($record->amount + $record->other_charges);
                            $total = round($total);
                    ?>
                    <tr>
                        <td><?= $record->bill_no ?></td>
                        <td><?= $record->sell_date ?></td>
                        <td><?= $record->buyer_name ?></td>
                        <td class="text-center"><?= $record->amount ?></td>
                        <td class="text-center"><?= $record->vat ?></td>
                        <td class="text-center"><?= $record->other_charges ?></td>
                        <td class="text-center"><?= $total ?></td>
                        <td class="text-center"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-cog" aria-hidden="true"></td>
                        <td class="text-center"><button class="btn btn-default"><i class="fa fa-times" aria-hidden="true" style="color:red"></i></button></td>
                        <td class="text-center"><a href="<?= base_url().'sale/editOld/'.$record->srno ?>" class="btn btn-success">Edit</a></td>
                        <td class="text-center"><button class="btn btn-success">Add</button></td>
                        <td class="text-center"><button class="btn btn-success">Print</button></td>
                        <td class="text-center"><button class="btn btn-success">Print</button></td>
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

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "sale/" + value);
            jQuery("#searchList").submit();
        });
        setTimeout( function() { $(".alert").fadeOut("slow") }, 5000);
    });
</script>