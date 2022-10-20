<?php if (!empty($errors)) { ?>
<div class="text-danger mb-3"><?php echo lang('Error.checkout', [], $language_lib->getCurrentCode()); ?></div>
		<?php foreach ($errors as $error) { ?>
				<div><i class="fas fa-times-circle fa-fw text-danger"></i> <?php echo $error; ?></div>
		<?php } ?>
<?php } else { ?>
<div class="alert alert-info mb-3"><?php echo $message; ?></div>
<div><?php echo $payment_method; ?></div>
<?php } ?>