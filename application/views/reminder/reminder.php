<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css" />
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-bell" aria-hidden="true"></i> Reminder
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
                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i>  Add New Reminder</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Reminder List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>reminder" method="POST" id="searchList">
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
                      <th>Dated</th>
                      <th>Text</th>
                      <th>Reminder Period</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($remRecords))
                    {
                        foreach($remRecords as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo date('d-m-Y', strtotime($record->date)) ?></td>
                        <td><?php echo $record->remindertext ?></td>
                        <td>
                        <?php
                            if ($record->period == 'm') {
                                echo 'Monthly';
                            }
                            else if ($record->period == 'd') {
                                echo 'Daily';
                            }
                            else if ($record->period == 'y') {
                                echo 'Yearly';
                            }
                            else {
                                echo 'Today';
                            }
                        ?>
                        </td>
                        <td class="text-center">
                            <a href="#" data-srno="<?php echo $record->srno; ?>" class="deleteReminder btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
            <form method="post" action="<?= base_url().'reminder/addNewReminder' ?>" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Reminder</h4>
                </div>
                <div class="modal-body">                    
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input class="form-control pull-right" id="datepicker" name="date" type="text" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="text">Reminder Text:</label>
                        <textarea type="text" class="form-control" id="text" name="reminderText" style="resize: none;" required autofocus></textarea>
                    </div>
                    <div class="form-group">
                        <label for="period">Set Period:</label>
                        <select class="form-control" name="period" id="period" required>
                            <option value="o">Once</option>
                            <option value="d">Daily</option>
                            <option value="m">Monthly</option>
                            <option value="y">Yearly</option>
                        </select>
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
            jQuery("#searchList").attr("action", baseURL + "reminder/" + value);
            jQuery("#searchList").submit();
        });

        jQuery('#datepicker').datepicker({
          autoclose: true,
          format : "dd-mm-yyyy"
        });
    });
</script>