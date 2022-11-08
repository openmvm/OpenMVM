<?php echo $header; ?><?php echo $column_left; ?>
<div class="container-fluid">
    <div id="content" class="content">
        <?php if ($breadcrumbs) { ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <?php if ($breadcrumb['active']) { ?>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
                    <?php } else { ?>
                    <li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                    <?php } ?>
                <?php } ?>
            </ol>
        </nav>
        <?php } ?>
        <div class="card border-0 shadow heading mb-3">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-file-invoice fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <div class="card border-0 shadow mb-3">
            <div class="card-body">
                <div class="collapse border-bottom" id="collapse-checkout-success-message">
                    <div class="card mb-1">
                        <div class="card-body">
                            <h3 class="text-center"><?php echo lang('Success.order_add', [], $language_lib->getCurrentCode()); ?></h3>
                            <p class="text-center"><?php echo lang('Text.order_add_message', [], $language_lib->getCurrentCode()); ?></p>
                            <h5 class="text-center"><?php echo lang('Text.order_id', [], $language_lib->getCurrentCode()); ?>:&nbsp;&nbsp;<strong><?php echo $order_id; ?></strong></h5>
                            <h5 class="text-center"><?php echo lang('Text.invoice', [], $language_lib->getCurrentCode()); ?>:&nbsp;&nbsp;<strong><?php echo $invoice; ?></strong></h5>
                            <h5 class="text-center"><?php echo lang('Text.date_added', [], $language_lib->getCurrentCode()); ?>:&nbsp;&nbsp;<strong><?php echo $date_added; ?></strong></h5>
                            <h5 class="text-center"><?php echo lang('Text.payment_method', [], $language_lib->getCurrentCode()); ?>:&nbsp;&nbsp;<strong><?php echo $payment_method; ?></strong></h5>
                            <h5 class="text-center"><?php echo lang('Text.total_order_amount', [], $language_lib->getCurrentCode()); ?>:&nbsp;&nbsp;<strong><?php echo $total_order_amount; ?></strong></h5>
                            <?php if (!empty($payment_method_text)) { ?>
                            <div class="card border border-primary mt-3 mx-auto w-50">
                                <div class="card-body"><?php echo $payment_method_text; ?></div>
                            </div>
                            <?php } ?>
                            <p class="text-center mt-5"><?php echo lang('Text.order_add_message_2', [], $language_lib->getCurrentCode()); ?></p>
                            <p class="text-center"><?php echo $order_add_message_3; ?></p>
                            <?php if ($sellers) { ?>
                            <p class="text-center"><?php echo lang('Text.order_add_message_4', [], $language_lib->getCurrentCode()); ?></p>
                            <div class="text-center">
                                <?php foreach ($sellers as $seller) { ?>
                                <div>&middot; <a href="<?php echo $seller['href']; ?>"><?php echo $seller['store_name']; ?></a></div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <h5 class="text-center mt-5"><?php echo lang('Text.order_add_message_5', [], $language_lib->getCurrentCode()); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="text-end mb-5">
                    <a class="link-secondary text-decoration-none" data-bs-toggle="collapse" href="#collapse-checkout-success-message" role="button" aria-expanded="false" aria-controls="collapseExample"><?php echo lang('Text.order_checkout_success_message', [], $language_lib->getCurrentCode()); ?> <i class="fas fa-caret-down fa-fw"></i></a>
                </div>
                <div class="row mb-5">
                    <div class="col-sm-6">
                        <table>
                            <tr>
                                <td><?php echo lang('Text.order_id', [], $language_lib->getCurrentCode()); ?></td>
                                <td>: <?php echo $order_id; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('Text.invoice', [], $language_lib->getCurrentCode()); ?></td>
                                <td>: <?php echo $invoice; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('Text.date_added', [], $language_lib->getCurrentCode()); ?></td>
                                <td>: <?php echo $date_added; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <table>
                            <tr>
                                <td><?php echo lang('Text.name', [], $language_lib->getCurrentCode()); ?></td>
                                <td>: <?php echo $name; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('Text.telephone', [], $language_lib->getCurrentCode()); ?></td>
                                <td>: <?php echo $telephone; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('Text.email', [], $language_lib->getCurrentCode()); ?></td>
                                <td>: <?php echo $email; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-sm-6">
                        <table>
                            <thead>
                                <tr>
                                    <td><strong><?php echo lang('Column.total_order_amount', [], $language_lib->getCurrentCode()); ?></strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong><?php echo $total_order_amount; ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2"><strong><?php echo lang('Column.order_status', [], $language_lib->getCurrentCode()); ?></strong></td>
                                </tr>
                            </thead>
                            <?php if ($order_status_histories) { ?>
                            <tbody>
                                <?php foreach ($order_status_histories as $order_status_history) { ?>
                                <tr>
                                    <td>- <?php echo $order_status_history['store_name']; ?></td>
                                    <td>: <strong><?php echo $order_status_history['order_status']['name']; ?></strong></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-sm-6">
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2"><strong><?php echo lang('Column.payment_address', [], $language_lib->getCurrentCode()); ?></strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $payment_address; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <?php if ($shipping_methods) { ?>
                        <table>
                            <thead>
                                <tr>
                                    <td><strong><?php echo lang('Column.shipping_address', [], $language_lib->getCurrentCode()); ?></strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $shipping_address; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-sm-6">
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2"><strong><?php echo lang('Column.payment_method', [], $language_lib->getCurrentCode()); ?></strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $payment_method; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <?php if ($shipping_methods) { ?>
                        <table>
                            <thead>
                                <tr>
                                    <td><strong><?php echo lang('Column.shipping_method', [], $language_lib->getCurrentCode()); ?></strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <table>
                                            <?php foreach ($shipping_methods as $shipping_method) { ?>
                                            <tr>
                                                <td><strong>- <?php echo $shipping_method['seller']; ?></strong></td>
                                                <td><strong>:</strong> <?php echo $shipping_method['shipping_method']; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <?php if ($shipping_methods) { ?>
                        <table>
                            <thead>
                                <tr>
                                    <td><strong><?php echo lang('Column.tracking_number', [], $language_lib->getCurrentCode()); ?></strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php if ($shipping_methods) { ?>
                                            <table>
                                                <?php foreach ($shipping_methods as $shipping_method) { ?>
                                                <tr>
                                                    <td><strong>- <?php echo $shipping_method['seller']; ?></strong></td>
                                                    <td><strong>:</strong> <?php if (!empty($shipping_method['tracking_number'])) { ?><?php echo $shipping_method['tracking_number']; ?><?php } else { ?><em><?php echo lang('Text.no_tracking_number', [], $language_lib->getCurrentCode()); ?></em><?php } ?></td>
                                                </tr>
                                                <?php } ?>
                                            </table>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($sellers) { ?>
                <h5 class="border-bottom pb-3 mb-3"><?php echo lang('Text.products', [], $language_lib->getCurrentCode()); ?></h5>
                    <?php foreach ($sellers as $seller) { ?>
                    <div class="border p-3 mb-5 bg-white">
                        <h6 class="border-bottom pb-3 mb-3"><strong><?php echo $seller['store_name']; ?></strong></h6>
                        <div class="table-responsive mb-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td class="w-50"><strong><?php echo lang('Column.products', [], $language_lib->getCurrentCode()); ?></strong></td>
                                        <td><strong><?php echo lang('Column.quantity', [], $language_lib->getCurrentCode()); ?></strong></td>
                                        <td><strong><?php echo lang('Column.price', [], $language_lib->getCurrentCode()); ?></strong></td>
                                        <td class="text-end"><strong><?php echo lang('Column.sub_total', [], $language_lib->getCurrentCode()); ?></strong></td>
                                    </tr>
                                </thead>
                                <?php if ($seller['product']) { ?>
                                <tbody>
                                    <?php foreach ($seller['product'] as $product) { ?>
                                    <tr>
                                        <td>
                                            <div><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                            <div class="small text-muted"><?php echo $product['seller']['store_name']; ?></div>
                                            <?php if (!empty($product['option'])) { ?>
                                            <div class="small">
                                                <div><?php echo lang('Text.options', [], $language_lib->getCurrentCode()); ?>:</div>
                                                <?php foreach ($product['option'] as $option) { ?>
                                                <div>- <?php echo $option['description'][$language->getCurrentId()]['name']; ?>: <?php echo $option['option_value']['description'][$language->getCurrentId()]['name']; ?></div>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $product['quantity']; ?></td>
                                        <td><?php echo $product['price']; ?></td>
                                        <td class="text-end"><?php echo $product['total']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <?php } ?>
                                <?php if ($seller['total']) { ?>
                                <tfoot>
                                    <?php foreach ($seller['total'] as $total) { ?>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong><?php echo $total['title']; ?></strong></td>
                                            <td class="text-end"><?php echo $total['value']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tfoot>
                                <?php } ?>
                            </table>
                        </div>
                        <div id="order-status-history-<?php echo $seller['seller_id']; ?>"></div>
                        <h6 class="border-bottom pb-3 mb-3"><strong><?php echo lang('Text.add_order_status_history', [], $language_lib->getCurrentCode()); ?></strong></h6>
                        <?php echo form_open($update_order_status_history, ['id' => 'form-order-status-history-' . $seller['seller_id']]); ?>
                        <fieldset>
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                            <input type="hidden" name="seller_id" value="<?php echo $seller['seller_id']; ?>" />
                            <div class="mb-3">
                                <label for="input-order-status-<?php echo $seller['seller_id']; ?>" class="form-label"><?php echo lang('Entry.order_status', [], $language_lib->getCurrentCode()); ?></label>
                                <select name="order_status_id" class="form-select" id="input-order-status-<?php echo $seller['seller_id']; ?>" onchange="getOrderStatus(this, $(this).val(), '<?php echo $seller['seller_id']; ?>');">
                                    <option value="0"><?php echo lang('Text.please_select', [], $language_lib->getCurrentCode()); ?></option>
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="notify" value="1" id="input-notify-<?php echo $seller['seller_id']; ?>">
                                <label class="form-check-label" for="input-notify-<?php echo $seller['seller_id']; ?>">
                                <?php echo lang('Text.notify_customer', [], $language_lib->getCurrentCode()); ?>
                                </label>
                            </div>
                        </fieldset>
                        <button type="button" id="button-update-order-status-history-<?php echo $seller['seller_id']; ?>" class="btn btn-primary" onclick="updateOrderStatusHistory(this, 'form-order-status-history-<?php echo $seller['seller_id']; ?>');"><i class="fas fa-pencil me-2"></i><?php echo lang('Button.update', [], $language_lib->getCurrentCode()); ?></button>
                        <?php echo form_close(); ?>
                    </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
<?php foreach ($sellers as $seller) { ?>
$('#order-status-history-<?php echo $seller['seller_id']; ?>').load('<?php echo $get_order_status_histories_url; ?>&order_id=<?php echo $order_id; ?>&seller_id=<?php echo $seller['seller_id']; ?>');
<?php } ?>
//--></script> 
<script type="text/javascript"><!--
function getOrderStatus(event, order_status_id, seller_id) {
    $.ajax({
        url: '<?php echo $get_order_status; ?>',
        method: 'post',
        dataType: 'json',
        data: {
            order_status_id: order_status_id
        },
        beforeSend: function() {
        },
        complete: function() {
        },
        success: function(json) {
            if (json['order_status']) {
                tinymce.get('input-comment-' + seller_id).setContent(json['order_status']['message']); 
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
//--></script> 
<script type="text/javascript"><!--
function updateOrderStatusHistory(event, dataForm) {
    var userData = $('#' + dataForm).serializeJSON();

    $.ajax({
        url: '<?php echo $update_order_status_history; ?>',
        method: 'post',
        dataType: 'json',
        data: JSON.stringify(userData),
        beforeSend: function() {
            $(event).find('i').removeClass('fa-pencil').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            $(event).find('i').removeClass('fa-spinner fa-spin').addClass('fa-pencil');
        },
        success: function(json) {
            if (json['seller_id'] && json['order_id']) {
                $('#order-status-history-<?php echo $seller['seller_id']; ?>').load('<?php echo $get_order_status_histories_url; ?>&order_id=' + json['order_id'] + '&seller_id=' + json['seller_id']);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
//--></script> 
<?php echo $footer; ?>
