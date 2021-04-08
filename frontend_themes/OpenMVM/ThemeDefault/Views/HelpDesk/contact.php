<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo lang('Heading.heading_contact_us', array(), $lang->getFrontEndLocale()); ?></h1>
  <?php echo form_open($action); ?>
  <div class="row">
  	<div class="col-sm-6">&nbsp;</div>
		<div class="col-sm-6">
			<div class="card card-body">
				<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_contact_form', array(), $lang->getFrontEndLocale()); ?></h5>
				<fieldset>
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
					  <?php if ($validation->hasError('firstname')) { ?>
		        <div class="text-danger small"><?php echo $validation->getError('firstname'); ?></div>
		      	<?php } ?>
					</div>
			  	<div class="form-floating mb-3">
					  <input type="text" name="email" value="<?php echo $email; ?>" class="form-control<?php if ($validation->hasError('email')) { ?> is-invalid<?php } ?>" id="input-email" placeholder="<?php echo lang('Entry.entry_email', array(), $lang->getFrontEndLocale()); ?>">
					  <label for="input-email"><?php echo lang('Entry.entry_email', array(), $lang->getFrontEndLocale()); ?></label>
					  <?php if ($validation->hasError('email')) { ?>
		        <div class="text-danger small"><?php echo $validation->getError('email'); ?></div>
		      	<?php } ?>
					</div>
			  	<div class="form-floating mb-3">
					  <textarea style="height: 200px" name="message" class="form-control<?php if ($validation->hasError('message')) { ?> is-invalid<?php } ?>" id="input-message" placeholder="<?php echo lang('Entry.entry_message', array(), $lang->getFrontEndLocale()); ?>"><?php echo $message; ?></textarea>
					  <label for="input-meta-description"><?php echo lang('Entry.entry_message', array(), $lang->getFrontEndLocale()); ?></label>
					  <?php if ($validation->hasError('message')) { ?>
            <div class="text-danger small"><?php echo $validation->getError('message'); ?></div>
          	<?php } ?>
					</div>
				</fieldset>
	      <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_send', array(), $lang->getFrontEndLocale()); ?>"><?php echo lang('Button.button_send', array(), $lang->getFrontEndLocale()); ?></button>
			</div>
		</div>
  </div>
  <?php echo form_close(); ?>
</section>
<!-- /.content -->
<?php echo $footer; ?>
