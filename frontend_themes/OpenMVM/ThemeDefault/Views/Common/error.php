<?php echo $header; ?>
<!-- Content -->
<section class="container-fluid content min-vh-100 mt-3">
	<?php if ($error) { ?>
	<div class="d-flex justify-content-center">
		<div class="card">
		  <div class="card-body">
				<div class="text-danger"><?php echo $error; ?></div>
		  </div>
		</div>		
	</div>		
	<?php } ?>
</section>
<!-- /.content -->
<?php echo $footer; ?>
