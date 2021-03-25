<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" type="image/png" href="<?php echo $favicon; ?>"/>
    <base href="<?php echo base_url(); ?>"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <?php echo csrf_meta(); ?>
    
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
   	<script src="<?php echo base_url('assets/backend_themes/openmvm/default/js/common.js'); ?>"></script>
    <link href="<?php echo base_url('assets/backend_themes/openmvm/default/css/stylesheet.css'); ?>" rel="stylesheet" media="screen"/>
  </head>
  <body class="bg-body">
  	<!-- Container Fluid -->
  	<div id="container-fluid" class="container-fluid">
  		<!-- Header -->
  		<section id="header" class="header">
        <nav class="navbar navbar-expand-sm navbar-dark bg-danger border-bottom border-warning p-0">
          <a class="navbar-brand d-none d-sm-none d-md-block ps-3" href="<?php echo base_url($_SERVER['app.adminDir'] . '/dashboard/' . $administrator_token); ?>"><img src="<?php echo base_url('assets/files/openmvm.png'); ?>" class="img-fluid" /></a>
          <a href="#" id="button-menu" class="d-block d-sm-block d-md-none ps-3 text-dark"><i class="fas fa-bars"></i></a>

          <div class="d-flex order-lg-1 ms-auto pe-2">
            <ul class="navbar-nav flex-row">
              <li class="nav-item border-left border-light px-2 py-2">
                <a class="nav-link small" href="<?php echo base_url(); ?>" target="_blank"><i class="fas fa-home"></i> OpenMVM</a>
              </li>
              <li class="nav-item border-left border-light px-2 py-2">
								<div class="dropdown">
								  <a href="#" class="nav-link small dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
								  	<i class="fas fa-user-circle"></i> <?php echo $administrator->getFirstName() . ' ' . $administrator->getLastName(); ?>
								  </a>
								  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
								    <li><a class="dropdown-item active" href="#">Action</a></li>
								    <li><a class="dropdown-item" href="#">Another action</a></li>
								    <li><a class="dropdown-item" href="#">Something else here</a></li>
								    <li><hr class="dropdown-divider"></li>
								    <li><a class="dropdown-item" href="#">Separated link</a></li>
								  </ul>
								</div>
              </li>
              <li class="nav-item border-left border-light px-2 py-2">
                <a class="nav-link small" href="<?php echo base_url($_SERVER['app.adminDir'] . '/logout'); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
              </li>
            </ul>
          </div>
        </nav>
      </section>
  		<!-- /.header -->
