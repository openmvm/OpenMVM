<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $heading_title; ?></title>
    <link rel="shortcut icon" type="image/png" href="<?php echo $favicon; ?>"/>
    <base href="<?php echo base_url(); ?>"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="csrf-token" content="">
    <script src="<?php echo base_url('assets/plugins/jquery/jquery-3.5.1.min.js'); ?>"></script>
   	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
   	<script src="<?php echo base_url('assets/backend_themes/openmvm/default/js/common.js'); ?>"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="<?php echo base_url('assets/plugins/fontawesome-free-5.15.2-web/css/all.min.css'); ?>" rel="stylesheet" media="screen"/>
    <link href="<?php echo base_url('assets/backend_themes/openmvm/default/css/stylesheet.css'); ?>" rel="stylesheet" media="screen"/>
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css"/>
  </head>
  <body class="bg-light">
  	<!-- Container Fluid -->
  	<div id="container-fluid" class="container-fluid">
  		<div class="d-flex align-items-center justify-content-center min-vh-100">
				<div class="card" style="width: 20rem;">
				  <div class="card-body">
				    <h5 class="card-title text-center border-bottom border-dark pb-2 mb-5"><?php echo $heading_title; ?></h5>
				  	<div class="text-success mb-5"><?php echo lang('Success.success_logged_out', array(), $lang->getBackEndLocale()); ?></div>
				  	<div class="text-center">[ <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/login'); ?>" class="card-link"><?php echo lang('Text.text_login', array(), $lang->getBackEndLocale()); ?></a> ]</div>
				  </div>
				</div>
  		</div>
		</div>
  	<!-- /.container-fluid -->
	</body>
</html>
