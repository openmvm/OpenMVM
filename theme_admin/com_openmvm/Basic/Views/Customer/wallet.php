<?php if (!empty($wallets)) { ?>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th><?php echo lang('column.date_added'); ?></th>
                <th><?php echo lang('column.amount'); ?></th>
                <th><?php echo lang('column.description'); ?></th>
                <th><?php echo lang('column.comment'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wallets as $wallet) { ?>
            <tr>
                <td><?php echo $wallet['date_added']; ?></td>
                <td><?php echo $wallet['amount']; ?></td>
                <td><?php echo $wallet['description']; ?></td>
                <td><?php echo $wallet['comment']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php } else { ?>
<div><?php echo lang('Text.no_transactions'); ?></div>
<?php } ?>
