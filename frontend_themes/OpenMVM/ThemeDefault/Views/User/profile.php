<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo lang('Heading.heading_profile', array(), $lang->getFrontEndLocale()); ?></h1>
  <?php echo form_open(base_url('/account/profile/' . $user_token)); ?>
  <div class="clearfix mb-3">
    <div class="float-end">
      <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_save', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-save"></i></button>
      <a href="<?php echo base_url('/account/' . $user_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
    </div>
  </div>
	<div class="accordion" id="accordionAccountProfile">
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="headingAccountProfile">
	      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccountProfile" aria-expanded="true" aria-controls="collapseAccountProfile">
	        <i class="fas fa-user fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_profile', array(), $lang->getFrontEndLocale()); ?>
	      </button>
	    </h2>
	    <div id="collapseAccountProfile" class="accordion-collapse collapse show" aria-labelledby="headingAccountProfile" data-bs-parent="#accordionAccountProfile">
	      <div class="accordion-body">

	        <div>
	          <fieldset>
					  	<div class="form-floating mb-3">
							  <input type="text" name="username" value="<?php echo $username; ?>" class="form-control<?php if ($validation->hasError('username')) { ?> is-invalid<?php } ?>" id="input-username" placeholder="<?php echo lang('Entry.entry_username', array(), $lang->getFrontEndLocale()); ?>" readonly>
							  <label for="input-username"><?php echo lang('Entry.entry_username', array(), $lang->getFrontEndLocale()); ?></label>
							  <?php if ($validation->hasError('username')) { ?>
                <div class="text-danger small"><?php echo $validation->getError('username'); ?></div>
              	<?php } ?>
							</div>
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
							  <input type="text" name="email" value="<?php echo $email; ?>" class="form-control<?php if ($validation->hasError('email')) { ?> is-invalid<?php } ?>" id="input-email" placeholder="<?php echo lang('Entry.entry_email', array(), $lang->getFrontEndLocale()); ?>" readonly>
							  <label for="input-email"><?php echo lang('Entry.entry_email', array(), $lang->getFrontEndLocale()); ?></label>
							  <?php if ($validation->hasError('email')) { ?>
                <div class="text-danger small"><?php echo $validation->getError('email'); ?></div>
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

	      </div>
	    </div>
	  </div>
	</div>
  <?php echo form_close(); ?>
</section>
<!-- /.content -->
<?php echo $footer; ?>
