<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-list-ol" aria-hidden="true"></i> Item List
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
                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i>  Add New Item</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Item List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>item" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Item Name</th>
                      <th>Price</th>
                      <th>Labour</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($itemRecords))
                    {
                        foreach($itemRecords as $record)
                        {
                    ?>
                    <tr>
                        <td><?= $record->item_name ?></td>
                        <td><?= $record->item_price ?></td>
                        <td><?= $record->item_labour ?></td>
                        <td class="text-center">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?= $record->srno ?>">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
    </section>
</div>

<div id="myModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <form method="post" action="<?= base_url() ?>item/addNewItem">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Item</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="itemname">Item Name:</label>
                        <input type="text" class="form-control" id="itemname" name="itemname" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="itemprice">Item Price:</label>
                        <input type="number" class="form-control" id="itemprice" step="any" name="itemprice" required>
                    </div>
                    <div class="form-group">
                        <label for="itemlabour">Labour:</label>
                        <input type="number" class="form-control" id="itemlabour" step="any" name="itemlabour" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Submit" class="btn btn-primary pull-right" />
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

if (!empty($itemRecords))
{
        // output data of each row
    foreach($itemRecords as $rec)
    {
    ?>
    <div id="myModal<?=$rec->srno?>" class="modal" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <form method="post" action="<?= base_url() ?>item/editItem">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Address</h4>
                    </div>
                    <div class="modal-body">                        
                        <div class="form-group hidden">
                            <label for="itemname">Item No:</label>
                            <input type="text" class="form-control" id="itemno" name="itemno" required value="<?=$rec->srno?>">
                        </div>
                        <div class="form-group">
                            <label for="itemname">Item Name:</label>
                            <input type="text" class="form-control" id="itemname" name="itemname" value="<?=$rec->item_name?>" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="itemprice">Item Price:</label>
                            <input type="number" class="form-control" id="itemprice" step="any" value="<?=$rec->item_price?>" name="itemprice" required>
                        </div>
                        <div class="form-group">
                            <label for="itemlabour">Labour:</label>
                            <input type="number" class="form-control" id="itemlabour" step="any" value="<?=$rec->item_labour?>" name="itemlabour" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-primary pull-right" />
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

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "item/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>