<?php if (!empty($customer_addresses)) { ?>
<select name="checkout_shipping_address" class="form-control">
    <?php foreach ($customer_addresses as $customer_address) { ?>
        <?php if ($customer_address['customer_address_id'] == $checkout_shipping_address_id) { ?>
        <option value="<?php echo $customer_address['customer_address_id']; ?>" selected="selected"><?php echo $customer_address['address']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $customer_address['customer_address_id']; ?>"><?php echo $customer_address['address']; ?></option>
        <?php } ?>
   <?php } ?>
</select>
<div class="form-check my-3">
	<input class="form-check-input" type="checkbox" value="1" id="check-checkout-shipping-address-add">
	<label class="form-check-label" for="check-checkout-shipping-address-add">
		<?php echo lang('Text.new_address'); ?>
	</label>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#check-checkout-shipping-address-add').change(function() {
		if (this.checked) {
			$('#form-checkout-shipping-address-add').removeClass('d-none');
		} else {
			$('#form-checkout-shipping-address-add').addClass('d-none');
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('select[name=\'checkout_shipping_address\']').on('change', function() {
		$.ajax({
			url: '<?php echo $checkout_set_shipping_address; ?>' + '&customer_address_id=' + this.value,
			dataType: 'json',
			beforeSend: function() {
				$('select[name=\'checkout_shipping_address\']').prop('disabled', true);
			},
			complete: function() {
				$('select[name=\'checkout_shipping_address\']').prop('disabled', false);
			},
			success: function(json) {
				// Refresh shipping methods
				$( '#checkout-shipping-method' ).html( '<i class="fas fa-spinner fa-spin"></i>' );
				$( '#checkout-shipping-method' ).load( '<?php echo $checkout_shipping_method; ?>' );

				// Refresh checkout cart
				$( '#checkout-cart' ).html( '<i class="fas fa-spinner fa-spin"></i>' );
				$( '#checkout-cart' ).load( '<?php echo $checkout_cart; ?>' );

				// Show selected checkout shipping address

			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});

	$('select[name=\'checkout_shipping_address\']').trigger('change');
});
//--></script> 
<?php } else { ?>
<div class="alert alert-warning" role="alert"><?php echo lang('Error.shipping_address_not_found'); ?></div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#form-checkout-shipping-address-add').removeClass('d-none');
});
//--></script> 
<?php } ?>
<div id="form-checkout-shipping-address-add" class="d-none">
	<fieldset>
        <div class="mb-3 required">
            <label for="input-checkout-shipping-address-firstname" class="form-label"><?php echo lang('Entry.firstname'); ?></label>
            <input type="text" name="firstname" value="" id="input-checkout-shipping-address-firstname" class="form-control" placeholder="<?php echo lang('Entry.firstname'); ?>">
        </div>
        <div class="mb-3 required">
            <label for="input-checkout-shipping-address-lastname" class="form-label"><?php echo lang('Entry.lastname'); ?></label>
            <input type="text" name="lastname" value="" id="input-checkout-shipping-address-lastname" class="form-control" placeholder="<?php echo lang('Entry.lastname'); ?>">
        </div>
        <div class="mb-3 required">
            <label for="input-checkout-shipping-address-address-1" class="form-label"><?php echo lang('Entry.address_1'); ?></label>
            <textarea rows="5" name="address_1" id="input-checkout-shipping-address-address-1" class="form-control" placeholder="<?php echo lang('Entry.address_1'); ?>"></textarea>
        </div>
        <div class="mb-3">
            <label for="input-checkout-shipping-address-address-2" class="form-label"><?php echo lang('Entry.address_2'); ?></label>
            <textarea rows="5" name="address_2" id="input-checkout-shipping-address-address-2" class="form-control" placeholder="<?php echo lang('Entry.address_2'); ?>"></textarea>
        </div>
        <div class="mb-3 required">
            <label for="input-checkout-shipping-address-city" class="form-label"><?php echo lang('Entry.city'); ?></label>
            <input type="text" name="city" value="" id="input-checkout-shipping-address-city" class="form-control" placeholder="">
        </div>
        <div class="mb-3 required">
            <label for="input-checkout-shipping-address-country" class="form-label"><?php echo lang('Entry.country'); ?></label>
            <select name="country_id" id="input-checkout-shipping-address-country" class="form-control">
                <option value=""><?php echo lang('Text.please_select'); ?></option>
                <?php foreach ($countries as $country) { ?>
                    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3 required">
            <label for="input-checkout-shipping-address-zone" class="form-label"><?php echo lang('Entry.zone'); ?></label>
            <select name="zone_id" id="input-checkout-shipping-address-zone" class="form-control"></select>
        </div>
        <div class="mb-3 required">
            <label for="input-checkout-shipping-address-telephone" class="form-label"><?php echo lang('Entry.telephone'); ?></label>
            <input type="text" name="telephone" value="" id="input-checkout-shipping-address-telephone" class="form-control" placeholder="<?php echo lang('Entry.telephone'); ?>">
        </div>
	</fieldset>
	<div class="buttons clearfix">
		<div class="float-end"><button type="button" class="btn btn-primary" id="button-checkout-shipping-address-add"><i class="fas fa-plus-circle fa-fw"></i> <?php echo lang('Button.add'); ?></button></div>
	</div>
</div>
<script type="text/javascript"><!--
$('#form-checkout-shipping-address-add select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: '<?php echo base_url(); ?>' + '/marketplace/localisation/country/get_country?country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').prop('disabled', true);
		},
		complete: function() {
			$('select[name=\'country_id\']').prop('disabled', false);
		},
		success: function(json) {
			html = '<option value=""><?php echo lang('Text.please_select'); ?></option>';
			
			if (json['zones'] && json['zones'] != '') {
				for (i = 0; i < json['zones'].length; i++) {
                    zone = json['zones'][i];

					html += '<option value="' + zone['zone_id'] + '">' + zone['name'] + '</option>';
				}
			} else {
				html += '<option value="" selected="selected"><?php echo lang('Text.none'); ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#form-checkout-shipping-address-add select[name=\'country_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#form-checkout-shipping-address-add #button-checkout-shipping-address-add').on('click', function() {
	$.ajax({
		url: '<?php echo base_url(); ?>' + '/marketplace/checkout/checkout/add_address?type=shipping_address',
		type: 'post',
		data: $('#form-checkout-shipping-address-add input[type=\'text\'], #form-checkout-shipping-address-add input[type=\'hidden\'], #form-checkout-shipping-address-add input[type=\'radio\']:checked, #form-checkout-shipping-address-add input[type=\'checkbox\']:checked, #form-checkout-shipping-address-add select, #form-checkout-shipping-address-add textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-checkout-shipping-address-add i').removeClass('fa-plus-circle').addClass('fa-spinner fa-spin');
		},
		complete: function() {
			$('#button-checkout-shipping-address-add i').removeClass('fa-spinner fa-spin').addClass('fa-plus-circle');
		},
		success: function(json) {
			if (json['error']) {
				$('#form-checkout-shipping-address-add .text-danger.small').remove();

		     	$.each(json['error'], function (key, value) {
					$('#input-checkout-shipping-address-' + key.replace('_' , '-')).after('<div class="text-danger small">' + value + '</div>');
		     	});			
 			}

 			if (json['success']) {
				// Refresh payment address
				$( '#checkout-payment-address' ).html( '<i class="fas fa-spinner fa-spin"></i>' );
				$( '#checkout-payment-address' ).load( '<?php echo $checkout_payment_address; ?>' );

				// Refresh shipping address
				$( '#checkout-shipping-address' ).html( '<i class="fas fa-spinner fa-spin"></i>' );
				$( '#checkout-shipping-address' ).load( '<?php echo $checkout_shipping_address; ?>' );

				// Refresh payment methods
				$( '#checkout-payment-method' ).html( '<i class="fas fa-spinner fa-spin"></i>' );
				$( '#checkout-payment-method' ).load( '<?php echo $checkout_payment_method; ?>' );

				// Refresh shipping methods
				$( '#checkout-shipping-method' ).html( '<i class="fas fa-spinner fa-spin"></i>' );
				$( '#checkout-shipping-method' ).load( '<?php echo $checkout_shipping_method; ?>' );

				// Show selected checkout shipping address

 			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//--></script> 
