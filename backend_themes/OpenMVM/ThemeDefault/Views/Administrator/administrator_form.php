<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-user-secret fa-fw"></i> <?php echo $heading_title; ?></h2>
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
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/administrators/' . $administrator_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
	    </div>
    </div>
		<div class="accordion" id="accordionAdministratorGroup">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingAdministratorGroup">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdministratorGroup" aria-expanded="true" aria-controls="collapseAdministratorGroup">
		        <i class="fas fa-user-secret fa-fw"></i>&nbsp;&nbsp;<?php echo $heading_title; ?>
		      </button>
		    </h2>
		    <div id="collapseAdministratorGroup" class="accordion-collapse collapse show" aria-labelledby="headingAdministratorGroup" data-bs-parent="#accordionAdministratorGroup">
		      <div class="accordion-body">

			      <ul class="nav nav-tabs" id="administratorTab" role="tablist">
			        <li class="nav-item">
			          <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.tab_general', array(), $lang->getBackEndLocale()); ?></a>
			        </li>
			      </ul>
			      <div class="tab-content mt-3" id="administratorTabContent">
			        <div class="tab-pane show active" id="general" role="tabpanel" aria-labelledby="general-tab">
			          <fieldset>
									<div class="form-floating mb-3">
									  <select name="administrator_group_id" class="form-select" id="input-administrator-group" aria-label="administrator-group">
			                <?php foreach ($administrator_groups as $administrator_group) { ?>
			                  <?php if ($administrator_group['administrator_group_id'] == $administrator_group_id) { ?>
			                    <option value="<?php echo $administrator_group['administrator_group_id']; ?>" selected><?php echo $administrator_group['name']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $administrator_group['administrator_group_id']; ?>"><?php echo $administrator_group['name']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-administrator-group"><?php echo lang('Entry.entry_administrator_group', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="username" value="<?php echo $username; ?>" class="form-control<?php if ($validation->hasError('username')) { ?> is-invalid<?php } ?>" id="input-username" placeholder="<?php echo lang('Entry.entry_username', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-username"><?php echo lang('Entry.entry_username', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('username')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('username'); ?></div>
	                	<?php } ?>
									</div>
			            <div class="form-group mb-3">
										<h5><?php echo lang('Entry.entry_avatar', array(), $lang->getBackEndLocale()); ?></h5>
		                <div class="image-container">
		                  <div id="input-avatar-href" class="image-thumb clickable d-flex" data-toggle="replace-image" data-target="input-avatar" data-replace="<?php echo $placeholder; ?>" data-locale="<?php echo $lang->getBackEndLocale(); ?>"><img src="<?php echo $thumb_avatar; ?>" class="img-fluid mx-auto my-auto" /></div>
		                  <input type="hidden" name="avatar" value="<?php echo $avatar; ?>" id="input-avatar" class="form-control">
		                  <div class="d-grid gap-2 mt-2">
		                  	<span class="btn btn-danger" data-toggle="delete-image" data-target="input-avatar" data-replace="<?php echo $placeholder; ?>"><i class="fas fa-trash-alt"></i></span>
		                	</div>
		                </div>
			            </div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="firstname" value="<?php echo $firstname; ?>" class="form-control<?php if ($validation->hasError('firstname')) { ?> is-invalid<?php } ?>" id="input-firstname" placeholder="<?php echo lang('Entry.entry_firstname', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-firstname"><?php echo lang('Entry.entry_firstname', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('firstname')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('firstname'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="lastname" value="<?php echo $lastname; ?>" class="form-control<?php if ($validation->hasError('lastname')) { ?> is-invalid<?php } ?>" id="input-lastname" placeholder="<?php echo lang('Entry.entry_lastname', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-lastname"><?php echo lang('Entry.entry_lastname', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('lastname')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('lastname'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="email" value="<?php echo $email; ?>" class="form-control<?php if ($validation->hasError('email')) { ?> is-invalid<?php } ?>" id="input-email" placeholder="<?php echo lang('Entry.entry_email', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-email"><?php echo lang('Entry.entry_email', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('email')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('email'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="password" name="password" value="<?php echo $password; ?>" class="form-control<?php if ($validation->hasError('password')) { ?> is-invalid<?php } ?>" id="input-password" placeholder="<?php echo lang('Entry.entry_password', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-password"><?php echo lang('Entry.entry_password', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('password')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('password'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="password" name="passconf" value="<?php echo $passconf; ?>" class="form-control<?php if ($validation->hasError('passconf')) { ?> is-invalid<?php } ?>" id="input-passconf" placeholder="<?php echo lang('Entry.entry_passconf', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-passconf"><?php echo lang('Entry.entry_passconf', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('passconf')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('passconf'); ?></div>
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
