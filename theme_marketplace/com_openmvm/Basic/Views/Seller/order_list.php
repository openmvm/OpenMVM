<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <div class="clearfix mb-3">
            <div class="float-start"><a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i> <?php echo lang('Button.cancel'); ?></a></div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?php echo lang('Column.data'); ?></th>
                        <th scope="col"><?php echo lang('Column.products'); ?></th>
                        <th scope="col"><?php echo lang('Column.total'); ?></th>
                        <th scope="col" class="text-end"><?php echo lang('Column.action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)) { ?>
                        <?php foreach ($orders as $order) { ?>
                        <tr>
                            <td>
                                <table class="mb-3">
                                    <tbody>
                                        <tr>
                                            <td><strong><?php echo lang('Text.date_added'); ?></strong></td>
                                            <td><strong>:</strong> <?php echo $order['date_added']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo lang('Text.order_id'); ?></strong></td>
                                            <td><strong>:</strong> <?php echo $order['order_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo lang('Text.invoice'); ?></strong></td>
                                            <td><strong>:</strong> <?php echo $order['invoice']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo lang('Text.order_status'); ?></strong></td>
                                            <td><strong>:</strong> <?php echo $order['order_status']['name']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <?php if ($order['product']) { ?>
                                <table class="table">
                                    <tbody>
                                        <?php foreach ($order['product'] as $product) { ?>
                                        <tr>
                                            <td class="w-25"><img src="<?php echo $product['thumb']; ?>" class="border p-1" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"></td>
                                            <td>
                                                <div><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a> X <?php echo $product['quantity']; ?></div>
                                                <?php if (!empty($product['option'])) { ?>
                                                <div class="small">
                                                    <div><?php echo lang('Text.options'); ?>:</div>
                                                    <?php foreach ($product['option'] as $option) { ?>
                                                    <div>- <?php echo $option['description'][$language->getCurrentId()]['name']; ?>: <?php echo $option['option_value']['description'][$language->getCurrentId()]['name']; ?></div>
                                                    <?php } ?>
                                                </div>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php } ?>
                            </td>
                            <td><?php echo $order['total']; ?></td>
                            <td class="text-end">
                                <div class="d-grid">
                                    <a href="<?php echo $order['info']; ?>" class="btn btn-outline-info btn-sm mb-2"><i class="fas fa-eye fa-fw"></i> <?php echo lang('Button.show_order', [], 'en'); ?></a>
                                    <?php if (!in_array($order['order_status']['order_status_id'], $non_acceptable_order_statuses)) { ?>
                                    <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="updateOrderStatus(this, '<?php echo $order['order_id']; ?>', '<?php echo $accepted_order_status_id; ?>');"><i class="fas fa-check fa-fw"></i> <?php echo lang('Button.accept_order', [], 'en'); ?></button>
                                    <?php } ?>
                                    <?php if (!in_array($order['order_status']['order_status_id'], $non_rejectable_order_statuses)) { ?>
                                    <button type="button" class="btn btn-outline-danger btn-sm mb-2" onclick="updateOrderStatus(this, '<?php echo $order['order_id']; ?>', '<?php echo $rejected_order_status_id; ?>');"><i class="fas fa-times fa-fw"></i> <?php echo lang('Button.reject_order', [], 'en'); ?></button>
                                    <?php } ?>
                                    <?php if ($order['order_status']['order_status_id'] == $shipped_order_status_id) { ?>
                                    <button type="button" class="btn btn-outline-warning btn-sm mb-2" onclick="updateOrderStatus(this, '<?php echo $order['order_id']; ?>', '<?php echo $delivered_order_status_id; ?>');"><i class="fas fa-truck-ramp-box fa-fw"></i> <?php echo lang('Button.mark_as_delivered', [], 'en'); ?></button>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td colspan="4" class="text-center"><?php echo lang('Error.no_data_found'); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
function updateOrderStatus(event, order_id, order_status_id) {
    $.ajax({
        url: '<?php echo $update_order_status; ?>',
        method: 'post',
        dataType: 'json',
        data: {
            order_id: order_id,
            order_status_id: order_status_id,
        },
        beforeSend: function() {
            $(event).html('<i class="fas fa-spinner fa-spin"></i>');
        },
        complete: function() {
            
        },
        success: function(json) {
            if (json['success']) {
                alert(json['success']);
            }

            if (json['error']) {
                alert(json['error']);
            }

            window.location.href = json['redirect'];
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
//--></script> 
<?php echo $footer; ?>
