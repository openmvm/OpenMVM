<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-shipping-fast fa-fw"></i> <?php echo $heading_title; ?></h2>
		<div class="heading-lead lead text-white"><?php echo $lead; ?></div>
	</section>
  <!-- /.heading-container -->

	<!-- Breadcrumb -->
	<?php if ($breadcrumbs) { ?>
	<section id="breadcrumb" class="bg-light p-3 mb-3">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb small p-0 m-0">
		  	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		  		<?php if ($breadcrumb['active']) { ?>
		    	<li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
	  			<?php } else { ?>
		    	<li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
	  			<?php } ?>
		  	<?php } ?>
		  </ol>
		</nav>
  </section>
	<?php } ?>
	<!-- /.breadcrumb -->

	<!-- Notification -->
	<?php if ($success || $error) { ?>
	<section id="notification" class="notification px-3">
		<?php if ($success) { ?>
		<div class="alert alert-success alert-dismissible" role="alert">
		  <?php echo $success; ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<?php } ?>
		<?php if ($error) { ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <?php echo $error; ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<?php } ?>
  </section>
	<?php } ?>
	<!-- /.notification -->

	<!-- Content -->
	<section class="content px-3">
    <?php echo form_open($action); ?>
    <div class="clearfix mb-3">
	    <div class="float-end">
	      <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_save', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-save"></i></button>
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/shipping_methods/' . $administrator_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
	    </div>
    </div>
		<div class="accordion" id="accordionAdministratorGroup">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingAdministratorGroup">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdministratorGroup" aria-expanded="true" aria-controls="collapseAdministratorGroup">
		        <i class="fas fa-shipping-fast fa-fw"></i>&nbsp;&nbsp;<?php echo $heading_title; ?>
		      </button>
		    </h2>
		    <div id="collapseAdministratorGroup" class="accordion-collapse collapse show" aria-labelledby="headingAdministratorGroup" data-bs-parent="#accordionAdministratorGroup">
		      <div class="accordion-body">

		        <ul class="nav nav-tabs" id="countryTab" role="tablist">
		          <li class="nav-item">
		            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.tab_general', array(), $lang->getBackEndLocale()); ?></a>
		          </li>
		        </ul>
		        <div class="tab-content mt-3" id="countryTabContent">
		          <div class="tab-pane show active" id="general" role="tabpanel" aria-labelledby="general-tab">
		            <fieldset>
						  		<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_mode', array(), $lang->getBackEndLocale()); ?></h5>
									<div class="form-floating mb-3">
									  <select name="shipping_fedex_mode" class="form-select" id="input-mode" aria-label="mode">
		                  <?php if ($shipping_fedex_mode == 'production') { ?>
		                    <option value="production" selected><?php echo lang('Text.text_production', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="test"><?php echo lang('Text.text_test', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="production"><?php echo lang('Text.text_production', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="test" selected><?php echo lang('Text.text_test', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-mode"><?php echo lang('Entry.entry_mode', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="shipping_fedex_url_test" value="<?php echo $shipping_fedex_url_test; ?>" class="form-control" id="input-url-test" placeholder="<?php echo lang('Entry.entry_url_test', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-url-test"><?php echo lang('Entry.entry_url_test', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="shipping_fedex_url_production" value="<?php echo $shipping_fedex_url_production; ?>" class="form-control" id="input-url-production" placeholder="<?php echo lang('Entry.entry_url_production', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-url-production"><?php echo lang('Entry.entry_url_production', array(), $lang->getBackEndLocale()); ?></label>
									</div>
						  		<h5 class="border-bottom border-dark pb-2 mt-5 mb-3"><?php echo lang('Text.text_credentials', array(), $lang->getBackEndLocale()); ?></h5>
							  	<div class="form-floating mb-3">
									  <input type="text" name="shipping_fedex_key" value="<?php echo $shipping_fedex_key; ?>" class="form-control" id="input-key" placeholder="<?php echo lang('Entry.entry_key', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-key"><?php echo lang('Entry.entry_key', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="password" name="shipping_fedex_password" value="<?php echo $shipping_fedex_password; ?>" class="form-control" id="input-password" placeholder="<?php echo lang('Entry.entry_password', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-password"><?php echo lang('Entry.entry_password', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="shipping_fedex_account_number" value="<?php echo $shipping_fedex_account_number; ?>" class="form-control" id="input-account-number" placeholder="<?php echo lang('Entry.entry_account_number', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-account-number"><?php echo lang('Entry.entry_account_number', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="shipping_fedex_meter_number" value="<?php echo $shipping_fedex_meter_number; ?>" class="form-control" id="input-meter-number" placeholder="<?php echo lang('Entry.entry_meter_number', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-meter-number"><?php echo lang('Entry.entry_meter_number', array(), $lang->getBackEndLocale()); ?></label>
									</div>
						  		<h5 class="border-bottom border-dark pb-2 mt-5 mb-3"><?php echo lang('Text.text_data', array(), $lang->getBackEndLocale()); ?></h5>
		              <div class="form-group mb-3">
	                  <div class="card bg-light" style="height: 250px; overflow: auto;">
	                    <div class="card-body">
	                    	<h5 class="card-title"><?php echo lang('Entry.entry_service', array(), $lang->getBackEndLocale()); ?></h5>
	                      <?php foreach ($services as $service) { ?>
	                      <div class="checkbox">
	                        <label>
	                          <?php if (in_array($service['value'], $shipping_fedex_service)) { ?>
	                          <input type="checkbox" name="shipping_fedex_service[]" value="<?php echo $service['value']; ?>" checked="checked" />
	                          <?php echo $service['text']; ?>
	                          <?php } else { ?>
	                          <input type="checkbox" name="shipping_fedex_service[]" value="<?php echo $service['value']; ?>" />
	                          <?php echo $service['text']; ?>
	                          <?php } ?>
	                        </label>
	                      </div>
	                      <?php } ?>
	                    </div>
	                  </div>
	                  <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="clickable"><?php echo lang('Text.text_select_all', array(), $lang->getBackEndLocale()); ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="clickable"><?php echo lang('Text.text_unselect_all', array(), $lang->getBackEndLocale()); ?></a>
		              </div>
									<div class="form-floating mb-3">
									  <select name="shipping_fedex_dropoff_type" class="form-select" id="input-dropoff-type" aria-label="dropoff-type">
									  	<?php foreach ($dropoff_types as $dropoff_type) { ?>
			                  <?php if ($dropoff_type['value'] == $shipping_fedex_geo_zone_id) { ?>
			                    <option value="<?php echo $dropoff_type['value']; ?>" selected><?php echo $dropoff_type['text']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $dropoff_type['value']; ?>"><?php echo $dropoff_type['text']; ?></option>
			                  <?php } ?>
									  	<?php } ?>
									  </select>
									  <label for="input-dropoff-type"><?php echo lang('Entry.entry_dropoff_type', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_fedex_packaging_type" class="form-select" id="input-packaging-type" aria-label="packaging-type">
									  	<?php foreach ($packaging_types as $packaging_type) { ?>
			                  <?php if ($packaging_type['value'] == $shipping_fedex_geo_zone_id) { ?>
			                    <option value="<?php echo $packaging_type['value']; ?>" selected><?php echo $packaging_type['text']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $packaging_type['value']; ?>"><?php echo $packaging_type['text']; ?></option>
			                  <?php } ?>
									  	<?php } ?>
									  </select>
									  <label for="input-packaging-type"><?php echo lang('Entry.entry_packaging_type', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_fedex_rate_type" class="form-select" id="input-rate-type" aria-label="rate-type">
									  	<?php foreach ($rate_types as $rate_type) { ?>
			                  <?php if ($rate_type['value'] == $shipping_fedex_geo_zone_id) { ?>
			                    <option value="<?php echo $rate_type['value']; ?>" selected><?php echo $rate_type['text']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $rate_type['value']; ?>"><?php echo $rate_type['text']; ?></option>
			                  <?php } ?>
									  	<?php } ?>
									  </select>
									  <label for="input-rate-type"><?php echo lang('Entry.entry_rate_type', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_fedex_display_delivery_time" class="form-select" id="input-display-delivery-time" aria-label="display_delivery_time">
		                  <?php if ($shipping_fedex_display_delivery_time) { ?>
		                    <option value="1" selected><?php echo lang('Text.text_yes', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0"><?php echo lang('Text.text_no', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="1"><?php echo lang('Text.text_yes', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0" selected><?php echo lang('Text.text_no', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-display-delivery-time"><?php echo lang('Entry.entry_display_delivery_time', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_fedex_display_delivery_weight" class="form-select" id="input-display-delivery-weight" aria-label="display_delivery_weight">
		                  <?php if ($shipping_fedex_display_delivery_weight) { ?>
		                    <option value="1" selected><?php echo lang('Text.text_yes', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0"><?php echo lang('Text.text_no', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="1"><?php echo lang('Text.text_yes', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0" selected><?php echo lang('Text.text_no', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-display-delivery-weight"><?php echo lang('Entry.entry_display_delivery_weight', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_fedex_weight_class_id" class="form-select" id="input-weight-class-id" aria-label="weight-class-id">
			                <?php foreach ($weight_classes as $weight_class) { ?>
			                  <?php if ($weight_class['weight_class_id'] == $shipping_fedex_weight_class_id) { ?>
			                    <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-weight-class-id"><?php echo lang('Entry.entry_weight_class', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_fedex_length_class_id" class="form-select" id="input-length-class-id" aria-label="length-class-id">
			                <?php foreach ($length_classes as $length_class) { ?>
			                  <?php if ($length_class['length_class_id'] == $shipping_fedex_length_class_id) { ?>
			                    <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-length-class-id"><?php echo lang('Entry.entry_length_class', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_fedex_origin_geo_zone_id" class="form-select" id="input-origin-geo-zone-id" aria-label="origin-geo-zone-id">
									  	<?php foreach ($geo_zones as $geo_zone) { ?>
			                  <?php if ($geo_zone['geo_zone_id'] == $shipping_fedex_origin_geo_zone_id) { ?>
			                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected><?php echo $geo_zone['name']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
			                  <?php } ?>
									  	<?php } ?>
									  </select>
									  <label for="input-origin-geo-zone"><?php echo lang('Entry.entry_origin_geo_zone', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_fedex_destination_geo_zone_id" class="form-select" id="input-destination-geo-zone-id" aria-label="destination-geo-zone-id">
									  	<?php foreach ($geo_zones as $geo_zone) { ?>
			                  <?php if ($geo_zone['geo_zone_id'] == $shipping_fedex_destination_geo_zone_id) { ?>
			                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected><?php echo $geo_zone['name']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
			                  <?php } ?>
									  	<?php } ?>
									  </select>
									  <label for="input-destination-geo-zone"><?php echo lang('Entry.entry_destination_geo_zone', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="number" name="shipping_fedex_sort_order" value="<?php echo $shipping_fedex_sort_order; ?>" class="form-control" id="input-sort-order" placeholder="<?php echo lang('Entry.entry_sort_order', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-sort-order"><?php echo lang('Entry.entry_sort_order', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_fedex_status" class="form-select" id="input-status" aria-label="status">
		                  <?php if ($shipping_fedex_status) { ?>
		                    <option value="1" selected><?php echo lang('Text.text_enabled', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0"><?php echo lang('Text.text_disabled', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="1"><?php echo lang('Text.text_enabled', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0" selected><?php echo lang('Text.text_disabled', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-status"><?php echo lang('Entry.entry_status', array(), $lang->getBackEndLocale()); ?></label>
									</div>
		            </fieldset>
		          </div>
		        </div>

		      </div>
		    </div>
		  </div>
		</div>
    <?php echo form_close(); ?>
	</section>
  <!-- /.content -->
<?php echo $footer; ?>
