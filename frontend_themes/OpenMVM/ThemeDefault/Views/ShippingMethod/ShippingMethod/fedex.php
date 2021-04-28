<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo lang('Heading.heading_fedex', array(), $lang->getFrontEndLocale()); ?></h1>
  <?php echo form_open($action); ?>
  <div class="clearfix mb-3">
    <div class="float-end">
	    <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_save', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-save"></i></button>
      <a href="<?php echo base_url('/account/store/shipping_methods/' . $user_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
    </div>
  </div>
	<div class="accordion" id="accordionStoreForm">
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="headingStoreForm">
	      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStoreForm" aria-expanded="true" aria-controls="collapseStoreForm">
	        <i class="fas fa-shipping-fast fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_fedex', array(), $lang->getFrontEndLocale()); ?>
	      </button>
	    </h2>
	    <div id="collapseStoreForm" class="accordion-collapse collapse show" aria-labelledby="headingStoreForm" data-bs-parent="#accordionStoreForm">
	      <div class="accordion-body">
	      	<div>
			      <fieldset>
					  	<div class="form-floating mb-3">
							  <input type="text" name="vendor_<?php echo $vendor_id; ?>_shipping_fedex_account_number" value="<?php echo ${'vendor_' . $vendor_id . '_shipping_fedex_account_number'}; ?>" class="form-control<?php if ($validation->hasError('vendor_' . $vendor_id . '_shipping_fedex_account_number')) { ?> is-invalid<?php } ?>" id="input-account-number" placeholder="<?php echo lang('Entry.entry_account_number', array(), $lang->getFrontEndLocale()); ?>">
							  <label for="input-account-number"><?php echo lang('Entry.entry_account_number', array(), $lang->getFrontEndLocale()); ?></label>
							  <?php if ($validation->hasError('vendor_' . $vendor_id . '_shipping_fedex_account_number')) { ?>
                <div class="text-danger small"><?php echo $validation->getError('vendor_' . $vendor_id . '_shipping_fedex_account_number'); ?></div>
              	<?php } ?>
							</div>
							<div class="row">
								<div class="col-sm-3">
							  	<div class="form-floating mb-3">
									  <input type="text" name="vendor_<?php echo $vendor_id; ?>_shipping_fedex_package_dimension_length" value="<?php echo ${'vendor_' . $vendor_id . '_shipping_fedex_package_dimension_length'}; ?>" class="form-control" id="input-package-dimension-length" placeholder="<?php echo lang('Entry.entry_package_dimension_length', array(), $lang->getFrontEndLocale()); ?>">
									  <label for="input-package-dimension-length"><?php echo lang('Entry.entry_package_dimension_length', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
								</div>
								<div class="col-sm-3">
							  	<div class="form-floating mb-3">
									  <input type="text" name="vendor_<?php echo $vendor_id; ?>_shipping_fedex_package_dimension_width" value="<?php echo ${'vendor_' . $vendor_id . '_shipping_fedex_package_dimension_width'}; ?>" class="form-control" id="input-package-dimension-width" placeholder="<?php echo lang('Entry.entry_package_dimension_width', array(), $lang->getFrontEndLocale()); ?>">
									  <label for="input-package-dimension-width"><?php echo lang('Entry.entry_package_dimension_width', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
								</div>
								<div class="col-sm-3">
							  	<div class="form-floating mb-3">
									  <input type="text" name="vendor_<?php echo $vendor_id; ?>_shipping_fedex_package_dimension_height" value="<?php echo ${'vendor_' . $vendor_id . '_shipping_fedex_package_dimension_height'}; ?>" class="form-control" id="input-package-dimension-height" placeholder="<?php echo lang('Entry.entry_package_dimension_height', array(), $lang->getFrontEndLocale()); ?>">
									  <label for="input-package-dimension-height"><?php echo lang('Entry.entry_package_dimension_height', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-floating mb-3">
									  <select name="vendor_<?php echo $vendor_id; ?>_shipping_fedex_length_class_id" class="form-select" id="input-length-class-id" aria-label="length-class-id">
			                <?php foreach ($length_classes as $length_class) { ?>
			                  <?php if ($length_class['length_class_id'] == ${'vendor_' . $vendor_id . '_shipping_fedex_length_class_id'}) { ?>
			                    <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-length-class-id"><?php echo lang('Entry.entry_length_class', array(), $lang->getFrontEndLocale()); ?></label>
									</div>
								</div>
							</div>
							<div class="form-floating mb-3">
							  <select name="vendor_<?php echo $vendor_id; ?>_shipping_fedex_status" class="form-select" id="input-status" aria-label="status">
                  <?php if (${'vendor_' . $vendor_id . '_shipping_fedex_status'}) { ?>
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
	      </div>
	    </div>
	  </div>
	</div>
  <?php echo form_close(); ?>
</section>
<!-- /.content -->
<?php echo $footer; ?>
