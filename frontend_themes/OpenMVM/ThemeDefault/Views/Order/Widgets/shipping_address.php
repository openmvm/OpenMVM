<div class="accordion" id="accordionShippingAddress">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingShippingAddress">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShippingAddress" aria-expanded="true" aria-controls="collapseShippingAddress">
        <?php echo lang('Text.text_shipping_address', array(), $lang->getFrontEndLocale()); ?>
      </button>
    </h2>
    <div id="collapseShippingAddress" class="accordion-collapse collapse show" aria-labelledby="headingShippingAddress" data-bs-parent="#accordionShippingAddress">
      <div class="accordion-body">
				<?php if ($user_addresses) { ?>
				<div id="shipping-address-container" class="form-floating mb-3">
				  <select name="shipping_address_id" class="form-select" id="input-shipping-address-id" aria-label="status">
				  	<?php foreach ($user_addresses as $user_address) { ?>
              <?php if ($user_address['user_address_id'] == $shipping_address_id) { ?>
                <option value="<?php echo $user_address['user_address_id']; ?>" selected><?php echo $user_address['address']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $user_address['user_address_id']; ?>"><?php echo $user_address['address']; ?></option>
              <?php } ?>
				  	<?php } ?>
				  </select>
				  <label for="input-shipping-address-id"><?php echo lang('Entry.entry_shipping_address', array(), $lang->getFrontEndLocale()); ?></label>
				</div>
				<?php } ?>
				<div id="form-check-add-shipping-address" class="form-check">
				  <input class="form-check-input" type="checkbox" name="add_shipping_address" value="" id="flexCheckShippingAddress">
				  <label class="form-check-label" for="flexCheckShippingAddress">
				    <?php echo lang('Entry.entry_new_address', array(), $lang->getFrontEndLocale()); ?>
				  </label>
				</div>
				<div id="shipping-address-form-container" class="d-none">
					<fieldset>
				  	<div class="form-floating mb-3">
						  <input type="text" name="firstname" value="" class="form-control" id="input-shipping-address-firstname" placeholder="<?php echo lang('Entry.entry_firstname', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-shipping-address-firstname"><?php echo lang('Entry.entry_firstname', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div class="form-floating mb-3">
						  <input type="text" name="lastname" value="" class="form-control" id="input-shipping-address-lastname" placeholder="<?php echo lang('Entry.entry_lastname', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-shipping-address-lastname"><?php echo lang('Entry.entry_lastname', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div class="form-floating mb-3">
						  <textarea style="height: 100px" name="address_1" class="form-control" id="input-shipping_address-address-1" placeholder="<?php echo lang('Entry.entry_address_1', array(), $lang->getFrontEndLocale()); ?>"><?php echo $address_1; ?></textarea>
						  <label for="input-shipping-address-address-1"><?php echo lang('Entry.entry_address_1', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div class="form-floating mb-3">
						  <textarea style="height: 100px" name="address_2" class="form-control" id="input-shipping-address-address-2" placeholder="<?php echo lang('Entry.entry_address_2', array(), $lang->getFrontEndLocale()); ?>"><?php echo $address_2; ?></textarea>
						  <label for="input-shipping-address-address-2"><?php echo lang('Entry.entry_address_2', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
						<div class="form-floating mb-3">
						  <select name="country_id" class="form-select" id="input-shipping-address-country-id" aria-label="input-shipping-address-country-id">
                <?php foreach ($countries as $country) { ?>
                  <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
						  </select>
						  <label for="input-shipping-address-country-id"><?php echo lang('Entry.entry_country', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
						<div id="shipping-address-state-id-container" class="form-floating mb-3">
						  <select name="state_id" class="form-select" id="input-shipping-address-state-id" aria-label="input-shipping-address-state-id">
						  </select>
						  <label for="input-shipping-address-state-id"><?php echo lang('Entry.entry_state', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div id="shipping-address-state-container" class="form-floating mb-3">
						  <input type="text" name="state" value="" class="form-control" id="input-shipping-address-state" placeholder="<?php echo lang('Entry.entry_state', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-shipping-address-state"><?php echo lang('Entry.entry_state', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
						<div id="shipping-address-city-id-container" class="form-floating mb-3">
						  <select name="city_id" class="form-select" id="input-shipping-address-city-id" aria-label="input-shipping-address-city-id">
						  </select>
						  <label for="input-shipping-address-city-id"><?php echo lang('Entry.entry_city', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div id="shipping-address-city-container" class="form-floating mb-3">
						  <input type="text" name="city" value="" class="form-control" id="input-shipping-address-city" placeholder="<?php echo lang('Entry.entry_city', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-shipping-address-city"><?php echo lang('Entry.entry_city', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
						<div id="shipping-address-district-id-container" class="form-floating mb-3">
						  <select name="district_id" class="form-select" id="input-shipping-address-district-id" aria-label="input-shipping-address-district-id">
						  </select>
						  <label for="input-shipping-address-district-id"><?php echo lang('Entry.entry_district', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div id="shipping-address-district-container" class="form-floating mb-3">
						  <input type="text" name="district" value="" class="form-control" id="input-shipping-address-district" placeholder="<?php echo lang('Entry.entry_district', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-shipping-address-district"><?php echo lang('Entry.entry_district', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div class="form-floating mb-3">
						  <input type="text" name="postal_code" value="" class="form-control" id="input-shipping-address-postal-code" placeholder="<?php echo lang('Entry.entry_postal_code', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-shipping-address-postal-code"><?php echo lang('Entry.entry_postal_code', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
				  	<div class="form-floating mb-3">
						  <input type="text" name="telephone" value="" class="form-control" id="input-shipping-address-telephone" placeholder="<?php echo lang('Entry.entry_telephone', array(), $lang->getFrontEndLocale()); ?>">
						  <label for="input-shipping-address-telephone"><?php echo lang('Entry.entry_telephone', array(), $lang->getFrontEndLocale()); ?></label>
						</div>
					</fieldset>
					<div class="text-end">
						<button type="submit" id="button-add-shipping-address" class="btn btn-primary"><?php echo lang('Button.button_address_add', array(), $lang->getFrontEndLocale()); ?></button>
					</div>
				</div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
<?php if (empty($user_addresses)) { ?>
	$('#form-check-add-shipping-address').addClass('d-none');
	$('#shipping-address-form-container').removeClass('d-none');
<?php } ?>
$("#flexCheckShippingAddress").click(function() {
  if ($('#flexCheckShippingAddress').is(':checked')) {
	  $('#shipping-address-form-container').addClass('mt-3').removeClass('d-none');
  } else {
	  $('#shipping-address-form-container').removeClass('mt-3').addClass('d-none');
  }
});                 
//--></script> 
<script type="text/javascript"><!--
$('#shipping-address-container select[name=\'shipping_address_id\']').on('change', function() {
  $.ajax({
    url: '<?php echo base_url('/order/checkout/widget/shipping_address/set'); ?>',
    type: 'post',
    dataType: 'json',
    data : {
      shipping_address_id : $('#shipping-address-container select[name=\'shipping_address_id\']').val()
    },
    beforeSend: function() {
      $('#shipping-address-container select[name=\'shipping_address_id\']').prop('disabled', true);
    },
    complete: function() {
      $('#shipping-address-container select[name=\'shipping_address_id\']').prop('disabled', false);
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

$('#shipping-address-container select[name=\'shipping_address_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#shipping-address-form-container select[name=\'country_id\']').on('change', function() {
  $.ajax({
    url: '<?php echo base_url('/localisation/get_country'); ?>',
    type: 'post',
    dataType: 'json',
    data : {
      country_id : $('#shipping-address-form-container select[name=\'country_id\']').val()
    },
    beforeSend: function() {
      $('#shipping-address-form-container select[name=\'country_id\']').prop('disabled', true);
    },
    complete: function() {
      $('#shipping-address-form-container select[name=\'country_id\']').prop('disabled', false);
    },
    success: function(json) {
    	if (json['state_input_type'] == 'select_box') {
    		$('#shipping-address-form-container #shipping-address-state-container').addClass('d-none');

	      html = '<option value=""><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>';
	      
	      if (json['states'] && json['states'] != '') {
	        for (i = 0; i < json['states'].length; i++) {
	          state = json['states'][i];

	          html += '<option value="' + state['state_id'] + '">' + state['name'] + '</option>';
	        }
	      } else {
	        html += '<option value="0" selected="selected"><?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?></option>';
	      }
	      
    		$('#shipping-address-form-container #shipping-address-state-id-container').removeClass('d-none');
	      $('#shipping-address-form-container select[name=\'state_id\']').html(html);
	      $('#shipping-address-form-container select[name=\'state_id\']').trigger('change');
    	} else {
    		$('#shipping-address-form-container #shipping-address-state-id-container').addClass('d-none');
    		$('#shipping-address-form-container #shipping-address-state-container').removeClass('d-none');
    	}
	      
    	if (json['city_input_type'] == 'select_box') {
    		$('#shipping-address-form-container #shipping-address-city-container').addClass('d-none');
    		$('#shipping-address-form-container #shipping-address-city-id-container').removeClass('d-none');
    	} else {
    		$('#shipping-address-form-container #shipping-address-city-id-container').addClass('d-none');
    		$('#shipping-address-form-container #shipping-address-city-container').removeClass('d-none');
    	}
	      
    	if (json['district_input_type'] == 'select_box') {
    		$('#shipping-address-form-container #shipping-address-district-container').addClass('d-none');
    		$('#shipping-address-form-container #shipping-address-district-id-container').removeClass('d-none');
    	} else {
    		$('#shipping-address-form-container #shipping-address-district-id-container').addClass('d-none');
    		$('#shipping-address-form-container #shipping-address-district-container').removeClass('d-none');
    	}
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

$('#shipping-address-form-container select[name=\'country_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#shipping-address-form-container select[name=\'state_id\']').on('change', function() {
  setTimeout(function(){
    var state_id = $('#shipping-address-form-container select[name=\'state_id\']').val();
    $.ajax({
      url: '<?php echo base_url('/localisation/get_state'); ?>',
      type: 'post',
      dataType: 'json',
      data : {
        state_id : state_id
      },
      beforeSend: function() {
        $('#shipping-address-form-container select[name=\'state_id\']').prop('disabled', true);
        $('#shipping-address-form-container select[name=\'city_id\']').prop('disabled', true);
      },
      complete: function() {
        $('#shipping-address-form-container select[name=\'state_id\']').prop('disabled', false);
        $('#shipping-address-form-container select[name=\'city_id\']').prop('disabled', false);
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
          $('#shipping-address-form-container input[name=\'state\']').val(json['name']);
        }
        $('#shipping-address-form-container select[name=\'city_id\']').html(html);
        $('#shipping-address-form-container select[name=\'city_id\']').trigger('change');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }, 200);
});

$('#shipping-address-form-container select[name=\'state_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#shipping-address-form-container select[name=\'city_id\']').on('change', function() {
  setTimeout(function(){
    var city_id = $('#shipping-address-form-container select[name=\'city_id\']').val();
    $.ajax({
      url: '<?php echo base_url('/localisation/get_city'); ?>',
      type: 'post',
      dataType: 'json',
      data : {
        city_id : city_id
      },
      beforeSend: function() {
        $('#shipping-address-form-container select[name=\'city_id\']').prop('disabled', true);
        $('#shipping-address-form-container select[name=\'district_id\']').prop('disabled', true);
      },
      complete: function() {
        $('#shipping-address-form-container select[name=\'city_id\']').prop('disabled', false);
        $('#shipping-address-form-container select[name=\'district_id\']').prop('disabled', false);
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
        	$('#shipping-address-form-container input[name=\'city\']').val(json['name']);
        }
        $('#shipping-address-form-container select[name=\'district_id\']').html(html);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }, 400);
});

$('#shipping-address-form-container select[name=\'city_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#shipping-address-form-container select[name=\'district_id\']').on('change', function() {
  setTimeout(function(){
    var district_id = $('#shipping-address-form-container select[name=\'district_id\']').val();
    $.ajax({
      url: '<?php echo base_url('/localisation/get_district'); ?>',
      type: 'post',
      dataType: 'json',
      data : {
        district_id : district_id
      },
      beforeSend: function() {
        $('#shipping-address-form-container select[name=\'district_id\']').prop('disabled', true);
      },
      complete: function() {
        $('#shipping-address-form-container select[name=\'district_id\']').prop('disabled', false);
      },
      success: function(json) {
        if (json['district_input_type'] == 'select_box') {
          $('#shipping-address-form-container input[name=\'district\']').val(json['name']);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }, 400);
});

$('#shipping-address-form-container select[name=\'district_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#button-add-shipping-address').on('click', function() {
	$.ajax({
		url: '<?php echo base_url('/order/checkout/widget/shipping_address/add'); ?>',
		type: 'post',
		data: $('#shipping-address-form-container input[type=\'text\'], #shipping-address-form-container select, #shipping-address-form-container textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-add-shipping-address').button('loading');
		},
		complete: function() {
			$('#button-add-shipping-address').button('reset');
		},
		success: function(json) {
			$('#shipping-address-form-container .alert-dismissible, #shipping-address-form-container .text-danger').remove();
			$('#shipping-address-form-container .form-control').removeClass('is-invalid');

			if (json['error']) {
				if (json['error']['input']) {
					for (i in json['error']['input']) {
						var element = $('#shipping-address-form-container #input-' + i.replace(/_/g, '-'));

						element.addClass('is-invalid');

						element.next('label').before('<div class="text-danger">' + json['error']['input'][i] + '</div>');
					}
				}

				if (json['error']['warning'] || json['error']['permission']) {
					$('#shipping-address-form-container').prepend('<div class="alert alert-danger alert-dismissible" role="alert">' + json['error']['warning'] + ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
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
			  scrollTop: $("#accordionShippingAddress").offset().top
			}, 1000);

			//alert(JSON.stringify(json['error']));
		},
    error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
	});
});
//--></script> 
