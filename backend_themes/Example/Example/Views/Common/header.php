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
    <meta name="csrf-token" content="">
    <script src="<?php echo base_url('assets/plugins/jquery/jquery-3.5.1.min.js'); ?>"></script>
   	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
   	<script src="<?php echo base_url('assets/backend_themes/example/example/js/common.js'); ?>"></script>
    <?php foreach ($scripts as $script) { ?>
    <?php echo $script; ?>
    <?php } ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="<?php echo base_url('assets/plugins/fontawesome-free-5.15.2-web/css/all.min.css'); ?>" rel="stylesheet" media="screen"/>
    <link href="<?php echo base_url('assets/backend_themes/example/example/css/stylesheet.css'); ?>" rel="stylesheet" media="screen"/>
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css"/>
    <?php foreach ($styles as $style) { ?>
    <?php echo $style; ?>
    <?php } ?>
  </head>
  <body class="bg-info">
  	<!-- Container Fluid -->
  	<div id="container-fluid" class="container-fluid">
  		<!-- Header -->
  		<section id="header" class="header">
        <nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom border-secondary p-0">
          <a class="navbar-brand d-none d-sm-none d-md-block ps-3" href="<?php echo base_url(); ?>"><?php echo lang('Heading.heading_administration', array(), $lang->getBackEndLocale()); ?></a>
          <a href="#" id="button-menu" class="d-block d-sm-block d-md-none ps-3 text-dark"><i class="fas fa-bars"></i></a>

          <div class="d-flex order-lg-1 ms-auto pe-2">
            <ul class="navbar-nav flex-row">
              <li class="nav-item border-left border-light px-2 py-2">
                <a class="nav-link small" href="<?php echo base_url(); ?>" target="_blank"><i class="fas fa-home"></i> Multi-Vendor Platform</a>
              </li>
              <li class="nav-item border-left border-light px-2 py-2">
                <a class="nav-link small" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
              </li>
            </ul>
          </div>
        </nav>
      </section>
  		<!-- /.header -->
