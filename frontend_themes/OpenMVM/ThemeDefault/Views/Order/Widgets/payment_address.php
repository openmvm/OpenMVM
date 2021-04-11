<div class="accordion" id="accordionPaymentAddress">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingPaymentAddress">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePaymentAddress" aria-expanded="true" aria-controls="collapsePaymentAddress">
        <?php echo lang('Text.text_payment_address', array(), $lang->getFrontEndLocale()); ?>
      </button>
    </h2>
    <div id="collapsePaymentAddress" class="accordion-collapse collapse show" aria-labelledby="headingPaymentAddress" data-bs-parent="#accordionPaymentAddress">
      <div class="accordion-body">
				<?php if ($user_addresses) { ?>
				<div id="payment-address-container" class="form-floating mb-3">
				  <select name="payment_address_id" class="form-select" id="input-payment-address-id" aria-label="status">
				  	<?php foreach ($user_addresses as $user_address) { ?>
              <?php if ($user_address['user_address_id'] == $payment_address_id) { ?>
                <option value="<?php echo $user_address['user_address_id']; ?>" selected><?php echo $user_address['address']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $user_address['user_address_id']; ?>"><?php echo $user_address['address']; ?></option>
              <?php } ?>
				  	<?php } ?>
				  </select>
				  <label for="input-payment-address-id"><?php echo lang('Entry.entry_payment_address', array(), $lang->getFrontEndLocale()); ?></label>
				</div>
				<?php } ?>
				<div id="form-check-add-payment-address" class="form-check">
				  <input class="form-check-input" type="checkbox" name="add_payment_address" value="" id="flexCheckPaymentAddress">
				  <label class="form-check-label" for="flexCheckPaymentAddress">
				    <?php echo lang('Entry.entry_new_address', array(), $lang->getFrontEndLocale()); ?>
				  </label>
				</div>
				<div id="payment-address-form-container" class="d-none">
					<fieldset>
				  	<div class="form-floating mb-3">
						  <input type="text" name="firstname" value="" class="form-control" id="input-payment-address-firstname" placeholder="<?php echo lang('Entry.entry_firstname', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-payment-address-firstname"><?php echo lang('Entry.entry_firstname', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div class="form-floating mb-3">
						  <input type="text" name="lastname" value="" class="form-control" id="input-payment-address-lastname" placeholder="<?php echo lang('Entry.entry_lastname', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-payment-address-lastname"><?php echo lang('Entry.entry_lastname', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div class="form-floating mb-3">
						  <textarea style="height: 100px" name="address_1" class="form-control" id="input-payment_address-address-1" placeholder="<?php echo lang('Entry.entry_address_1', array(), $lang->getFrontEndLocale()); ?>"><?php echo $address_1; ?></textarea>
						  <label for="input-payment-address-address-1"><?php echo lang('Entry.entry_address_1', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div class="form-floating mb-3">
						  <textarea style="height: 100px" name="address_2" class="form-control" id="input-payment-address-address-2" placeholder="<?php echo lang('Entry.entry_address_2', array(), $lang->getFrontEndLocale()); ?>"><?php echo $address_2; ?></textarea>
						  <label for="input-payment-address-address-2"><?php echo lang('Entry.entry_address_2', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
						<div class="form-floating mb-3">
						  <select name="country_id" class="form-select" id="input-payment-address-country-id" aria-label="input-payment-address-country-id">
                <?php foreach ($countries as $country) { ?>
                  <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
						  </select>
						  <label for="input-payment-address-country-id"><?php echo lang('Entry.entry_country', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
						<div id="payment-address-state-id-container" class="form-floating mb-3">
						  <select name="state_id" class="form-select" id="input-payment-address-state-id" aria-label="input-payment-address-state-id">
						  </select>
						  <label for="input-payment-address-state-id"><?php echo lang('Entry.entry_state', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div id="payment-address-state-container" class="form-floating mb-3">
						  <input type="text" name="state" value="" class="form-control" id="input-payment-address-state" placeholder="<?php echo lang('Entry.entry_state', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-payment-address-state"><?php echo lang('Entry.entry_state', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
						<div id="payment-address-city-id-container" class="form-floating mb-3">
						  <select name="city_id" class="form-select" id="input-payment-address-city-id" aria-label="input-payment-address-city-id">
						  </select>
						  <label for="input-payment-address-city-id"><?php echo lang('Entry.entry_city', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div id="payment-address-city-container" class="form-floating mb-3">
						  <input type="text" name="city" value="" class="form-control" id="input-payment-address-city" placeholder="<?php echo lang('Entry.entry_city', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-payment-address-city"><?php echo lang('Entry.entry_city', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
						<div id="payment-address-district-id-container" class="form-floating mb-3">
						  <select name="district_id" class="form-select" id="input-payment-address-district-id" aria-label="input-payment-address-district-id">
						  </select>
						  <label for="input-payment-address-district-id"><?php echo lang('Entry.entry_district', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div id="payment-address-district-container" class="form-floating mb-3">
						  <input type="text" name="district" value="" class="form-control" id="input-payment-address-district" placeholder="<?php echo lang('Entry.entry_district', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-payment-address-district"><?php echo lang('Entry.entry_district', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div class="form-floating mb-3">
						  <input type="text" name="postal_code" value="" class="form-control" id="input-payment-address-postal-code" placeholder="<?php echo lang('Entry.entry_postal_code', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-payment-address-postal-code"><?php echo lang('Entry.entry_postal_code', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div class="form-floating mb-3">
						  <input type="text" name="telephone" value="" class="form-control" id="input-payment-address-telephone" placeholder="<?php echo lang('Entry.entry_telephone', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-payment-address-telephone"><?php echo lang('Entry.entry_telephone', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
					</fieldset>
					<div class="text-end">
						<button type="submit" id="button-add-payment-address" class="btn btn-primary"><?php echo lang('Button.button_address_add', array(), $lang->getFrontEndLocale()); ?></button>
					</div>
				</div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
<?php if (empty($user_addresses)) { ?>
	$('#form-check-add-payment-address').addClass('d-none');
	$('#payment-address-form-container').removeClass('d-none');
<?php } ?>
$("#flexCheckPaymentAddress").click(function() {
  if ($('#flexCheckPaymentAddress').is(':checked')) {
	  $('#payment-address-form-container').addClass('mt-3').removeClass('d-none');
  } else {
	  $('#payment-address-form-container').removeClass('mt-3').addClass('d-none');
  }
});                 
//--></script> 
<script type="text/javascript"><!--
$('#payment-address-container select[name=\'payment_address_id\']').on('change', function() {
  $.ajax({
    url: '<?php echo base_url('/order/checkout/widget/payment_address/set'); ?>',
    type: 'post',
    dataType: 'json',
    data : {
      payment_address_id : $('#payment-address-container select[name=\'payment_address_id\']').val()
    },
    beforeSend: function() {
      $('#payment-address-container select[name=\'payment_address_id\']').prop('disabled', true);
    },
    complete: function() {
      $('#payment-address-container select[name=\'payment_address_id\']').prop('disabled', false);
    },
    success: function(json) {
			// Checkout Cart Set Order
			$.get('<?php echo base_url('/order/checkout/widget/checkout_cart/set'); ?>');

      // Refresh checkout widgets
			// $('#widget-payment-address').load('<?php echo base_url('/order/checkout/widget/payment_address'); ?>');
			// $('#widget-shipping-address').load('<?php echo base_url('/order/checkout/widget/shipping_address'); ?>');
			$('#widget-payment-method').load('<?php echo base_url('/order/checkout/widget/payment_method'); ?>');
			$('#widget-shipping-method').load('<?php echo base_url('/order/checkout/widget/shipping_method'); ?>');
			$('#widget-checkout-cart').load('<?php echo base_url('/order/checkout/widget/checkout_cart'); ?>');
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

$('#payment-address-container select[name=\'payment_address_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#payment-address-form-container select[name=\'country_id\']').on('change', function() {
  $.ajax({
    url: '<?php echo base_url('/localisation/get_country'); ?>',
    type: 'post',
    dataType: 'json',
    data : {
      country_id : $('#payment-address-form-container select[name=\'country_id\']').val()
    },
    beforeSend: function() {
      $('#payment-address-form-container select[name=\'country_id\']').prop('disabled', true);
    },
    complete: function() {
      $('#payment-address-form-container select[name=\'country_id\']').prop('disabled', false);
    },
    success: function(json) {
    	if (json['state_input_type'] == 'select_box') {
    		$('#payment-address-form-container #payment-address-state-container').addClass('d-none');

	      html = '<option value=""><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>';
	      
	      if (json['states'] && json['states'] != '') {
	        for (i = 0; i < json['states'].length; i++) {
	          state = json['states'][i];

	          html += '<option value="' + state['state_id'] + '">' + state['name'] + '</option>';
	        }
	      } else {
	        html += '<option value="0" selected="selected"><?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?></option>';
	      }
	      
    		$('#payment-address-form-container #payment-address-state-id-container').removeClass('d-none');
	      $('#payment-address-form-container select[name=\'state_id\']').html(html);
	      $('#payment-address-form-container select[name=\'state_id\']').trigger('change');
    	} else {
    		$('#payment-address-form-container #payment-address-state-id-container').addClass('d-none');
    		$('#payment-address-form-container #payment-address-state-container').removeClass('d-none');
    	}
	      
    	if (json['city_input_type'] == 'select_box') {
    		$('#payment-address-form-container #payment-address-city-container').addClass('d-none');
    		$('#payment-address-form-container #payment-address-city-id-container').removeClass('d-none');
    	} else {
    		$('#payment-address-form-container #payment-address-city-id-container').addClass('d-none');
    		$('#payment-address-form-container #payment-address-city-container').removeClass('d-none');
    	}
	      
    	if (json['district_input_type'] == 'select_box') {
    		$('#payment-address-form-container #payment-address-district-container').addClass('d-none');
    		$('#payment-address-form-container #payment-address-district-id-container').removeClass('d-none');
    	} else {
    		$('#payment-address-form-container #payment-address-district-id-container').addClass('d-none');
    		$('#payment-address-form-container #payment-address-district-container').removeClass('d-none');
    	}
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

$('#payment-address-form-container select[name=\'country_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#payment-address-form-container select[name=\'state_id\']').on('change', function() {
  setTimeout(function(){
    var state_id = $('#payment-address-form-container select[name=\'state_id\']').val();
    $.ajax({
      url: '<?php echo base_url('/localisation/get_state'); ?>',
      type: 'post',
      dataType: 'json',
      data : {
        state_id : state_id
      },
      beforeSend: function() {
        $('#payment-address-form-container select[name=\'state_id\']').prop('disabled', true);
        $('#payment-address-form-container select[name=\'city_id\']').prop('disabled', true);
      },
      complete: function() {
        $('#payment-address-form-container select[name=\'state_id\']').prop('disabled', false);
        $('#payment-address-form-container select[name=\'city_id\']').prop('disabled', false);
      },
      success: function(json) {
        html = '<option value=""><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>';
        
        if (json['cities'] && json['cities'] != '') {
          for (i = 0; i < json['cities'].length; i++) {
            city = json['cities'][i];

            html += '<option value="' + city['city_id'] + '">' + city['name'] + '</option>';
          }
        } else {
          html += '<option value="0" selected="selected"><?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?></option>';
        }
        
        if (json['state_input_type'] == 'select_box') {
          $('#payment-address-form-container input[name=\'state\']').val(json['name']);
        }
        $('#payment-address-form-container select[name=\'city_id\']').html(html);
        $('#payment-address-form-container select[name=\'city_id\']').trigger('change');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }, 200);
});

$('#payment-address-form-container select[name=\'state_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#payment-address-form-container select[name=\'city_id\']').on('change', function() {
  setTimeout(function(){
    var city_id = $('#payment-address-form-container select[name=\'city_id\']').val();
    $.ajax({
      url: '<?php echo base_url('/localisation/get_city'); ?>',
      type: 'post',
      dataType: 'json',
      data : {
        city_id : city_id
      },
      beforeSend: function() {
        $('#payment-address-form-container select[name=\'city_id\']').prop('disabled', true);
        $('#payment-address-form-container select[name=\'district_id\']').prop('disabled', true);
      },
      complete: function() {
        $('#payment-address-form-container select[name=\'city_id\']').prop('disabled', false);
        $('#payment-address-form-container select[name=\'district_id\']').prop('disabled', false);
      },
      success: function(json) {
        html = '<option value=""><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>';
        
        if (json['districts'] && json['districts'] != '') {
          for (i = 0; i < json['districts'].length; i++) {
            district = json['districts'][i];

            html += '<option value="' + district['district_id'] + '">' + district['name'] + '</option>';
          }
        } else {
          html += '<option value="0" selected="selected"><?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?></option>';
        }
        
        if (json['city_input_type'] == 'select_box') {
        	$('#payment-address-form-container input[name=\'city\']').val(json['name']);
        }
        $('#payment-address-form-container select[name=\'district_id\']').html(html);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }, 400);
});

$('#payment-address-form-container select[name=\'city_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#payment-address-form-container select[name=\'district_id\']').on('change', function() {
  setTimeout(function(){
    var district_id = $('#payment-address-form-container select[name=\'district_id\']').val();
    $.ajax({
      url: '<?php echo base_url('/localisation/get_district'); ?>',
      type: 'post',
      dataType: 'json',
      data : {
        district_id : district_id
      },
      beforeSend: function() {
        $('#payment-address-form-container select[name=\'district_id\']').prop('disabled', true);
      },
      complete: function() {
        $('#payment-address-form-container select[name=\'district_id\']').prop('disabled', false);
      },
      success: function(json) {
        if (json['district_input_type'] == 'select_box') {
          $('#payment-address-form-container input[name=\'district\']').val(json['name']);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }, 400);
});

$('#payment-address-form-container select[name=\'district_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#button-add-payment-address').on('click', function() {
	$.ajax({
		url: '<?php echo base_url('/order/checkout/widget/payment_address/add'); ?>',
		type: 'post',
		data: $('#payment-address-form-container input[type=\'text\'], #payment-address-form-container select, #payment-address-form-container textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-add-payment-address').button('loading');
		},
		complete: function() {
			$('#button-add-payment-address').button('reset');
		},
		success: function(json) {
			$('#payment-address-form-container .alert-dismissible, #payment-address-form-container .text-danger').remove();
			$('#payment-address-form-container .form-control').removeClass('is-invalid');

			if (json['error']) {
				if (json['error']['input']) {
					for (i in json['error']['input']) {
						var element = $('#payment-address-form-container #input-' + i.replace(/_/g, '-'));

						element.addClass('is-invalid');

						element.next('label').before('<div class="text-danger">' + json['error']['input'][i] + '</div>');
					}
				}

				if (json['error']['warning'] || json['error']['permission']) {
					$('#payment-address-form-container').prepend('<div class="alert alert-danger alert-dismissible" role="alert">' + json['error']['warning'] + ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
				}
			}

			if (json['success']) {
				$('#widget-payment-address').load('<?php echo base_url('/order/checkout/widget/payment_address'); ?>');
				$('#widget-shipping-address').load('<?php echo base_url('/order/checkout/widget/shipping_address'); ?>');
				$('#widget-payment-method').load('<?php echo base_url('/order/checkout/widget/payment_method'); ?>');
				$('#widget-shipping-method').load('<?php echo base_url('/order/checkout/widget/shipping_method'); ?>');
				$('#widget-checkout-cart').load('<?php echo base_url('/order/checkout/widget/checkout_cart'); ?>');
			}

			$([document.documentElement, document.body]).animate({
			  scrollTop: $("#accordionPaymentAddress").offset().top
			}, 1000);

			//alert(JSON.stringify(json['error']));
		},
    error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
	});
});
//--></script> 
