<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <div class="card mb-5">
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
        <div class="d-none">
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
                        <?php if ($order_statuses) { ?>
                        <tbody>
                            <?php foreach ($order_statuses as $order_status) { ?>
                            <tr>
                                <td><strong>- <?php echo $order_status['store_name']; ?></strong></td>
                                <td><strong>:</strong> <?php echo $order_status['order_status']; ?></td>
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
                                <td>
                                    <?php if ($shipping_methods) { ?>
                                        <table>
                                            <?php foreach ($shipping_methods as $shipping_method) { ?>
                                            <tr>
                                                <td><strong>- <?php echo $shipping_method['seller']; ?></strong></td>
                                                <td><strong>:</strong> <?php echo $shipping_method['shipping_method']; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                    <?php if ($seller['order_status']) { ?>
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
                                <?php foreach ($seller['order_status'] as $order_status) { ?>
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
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
<?php echo $footer; ?>
