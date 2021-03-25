<?php echo $header; ?>
<!-- Content -->
<section class="container-fluid content min-vh-100 mt-3">
	<?php if ($error) { ?>
	<div class="d-flex justify-content-center">
		<div class="card">
		  <div class="card-body">
			    <div class="text-success"><?php echo $success; ?></div>
		  </div>
		</div>		
	</div>		
	<?php } ?>
</section>
<!-- /.content -->
<?php echo $footer; ?>
