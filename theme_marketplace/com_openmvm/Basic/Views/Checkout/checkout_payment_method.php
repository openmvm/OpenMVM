<?php if (!empty($payment_methods)) { ?>
    <div id="checkout-payment-method">
    <?php foreach ($payment_methods as $payment_method) { ?>
        <div class="form-check">
            <?php if ($payment_method['code'] == $checkout_payment_method_code) { ?>
            <input class="form-check-input" type="radio" name="checkout_payment_method" value="<?php echo $payment_method['code']; ?>" id="input-checkout-payment-method-<?php echo $payment_method['id']; ?>" checked="checked">
            <?php } else { ?>
            <input class="form-check-input" type="radio" name="checkout_payment_method" value="<?php echo $payment_method['code']; ?>" id="input-checkout-payment-method-<?php echo $payment_method['id']; ?>">
            <?php } ?>
            <label class="form-check-label" for="input-checkout-payment-method-<?php echo $payment_method['id']; ?>">
                <?php echo $payment_method['name']; ?>
            </label>
        </div>
    <?php } ?>
    </div>
    <script type="text/javascript"><!--
    $( document ).ready(function() {
        $('#checkout-payment-method .form-check-input').on('click', function() {
            code = $(this).val();

            $.ajax({
                url: '<?php echo $checkout_set_payment_method; ?>' + '&code=' + code,
                dataType: 'json',
                beforeSend: function() {
                    $('#checkout-payment-method .form-check-input').prop('disabled', true);
                },
                complete: function() {
                    $('#checkout-payment-method .form-check-input').prop('disabled', false);
                },
                success: function(json) {
                    // Refresh checkout confirm
                    $( '#checkout-confirm' ).html( '<i class="fas fa-spinner fa-spin"></i>' );
                    $( '#checkout-confirm' ).load( '<?php echo $checkout_confirm; ?>' );

                    // Show selected checkout payment address
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });

            //alert(code + ' - ' + seller);
        });
    }); 
    //--></script> 
<?php } else { ?>
<div class="alert alert-warning" role="alert"><?php echo lang('Error.payment_method_not_available', [], $language_lib->getCurrentCode()); ?></div>
<?php } ?>
