<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-weight-hanging fa-fw"></i> <?php echo $heading_title; ?></h2>
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
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/localisation/weight_classes/' . $administrator_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
	    </div>
    </div>
		<div class="accordion" id="accordionAdministratorGroup">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingAdministratorGroup">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdministratorGroup" aria-expanded="true" aria-controls="collapseAdministratorGroup">
		        <i class="fas fa-weight-hanging fa-fw"></i>&nbsp;&nbsp;<?php echo $heading_title; ?>
		      </button>
		    </h2>
		    <div id="collapseAdministratorGroup" class="accordion-collapse collapse show" aria-labelledby="headingAdministratorGroup" data-bs-parent="#accordionAdministratorGroup">
		      <div class="accordion-body">

		        <ul class="nav nav-tabs" id="weightClassTab" role="tablist">
		          <li class="nav-item">
		            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.tab_general', array(), $lang->getBackEndLocale()); ?></a>
		          </li>
		        </ul>
		        <div class="tab-content mt-3" id="weightClassTabContent">
		          <div class="tab-pane show active" id="general" role="tabpanel" aria-labelledby="general-tab">
		            <fieldset>
						  		<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_description', array(), $lang->getBackEndLocale()); ?></h5>
						  		<?php foreach ($languages as $language) { ?>
							  	<div class="form-floating mb-3">
									  <input type="text" name="description[<?php echo $language['language_id']; ?>][title]" value="<?php echo $description[$language['language_id']]['title']; ?>" class="form-control<?php if ($validation->hasError('description.' . $language['language_id'] . '.title')) { ?> is-invalid<?php } ?>" id="input-value" placeholder="<?php echo lang('Entry.entry_title', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-value"><img src="<?php echo base_url('assets/flags/' . $language['image']); ?>" /> <?php echo lang('Entry.entry_title', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('description.' . $language['language_id'] . '.title')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('description.' . $language['language_id'] . '.title'); ?></div>
	                	<?php } ?>
									</div>
						  		<?php } ?>
						  		<hr />
						  		<?php foreach ($languages as $language) { ?>
							  	<div class="form-floating mb-3">
									  <input type="text" name="description[<?php echo $language['language_id']; ?>][unit]" value="<?php echo $description[$language['language_id']]['unit']; ?>" class="form-control<?php if ($validation->hasError('description.' . $language['language_id'] . '.unit')) { ?> is-invalid<?php } ?>" id="input-value" placeholder="<?php echo lang('Entry.entry_unit', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-value"><img src="<?php echo base_url('assets/flags/' . $language['image']); ?>" /> <?php echo lang('Entry.entry_unit', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('description.' . $language['language_id'] . '.unit')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('description.' . $language['language_id'] . '.unit'); ?></div>
	                	<?php } ?>
									</div>
						  		<?php } ?>
						  		<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_data', array(), $lang->getBackEndLocale()); ?></h5>
							  	<div class="form-floating mb-3">
									  <input type="text" name="value" value="<?php echo $value; ?>" class="form-control<?php if ($validation->hasError('value')) { ?> is-invalid<?php } ?>" id="input-value" placeholder="<?php echo lang('Entry.entry_value', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-value"><?php echo lang('Entry.entry_value', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('value')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('value'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" class="form-control<?php if ($validation->hasError('sort_order')) { ?> is-invalid<?php } ?>" id="input-sort-order" placeholder="<?php echo lang('Entry.entry_sort_order', array(), $lang->getBackEndLocale()); ?>">
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
