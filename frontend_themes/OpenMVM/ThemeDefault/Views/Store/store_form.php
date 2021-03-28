<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo lang('Heading.heading_my_store', array(), $lang->getFrontEndLocale()); ?></h1>
  <?php echo form_open($action); ?>
  <div class="clearfix mb-3">
    <div class="float-end">
      <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_save', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-save"></i></button>
      <a href="<?php echo base_url('/account/' . $user_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
    </div>
  </div>
	<div class="accordion" id="accordionStoreForm">
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="headingStoreForm">
	      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStoreForm" aria-expanded="true" aria-controls="collapseStoreForm">
	        <i class="fas fa-store fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_my_store', array(), $lang->getFrontEndLocale()); ?>
	      </button>
	    </h2>
	    <div id="collapseStoreForm" class="accordion-collapse collapse show" aria-labelledby="headingStoreForm" data-bs-parent="#accordionStoreForm">
	      <div class="accordion-body">

	        <div>
						<ul class="nav nav-tabs mb-3" id="storeTab" role="tablist">
						  <li class="nav-item" role="presentation">
						    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.tab_general', array(), $lang->getFrontEndLocale()); ?></button>
						  </li>
						  <li class="nav-item" role="presentation">
						    <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab" aria-controls="images" aria-selected="false"><?php echo lang('Tab.tab_images', array(), $lang->getFrontEndLocale()); ?></button>
						  </li>
						  <li class="nav-item" role="presentation">
						    <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false"><?php echo lang('Tab.tab_shipping', array(), $lang->getFrontEndLocale()); ?></button>
						  </li>
						</ul>
						<div class="tab-content" id="storeTabContent">
						  <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
			          <fieldset>
								  <h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_general', array(), $lang->getFrontEndLocale()); ?></h5>
							  	<div class="form-floating mb-3">
									  <input type="text" name="name" value="<?php echo $name; ?>" class="form-control<?php if ($validation->hasError('name')) { ?> is-invalid<?php } ?>" id="input-name" placeholder="<?php echo lang('Entry.entry_name', array(), $lang->getFrontEndLocale()); ?>">
									  <label for="input-name"><?php echo lang('Entry.entry_name', array(), $lang->getFrontEndLocale()); ?></label>
									  <?php if ($validation->hasError('name')) { ?>
		                <div class="text-danger small"><?php echo $validation->getError('name'); ?></div>
		              	<?php } ?>
									</div>
								  <h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_description', array(), $lang->getFrontEndLocale()); ?></h5>
									<ul class="nav nav-tabs mb-3" id="languageTab" role="tablist">
										<?php foreach ($languages as $language) { ?>
									  <li class="nav-item" role="presentation">
									    <button class="nav-link" id="language-<?php echo $language['language_id']; ?>-tab" data-bs-toggle="tab" data-bs-target="#language-<?php echo $language['language_id']; ?>" type="button" role="tab" aria-controls="language-<?php echo $language['language_id']; ?>" aria-selected="false"><?php echo $language['name']; ?></button>
									  </li>
										<?php } ?>
									</ul>
									<div class="tab-content" id="languageTabContent">
										<?php foreach ($languages as $language) { ?>
									  <div class="tab-pane fade" id="language-<?php echo $language['language_id']; ?>" role="tabpanel" aria-labelledby="language-<?php echo $language['language_id']; ?>-tab">
									  	<div class="form-floating mb-3">
											  <textarea name="description[<?php echo $language['language_id']; ?>][description]" class="form-control tinymce<?php if ($validation->hasError('description.' . $language['language_id'] . '.description')) { ?> is-invalid<?php } ?>" id="input-description-<?php echo $language['language_id']; ?>-description" placeholder="<?php echo lang('Entry.entry_description', array(), $lang->getBackEndLocale()); ?>"><?php echo $description[$language['language_id']]['description']; ?></textarea>
											  <label for="input-description-<?php echo $language['language_id']; ?>-description"><?php echo lang('Entry.entry_description', array(), $lang->getBackEndLocale()); ?></label>
											  <?php if ($validation->hasError('description.' . $language['language_id'] . '.description')) { ?>
				                <div class="text-danger small"><?php echo $validation->getError('description.' . $language['language_id'] . '.description'); ?></div>
				              	<?php } ?>
											</div>
									  	<div class="form-floating mb-3">
											  <textarea style="height: 200px;" name="description[<?php echo $language['language_id']; ?>][short_description]" class="form-control<?php if ($validation->hasError('description.' . $language['language_id'] . '.short_description')) { ?> is-invalid<?php } ?>" id="input-description-<?php echo $language['language_id']; ?>-short-description" placeholder="<?php echo lang('Entry.entry_short_description', array(), $lang->getBackEndLocale()); ?>"><?php echo $description[$language['language_id']]['short_description']; ?></textarea>
											  <label for="input-description-<?php echo $language['language_id']; ?>-short-description"><?php echo lang('Entry.entry_short_description', array(), $lang->getBackEndLocale()); ?></label>
											  <?php if ($validation->hasError('description.' . $language['language_id'] . '.short_description')) { ?>
				                <div class="text-danger small"><?php echo $validation->getError('description.' . $language['language_id'] . '.short_description'); ?></div>
				              	<?php } ?>
											</div>
									  	<div class="form-floating mb-3">
											  <input type="text" name="description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo $description[$language['language_id']]['meta_title']; ?>" class="form-control" id="input-description-<?php echo $language['language_id']; ?>-meta-title" placeholder="<?php echo lang('Entry.entry_meta_title', array(), $lang->getFrontEndLocale()); ?>">
											  <label for="input-description-<?php echo $language['language_id']; ?>-meta-title"><?php echo lang('Entry.entry_meta_title', array(), $lang->getFrontEndLocale()); ?></label>
											</div>
									  	<div class="form-floating mb-3">
											  <textarea style="height: 200px;" name="description[<?php echo $language['language_id']; ?>][meta_description]" class="form-control" id="input-description-<?php echo $language['language_id']; ?>-meta-description" placeholder="<?php echo lang('Entry.entry_meta_description', array(), $lang->getBackEndLocale()); ?>"><?php echo $description[$language['language_id']]['meta_description']; ?></textarea>
											  <label for="input-description-<?php echo $language['language_id']; ?>-meta-description"><?php echo lang('Entry.entry_meta_description', array(), $lang->getBackEndLocale()); ?></label>
											</div>
									  	<div class="form-floating mb-3">
											  <input type="text" name="description[<?php echo $language['language_id']; ?>][meta_keywords]" value="<?php echo $description[$language['language_id']]['meta_keywords']; ?>" class="form-control" id="input-description-<?php echo $language['language_id']; ?>-meta-keywords" placeholder="<?php echo lang('Entry.entry_meta_keywords', array(), $lang->getFrontEndLocale()); ?>">
											  <label for="input-description-<?php echo $language['language_id']; ?>-meta-keywords"><?php echo lang('Entry.entry_meta_keywords', array(), $lang->getFrontEndLocale()); ?></label>
											</div>
									  	<div class="form-floating mb-3">
											  <input type="text" name="description[<?php echo $language['language_id']; ?>][tags]" value="<?php echo $description[$language['language_id']]['tags']; ?>" class="form-control" id="input-description-<?php echo $language['language_id']; ?>-tags" placeholder="<?php echo lang('Entry.entry_tags', array(), $lang->getFrontEndLocale()); ?>">
											  <label for="input-description-<?php echo $language['language_id']; ?>-tags"><?php echo lang('Entry.entry_tags', array(), $lang->getFrontEndLocale()); ?></label>
											</div>
									  </div>
										<?php } ?>
									</div>
			          </fieldset>
						  </div>
						  <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
			          </fieldset>
			            <div class="form-group mb-3">
										<h5><?php echo lang('Entry.entry_logo', array(), $lang->getBackEndLocale()); ?></h5>
		                <div class="image-container">
		                  <div id="input-logo-href" class="image-thumb clickable d-flex" data-toggle="replace-image" data-target="input-logo" data-replace="<?php echo $placeholder; ?>" data-locale="<?php echo $lang->getBackEndLocale(); ?>"><img src="<?php echo $thumb_logo; ?>" class="img-fluid mx-auto my-auto" /></div>
		                  <input type="hidden" name="logo" value="<?php echo $logo; ?>" id="input-logo" class="form-control">
		                  <div class="d-grid gap-2 mt-2">
		                  	<span class="btn btn-danger" data-toggle="delete-image" data-target="input-logo" data-replace="<?php echo $placeholder; ?>"><i class="fas fa-trash-alt"></i></span>
		                	</div>
		                </div>
			            </div>
			            <div class="form-group mb-3">
										<h5><?php echo lang('Entry.entry_wallpaper', array(), $lang->getBackEndLocale()); ?></h5>
		                <div class="image-container">
		                  <div id="input-wallpaper-href" class="image-thumb clickable d-flex" data-toggle="replace-image" data-target="input-wallpaper" data-replace="<?php echo $placeholder; ?>" data-locale="<?php echo $lang->getBackEndLocale(); ?>"><img src="<?php echo $thumb_wallpaper; ?>" class="img-fluid mx-auto my-auto" /></div>
		                  <input type="hidden" name="wallpaper" value="<?php echo $wallpaper; ?>" id="input-wallpaper" class="form-control">
		                  <div class="d-grid gap-2 mt-2">
		                  	<span class="btn btn-danger" data-toggle="delete-image" data-target="input-wallpaper" data-replace="<?php echo $placeholder; ?>"><i class="fas fa-trash-alt"></i></span>
		                	</div>
		                </div>
			            </div>
			          </fieldset>
						  </div>
						  <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
			          <fieldset>
									<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_shipping_origin', array(), $lang->getBackEndLocale()); ?></h5>
									<div class="form-floating mb-3">
									  <select name="shipping_origin_country_id" class="form-select" id="input-shipping-origin-country-id" aria-label="input-shipping-origin-country-id">
		                  <?php foreach ($countries as $country) { ?>
		                    <?php if ($country['country_id'] == $shipping_origin_country_id) { ?>
		                      <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
		                    <?php } else { ?>
		                      <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
		                    <?php } ?>
		                  <?php } ?>
									  </select>
									  <label for="input-shipping-origin-country-id"><?php echo lang('Entry.entry_country', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_origin_state_id" class="form-select" id="input-shipping-origin-state-id" aria-label="input-shipping-origin-state-id">
									  </select>
									  <label for="input-shipping-origin-state-id"><?php echo lang('Entry.entry_state', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_origin_city_id" class="form-select" id="input-shipping-origin-city-id" aria-label="input-shipping-origin-city-id">
									  </select>
									  <label for="input-shipping-origin-city-id"><?php echo lang('Entry.entry_city', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_origin_district_id" class="form-select" id="input-shipping-origin-district-id" aria-label="input-shipping-origin-district-id">
									  </select>
									  <label for="input-shipping-origin-district-id"><?php echo lang('Entry.entry_district', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
			          </fieldset>
						  </div>
						</div>
	        </div>

	      </div>
	    </div>
	  </div>
	</div>
  <?php echo form_close(); ?>
</section>
<!-- /.content -->
<script type="text/javascript"><!--
$('select[name=\'shipping_origin_country_id\']').on('change', function() {
  $.ajax({
    url: '<?php echo base_url('/localisation/get_country'); ?>',
    type: 'post',
    dataType: 'json',
    data : {
      country_id : $('select[name=\'shipping_origin_country_id\']').val()
    },
    beforeSend: function() {
      $('select[name=\'shipping_origin_country_id\']').prop('disabled', true);
    },
    complete: function() {
      $('select[name=\'shipping_origin_country_id\']').prop('disabled', false);
    },
    success: function(json) {
      html = '<option value=""><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>';
      
      if (json['states'] && json['states'] != '') {
        for (i = 0; i < json['states'].length; i++) {
          state = json['states'][i];

          html += '<option value="' + state['state_id'] + '"';
          
          if (state['state_id'] == '<?php echo $shipping_origin_state_id; ?>') {
            html += ' selected="selected"';
          }
          
          html += '>' + state['name'] + '</option>';
        }
      } else {
        html += '<option value="0" selected="selected"><?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?></option>';
      }
      
      $('select[name=\'shipping_origin_state_id\']').html(html);
      $('select[name=\'shipping_origin_state_id\']').trigger('change');
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

$('select[name=\'shipping_origin_country_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'shipping_origin_state_id\']').on('change', function() {
  setTimeout(function(){
    var state_id = $('select[name=\'shipping_origin_state_id\']').val();
    $.ajax({
      url: '<?php echo base_url('/localisation/get_state'); ?>',
      type: 'post',
      dataType: 'json',
      data : {
        state_id : state_id
      },
      beforeSend: function() {
        $('select[name=\'shipping_origin_state_id\']').prop('disabled', true);
        $('select[name=\'shipping_origin_city_id\']').prop('disabled', true);
      },
      complete: function() {
        $('select[name=\'shipping_origin_state_id\']').prop('disabled', false);
        $('select[name=\'shipping_origin_city_id\']').prop('disabled', false);
      },
      success: function(json) {
        html = '<option value=""><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>';
        
        if (json['cities'] && json['cities'] != '') {
          for (i = 0; i < json['cities'].length; i++) {
            city = json['cities'][i];

            html += '<option value="' + city['city_id'] + '"';
            
            if (city['city_id'] == '<?php echo $shipping_origin_city_id; ?>') {
              html += ' selected="selected"';
            }
            
            html += '>' + city['name'] + '</option>';
          }
        } else {
          html += '<option value="0" selected="selected"><?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?></option>';
        }
        
        $('select[name=\'shipping_origin_city_id\']').html(html);
        $('select[name=\'shipping_origin_city_id\']').trigger('change');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }, 200);
});

$('select[name=\'shipping_origin_state_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'shipping_origin_city_id\']').on('change', function() {
  setTimeout(function(){
    var city_id = $('select[name=\'shipping_origin_city_id\']').val();
    $.ajax({
      url: '<?php echo base_url('/localisation/get_city'); ?>',
      type: 'post',
      dataType: 'json',
      data : {
        city_id : city_id
      },
      beforeSend: function() {
        $('select[name=\'shipping_origin_city_id\']').prop('disabled', true);
        $('select[name=\'shipping_origin_district_id\']').prop('disabled', true);
      },
      complete: function() {
        $('select[name=\'shipping_origin_city_id\']').prop('disabled', false);
        $('select[name=\'shipping_origin_district_id\']').prop('disabled', false);
      },
      success: function(json) {
        html = '<option value=""><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>';
        
        if (json['districts'] && json['districts'] != '') {
          for (i = 0; i < json['districts'].length; i++) {
            district = json['districts'][i];

            html += '<option value="' + district['district_id'] + '"';
            
            if (district['district_id'] == '<?php echo $shipping_origin_district_id; ?>') {
              html += ' selected="selected"';
            }
            
            html += '>' + district['name'] + '</option>';
          }
        } else {
          html += '<option value="0" selected="selected"><?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?></option>';
        }
        
        $('select[name=\'shipping_origin_district_id\']').html(html);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }, 400);
});

$('select[name=\'shipping_origin_city_id\']').trigger('change');
//--></script> 
<?php echo $footer; ?>
