<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <div class="clearfix border-bottom pb-3 mb-3">
            <div class="float-start"><h1><?php echo $heading_title; ?> #<?php echo $order_id; ?></h1><h6 class="text-muted"><?php echo $invoice; ?></h6></div>
            <div class="float-end"></div>
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
                    <tr>
                        <td><?php echo lang('Text.order_status', [], $language_lib->getCurrentCode()); ?></td>
                        <td>: <?php echo $order_status; ?></td>
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
                <table>
                    <thead>
                        <tr>
                            <td><strong><?php echo lang('Column.shipping_method', [], $language_lib->getCurrentCode()); ?></strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $shipping_method; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <table>
                    <thead>
                        <tr>
                            <td><strong><?php echo lang('Column.tracking_number', [], $language_lib->getCurrentCode()); ?></strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php if (!empty($tracking_number)) { ?><strong><?php echo $tracking_number; ?></strong> [ <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#tracking-number-add-modal"><?php echo lang('Text.tracking_number_edit', [], $language_lib->getCurrentCode()); ?></a> ]<?php } else { ?><em><?php echo lang('Text.no_tracking_number', [], $language_lib->getCurrentCode()); ?></em> [ <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#tracking-number-add-modal"><?php echo lang('Text.tracking_number_add', [], $language_lib->getCurrentCode()); ?></a> ]<?php } ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if ($order_products) { ?>
        <h5 class="border-bottom pb-3 mb-3"><?php echo lang('Text.products', [], $language_lib->getCurrentCode()); ?></h5>
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
                <tbody>
                    <?php foreach ($order_products as $product) { ?>
                    <tr>
                        <td>
                            <div><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                            <?php if (!empty($product['option'])) { ?>
                            <div class="small">
                                <div><?php echo lang('Text.options', [], $language_lib->getCurrentCode()); ?>:</div>
                                <?php foreach ($product['option'] as $option) { ?>
                                <div>- <?php echo $option['description'][$language_lib->getCurrentId()]['name']; ?>: <?php echo $option['option_value']['description'][$language_lib->getCurrentId()]['name']; ?></div>
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
                <?php if ($order_totals) { ?>
                <tfoot>
                    <?php foreach ($order_totals as $order_total) { ?>
                        <tr>
                            <td colspan="3" class="text-end"><strong><?php echo $order_total['title']; ?></strong></td>
                            <td class="text-end"><?php echo $order_total['value']; ?></td>
                        </tr>
                    <?php } ?>
                </tfoot>
                <?php } ?>
            </table>
        </div>
        <?php } ?>
        <?php if ($order_status_histories) { ?>
        <h5 class="border-bottom pb-3 mb-3"><?php echo lang('Text.order_status_histories', [], $language_lib->getCurrentCode()); ?></h5>
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
                    <?php foreach ($order_status_histories as $order_status) { ?>
                    <tr>
                        <td><?php echo $order_status['date_added']; ?></td>
                        <td><?php echo $order_status['order_status']; ?></td>
                        <td><?php echo $order_status['comment']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="tracking-number-add-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tracking-number-add-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tracking-number-add-label"><?php echo lang('Heading.tracking_number', [], $language_lib->getCurrentCode()); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-tracking-number">
                    <fieldset>
                        <div class="mb-3 required">
                            <label for="input-tracking-number" class="form-label"><?php echo lang('Entry.tracking_number', [], $language_lib->getCurrentCode()); ?></label>
                            <input type="text" name="tracking_number" value="<?php echo $tracking_number; ?>" id="input-tracking-number" class="form-control" placeholder="<?php echo lang('Entry.tracking_number', [], $language_lib->getCurrentCode()); ?>">
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle fa-fw"></i> <?php echo lang('Button.close', [], $language_lib->getCurrentCode()); ?></button>
                <button type="button" id="button-tracking-number-add" class="btn btn-success"><i class="fas fa-save fa-fw"></i> <?php echo lang('Button.save', [], $language_lib->getCurrentCode()); ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
$('#button-tracking-number-add').on('click', function() {
    $.ajax({
        url: '<?php echo $tracking_number_add; ?>',
        type: 'post',
        dataType: 'json',
        data: $('#form-tracking-number').serialize(),
        beforeSend: function() {
            $('#button-tracking-number-add i').removeClass('fa-save').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            $('#button-tracking-number-add i').removeClass('fa-spinner fa-spin').addClass('fa-save');
        },
        success: function(json) {
            if (json['error']) {
                alert(json['error']);
            }

            if (json['success']) {
                alert(json['success']);
                
                window.location.replace(json['redirect']);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
//--></script>
<?php echo $footer; ?>
