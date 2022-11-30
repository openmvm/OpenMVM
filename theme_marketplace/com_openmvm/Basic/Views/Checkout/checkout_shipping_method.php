<?php if (!empty($sellers && $has_shipping)) { ?>
    <h3 class="border-bottom border-3 pb-3 mb-3"><?php echo lang('Heading.shipping_method', [], $language_lib->getCurrentCode()); ?></h3>
    <?php foreach ($sellers as $seller) { ?>
        <div id="checkout-shipping-method-<?php echo $seller['seller_id']; ?>" class="mb-3">
            <h5 class="border-bottom pb-2"><?php echo $seller['store_name']; ?></h5>
            <?php if ($seller['has_shipping']) { ?>
                <?php if (!empty($seller['shipping_method'])) { ?>
                    <?php foreach ($seller['shipping_method'] as $shipping_method) { ?>
                        <div>
                            <div><strong><?php echo $shipping_method['name']; ?></strong></div>
                            <?php if (!empty($shipping_method['quote_data'])) { ?>
                                <div>
                                    <?php foreach ($shipping_method['quote_data'] as $quote_data) { ?>
                                    <div class="form-check">
                                        <?php if ($quote_data['code'] == ${'checkout_shipping_method_' . $seller['seller_id']}['code']) { ?>
                                        <input class="form-check-input" type="radio" name="checkout_shipping_method_<?php echo $seller['seller_id']; ?>" value="<?php echo $quote_data['code']; ?>" id="input-checkout-shipping-method-<?php echo $seller['seller_id']; ?>-<?php echo $shipping_method['id']; ?>" data-seller-id="<?php echo $seller['seller_id']; ?>" data-cost="<?php echo $quote_data['cost']; ?>" data-text="<?php echo $quote_data['text']; ?>" checked="checked">
                                        <?php } else { ?>
                                        <input class="form-check-input" type="radio" name="checkout_shipping_method_<?php echo $seller['seller_id']; ?>" value="<?php echo $quote_data['code']; ?>" id="input-checkout-shipping-method-<?php echo $seller['seller_id']; ?>-<?php echo $shipping_method['id']; ?>" data-seller-id="<?php echo $seller['seller_id']; ?>" data-cost="<?php echo $quote_data['cost']; ?>" data-text="<?php echo $quote_data['text']; ?>">
                                        <?php } ?>
                                        <label class="form-check-label" for="input-checkout-shipping-method-<?php echo $seller['seller_id']; ?>-<?php echo $shipping_method['id']; ?>">
                                            <?php echo $quote_data['text']; ?> - <?php echo $quote_data['cost_formatted']; ?>
                                        </label>
                                    </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                <div class="alert alert-warning" role="alert"><?php echo lang('Error.shipping_method_not_available', [], $language_lib->getCurrentCode()); ?></div>
                <?php } ?>
            <?php } else { ?>
            <div class="text-secondary"><?php echo lang('Text.no_shipping_method_required', [], $language_lib->getCurrentCode()); ?></div>
            <?php } ?>
        </div>
        <script type="text/javascript"><!--
        $( document ).ready(function() {
            var seller = '<?php echo $seller['seller_id']; ?>';

            $('#checkout-shipping-method-' + seller + ' .form-check-input').on('click', function() {
                code = $(this).val();
                seller_id = $(this).attr('data-seller-id');
                cost = $(this).attr('data-cost');
                text = $(this).attr('data-text');

                $.ajax({
                    url: '<?php echo $checkout_set_shipping_method; ?>' + '&seller_id=' + seller_id + '&code=' + code,
                    type: 'post',
                    data: {
                        cost: cost,
                        text: text
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#checkout-shipping-method-' + seller_id + ' .form-check-input').prop('disabled', true);
                    },
                    complete: function() {
                        $('#checkout-shipping-method-' + seller_id + ' .form-check-input').prop('disabled', false);
                    },
                    success: function(json) {
                        // Refresh payment methods
                        $( '#checkout-payment-method' ).html( '<i class="fas fa-spinner fa-spin"></i>' );
                        $( '#checkout-payment-method' ).load( '<?php echo $checkout_payment_method; ?>' );

                        // Refresh checkout cart
                        $( '#checkout-cart' ).html( '<i class="fas fa-spinner fa-spin"></i>' );
                        $( '#checkout-cart' ).load( '<?php echo $checkout_cart; ?>' );

                        // Refresh checkout confirm
                        $( '#checkout-confirm' ).html( '<i class="fas fa-spinner fa-spin"></i>' );
                        $( '#checkout-confirm' ).load( '<?php echo $checkout_confirm; ?>' );

                        // Show selected checkout shipping address
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });

                //alert(code + ' - ' + seller);
            });
        }); 
        //--></script> 
    <?php } ?>
<?php } ?>
