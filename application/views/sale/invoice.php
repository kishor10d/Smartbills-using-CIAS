<div class="content-wrapper">
    
    <section class="content">
        <section class="invoice">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                    <i class="fa fa-globe"></i> CodeInsect
                    <small class="pull-right">Date: <?= date('d-m-Y', strtotime($billData->sell_date)) ?></small>
                    </h2>
                </div>
            </div>
            <div class="row invoice-info">
                <div class="col-md-4 col-sm-4 invoice-col">
                    From,
                    <address>
                    <strong>CodeInsect</strong><br>
                    Pune<br>
                    https://codeinsect.com
                    </address>
                </div>
                <div class="col-md-4 col-sm-4 invoice-col">
                    To,
                    <address>
                    <strong><?= $billData->buyer_name ?></strong><br>
                    <?= $billData->buyer_address ?>
                    </address>
                </div>
                <div class="col-md-4 col-sm-4 invoice-col">
                    <b>Invoice #<?= $billData->bill_no ?></b><br>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Item Rate</th>
                                <th>Quantity</th>
                                <th>Weight</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $subTotal = 0;
                            foreach ($itemData as $value) {  
                                $subTotal = $subTotal + ($value->quantity * $value->item_rate);
                            ?>
                            <tr>
                                <td><?= $value->item_name ?></td>
                                <td><?= $value->item_rate ?></td>
                                <td><?= $value->quantity ?></td>
                                <td><?= $value->weight ?></td>
                                <td><?= $value->quantity * $value->item_rate ?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <th>Subtotal</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><?= $subTotal ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- <hr> -->
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <p class="lead">Invoice Summary</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td><?= $billData->amount ?></td>
                            </tr>
                            <tr>
                            <th>Other Charges</th>
                            <td><?= $billData->other_charges ?></td>
                            </tr>
                            <tr>
                            <th>Tax (<?= $billData->vat ?>%)</th>
                            <td><?= $tax = (($billData->amount + $billData->other_charges) * $billData->vat) / 100 ?></td>
                            </tr>
                            <tr>
                            <th>Total:</th>
                            <td style="font-weight:bolder"><?= $billData->amount + $billData->other_charges + $tax ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </section>
</div>