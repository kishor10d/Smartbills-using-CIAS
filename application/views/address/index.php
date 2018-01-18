<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-envelope" aria-hidden="true"></i> Address 
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
                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i>  Add New Address</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Address List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>address" method="POST" id="addressList">
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
                            <th>Company Name</th>
                            <th>Address</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        <?php
                        if(!empty($addressRecords))
                        {
                            foreach($addressRecords as $record)
                            {
                        ?>
                        <tr>
                            <td><?php echo $record->companyname ?></td>
                            <td><?php echo $record->address ?></td>
                            <td class="text-center">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModel<?= $record->srno?>"><i class="fa fa-pencil"></i></button>  
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
        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="<?= base_url().'address/addNewAddress' ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Address</h4>
                </div>
                <div class="modal-body">
                
                    <div class="form-group">
                        <label for="company">Company Name:</label>
                        <input type="text" class="form-control" id="company" name="company" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="address">Company Address:</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>            
                </div>
                <div class="modal-footer">
                    <input type="Submit" value="Submit" class="btn btn-primary pull-right" />
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if(!empty($addressRecords))
{
    foreach($addressRecords as $record)
    {
    ?>
    <div id="updateModel<?=$record->srno?>" class="modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="<?= base_url().'address/updateAddress' ?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Address</h4>
                    </div>
                    <div class="modal-body">                        
                        <div class="form-group">
                            <label for="company">Company Name:</label>
                            <input type="text" class="form-control hidden" id="srno" name="srno" value="<?=$record->srno?>" required>
                            <input type="text" value="<?=$record->companyname?>" class="form-control" id="company" name="company" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="address">Company Address:</label>
                            <input type="text" value="<?=$record->address?>" class="form-control" id="address" name="address" required>
                        </div>                        
                    </div>
                    <div class="modal-footer">
                        <input type="Submit" value="Submit" class="btn btn-primary pull-right" />
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
            jQuery("#addressList").attr("action", baseURL + "address/" + value);
            jQuery("#addressList").submit();
        });
    });
</script>
