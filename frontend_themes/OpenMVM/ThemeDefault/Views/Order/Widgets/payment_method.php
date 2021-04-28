<?php if (!$error) { ?>
  <?php if ($payment_methods) { ?>
		<?php foreach ($payment_methods as $payment_method) { ?>
		<div class="form-check">
		  <input class="form-check-input" type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="input-payment-method<?php echo $payment_method['code']; ?>"<?php if ($code == $payment_method['code']) { ?> checked<?php } ?>>
		  <label class="form-check-label" for="input-payment-method<?php echo $payment_method['code']; ?>">
		    <?php echo $payment_method['title']; ?> <?php if ($payment_method['terms']) { ?><?php echo $payment_method['terms']; ?><?php } ?>
		  </label>
		</div>
		<?php } ?>
  <?php } ?>
<?php } else { ?>
	<div class="alert alert-danger alert-dismissible" role="alert">
	  <?php echo lang('Error.error_payment_method_previous_options', array(), $lang->getFrontEndLocale()); ?>
	</div>
<?php } ?>
<script type="text/javascript"><!--
$('#accordionPaymentMethod input:radio').click(function() { 
  $.ajax({
    url: '<?php echo base_url('/order/checkout/widget/payment_method/set'); ?>',
    type: 'post',
    dataType: 'json',
    data : {
      value: $(this).val(),
    },
    beforeSend: function() {
      $('#accordionPaymentMethod input[name=\'' + $(this).attr('name') + '\']').prop('disabled', true);
    },
    complete: function() {
      $('#accordionPaymentMethod input[name=\'' + $(this).attr('name') + '\']').prop('disabled', false);
    },
    success: function(json) {
			// Checkout Cart Set Order
			$.get('<?php echo base_url('/order/checkout/widget/checkout_cart/set'); ?>');

      // Refresh checkout widgets
			// $('#widget-payment-address').load('<?php echo base_url('/order/checkout/widget/payment_address'); ?>');
			// $('#widget-shipping-address').load('<?php echo base_url('/order/checkout/widget/shipping_address'); ?>');
			// $('#widget-shipping-method').load('<?php echo base_url('/order/checkout/widget/shipping_method'); ?>');
			// $('#widget-payment-method').load('<?php echo base_url('/order/checkout/widget/payment_method'); ?>');
			$('#widget-checkout-cart').load('<?php echo base_url('/order/checkout/widget/checkout_cart'); ?>');
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}); 
//--></script> 