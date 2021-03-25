<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-cog fa-fw"></i> <?php echo $heading_title; ?></h2>
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
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/dashboard/' . $administrator_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
	    </div>
    </div>
		<div class="accordion" id="accordionSetting">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingSetting">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
		        <i class="fas fa-edit fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_category', array(), $lang->getBackEndLocale()); ?>
		      </button>
		    </h2>
		    <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionSetting">
		      <div class="accordion-body">
						<ul class="nav nav-tabs mb-3" id="tab-setting" role="tablist">
						  <li class="nav-item" role="presentation">
						    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.tab_general', array(), $lang->getBackEndLocale()); ?></button>
						  </li>
						</ul>
						<div class="tab-content" id="myTabContent">
						  <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
						  	<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_general', array(), $lang->getBackEndLocale()); ?></h5>
						  	<div class="form-floating mb-3">
								  <input type="text" name="name" value="<?php echo $name; ?>" class="form-control<?php if ($validation->hasError('name')) { ?> is-invalid<?php } ?>" id="input-name" placeholder="<?php echo lang('Entry.entry_name', array(), $lang->getBackEndLocale()); ?>">
								  <label for="input-name"><?php echo lang('Entry.entry_name', array(), $lang->getBackEndLocale()); ?></label>
								  <?php if ($validation->hasError('name')) { ?>
                  <div class="text-danger small"><?php echo $validation->getError('name'); ?></div>
                	<?php } ?>
								</div>
								<div class="form-floating mb-3">
								  <select name="orientation" class="form-select" id="input-orientation" aria-label="orientation">
	                  <?php if ($orientation == 'horizontal') { ?>
	                    <option value="horizontal" selected><?php echo lang('Text.text_horizontal', array(), $lang->getBackEndLocale()); ?></option>
	                    <option value="vertical"><?php echo lang('Text.text_vertical', array(), $lang->getBackEndLocale()); ?></option>
	                  <?php } else { ?>
	                    <option value="horizontal"><?php echo lang('Text.text_horizontal', array(), $lang->getBackEndLocale()); ?></option>
	                    <option value="vertical" selected><?php echo lang('Text.text_vertical', array(), $lang->getBackEndLocale()); ?></option>
	                  <?php } ?>
								  </select>
								  <label for="input-status"><?php echo lang('Entry.entry_status', array(), $lang->getBackEndLocale()); ?></label>
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
