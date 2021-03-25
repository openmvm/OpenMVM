<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<div class="d-flex justify-content-center">
		<div class="card">
		  <div class="card-header">
		    <h4 class="text-center"><?php echo lang('Heading.heading_login', array(), $lang->getFrontEndLocale()); ?></h4>
		  </div>
		  <div class="card-body">
				<!-- Notification -->
				<?php if ($success || $error) { ?>
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
				<?php } ?>
				<!-- /.notification -->
    		<?php echo form_open(base_url('login')); ?>
		    <fieldset>
			  	<div class="form-floating mb-3">
					  <input type="text" name="email" value="<?php echo $email; ?>" class="form-control<?php if ($validation->hasError('email')) { ?> is-invalid<?php } ?>" id="input-email" placeholder="<?php echo lang('Entry.entry_email', array(), $lang->getFrontEndLocale()); ?>">
					  <label for="input-email"><?php echo lang('Entry.entry_email', array(), $lang->getFrontEndLocale()); ?></label>
					  <?php if ($validation->hasError('email')) { ?>
            <div class="text-danger small"><?php echo $validation->getError('email'); ?></div>
          	<?php } ?>
					</div>
			  	<div class="form-floating mb-3">
					  <input type="password" name="password" value="<?php echo $password; ?>" class="form-control<?php if ($validation->hasError('password')) { ?> is-invalid<?php } ?>" id="input-password" placeholder="<?php echo lang('Entry.entry_password', array(), $lang->getFrontEndLocale()); ?>">
					  <label for="input-password"><?php echo lang('Entry.entry_password', array(), $lang->getFrontEndLocale()); ?></label>
					  <?php if ($validation->hasError('password')) { ?>
            <div class="text-danger small"><?php echo $validation->getError('password'); ?></div>
          	<?php } ?>
					</div>
		    </fieldset>
				<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
        <div class="d-grid gap-2 my-2">
        	<button type="submit" id="button-login" class="btn btn-primary"><?php echo lang('Button.button_login', array(), $lang->getFrontEndLocale()); ?></button>
      	</div>
    		<?php echo form_close(); ?>
		  </div>
		</div>
	</div>
</section>
<!-- /.content -->
<?php echo $footer; ?>