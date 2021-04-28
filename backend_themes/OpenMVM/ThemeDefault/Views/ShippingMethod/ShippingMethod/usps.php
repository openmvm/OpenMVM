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
							  	<div class="form-floating mb-3">
									  <input type="text" name="shipping_usps_user_id" value="<?php echo $shipping_usps_user_id; ?>" class="form-control" id="input-user-id" placeholder="<?php echo lang('Entry.entry_user_id', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-user-id"><?php echo lang('Entry.entry_user_id', array(), $lang->getBackEndLocale()); ?></label>
									</div>
		              <div class="form-group mb-3">
	                  <div class="card bg-light" style="height: 250px; overflow: auto;">
	                    <div class="card-body">
	                    	<h5 class="card-title"><?php echo lang('Entry.entry_domestic_services', array(), $lang->getBackEndLocale()); ?></h5>
	                      <?php foreach ($domestic_services as $domestic_service) { ?>
	                      <div class="checkbox">
	                        <label>
	                          <?php if (${'shipping_usps_' . $domestic_service['value']}) { ?>
	                          <input type="checkbox" name="shipping_usps_<?php echo $domestic_service['value']; ?>" value="1" checked="checked" />
	                          <?php echo $domestic_service['text']; ?>
	                          <?php } else { ?>
	                          <input type="checkbox" name="shipping_usps_<?php echo $domestic_service['value']; ?>" value="1" />
	                          <?php echo $domestic_service['text']; ?>
	                          <?php } ?>
	                        </label>
	                      </div>
	                      <?php } ?>
	                    </div>
	                  </div>
	                  <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="clickable"><?php echo lang('Text.text_select_all', array(), $lang->getBackEndLocale()); ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="clickable"><?php echo lang('Text.text_unselect_all', array(), $lang->getBackEndLocale()); ?></a>
		              </div>
		              <div class="form-group mb-3">
	                  <div class="card bg-light" style="height: 250px; overflow: auto;">
	                    <div class="card-body">
	                    	<h5 class="card-title"><?php echo lang('Entry.entry_international_services', array(), $lang->getBackEndLocale()); ?></h5>
	                      <?php foreach ($international_services as $international_service) { ?>
	                      <div class="checkbox">
	                        <label>
	                          <?php if (${'shipping_usps_' . $international_service['value']}) { ?>
	                          <input type="checkbox" name="shipping_usps_<?php echo $international_service['value']; ?>" value="1" checked="checked" />
	                          <?php echo $international_service['text']; ?>
	                          <?php } else { ?>
	                          <input type="checkbox" name="shipping_usps_<?php echo $international_service['value']; ?>" value="1" />
	                          <?php echo $international_service['text']; ?>
	                          <?php } ?>
	                        </label>
	                      </div>
	                      <?php } ?>
	                    </div>
	                  </div>
	                  <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="clickable"><?php echo lang('Text.text_select_all', array(), $lang->getBackEndLocale()); ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="clickable"><?php echo lang('Text.text_unselect_all', array(), $lang->getBackEndLocale()); ?></a>
		              </div>
									<div class="form-floating mb-3">
									  <select name="shipping_usps_display_delivery_time" class="form-select" id="input-display-delivery-time" aria-label="display_delivery_time">
		                  <?php if ($shipping_usps_display_delivery_time) { ?>
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
									  <select name="shipping_usps_display_delivery_weight" class="form-select" id="input-display-delivery-weight" aria-label="display_delivery_weight">
		                  <?php if ($shipping_usps_display_delivery_weight) { ?>
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
									  <select name="shipping_usps_weight_class_id" class="form-select" id="input-weight-class-id" aria-label="weight-class-id">
			                <?php foreach ($weight_classes as $weight_class) { ?>
			                  <?php if ($weight_class['weight_class_id'] == $shipping_usps_weight_class_id) { ?>
			                    <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-weight-class-id"><?php echo lang('Entry.entry_weight_class', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_usps_length_class_id" class="form-select" id="input-length-class-id" aria-label="length-class-id">
			                <?php foreach ($length_classes as $length_class) { ?>
			                  <?php if ($length_class['length_class_id'] == $shipping_usps_length_class_id) { ?>
			                    <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-length-class-id"><?php echo lang('Entry.entry_length_class', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_usps_origin_geo_zone_id" class="form-select" id="input-origin-geo-zone-id" aria-label="origin-geo-zone-id">
									  	<?php foreach ($geo_zones as $geo_zone) { ?>
			                  <?php if ($geo_zone['geo_zone_id'] == $shipping_usps_origin_geo_zone_id) { ?>
			                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected><?php echo $geo_zone['name']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
			                  <?php } ?>
									  	<?php } ?>
									  </select>
									  <label for="input-origin-geo-zone"><?php echo lang('Entry.entry_origin_geo_zone', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_usps_destination_geo_zone_id" class="form-select" id="input-destination-geo-zone-id" aria-label="destination-geo-zone-id">
									  	<?php foreach ($geo_zones as $geo_zone) { ?>
			                  <?php if ($geo_zone['geo_zone_id'] == $shipping_usps_destination_geo_zone_id) { ?>
			                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected><?php echo $geo_zone['name']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
			                  <?php } ?>
									  	<?php } ?>
									  </select>
									  <label for="input-destination-geo-zone"><?php echo lang('Entry.entry_destination_geo_zone', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="number" name="shipping_usps_sort_order" value="<?php echo $shipping_usps_sort_order; ?>" class="form-control" id="input-sort-order" placeholder="<?php echo lang('Entry.entry_sort_order', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-sort-order"><?php echo lang('Entry.entry_sort_order', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_usps_status" class="form-select" id="input-status" aria-label="status">
		                  <?php if ($shipping_usps_status) { ?>
		                    <option value="1" selected><?php echo lang('Text.text_enabled', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0"><?php echo lang('Text.text_disabled', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="1"><?php echo lang('Text.text_enabled', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0" selected><?php echo lang('Text.text_disabled', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-status"><?php echo lang('Entry.entry_status', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="shipping_usps_debug" class="form-select" id="input-debug" aria-label="debug">
		                  <?php if ($shipping_usps_debug) { ?>
		                    <option value="1" selected><?php echo lang('Text.text_enabled', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0"><?php echo lang('Text.text_disabled', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="1"><?php echo lang('Text.text_enabled', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0" selected><?php echo lang('Text.text_disabled', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-debug"><?php echo lang('Entry.entry_debug', array(), $lang->getBackEndLocale()); ?></label>
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
