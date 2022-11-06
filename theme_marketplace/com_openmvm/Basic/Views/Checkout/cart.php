<?php echo $header; ?>
<div class="container-fluid">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php if (!empty($sellers)) { ?>
            <?php foreach ($sellers as $seller) { ?>
            <div class="border-bottom clearfix">
                <h5 class="float-start"><?php echo $seller['store_name']; ?></h5>
                <div class="float-end"><a href="<?php echo $seller['checkout']; ?>" class="btn btn-primary mb-2"><i class="fas fa-cash-register me-2"></i><?php echo lang('button.checkout', [], $language_lib->getCurrentCode()); ?></a></div>
            </div>
                <?php if ($seller['product']) { ?>
                    <div class="table-responsive mb-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap" scope="col"><?php echo lang('Column.image', [], $language_lib->getCurrentCode()); ?></th>
                                    <th class="text-nowrap w-50" scope="col"><?php echo lang('Column.product', [], $language_lib->getCurrentCode()); ?></th>
                                    <th class="text-nowrap text-end" scope="col"><?php echo lang('Column.qty', [], $language_lib->getCurrentCode()); ?></th>
                                    <th class="text-nowrap text-end" scope="col"><?php echo lang('Column.sub_total', [], $language_lib->getCurrentCode()); ?></th>
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
                                            <div><?php echo lang('Text.options', [], $language_lib->getCurrentCode()); ?>:</div>
                                            <?php foreach ($product['option'] as $option) { ?>
                                            <div>- <?php echo $option['description'][$language_lib->getCurrentId()]['name']; ?>: <?php echo $option['option_value']['description'][$language_lib->getCurrentId()]['name']; ?></div>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                        <div class="text-muted my-3"><?php echo $product['quantity']; ?> X <?php echo $product['price']; ?></div>
                                        <div class="mt-3"><?php echo form_open($product['remove_cart'], ['id' => 'form-cart-remove-' . $product['cart_id'] . '']); ?><input type="hidden" name="product_variant" value="<?php echo $product['product_variant']; ?>" /><?php echo form_close(); ?><button type="button" class="btn btn-sm btn-danger button-action" data-form="form-cart-remove-<?php echo $product['cart_id']; ?>" data-form-action="<?php echo $product['remove_cart']; ?>" data-icon="fa-fa-trash-alt" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-trash-alt fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.remove', [], $language_lib->getCurrentCode()); ?></span></button></div>
                                    </td>
                                    <td class="text-end small"><?php echo $product['quantity']; ?></td>
                                    <td class="text-end small"><?php echo $product['total']; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-grid gap-2"><a href="<?php echo $checkout; ?>" class="btn btn-success"><i class="fas fa-cash-register me-2"></i><?php echo lang('Button.checkout_all', [], $language_lib->getCurrentCode()); ?></a></div>
                </div>
            </div>
        <?php } else { ?>
        <div><?php echo lang('Text.cart_empty', [], $language_lib->getCurrentCode()); ?></div>
        <?php } ?>
    </div>
</div>
<?php echo $footer; ?>
