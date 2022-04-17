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
                                            <td><strong>:</strong> <?php echo $order['order_status']; ?></td>
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
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php } ?>
                            </td>
                            <td><?php echo $order['total']; ?></td>
                            <td class="text-end"><a href="<?php echo $order['info']; ?>" class="btn btn-info"><i class="fas fa-eye fa-fw"></i></a></td>
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
<?php echo $footer; ?>
