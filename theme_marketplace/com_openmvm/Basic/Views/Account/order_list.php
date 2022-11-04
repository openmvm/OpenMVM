<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <div class="clearfix mb-3">
            <div class="float-start"><a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i> <?php echo lang('Button.cancel', [], $language_lib->getCurrentCode()); ?></a></div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?php echo lang('Column.data', [], $language_lib->getCurrentCode()); ?></th>
                        <th scope="col"><?php echo lang('Column.products', [], $language_lib->getCurrentCode()); ?></th>
                        <th scope="col"><?php echo lang('Column.total', [], $language_lib->getCurrentCode()); ?></th>
                        <th scope="col" class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
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
                                            <td><strong><?php echo lang('Text.date_added', [], $language_lib->getCurrentCode()); ?></strong></td>
                                            <td><strong>:</strong> <?php echo $order['date_added']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo lang('Text.order_id', [], $language_lib->getCurrentCode()); ?></strong></td>
                                            <td><strong>:</strong> <?php echo $order['order_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo lang('Text.invoice', [], $language_lib->getCurrentCode()); ?></strong></td>
                                            <td><strong>:</strong> <?php echo $order['invoice']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php if ($order['order_status']) { ?>
                                <table class="mb-3">
                                    <thead>
                                        <tr>
                                            <td colspan="2"><strong><?php echo lang('Column.order_status', [], $language_lib->getCurrentCode()); ?></strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($order['order_status'] as $order_status) { ?>
                                        <tr>
                                            <td>- <?php echo $order_status['store_name']; ?></td>
                                            <td>: <strong><?php echo $order_status['order_status']; ?></strong></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php } ?>
                                <?php if ($order['seller']) { ?>
                                <table class="mb-3">
                                    <thead>
                                        <tr>
                                            <td colspan="2"><strong><?php echo lang('Column.tracking_number', [], $language_lib->getCurrentCode()); ?></strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($order['seller'] as $seller) { ?>
                                            <?php if ($seller['shipping_method']) { ?>
                                            <tr>
                                                <td>- <?php echo $seller['store_name']; ?></td>
                                                <td>: <?php if (!empty($seller['tracking_number'])) { ?><strong><?php echo $seller['tracking_number']; ?></strong><?php } else { ?><em><?php echo lang('Text.no_tracking_number', [], $language_lib->getCurrentCode()); ?></em><?php } ?></td>
                                            </tr>
                                            <?php } else { ?>
                                            <tr>
                                                <td>- <?php echo $seller['store_name']; ?></td>
                                                <td>: <?php echo lang('Text.no_shipping_method_required', [], $language_lib->getCurrentCode()); ?></td>
                                            </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($order['seller']) { ?>
                                    <?php foreach ($order['seller'] as $seller) { ?>
                                    <div><?php echo $seller['store_name']; ?></div>
                                        <?php if ($seller['product']) { ?>
                                        <table class="table">
                                            <tbody>
                                                <?php foreach ($seller['product'] as $product) { ?>
                                                <tr>
                                                    <td class="w-25"><img src="<?php echo $product['thumb']; ?>" class="border p-1" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"></td>
                                                    <td>
                                                        <div><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a> X <?php echo $product['quantity']; ?></div>
                                                        <?php if (!empty($product['option'])) { ?>
                                                        <div class="small">
                                                            <div><?php echo lang('Text.options', [], $language_lib->getCurrentCode()); ?>:</div>
                                                            <?php foreach ($product['option'] as $option) { ?>
                                                            <div>- <?php echo $option['description'][$language_lib->getCurrentId()]['name']; ?>: <?php echo $option['option_value']['description'][$language_lib->getCurrentId()]['name']; ?></div>
                                                            <?php } ?>
                                                        </div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                            <td><?php echo $order['total']; ?></td>
                            <td class="text-end"><a href="<?php echo $order['info']; ?>" class="btn btn-info"><i class="fas fa-eye fa-fw"></i></a></td>
                        </tr>
                        <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td colspan="4" class="text-center"><?php echo lang('Error.no_data_found', [], $language_lib->getCurrentCode()); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $footer; ?>
