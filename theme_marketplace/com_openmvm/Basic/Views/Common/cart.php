<?php if (!empty($sellers)) { ?>
    <?php foreach ($sellers as $seller) { ?>
    <h5 class="border-bottom pb-3"><?php echo $seller['store_name']; ?></h5>
    <div class="text-end small"><strong><?php echo lang('Text.weight', [], $language_lib->getCurrentCode()); ?>:</strong> <?php echo $seller['weight']; ?></div>
        <?php if ($seller['product']) { ?>
            <div class="table-responsive mb-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap" scope="col"><?php echo lang('Column.image', [], $language_lib->getCurrentCode()); ?></th>
                            <th class="text-nowrap" scope="col"><?php echo lang('Column.product', [], $language_lib->getCurrentCode()); ?></th>
                            <th class="text-nowrap text-end" scope="col"><?php echo lang('Column.qty', [], $language_lib->getCurrentCode()); ?></th>
                            <th class="text-nowrap text-end" scope="col"><?php echo lang('Column.sub_total', [], $language_lib->getCurrentCode()); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($seller['product'] as $product) { ?>
                        <tr>
                            <td><img src="<?php echo $product['thumb']; ?>" class="border p-1" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"></td>
                            <td class="small">
                                <div><?php echo $product['name']; ?></div>
                                <?php if (!empty($product['option'])) { ?>
                                <div class="small">
                                    <div><?php echo lang('Text.options', [], $language_lib->getCurrentCode()); ?>:</div>
                                    <?php foreach ($product['option'] as $option) { ?>
                                    <div>- <?php echo $option['description'][$language_lib->getCurrentId()]['name']; ?>: <?php echo $option['option_value']['description'][$language_lib->getCurrentId()]['name']; ?></div>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                                <div class="text-muted my-3"><?php echo $product['quantity']; ?> X <?php echo $product['price']; ?></div>
                                <div><a role="button" class="link-danger text-decoration-none" onclick="cartRemove(this, '<?php echo $product['product_id']; ?>', '<?php echo htmlentities($product['product_variant']); ?>');"><i class="fas fa-trash-alt fa-fw"></i> <?php echo lang('Button.remove', [], $language_lib->getCurrentCode()); ?></a></div>
                            </td>
                            <td class="text-end small"><?php echo $product['quantity']; ?></td>
                            <td class="text-end small"><?php echo $product['total']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    <div class="d-grid gap-2 mb-5"><a href="<?php echo $seller['checkout']; ?>" class="btn btn-primary"><i class="fas fa-cash-register me-2"></i><?php echo lang('button.checkout', [], $language_lib->getCurrentCode()); ?></a></div>
    <?php } ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="d-grid gap-2"><a href="<?php echo $shopping_cart; ?>" class="btn btn-danger"><i class="fas fa-shopping-cart me-2"></i><?php echo lang('Button.shopping_cart', [], $language_lib->getCurrentCode()); ?></a></div>
        </div>
        <div class="col-sm-6">
            <div class="d-grid gap-2"><a href="<?php echo $checkout; ?>" class="btn btn-success"><i class="fas fa-cash-register me-2"></i><?php echo lang('Button.checkout_all', [], $language_lib->getCurrentCode()); ?></a></div>
        </div>
    </div>
<?php } else { ?>
<div><?php echo lang('Text.cart_empty', [], $language_lib->getCurrentCode()); ?></div>
<?php } ?>
<script type="text/javascript"><!--
$(document).ready(function() {
    $('#offcanvas-right-icon-total-products').remove();

    var total_products = '<?php echo $total_products; ?>';

    if (total_products > 0) {
        html = '<span id="offcanvas-right-icon-total-products" class="position-absolute top-25 start-75 translate-middle badge rounded-pill bg-danger small">';
        html += '    <small>' + total_products + '</small>';
        html += '</span>';
        
        $('#icon-offcanvas-right').append(html);
    } else {
        $('#offcanvas-right-icon-total-products').remove();
    }
});
//--></script> 
