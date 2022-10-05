<?php echo $header; ?>
<div class="container-fluid">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php if (!empty($sellers)) { ?>
            <?php foreach ($sellers as $seller) { ?>
            <h5 class="border-bottom pb-3"><?php echo $seller['store_name']; ?></h5>
                <?php if ($seller['product']) { ?>
                    <div class="table-responsive mb-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap" scope="col"><?php echo lang('Column.image'); ?></th>
                                    <th class="text-nowrap w-50" scope="col"><?php echo lang('Column.product'); ?></th>
                                    <th class="text-nowrap text-end" scope="col"><?php echo lang('Column.qty'); ?></th>
                                    <th class="text-nowrap text-end" scope="col"><?php echo lang('Column.sub_total'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($seller['product'] as $product) { ?>
                                <tr>
                                    <td><img src="<?php echo $product['thumb']; ?>" class="border p-1" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"></td>
                                    <td class="small">
                                        <div><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                        <?php if (!empty($product['option'])) { ?>
                                        <div class="small">
                                            <div><?php echo lang('Text.options'); ?>:</div>
                                            <?php foreach ($product['option'] as $option) { ?>
                                            <div>- <?php echo $option['description'][$language->getCurrentId()]['name']; ?>: <?php echo $option['option_value']['description'][$language->getCurrentId()]['name']; ?></div>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                        <div class="text-muted my-3"><?php echo $product['quantity']; ?> X <?php echo $product['price']; ?></div>
                                        <div class="mt-3"><a href="javascript:void(0);" class="link-danger text-decoration-none"><i class="fas fa-trash-alt fa-fw"></i> <?php echo lang('Button.remove'); ?></a></div>
                                    </td>
                                    <td class="text-end small"><?php echo $product['quantity']; ?></td>
                                    <td class="text-end small"><?php echo $product['total']; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <div class="d-grid gap-2 mb-5"><a href="<?php echo $seller['checkout']; ?>" class="btn btn-primary"><?php echo lang('button.checkout'); ?></a></div>
            <?php } ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-grid gap-2"><a href="<?php echo $checkout; ?>" class="btn btn-success"><?php echo lang('Button.checkout_all'); ?></a></div>
                </div>
            </div>
        <?php } else { ?>
        <div><?php echo lang('Text.cart_empty'); ?></div>
        <?php } ?>
    </div>
</div>
<?php echo $footer; ?>
