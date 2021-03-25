<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<div class="d-flex justify-content-center">
		<div class="card">
		  <div class="card-header">
		    <h4 class="text-center"><?php echo lang('Heading.heading_logout', array(), $lang->getFrontEndLocale()); ?></h4>
		  </div>
		  <div class="card-body">
			  	<div class="text-success mb-5"><?php echo lang('Success.success_logged_out', array(), $lang->getBackEndLocale()); ?></div>
			  	<div class="text-center">[ <a href="<?php echo base_url('/login'); ?>" class="card-link"><?php echo lang('Text.text_login', array(), $lang->getFrontEndLocale()); ?></a> ]</div>
		  </div>
		</div>
	</div>
</section>
<!-- /.content -->
<?php echo $footer; ?>