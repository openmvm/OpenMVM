<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" type="image/png" href="<?php echo $favicon; ?>"/>
    <base href="<?php echo base_url(); ?>"/>
    <meta name="description" content="<?php echo $meta_description; ?>"/>
    <meta name="keywords" content="<?php echo $meta_keywords; ?>"/>
    <script src="<?php echo base_url('assets/plugins/jquery/jquery-3.5.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap-5.0.0-beta2-dist/js/bootstrap.bundle.min.js'); ?>" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <?php foreach ($scripts as $script) { ?>
    <?php echo $script; ?>
    <?php } ?>
    <link href="<?php echo base_url('assets/plugins/bootstrap-5.0.0-beta2-dist/css/bootstrap.min.css'); ?>" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="<?php echo base_url('assets/plugins/fontawesome-free-5.15.2-web/css/all.min.css'); ?>" rel="stylesheet" media="screen"/>
    <?php foreach ($styles as $style) { ?>
    <?php echo $style; ?>
    <?php } ?>
  </head>
  <body class="bg-white mt-4">
  	<!-- Container Fluid -->
  	<div class="container">
			<!-- Notification -->
			<?php if ($success || $error) { ?>
			<section id="notification" class="container notification px-3">
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
