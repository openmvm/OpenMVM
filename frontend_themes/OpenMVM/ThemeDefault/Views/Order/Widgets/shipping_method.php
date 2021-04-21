<?php if (!$error) { ?>
	<?php foreach ($stores as $store) { ?>
		<div class="mb-3">
			<h5 class="border-bottom border-danger pb-2 mb-2"><strong><?php echo $store['name']; ?></strong> (<?php echo lang('Text.text_weight', array(), $lang->getFrontEndLocale()); ?>: <?php echo $store['weight']; ?>)</h5>
			<div>
				<?php if ($store['shipping_methods']) { ?>
        	<?php foreach ($store['shipping_methods'] as $shipping_method) { ?>
	      		<div><strong><?php echo $shipping_method['title']; ?></strong></div>
	      		<?php foreach ($shipping_method['quote'] as $quote) { ?>
						<div class="form-check">
						  <input class="form-check-input" type="radio" name="shipping_method[<?php echo $store['store_id']; ?>]" value="<?php echo $quote['code']; ?>" data-store-id="<?php echo $store['store_id']; ?>" id="input-shipping-method-<?php echo $store['store_id']; ?>-<?php echo $quote['code']; ?>"<?php if (${'shipping_method_' . $store['store_id']} == $quote['code']) { ?> checked<?php } ?>>
						  <label class="form-check-label" for="input-shipping-method-<?php echo $store['store_id']; ?>-<?php echo $quote['code']; ?>">
						    <?php echo $quote['title']; ?> - <?php echo $quote['text']; ?>
						  </label>
						</div>
	      		<?php } ?>
        	<?php } ?>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
<?php } else { ?>
	<div class="alert alert-danger alert-dismissible" role="alert">
	  <?php echo lang('Error.error_shipping_method_previous_options', array(), $lang->getFrontEndLocale()); ?>
	</div>
<?php } ?>
<script type="text/javascript"><!--
$('#accordionShippingMethod input:radio').click(function() { 
  $.ajax({
    url: '<?php echo base_url('/order/checkout/widget/shipping_method/set'); ?>',
    type: 'post',
    dataType: 'json',
    data : {
      store_id : $(this).attr('data-store-id'),
      name : $(this).attr('name'),
      value: $(this).val(),
    },
    beforeSend: function() {
      $('#accordionShippingMethod input[name=\'' + $(this).attr('name') + '\']').prop('disabled', true);
    },
    complete: function() {
      $('#accordionShippingMethod input[name=\'' + $(this).attr('name') + '\']').prop('disabled', false);
    },
    success: function(json) {
			// Checkout Cart Set Order
			$.get('<?php echo base_url('/order/checkout/widget/checkout_cart/set'); ?>');

      // Refresh checkout widgets
			// $('#widget-payment-address').load('<?php echo base_url('/order/checkout/widget/payment_address'); ?>');
			// $('#widget-shipping-address').load('<?php echo base_url('/order/checkout/widget/shipping_address'); ?>');
			// $('#widget-shipping-method').load('<?php echo base_url('/order/checkout/widget/shipping_method'); ?>');
			$('#widget-payment-method').load('<?php echo base_url('/order/checkout/widget/payment_method'); ?>');
			$('#widget-checkout-cart').load('<?php echo base_url('/order/checkout/widget/checkout_cart'); ?>');
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}); 
//--></script> 
