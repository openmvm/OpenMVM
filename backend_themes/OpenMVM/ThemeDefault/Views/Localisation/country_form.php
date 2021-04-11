<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-globe-americas fa-fw"></i> <?php echo $heading_title; ?></h2>
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
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/localisation/countries/' . $administrator_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
	    </div>
    </div>
		<div class="accordion" id="accordionAdministratorGroup">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingAdministratorGroup">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdministratorGroup" aria-expanded="true" aria-controls="collapseAdministratorGroup">
		        <i class="fas fa-globe-americas fa-fw"></i>&nbsp;&nbsp;<?php echo $heading_title; ?>
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
									  <input type="text" name="name" value="<?php echo $name; ?>" class="form-control<?php if ($validation->hasError('name')) { ?> is-invalid<?php } ?>" id="input-name" placeholder="<?php echo lang('Entry.entry_name', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-name"><?php echo lang('Entry.entry_name', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('name')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('name'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="iso_code_2" value="<?php echo $iso_code_2; ?>" class="form-control<?php if ($validation->hasError('iso_code_2')) { ?> is-invalid<?php } ?>" id="input-iso-code-2" placeholder="<?php echo lang('Entry.entry_iso_code_2', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-iso-code-2"><?php echo lang('Entry.entry_iso_code_2', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('iso_code_2')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('iso_code_2'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="iso_code_3" value="<?php echo $iso_code_3; ?>" class="form-control<?php if ($validation->hasError('iso_code_3')) { ?> is-invalid<?php } ?>" id="input-iso-code-3" placeholder="<?php echo lang('Entry.entry_iso_code_3', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-iso-code-3"><?php echo lang('Entry.entry_iso_code_3', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('iso_code_3')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('iso_code_3'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="iso_code_numeric" value="<?php echo $iso_code_numeric; ?>" class="form-control<?php if ($validation->hasError('iso_code_numeric')) { ?> is-invalid<?php } ?>" id="input-iso-code-numeric" placeholder="<?php echo lang('Entry.entry_iso_code_numeric', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-iso-code-numeric"><?php echo lang('Entry.entry_iso_code_numeric', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('iso_code_numeric')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('iso_code_numeric'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="code_dial_in" value="<?php echo $code_dial_in; ?>" class="form-control<?php if ($validation->hasError('code_dial_in')) { ?> is-invalid<?php } ?>" id="input-code-dial-in" placeholder="<?php echo lang('Entry.entry_code_dial_in', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-code-dial-in"><?php echo lang('Entry.entry_code_dial_in', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('code_dial_in')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('code_dial_in'); ?></div>
	                	<?php } ?>
									</div>
									<div class="form-floating mb-3">
									  <select name="state_input_type" class="form-select" id="input-state-input-type" aria-label="state-input-type">
		                  <?php if ($state_input_type == 'select_box') { ?>
		                    <option value="select_box" selected><?php echo lang('Text.text_select_box', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="text_input"><?php echo lang('Text.text_text_input', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="select_box"><?php echo lang('Text.text_select_box', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="text_input" selected><?php echo lang('Text.text_text_input', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-state-input-type"><?php echo lang('Entry.entry_state_input_type', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="city_input_type" class="form-select" id="input-city-input-type" aria-label="city-input-type">
		                  <?php if ($city_input_type == 'select_box') { ?>
		                    <option value="select_box" selected><?php echo lang('Text.text_select_box', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="text_input"><?php echo lang('Text.text_text_input', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="select_box"><?php echo lang('Text.text_select_box', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="text_input" selected><?php echo lang('Text.text_text_input', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-city-input-type"><?php echo lang('Entry.entry_city_input_type', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="district_input_type" class="form-select" id="input-district-input-type" aria-label="district-input-type">
		                  <?php if ($district_input_type == 'select_box') { ?>
		                    <option value="select_box" selected><?php echo lang('Text.text_select_box', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="text_input"><?php echo lang('Text.text_text_input', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="select_box"><?php echo lang('Text.text_select_box', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="text_input" selected><?php echo lang('Text.text_text_input', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-district-input-type"><?php echo lang('Entry.entry_district_input_type', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="district_required" class="form-select" id="input-district-required" aria-label="district-required">
		                  <?php if ($district_required) { ?>
		                    <option value="1" selected><?php echo lang('Text.text_yes', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0"><?php echo lang('Text.text_no', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="1"><?php echo lang('Text.text_yes', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0" selected><?php echo lang('Text.text_no', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-district-required"><?php echo lang('Entry.entry_district_required', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <textarea style="height: 100px" name="address_format" class="form-control" id="input-address-format" placeholder="<?php echo lang('Entry.entry_address_format', array(), $lang->getBackEndLocale()); ?>"><?php echo $address_format; ?></textarea>
									  <label for="input-address-format"><?php echo lang('Entry.entry_address_format', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="number" name="sort_order" value="<?php echo $sort_order; ?>" class="form-control<?php if ($validation->hasError('sort_order')) { ?> is-invalid<?php } ?>" id="input-sort-order" placeholder="<?php echo lang('Entry.entry_sort_order', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-sort-order"><?php echo lang('Entry.entry_sort_order', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('sort_order')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('sort_order'); ?></div>
	                	<?php } ?>
									</div>
									<div class="form-floating mb-3">
									  <select name="status" class="form-select" id="input-status" aria-label="status">
		                  <?php if ($status) { ?>
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
