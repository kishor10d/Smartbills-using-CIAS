<?php $this->load->helper('form'); ?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-area-chart" aria-hidden="true"></i> Purchase Report
        <small>Purchase details for companies</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-2 col-xs-12">
                <div class="form-group">
                    <select name="partyName" class="form-control" id="partyName">
                        <option value="">All</option>
                        <?php
                        foreach($purchaseParties as $par)
                        {
                            $party_name = url_title($par->party_name, "-", TRUE);
                            ?>
                            <option <?php if($selected == $party_name) { echo "selected=selected"; } ?>
                                    data-selected2="<?= htmlentities($par->party_name) ?>"
                                    value="<?= $party_name ?>"><?= $par->party_name ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?= $selected2 ?></h3>
                        <div class="box-tools">
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Bill No</th>
                                <th>Bill date</th>
                                <th>Total Bill Amount</th>
                                <th>Total Bill Paid</th>
                                <th>Unpaid Amount</th>
                                <th class="text-center">Payment Details</th>
                            </tr>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

jQuery(document).ready(function(){
    jQuery("#partyName").on("change", function(){        
        var selected2 = jQuery("#partyName :selected").data("selected2");
        if(jQuery(this).val().length){
            location.href = baseURL + "purchase-report/"+jQuery(this).val()+"/"+ selected2;
        } else {
            location.href = baseURL + "purchase-report/";
        }
    });
});

</script>