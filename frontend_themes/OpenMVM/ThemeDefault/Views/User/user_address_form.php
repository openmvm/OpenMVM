<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo lang('Heading.heading_address_book', array(), $lang->getFrontEndLocale()); ?></h1>
  <?php echo form_open($action); ?>
  <div class="clearfix mb-3">
    <div class="float-end">
      <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_save', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-save"></i></button>
      <a href="<?php echo base_url('/account/address/' . $user_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
    </div>
  </div>
	<div class="accordion" id="accordionAccountProfile">
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="headingAccountProfile">
	      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccountProfile" aria-expanded="true" aria-controls="collapseAccountProfile">
	        <i class="fas fa-address-book fa-fw"></i>&nbsp;&nbsp;<?php echo $heading_title; ?>
	      </button>
	    </h2>
	    <div id="collapseAccountProfile" class="accordion-collapse collapse show" aria-labelledby="headingAccountProfile" data-bs-parent="#accordionAccountProfile">
	      <div class="accordion-body">

	        <div>
	          <fieldset>
					  	<div class="form-floating mb-3">
							  <input type="text" name="firstname" value="<?php echo $firstname; ?>" class="form-control<?php if ($validation->hasError('firstname')) { ?> is-invalid<?php } ?>" id="input-firstname" placeholder="<?php echo lang('Entry.entry_firstname', array(), $lang->getFrontEndLocale()); ?>">
							  <label for="input-firstname"><?php echo lang('Entry.entry_firstname', array(), $lang->getFrontEndLocale()); ?></label>
							  <?php if ($validation->hasError('firstname')) { ?>
                <div class="text-danger small"><?php echo $validation->getError('firstname'); ?></div>
              	<?php } ?>
							</div>
					  	<div class="form-floating mb-3">
							  <input type="text" name="lastname" value="<?php echo $lastname; ?>" class="form-control<?php if ($validation->hasError('lastname')) { ?> is-invalid<?php } ?>" id="input-lastname" placeholder="<?php echo lang('Entry.entry_lastname', array(), $lang->getFrontEndLocale()); ?>">
							  <label for="input-lastname"><?php echo lang('Entry.entry_lastname', array(), $lang->getFrontEndLocale()); ?></label>
							  <?php if ($validation->hasError('lastname')) { ?>
                <div class="text-danger small"><?php echo $validation->getError('lastname'); ?></div>
              	<?php } ?>
							</div>
					  	<div class="form-floating mb-3">
							  <textarea style="height: 100px" name="address_1" class="form-control<?php if ($validation->hasError('address_1')) { ?> is-invalid<?php } ?>" id="input-address-1" placeholder="<?php echo lang('Entry.entry_address_1', array(), $lang->getFrontEndLocale()); ?>"><?php echo $address_1; ?></textarea>
							  <label for="input-address-1"><?php echo lang('Entry.entry_address_1', array(), $lang->getFrontEndLocale()); ?></label>
							  <?php if ($validation->hasError('address_1')) { ?>
                <div class="text-danger small"><?php echo $validation->getError('address_1'); ?></div>
              	<?php } ?>
							</div>
					  	<div class="form-floating mb-3">
							  <textarea style="height: 100px" name="address_2" class="form-control" id="input-address-2" placeholder="<?php echo lang('Entry.entry_address_2', array(), $lang->getFrontEndLocale()); ?>"><?php echo $address_2; ?></textarea>
							  <label for="input-address-2"><?php echo lang('Entry.entry_address_2', array(), $lang->getFrontEndLocale()); ?></label>
							</div>
							<div class="form-floating mb-3">
							  <select name="country_id" class="form-select" id="input-country-id" aria-label="input-country-id">
                  <?php foreach ($countries as $country) { ?>
                    <?php if ($country['country_id'] == $country_id) { ?>
                      <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
							  </select>
							  <label for="input-country-id"><?php echo lang('Entry.entry_country', array(), $lang->getFrontEndLocale()); ?></label>
							</div>
							<div class="form-floating mb-3">
							  <select name="state_id" class="form-select" id="input-state-id" aria-label="input-state-id">
							  </select>
							  <label for="input-state-id"><?php echo lang('Entry.entry_state', array(), $lang->getFrontEndLocale()); ?></label>
							</div>
							<div class="form-floating mb-3">
							  <select name="city_id" class="form-select" id="input-city-id" aria-label="input-city-id">
							  </select>
							  <label for="input-city-id"><?php echo lang('Entry.entry_city', array(), $lang->getFrontEndLocale()); ?></label>
							</div>
							<div class="form-floating mb-3">
							  <select name="district_id" class="form-select" id="input-district-id" aria-label="input-district-id">
							  </select>
							  <label for="input-district-id"><?php echo lang('Entry.entry_district', array(), $lang->getFrontEndLocale()); ?></label>
							</div>
					  	<div class="form-floating mb-3">
							  <input type="text" name="postal_code" value="<?php echo $postal_code; ?>" class="form-control" id="input-postal-code" placeholder="<?php echo lang('Entry.entry_postal_code', array(), $lang->getFrontEndLocale()); ?>">
							  <label for="input-postal-code"><?php echo lang('Entry.entry_postal_code', array(), $lang->getFrontEndLocale()); ?></label>
							</div>
					  	<div class="form-floating mb-3">
							  <input type="text" name="telephone" value="<?php echo $telephone; ?>" class="form-control" id="input-telephone" placeholder="<?php echo lang('Entry.entry_telephone', array(), $lang->getFrontEndLocale()); ?>">
							  <label for="input-telephone"><?php echo lang('Entry.entry_telephone', array(), $lang->getFrontEndLocale()); ?></label>
							</div>
	          </fieldset>
	        </div>

	      </div>
	    </div>
	  </div>
	</div>
  <?php echo form_close(); ?>
</section>
<!-- /.content -->
<script type="text/javascript"><!--
$('select[name=\'country_id\']').on('change', function() {
  $.ajax({
    url: '<?php echo base_url('/localisation/get_country'); ?>',
    type: 'post',
    dataType: 'json',
    data : {
      country_id : $('select[name=\'country_id\']').val()
    },
    beforeSend: function() {
      $('select[name=\'country_id\']').prop('disabled', true);
    },
    complete: function() {
      $('select[name=\'country_id\']').prop('disabled', false);
    },
    success: function(json) {
      html = '<option value=""><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>';
      
      if (json['states'] && json['states'] != '') {
        for (i = 0; i < json['states'].length; i++) {
          state = json['states'][i];

          html += '<option value="' + state['state_id'] + '"';
          
          if (state['state_id'] == '<?php echo $state_id; ?>') {
            html += ' selected="selected"';
          }
          
          html += '>' + state['name'] + '</option>';
        }
      } else {
        html += '<option value="0" selected="selected"><?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?></option>';
      }
      
      $('select[name=\'state_id\']').html(html);
      $('select[name=\'state_id\']').trigger('change');
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

$('select[name=\'country_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'state_id\']').on('change', function() {
  setTimeout(function(){
    var state_id = $('select[name=\'state_id\']').val();
    $.ajax({
      url: '<?php echo base_url('/localisation/get_state'); ?>',
      type: 'post',
      dataType: 'json',
      data : {
        state_id : state_id
      },
      beforeSend: function() {
        $('select[name=\'state_id\']').prop('disabled', true);
        $('select[name=\'city_id\']').prop('disabled', true);
      },
      complete: function() {
        $('select[name=\'state_id\']').prop('disabled', false);
        $('select[name=\'city_id\']').prop('disabled', false);
      },
      success: function(json) {
        html = '<option value=""><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>';
        
        if (json['cities'] && json['cities'] != '') {
          for (i = 0; i < json['cities'].length; i++) {
            city = json['cities'][i];

            html += '<option value="' + city['city_id'] + '"';
            
            if (city['city_id'] == '<?php echo $city_id; ?>') {
              html += ' selected="selected"';
            }
            
            html += '>' + city['name'] + '</option>';
          }
        } else {
          html += '<option value="0" selected="selected"><?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?></option>';
        }
        
        $('select[name=\'city_id\']').html(html);
        $('select[name=\'city_id\']').trigger('change');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }, 200);
});

$('select[name=\'state_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'city_id\']').on('change', function() {
  setTimeout(function(){
    var city_id = $('select[name=\'city_id\']').val();
    $.ajax({
      url: '<?php echo base_url('/localisation/get_city'); ?>',
      type: 'post',
      dataType: 'json',
      data : {
        city_id : city_id
      },
      beforeSend: function() {
        $('select[name=\'city_id\']').prop('disabled', true);
        $('select[name=\'district_id\']').prop('disabled', true);
      },
      complete: function() {
        $('select[name=\'city_id\']').prop('disabled', false);
        $('select[name=\'district_id\']').prop('disabled', false);
      },
      success: function(json) {
        html = '<option value=""><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>';
        
        if (json['districts'] && json['districts'] != '') {
          for (i = 0; i < json['districts'].length; i++) {
            district = json['districts'][i];

            html += '<option value="' + district['district_id'] + '"';
            
            if (district['district_id'] == '<?php echo $district_id; ?>') {
              html += ' selected="selected"';
            }
            
            html += '>' + district['name'] + '</option>';
          }
        } else {
          html += '<option value="0" selected="selected"><?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?></option>';
        }
        
        $('select[name=\'district_id\']').html(html);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }, 400);
});

$('select[name=\'city_id\']').trigger('change');
//--></script> 
<?php echo $footer; ?>
