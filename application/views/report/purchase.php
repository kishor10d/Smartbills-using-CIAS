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
            <?php

            // pre($grabbed);

            foreach($purchaseParties as $par)
            {
                $companyData = isset($grabbed[$par->party_name]) ? $grabbed[$par->party_name] : NULL;

                // pre($companyData);
                
                if(!is_null($companyData))
                {
                ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?= $par->party_name ?></h3>
                        <div class="box-tools">
                        </div>
                    </div>
                    <?php
                    foreach($companyData["row"] as $cRow)
                    {
                    ?>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th colspan="5"><?= $cRow["month"] ?></th>
                                <th class="text-right"><?= $cRow["year"] ?></th>
                            </tr>
                            <tr>
                                <th>Bill No</th>
                                <th>Bill date</th>
                                <th>Total Bill Amount</th>
                                <th>Total Bill Paid</th>
                                <th>Unpaid Amount</th>
                                <th>Payment Details</th>
                            </tr>
                            <?php
                            for($j = 0; $j < $cRow["count"]; $j++)
                            {
                                ?>
                                <tr>
                                <td><?= $cRow[$j]->bill_no ?></td>
                                <td><?= $cRow[$j]->pur_date ?></td>
                                <td><?= $cRow[$j]->row_total ?></td>
                                <td><?= $cRow[$j]->row_total_paid ?></td>
                                <td><?= $cRow[$j]->row_total - $cRow[$j]->row_total_paid ?></td>
                                <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal<?=$cRow[$j]->srno?>">
                                    <i class="fa fa-cog" aria-hidden="true">
                                </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <th></th>
                                <th>Total</th>
                                <th><?= $cRow["monthly_total"] ?></th>
                                <th><?= $cRow["monthly_paid_total"] ?></th>
                                <th><?= $cRow["monthly_total"] - $cRow["monthly_paid_total"] ?></th>
                                <th></th>
                            </tr>
                        </table>
                        <?= ($j >= $cRow["count"] ? "<hr>" : false); ?>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="box-footer clearfix">
                        <div class="row">
                            <div class="col-md-3">Company Report (<?= $par->party_name ?>)</div>
                            <div class="col-md-3">Total : <?= $companyData["companyTotal"] ?></div>
                            <div class="col-md-3">Paid : <?= $companyData["companyPaidTotal"] ?></div>
                            <div class="col-md-3">Bal : <?= $companyData["companyTotal"] - $companyData["companyPaidTotal"] ?></div>
                        </div>
                    </div>
                </div>

                <?php
                }
            }
            ?>
            </div>
        </div>
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-4"><h3 class="box-title">Total : <?= $grabbed["allTotal"] ?></h3></div>
                    <div class="col-md-4"><h3 class="box-title">Paid : <?= $grabbed["allPaidTotal"] ?></h3></div>
                    <div class="col-md-4"><h3 class="box-title">Balance : <?= $grabbed["allTotal"] - $grabbed["allPaidTotal"] ?></h3></div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
foreach ($paidData as $paidKey=>$paidValue)
{
    ?>
    <div id="myModal<?=$paidKey?>" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Details</h4>
                </div>
                <div class="modal-body">
                <?php
                if(!empty($paidValue))
                {
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Paid Date</th>
                                <th>Paid Amount</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($paidValue as $values) {
                            
                            ?>
                            <tr>
                                <td><?=date('Y-m-d', strtotime($values->paid_date))?></td>
                                <td><?=$values->paid_amount?></td>
                                <td><?=$values->details?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                <?php
                } else {
                    ?><h3>No paid entries found</h3><?php
                }
                ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>


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