<?php if (!empty($customer_addresses)) { ?>
<select name="checkout_payment_address" class="form-select">
    <?php foreach ($customer_addresses as $customer_address) { ?>
        <?php if ($customer_address['customer_address_id'] == $checkout_payment_address_id) { ?>
        <option value="<?php echo $customer_address['customer_address_id']; ?>" selected="selected"><?php echo $customer_address['address']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $customer_address['customer_address_id']; ?>"><?php echo $customer_address['address']; ?></option>
        <?php } ?>
    <?php } ?>
</select>
<div class="form-check my-3">
	<input class="form-check-input" type="checkbox" value="1" id="check-checkout-payment-address-add">
	<label class="form-check-label" for="check-checkout-payment-address-add">
		<?php echo lang('Text.new_address', [], $language_lib->getCurrentCode()); ?>
	</label>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#check-checkout-payment-address-add').change(function() {
		if (this.checked) {
			$('#form-checkout-payment-address-add').removeClass('d-none');
		} else {
			$('#form-checkout-payment-address-add').addClass('d-none');
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('select[name=\'checkout_payment_address\']').on('change', function() {
		$.ajax({
			url: '<?php echo $checkout_set_payment_address; ?>' + '&customer_address_id=' + this.value,
			dataType: 'json',
			beforeSend: function() {
				$('select[name=\'checkout_payment_address\']').prop('disabled', true);
			},
			complete: function() {
				$('select[name=\'checkout_payment_address\']').prop('disabled', false);
			},
			success: function(json) {
				// Refresh payment methods
				$( '#checkout-payment-method' ).html( '<i class="fas fa-spinner fa-spin"></i>' );
				$( '#checkout-payment-method' ).load( '<?php echo $checkout_payment_method; ?>' );

				// Refresh checkout cart
				$( '#checkout-cart' ).html( '<i class="fas fa-spinner fa-spin"></i>' );
				$( '#checkout-cart' ).load( '<?php echo $checkout_cart; ?>' );

				// Show selected checkout payment address

			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});

	$('select[name=\'checkout_payment_address\']').trigger('change');
});
//--></script> 
<?php } else { ?>
<div class="alert alert-warning" role="alert"><?php echo lang('Error.payment_address_not_found', [], $language_lib->getCurrentCode()); ?></div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#form-checkout-payment-address-add').removeClass('d-none');
});
//--></script> 
<?php } ?>
<div id="form-checkout-payment-address-add" class="d-none">
	<fieldset>
        <div class="mb-3 required">
            <label for="input-checkout-payment-address-firstname" class="form-label"><?php echo lang('Entry.firstname', [], $language_lib->getCurrentCode()); ?></label>
            <input type="text" name="firstname" value="" id="input-checkout-payment-address-firstname" class="form-control" placeholder="<?php echo lang('Entry.firstname', [], $language_lib->getCurrentCode()); ?>">
        </div>
        <div class="mb-3 required">
            <label for="input-checkout-payment-address-lastname" class="form-label"><?php echo lang('Entry.lastname', [], $language_lib->getCurrentCode()); ?></label>
            <input type="text" name="lastname" value="" id="input-checkout-payment-address-lastname" class="form-control" placeholder="<?php echo lang('Entry.lastname', [], $language_lib->getCurrentCode()); ?>">
        </div>
        <div class="mb-3 required">
            <label for="input-checkout-payment-address-address-1" class="form-label"><?php echo lang('Entry.address_1', [], $language_lib->getCurrentCode()); ?></label>
            <textarea rows="5" name="address_1" id="input-checkout-payment-address-address-1" class="form-control" placeholder="<?php echo lang('Entry.address_1', [], $language_lib->getCurrentCode()); ?>"></textarea>
        </div>
        <div class="mb-3">
            <label for="input-checkout-payment-address-address-2" class="form-label"><?php echo lang('Entry.address_2', [], $language_lib->getCurrentCode()); ?></label>
            <textarea rows="5" name="address_2" id="input-checkout-payment-address-address-2" class="form-control" placeholder="<?php echo lang('Entry.address_2', [], $language_lib->getCurrentCode()); ?>"></textarea>
        </div>
        <div class="mb-3 required">
            <label for="input-checkout-payment-address-city" class="form-label"><?php echo lang('Entry.city', [], $language_lib->getCurrentCode()); ?></label>
            <input type="text" name="city" value="" id="input-checkout-payment-address-city" class="form-control" placeholder="">
        </div>
        <div class="mb-3 required">
            <label for="input-checkout-payment-address-country" class="form-label"><?php echo lang('Entry.country', [], $language_lib->getCurrentCode()); ?></label>
            <select name="country_id" id="input-checkout-payment-address-country" class="form-select">
                <option value=""><?php echo lang('Text.please_select', [], $language_lib->getCurrentCode()); ?></option>
                <?php foreach ($countries as $country) { ?>
                    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3 required">
            <label for="input-checkout-payment-address-zone" class="form-label"><?php echo lang('Entry.zone', [], $language_lib->getCurrentCode()); ?></label>
            <select name="zone_id" id="input-checkout-payment-address-zone" class="form-select"></select>
        </div>
        <div class="mb-3 required">
            <label for="input-checkout-payment-address-telephone" class="form-label"><?php echo lang('Entry.telephone', [], $language_lib->getCurrentCode()); ?></label>
            <input type="text" name="telephone" value="" id="input-checkout-payment-address-telephone" class="form-control" placeholder="<?php echo lang('Entry.telephone', [], $language_lib->getCurrentCode()); ?>">
        </div>
	</fieldset>
	<div class="buttons clearfix">
		<div class="float-end"><button type="button" class="btn btn-primary" id="button-checkout-payment-address-add"><i class="fas fa-plus-circle fa-fw"></i> <?php echo lang('Button.add', [], $language_lib->getCurrentCode()); ?></button></div>
	</div>
</div>
<script type="text/javascript"><!--
$('#form-checkout-payment-address-add select[name=\'country_id\']').on('change', function() {
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
			html = '<option value=""><?php echo lang('Text.please_select', [], $language_lib->getCurrentCode()); ?></option>';
			
			if (json['zones'] && json['zones'] != '') {
				for (i = 0; i < json['zones'].length; i++) {
                    zone = json['zones'][i];

					html += '<option value="' + zone['zone_id'] + '">' + zone['name'] + '</option>';
				}
			} else {
				html += '<option value="" selected="selected"><?php echo lang('Text.none', [], $language_lib->getCurrentCode()); ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#form-checkout-payment-address-add select[name=\'country_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#form-checkout-payment-address-add #button-checkout-payment-address-add').on('click', function() {
	$.ajax({
		url: '<?php echo $add_address; ?>' + '&type=payment_address',
		type: 'post',
		data: $('#form-checkout-payment-address-add input[type=\'text\'], #form-checkout-payment-address-add input[type=\'hidden\'], #form-checkout-payment-address-add input[type=\'radio\']:checked, #form-checkout-payment-address-add input[type=\'checkbox\']:checked, #form-checkout-payment-address-add select, #form-checkout-payment-address-add textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-checkout-payment-address-add i').removeClass('fa-plus-circle').addClass('fa-spinner fa-spin');
		},
		complete: function() {
			$('#button-checkout-payment-address-add i').removeClass('fa-spinner fa-spin').addClass('fa-plus-circle');
		},
		success: function(json) {
			if (json['error']) {
				$('#form-checkout-payment-address-add .text-danger.small').remove();

		     	$.each(json['error'], function (key, value) {
					$('#input-checkout-payment-address-' + key.replace('_' , '-')).after('<div class="text-danger small">' + value + '</div>');
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

				// Show selected checkout payment address

 			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//--></script> 
