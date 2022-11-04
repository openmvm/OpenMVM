<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <div class="row">
            <div class="col-sm-7">
                <h3 class="border-bottom border-3 pb-3 mb-3"><?php echo lang('Heading.payment_address', [], $language_lib->getCurrentCode()); ?></h3>
                <div id="checkout-payment-address" class="mb-3"><i class="fas fa-spinner fa-spin"></i></div>
                <div id="checkout-shipping-address" class="mb-3"><i class="fas fa-spinner fa-spin"></i></div>
                <div id="checkout-shipping-method" class="mb-3"><i class="fas fa-spinner fa-spin"></i></div>
                <h3 class="border-bottom border-3 pb-3 mb-3"><?php echo lang('Heading.payment_method', [], $language_lib->getCurrentCode()); ?></h3>
                <div id="checkout-payment-method" class="mb-3"><i class="fas fa-spinner fa-spin"></i></div>
            </div>
            <div class="col-sm-5">
                <h3 class="border-bottom border-3 pb-3 mb-3"><?php echo lang('Heading.shopping_cart', [], $language_lib->getCurrentCode()); ?></h3>
                <div id="checkout-cart"><i class="fas fa-spinner fa-spin"></i></div>
                <h3 class="border-bottom border-3 pb-3 mb-3"><?php echo lang('Heading.confirm', [], $language_lib->getCurrentCode()); ?></h3>
                <div id="checkout-confirm"><i class="fas fa-spinner fa-spin"></i></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
    $( '#checkout-payment-address' ).load( '<?php echo $checkout_payment_address; ?>' );
    $( '#checkout-shipping-address' ).load( '<?php echo $checkout_shipping_address; ?>' );
    $( '#checkout-shipping-method' ).load( '<?php echo $checkout_shipping_method; ?>' );
    $( '#checkout-payment-method' ).load( '<?php echo $checkout_payment_method; ?>' );
    $( '#checkout-cart' ).load( '<?php echo $checkout_cart; ?>' );
    $( '#checkout-confirm' ).load( '<?php echo $checkout_confirm; ?>' );
});
//--></script> 
<?php echo $footer; ?>
