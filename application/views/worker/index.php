<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css" />
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-bell" aria-hidden="true"></i> Workers
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
                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-plus" aria-hidden="true"></i>  Add New Worker
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Workers List</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>worker" method="POST" id="searchList">
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
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Salary (per day)</th>
                                <th>Loan Taken</th>
                                <th>Loan Paid</th>
                                <th>Loan Bal</th>
                                <th>Pay Salary</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            <?php
                            if(!empty($workerRecords))
                            {
                                foreach($workerRecords as $record)
                                {
                                ?>
                            <tr>
                                <td><?php echo $record->worker_name ?></td>
                                <td><?php echo $record->phone ?></td>
                                <td style="width: 20%"><?php echo $record->address ?></td>
                                <td><?php echo $record->salary ?></td>
                                <td><?php echo $record->WLamount ?> <br />
                                    <button class="btn btn-primary btn-sm" 
                                    onclick="addloan(<?=$record->srno?>)">Add Loan</button>
                                </td>
                                <td><?php echo $record->WLPamount ?> <br />
                                    <button class="btn btn-primary btn-sm" 
                                    onclick="payoff(<?=$record->srno?>)">Pay Off</button>
                                </td>
                                <td><?php echo ($record->WLamount - $record->WLPamount) ?></td>
                                <td><?php echo $record->SGamount ?> <br />
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#paysalary<?=$record->srno ?>"><i class="fa fa-gear"> </i></button></td>
                                <td class="text-center"> <br />
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?= $record->srno ?>">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </button> 
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
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Worker</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url().'worker/addNewWorker' ?>">
                    <div class="form-group">
                        <label for="itemname">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="itemprice">Phone:</label>
                        <input type="number" class="form-control" id="phone" step="any" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="itemlabour">Address:</label>
                        <input type="text" class="form-control" id="address" step="any" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="itemlabour">Salary (per day):</label>
                        <input type="text" class="form-control" id="salary" step="any" name="salary" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
if(!empty($workerRecords))
{
    foreach($workerRecords as $rec) {
    ?>

    <div id="myModal<?= $rec->srno ?>" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Workers</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= base_url() ?>worker/editWorker">
                        <input type="text" class="form-control hidden" id="srno" name="srno" value="<?=$rec->srno ?>" required>
                        <div class="form-group">
                            <label for="itemname">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?=$rec->worker_name ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="itemprice">Phone:</label>
                            <input type="number" class="form-control" id="phone" step="any" name="phone" value="<?=$rec->phone ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="itemlabour">Address:</label>
                            <input type="text" class="form-control" id="address" step="any" name="address" value="<?=$rec->address ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="itemlabour">Salary(per day):</label>
                            <input type="text" class="form-control" id="salary" step="any" name="salary" value="<?=$rec->salary ?>" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>    
    <?php
    }
}
?>


<?php

if(!empty($workerRecords))
{
    foreach($workerRecords as $rec) {
    ?>

    <div id="paysalary<?=$rec->srno?>" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Pay Salary</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= base_url() ?>worker/paySalary">
                        <input type="text" class="form-control hidden" id="workerid" name="workerid" value="<?=$rec->srno?>" required>
                        <div class="form-group">
                            <label for="dateloan">Date of Salary:</label>
                            <input class="form-control datepicker" type="text" id="salarypaiddate" name="salarypaiddate" value="<?=date("d-m-Y")?>" required>
                        </div>
                        <div class="form-group">
                            <label for="perdaysal">Per Day Salary:</label>
                            <input type="text" class="form-control" id="perdaysal" name="perdaysal" value="<?=$rec->salary?>" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="daysfilled">No of Days filled:</label>
                            <input type="number" class="form-control" id="daysfilled<?=$rec->srno?>" step="any" name="daysfilled" onchange="function<?=$rec->srno?>(<?=$rec->salary?>)" oninput="function<?=$rec->srno?>(<?=$rec->salary?>)" value="1" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="totalsal">Total Salary:</label>
                            <input type="number" class="form-control" id="totalsal<?=$rec->srno?>" step="any" name="totalsal" readonly value="<?=$rec->salary?>" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>

    </div>

    <script>
        function function<?=$rec->srno?>(a){
            document.getElementById('totalsal<?=$rec->srno?>').value = document.getElementById('daysfilled<?=$rec->srno?>').value * a;
        }
    </script>
    <?php
    }
}
?>

<div id="myModalloantaken" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Loan Taken</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url() ?>worker/loanTaken">
                    <input type="text" required id="workerids" name="workerid" class="hidden">
                    <div class="form-group">
                        <label for="dateloan">Date of loan:</label>
                        <input class="form-control datepicker" type="text" id="dateloan" name="dateloan" value="<?=date("d-m-Y")?>" required>
                    </div>
                    <div class="form-group">
                        <label for="loanamount">Loan amount:</label>
                        <input class="form-control" type="number" id="loanamount" name="loanamount" min="1" required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="submit" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="myModalloanpaidoff" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Loan Paid Off</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url() ?>worker/loanPayOff">
                    <input type="text" required id="workersrnos" name="workersrno" class="hidden">
                    <div class="form-group">
                        <label for="dateloan">Date of loan:</label>
                        <input class="form-control datepicker" type="text" id="paiddate" name="paiddate" value="<?=date("d-m-Y")?>" required>
                    </div>
                    <div class="form-group">
                        <label for="loanamount">Loan amount:</label>
                        <input class="form-control" type="number" id="paidamount" name="paidamount" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
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
        jQuery( ".datepicker" ).datepicker({ format: 'dd-mm-yyyy' });
    });

    function addloan(srno){
        $('#workerids').val(srno);
        $('#myModalloantaken').modal('show');
    }
    function payoff(srno){
        $('#workersrnos').val(srno);
        $('#myModalloanpaidoff').modal('show');
    }
</script>