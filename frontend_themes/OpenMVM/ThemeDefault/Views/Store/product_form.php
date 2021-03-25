<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo lang('Heading.heading_my_products', array(), $lang->getFrontEndLocale()); ?></h1>
  <?php echo form_open($action); ?>
  <div class="clearfix mb-3">
    <div class="float-end">
      <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_save', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-save"></i></button>
      <a href="<?php echo base_url('/account/store/products/' . $user_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
    </div>
  </div>
	<div class="accordion" id="accordionProductForm">
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="headingProductForm">
	      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProductForm" aria-expanded="true" aria-controls="collapseProductForm">
	        <i class="fas fa-boxes fa-fw"></i>&nbsp;&nbsp;<?php echo $heading_title; ?>
	      </button>
	    </h2>
	    <div id="collapseProductForm" class="accordion-collapse collapse show" aria-labelledby="headingProductForm" data-bs-parent="#accordionProductForm">
	      <div class="accordion-body">

	        <div>
						<ul class="nav nav-tabs mb-3" id="productTab" role="tablist">
						  <li class="nav-item" role="presentation">
						    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.tab_general', array(), $lang->getFrontEndLocale()); ?></button>
						  </li>
						  <li class="nav-item" role="presentation">
						    <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="false"><?php echo lang('Tab.tab_data', array(), $lang->getFrontEndLocale()); ?></button>
						  </li>
						  <li class="nav-item" role="presentation">
						    <button class="nav-link" id="links-tab" data-bs-toggle="tab" data-bs-target="#links" type="button" role="tab" aria-controls="links" aria-selected="false"><?php echo lang('Tab.tab_links', array(), $lang->getFrontEndLocale()); ?></button>
						  </li>
						  <li class="nav-item" role="presentation">
						    <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab" aria-controls="images" aria-selected="false"><?php echo lang('Tab.tab_images', array(), $lang->getFrontEndLocale()); ?></button>
						  </li>
						</ul>
						<div class="tab-content" id="productTabContent">
						  <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
			          <fieldset>
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
											  <input type="text" name="description[<?php echo $language['language_id']; ?>][name]" value="<?php echo $description[$language['language_id']]['name']; ?>" class="form-control<?php if ($validation->hasError('description.' . $language['language_id'] . '.name')) { ?> is-invalid<?php } ?>" id="input-description-<?php echo $language['language_id']; ?>-name" placeholder="<?php echo lang('Entry.entry_name', array(), $lang->getFrontEndLocale()); ?>">
											  <label for="input-description-<?php echo $language['language_id']; ?>-name"><?php echo lang('Entry.entry_name', array(), $lang->getFrontEndLocale()); ?></label>
											  <?php if ($validation->hasError('description.' . $language['language_id'] . '.name')) { ?>
				                <div class="text-danger small"><?php echo $validation->getError('description.' . $language['language_id'] . '.name'); ?></div>
				              	<?php } ?>
											</div>
									  	<div class="form-floating mb-3">
											  <textarea name="description[<?php echo $language['language_id']; ?>][description]" class="form-control tinymce<?php if ($validation->hasError('description.' . $language['language_id'] . '.description')) { ?> is-invalid<?php } ?>" id="input-description-<?php echo $language['language_id']; ?>-description" placeholder="<?php echo lang('Entry.entry_description', array(), $lang->getFrontEndLocale()); ?>"><?php echo $description[$language['language_id']]['description']; ?></textarea>
											  <label for="input-description-<?php echo $language['language_id']; ?>-description"><?php echo lang('Entry.entry_description', array(), $lang->getFrontEndLocale()); ?></label>
											  <?php if ($validation->hasError('description.' . $language['language_id'] . '.description')) { ?>
				                <div class="text-danger small"><?php echo $validation->getError('description.' . $language['language_id'] . '.description'); ?></div>
				              	<?php } ?>
											</div>
									  	<div class="form-floating mb-3">
											  <textarea style="height: 200px;" name="description[<?php echo $language['language_id']; ?>][short_description]" class="form-control<?php if ($validation->hasError('description.' . $language['language_id'] . '.short_description')) { ?> is-invalid<?php } ?>" id="input-description-<?php echo $language['language_id']; ?>-short-description" placeholder="<?php echo lang('Entry.entry_short_description', array(), $lang->getFrontEndLocale()); ?>"><?php echo $description[$language['language_id']]['short_description']; ?></textarea>
											  <label for="input-description-<?php echo $language['language_id']; ?>-short-description"><?php echo lang('Entry.entry_short_description', array(), $lang->getFrontEndLocale()); ?></label>
											  <?php if ($validation->hasError('description.' . $language['language_id'] . '.short_description')) { ?>
				                <div class="text-danger small"><?php echo $validation->getError('description.' . $language['language_id'] . '.short_description'); ?></div>
				              	<?php } ?>
											</div>
									  	<div class="form-floating mb-3">
											  <input type="text" name="description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo $description[$language['language_id']]['meta_title']; ?>" class="form-control" id="input-description-<?php echo $language['language_id']; ?>-meta-title" placeholder="<?php echo lang('Entry.entry_meta_title', array(), $lang->getFrontEndLocale()); ?>">
											  <label for="input-description-<?php echo $language['language_id']; ?>-meta-title"><?php echo lang('Entry.entry_meta_title', array(), $lang->getFrontEndLocale()); ?></label>
											</div>
									  	<div class="form-floating mb-3">
											  <textarea style="height: 200px;" name="description[<?php echo $language['language_id']; ?>][meta_description]" class="form-control" id="input-description-<?php echo $language['language_id']; ?>-meta-description" placeholder="<?php echo lang('Entry.entry_meta_description', array(), $lang->getFrontEndLocale()); ?>"><?php echo $description[$language['language_id']]['meta_description']; ?></textarea>
											  <label for="input-description-<?php echo $language['language_id']; ?>-meta-description"><?php echo lang('Entry.entry_meta_description', array(), $lang->getFrontEndLocale()); ?></label>
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
						  <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">
			          <fieldset>
							  	<div class="form-floating mb-3">
									  <input type="number" min="0" step="any" name="price" value="<?php echo $price; ?>" class="form-control" id="input-price" placeholder="<?php echo lang('Entry.entry_price', array(), $lang->getFrontEndLocale()); ?>">
									  <label for="input-price"><?php echo lang('Entry.entry_price', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="number" min="0" step="1" name="quantity" value="<?php echo $quantity; ?>" class="form-control" id="input-quantity" placeholder="<?php echo lang('Entry.entry_quantity', array(), $lang->getFrontEndLocale()); ?>">
									  <label for="input-quantity"><?php echo lang('Entry.entry_quantity', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping" class="form-select" id="input-shipping" aria-label="shipping">
		                  <?php if ($shipping) { ?>
		                    <option value="1" selected><?php echo lang('Text.text_yes', array(), $lang->getFrontEndLocale()); ?></option>
		                    <option value="0"><?php echo lang('Text.text_no', array(), $lang->getFrontEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="1"><?php echo lang('Text.text_yes', array(), $lang->getFrontEndLocale()); ?></option>
		                    <option value="0" selected><?php echo lang('Text.text_no', array(), $lang->getFrontEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-shipping"><?php echo lang('Entry.entry_requires_shipping', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="number" min="0" step="any" name="weight" value="<?php echo $weight; ?>" class="form-control" id="input-weight" placeholder="<?php echo lang('Entry.entry_weight', array(), $lang->getFrontEndLocale()); ?>">
									  <label for="input-price"><?php echo lang('Entry.entry_weight', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="weight_class_id" class="form-select" id="input-weight-class-id" aria-label="weight_class_id">
									  	<option value=""><?php echo lang('Text.text_select', array(), $lang->getFrontEndLocale()); ?></option>
									  	<?php foreach ($weight_classes as $weight_class) { ?>
			                  <?php if ($weight_class['weight_class_id'] == $weight_class_id) { ?>
			                    <option value="<?php echo $weight_class['weight_class_id']; ?>" selected><?php echo $weight_class['title']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
			                  <?php } ?>
									  	<?php } ?>
									  </select>
									  <label for="input-weight-class-id"><?php echo lang('Entry.entry_weight_class', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="number" min="0" step="any" name="length" value="<?php echo $length; ?>" class="form-control" id="input-length" placeholder="<?php echo lang('Entry.entry_length', array(), $lang->getFrontEndLocale()); ?>">
									  <label for="input-price"><?php echo lang('Entry.entry_length', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="number" min="0" step="any" name="width" value="<?php echo $width; ?>" class="form-control" id="input-width" placeholder="<?php echo lang('Entry.entry_width', array(), $lang->getFrontEndLocale()); ?>">
									  <label for="input-price"><?php echo lang('Entry.entry_width', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="number" min="0" step="any" name="height" value="<?php echo $height; ?>" class="form-control" id="input-height" placeholder="<?php echo lang('Entry.entry_height', array(), $lang->getFrontEndLocale()); ?>">
									  <label for="input-price"><?php echo lang('Entry.entry_height', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="length_class_id" class="form-select" id="input-length-class-id" aria-label="length_class_id">
									  	<option value=""><?php echo lang('Text.text_select', array(), $lang->getFrontEndLocale()); ?></option>
									  	<?php foreach ($length_classes as $length_class) { ?>
			                  <?php if ($length_class['length_class_id'] == $length_class_id) { ?>
			                    <option value="<?php echo $length_class['length_class_id']; ?>" selected><?php echo $length_class['title']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
			                  <?php } ?>
									  	<?php } ?>
									  </select>
									  <label for="input-length-class-id"><?php echo lang('Entry.entry_length_class', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="status" class="form-select" id="input-status" aria-label="status">
		                  <?php if ($status) { ?>
		                    <option value="1" selected><?php echo lang('Text.text_enabled', array(), $lang->getFrontEndLocale()); ?></option>
		                    <option value="0"><?php echo lang('Text.text_disabled', array(), $lang->getFrontEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="1"><?php echo lang('Text.text_enabled', array(), $lang->getFrontEndLocale()); ?></option>
		                    <option value="0" selected><?php echo lang('Text.text_disabled', array(), $lang->getFrontEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-status"><?php echo lang('Entry.entry_status', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
			          </fieldset>
						  </div>
						  <div class="tab-pane fade" id="links" role="tabpanel" aria-labelledby="links-tab">
			          <fieldset>
							  	<div class="form-floating mb-3">
									  <input type="text" name="category" value="" class="form-control" id="input-category" placeholder="<?php echo lang('Entry.entry_category', array(), $lang->getFrontEndLocale()); ?>">
									  <label for="input-category"><?php echo lang('Entry.entry_category', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
                  <div id="product-category" class="card bg-white p-2" style="height: 150px; overflow: auto;">
                    <?php foreach ($product_categories as $product_category) { ?>
                    <div id="product-category<?php echo $product_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_category['name']; ?>
                      <input type="hidden" name="product_category[]" value="<?php echo $product_category['category_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
			          </fieldset>
						  </div>
						  <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
			          <fieldset>
			            <div class="form-group mb-3">
										<h5><?php echo lang('Entry.entry_image', array(), $lang->getFrontEndLocale()); ?></h5>
		                <div class="image-container">
		                  <div id="input-image-href" class="image-thumb clickable d-flex" data-toggle="replace-image" data-target="input-image" data-replace="<?php echo $placeholder; ?>" data-locale="<?php echo $lang->getFrontEndLocale(); ?>"><img src="<?php echo $thumb_image; ?>" class="img-fluid mx-auto my-auto" /></div>
		                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" class="form-control">
		                  <div class="d-grid gap-2 mt-2">
		                  	<span class="btn btn-danger" data-toggle="delete-image" data-target="input-image" data-replace="<?php echo $placeholder; ?>"><i class="fas fa-trash-alt"></i></span>
		                	</div>
		                </div>
			            </div>
			            <div class="form-group mb-3">
										<h5><?php echo lang('Entry.entry_wallpaper', array(), $lang->getFrontEndLocale()); ?></h5>
		                <div class="image-container">
		                  <div id="input-wallpaper-href" class="image-thumb clickable d-flex" data-toggle="replace-image" data-target="input-wallpaper" data-replace="<?php echo $placeholder; ?>" data-locale="<?php echo $lang->getFrontEndLocale(); ?>"><img src="<?php echo $thumb_wallpaper; ?>" class="img-fluid mx-auto my-auto" /></div>
		                  <input type="hidden" name="wallpaper" value="<?php echo $wallpaper; ?>" id="input-wallpaper" class="form-control">
		                  <div class="d-grid gap-2 mt-2">
		                  	<span class="btn btn-danger" data-toggle="delete-image" data-target="input-wallpaper" data-replace="<?php echo $placeholder; ?>"><i class="fas fa-trash-alt"></i></span>
		                	</div>
		                </div>
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
// Category
$('input[name=\'category\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: '<?php echo base_url('/category/autocomplete'); ?>',
      type: 'post',
      dataType: 'json',
      data : {
        filter_name : request
      },
      beforeSend: function() {
        //$('#combobox #input-combobox-' + prev_val).after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
      },
      complete: function() {
        //$('.fa-spin').remove();
      },
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  },
  'select': function(item) {
    $('input[name=\'category\']').val('');

    $('#product-category' + item['value']).remove();

    $('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_category[]" value="' + item['value'] + '" /></div>');
  }
});

$('#product-category').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});
--></script>
<?php echo $footer; ?>
