<?php if (!empty($sellers)) { ?>
    <?php foreach ($sellers as $seller) { ?>
        <?php if ($seller['product']) { ?>
        <h5 class="border-bottom pb-3"><?php echo $seller['store_name']; ?></h5>
        <div class="clearfix">
            <div class="float-end"><strong><?php echo lang('Text.weight', [], $language_lib->getCurrentCode()); ?>:</strong> <?php echo $seller['weight']; ?></div>
        </div>
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
                            <div class="mt-3"><a href="#" class="link-danger text-decoration-none"><i class="fas fa-trash-alt fa-fw"></i> <?php echo lang('Button.remove', [], $language_lib->getCurrentCode()); ?></a></div>
                        </td>
                        <td class="text-end small"><span role="button" class="link-secondary me-1" onclick="subtractQuantity(this, '<?php echo $product['product_id']; ?>', '<?php echo htmlentities($product['product_variant']); ?>');"><i class="fas fa-circle-minus"></i></span><span class="d-inline-block text-center" style="width: 36px;"><?php echo $product['quantity']; ?></span><span role="button" class="link-secondary ms-1" onclick="addQuantity(this, '<?php echo $product['product_id']; ?>', '<?php echo htmlentities($product['product_variant']); ?>');"><i class="fas fa-circle-plus"></i></span></td>
                        <td class="text-end small"><?php echo $product['total']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <?php if ($seller['order_total']) { ?>
                <tfoot>
                    <?php foreach ($seller['order_total'] as $order_total) { ?>
                        <tr>
                            <td colspan="3" class="text-end small"><strong><?php echo $order_total['title']; ?></strong></td>
                            <td class="text-end small"><?php echo $order_total['text']; ?></td>
                        </tr>
                    <?php } ?>
                </tfoot>
                <?php } ?>
            </table>
        </div>
        <?php } else { ?>
        <div><?php echo lang('Text.cart_empty', [], $language_lib->getCurrentCode()); ?></div>
        <?php } ?>
    <?php } ?>
    <?php if (!empty($payment_address)) { ?>
    <h5 class="border-bottom border-3 pb-3 mb-3"><?php echo lang('Heading.payment_address', [], $language_lib->getCurrentCode()); ?></h5>
    <div class="mb-3"><?php echo $payment_address; ?></div>
    <?php } ?>
    <?php if (!empty($shipping_address) && $has_shipping) { ?>
    <h5 class="border-bottom border-3 pb-3 mb-3"><?php echo lang('Heading.shipping_address', [], $language_lib->getCurrentCode()); ?></h5>
    <div class="mb-3"><?php echo $shipping_address; ?></div>
    <?php } ?>
<?php } else { ?>
<div><?php echo lang('Text.cart_empty', [], $language_lib->getCurrentCode()); ?></div>
<?php } ?>
<script type="text/javascript"><!--
$(document).ready(function() {
    // Refresh checkout confirm
    $( '#checkout-confirm' ).html( '<i class="fas fa-spinner fa-spin"></i>' );
    $( '#checkout-confirm' ).load( '<?php echo $checkout_confirm; ?>' );
});
//--></script> 
<script type="text/javascript"><!--
function addQuantity(event, product_id, product_variant) {
    $.ajax({
        url: '<?php echo $checkout_cart_update_quantity; ?>',
        type: 'post',
        dataType: 'json',
        data: {
            product_id: product_id,
            quantity: 1,
            product_variant: product_variant
        },
        beforeSend: function() {
            $(event).find('i').removeClass('fa-circle-plus').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            $(event).find('i').removeClass('fa-spinner fa-spin').addClass('fa-circle-plus');
        },
        success: function(json) {
            $( '#checkout-cart' ).load( '<?php echo $checkout_cart; ?>' );
            $( '#checkout-shipping-method' ).load( '<?php echo $checkout_shipping_method; ?>' );
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function subtractQuantity(event, product_id, product_variant) {
    $.ajax({
        url: '<?php echo $checkout_cart_update_quantity; ?>',
        type: 'post',
        dataType: 'json',
        data: {
            product_id: product_id,
            quantity: -1,
            product_variant: product_variant
        },
        beforeSend: function() {
            $(event).find('i').removeClass('fa-circle-minus').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            $(event).find('i').removeClass('fa-spinner fa-spin').addClass('fa-circle-minus');
        },
        success: function(json) {
            $( '#checkout-cart' ).load( '<?php echo $checkout_cart; ?>' );
            $( '#checkout-shipping-method' ).load( '<?php echo $checkout_shipping_method; ?>' );
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
//--></script> 
