<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><?php echo lang('Column.order_id', [], $language_lib->getCurrentId()); ?></th>
                    <th><?php echo lang('Column.date', [], $language_lib->getCurrentId()); ?></th>
                    <th><?php echo lang('Column.image', [], $language_lib->getCurrentId()); ?></th>
                    <th><?php echo lang('Column.product', [], $language_lib->getCurrentId()); ?></th>
                    <th class="w-50"><?php echo lang('Column.review', [], $language_lib->getCurrentId()); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($order_products) { ?>
                    <?php foreach ($order_products as $order_product) { ?>
                    <tr>
                        <td><?php echo $order_product['order_id']; ?></td>
                        <td><?php echo $order_product['date_added']; ?></td>
                        <td><img src="<?php echo $order_product['thumb']; ?>" class="border p-1" alt="<?php echo $order_product['name']; ?>" title="<?php echo $order_product['name']; ?>"></td>
                        <td>
                            <div><?php if (!empty($order_product['href'])) { ?><a href="<?php echo $order_product['href']; ?>"><?php echo $order_product['name']; ?></a><?php } else { ?><?php echo $order_product['name']; ?><?php } ?></div>
                            <?php if (!empty($order_product['option'])) { ?>
                            <div class="small">
                                <div><?php echo lang('Text.options', [], $language_lib->getCurrentCode()); ?>:</div>
                                <?php foreach ($order_product['option'] as $option) { ?>
                                <div>- <?php echo $option['description'][$language_lib->getCurrentId()]['name']; ?>: <?php echo $option['option_value']['description'][$language_lib->getCurrentId()]['name']; ?></div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if (!empty($order_product['product_review'])) { ?>
                            <div class="clearfix mb-3">
                                <a href="<?php echo $order_product['edit']; ?>" class="btn btn-outline-secondary btn-sm float-end"><i class="fas fa-pen-to-square me-2"></i><?php echo lang('Button.product_review_edit', [], $language_lib->getCurrentCode()); ?></a>
                            </div>
                            <div><?php echo nl2br($order_product['product_review']['review']); ?></div>
                            <?php } else { ?>
                            <div class="clearfix"><a href="<?php echo $order_product['add']; ?>" class="btn btn-primary btn-sm float-end"><i class="fas fa-pen-to-square me-2"></i><?php echo lang('Button.product_review_add', [], $language_lib->getCurrentCode()); ?></a></div>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                <tr>
                    <td colspan="5"><?php echo lang('Text.no_data_found', [], $language_lib->getCurrentId()); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php echo $footer; ?>
