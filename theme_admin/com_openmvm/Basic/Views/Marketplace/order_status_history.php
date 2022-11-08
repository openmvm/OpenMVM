<?php if ($order_status_histories) { ?>
<h6 class="border-bottom pb-3 mb-3"><?php echo lang('Text.order_status_histories', [], $language_lib->getCurrentCode()); ?></h6>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <td><strong><?php echo lang('Column.date_added', [], $language_lib->getCurrentCode()); ?></strong></td>
                <td><strong><?php echo lang('Column.order_status', [], $language_lib->getCurrentCode()); ?></strong></td>
                <td class="w-50"><strong><?php echo lang('Column.comment', [], $language_lib->getCurrentCode()); ?></strong></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_status_histories as $order_status_history) { ?>
            <tr>
                <td><?php echo $order_status_history['date_added']; ?></td>
                <td><?php echo $order_status_history['order_status']; ?></td>
                <td><?php echo $order_status_history['comment']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php } ?>
