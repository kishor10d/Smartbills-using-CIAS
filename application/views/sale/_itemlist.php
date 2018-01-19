<div class="row">
    <div class="col-md-12 table-responsive">
        <table class="table table-hover">
            <tr>
                <th>Item Name</th>
                <th>Item Rate</th>
                <th>Quantity</th>
                <th>Weight</th>
                <th>Amount</th>
                <th>Delete Item</th>
            </tr>

        <?php 

        foreach ($itemData as $value) {  
        ?>
            <tr>
                <td><?= $value->item_name ?></td>
                <td><?= $value->item_rate ?></td>
                <td><?= $value->quantity ?></td>
                <td><?= $value->weight ?></td>
                <td><?php echo $value->quantity * $value->item_rate; ?></td>
                <td>
                    <a href="" type="button" data-srno="<?= $value->srno ?>" class="btn btn-danger itemDelete">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </table>
    </div>
</div>
