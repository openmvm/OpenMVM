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
   	<script src="<?php echo base_url('assets/frontend_themes/openmvm/default/js/common.js'); ?>"></script>
    <link href="<?php echo base_url('assets/frontend_themes/openmvm/default/css/stylesheet.css'); ?>" rel="stylesheet" media="screen"/>
  </head>
  <body class="bg-light">
		<!-- Header -->
		<section id="header" class="header bg-danger">
      <div id="menu-top" class="container menu-top py-2">
      	<div class="clearfix">
      		<div class="float-start">
      			<ul class="list-unstyled list-inline small py-0 my-0">
      				<li class="list-inline-item"><?php echo $widget_language; ?></li>
      				<li class="list-inline-item"><?php echo $widget_currency; ?></li>
      			</ul>
      		</div>
      		<div class="float-end">
      			<ul class="list-unstyled list-inline small py-0 my-0">
      				<li class="list-inline-item"><a href="#" class="link-light text-decoration-none"><i class="far fa-bell"></i> Notification</a></li>
      				<li class="list-inline-item"><a href="#" class="link-light text-decoration-none"><i class="far fa-question-circle"></i> Help</a></li>
      				<?php if ($is_logged) { ?>
      				<li class="list-inline-item">
								<div class="dropdown">
								  <a href="<?php echo base_url('/account/' . $user_token); ?>" class="dropdown-toggle link-light text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false"><?php echo lang('Text.text_my_account', array(), $lang->getFrontEndLocale()); ?></a>
								  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
								  	<li><h6 class="dropdown-header"><?php echo lang('Text.text_account', array(), $lang->getFrontEndLocale()); ?></h6></li>
								    <li><a class="dropdown-item small" href="<?php echo base_url('/account/' . $user_token); ?>"><?php echo lang('Text.text_my_account', array(), $lang->getFrontEndLocale()); ?></a></li>
								    <li><a class="dropdown-item small" href="<?php echo base_url('/account/profile/' . $user_token); ?>"><?php echo lang('Text.text_my_profile', array(), $lang->getFrontEndLocale()); ?></a></li>
								    <li><a class="dropdown-item small" href="<?php echo base_url('/account/address/' . $user_token); ?>"><?php echo lang('Text.text_my_address_book', array(), $lang->getFrontEndLocale()); ?></a></li>
								    <li><a class="dropdown-item small text-decoration-none" href="<?php echo base_url('/account/filemanager/' . $user_token); ?>"><?php echo lang('Text.text_filemanager', array(), $lang->getFrontEndLocale()); ?></a></li>
								    <li><hr class="dropdown-divider"></li>
								  	<li><h6 class="dropdown-header"><?php echo lang('Text.text_orders', array(), $lang->getFrontEndLocale()); ?></h6></li>
								    <li><a class="dropdown-item small" href="<?php echo base_url('/account/orders/' . $user_token); ?>"><?php echo lang('Text.text_my_orders', array(), $lang->getFrontEndLocale()); ?></a></li>
								    <li><hr class="dropdown-divider"></li>
								  	<li><h6 class="dropdown-header"><?php echo lang('Text.text_store', array(), $lang->getFrontEndLocale()); ?></h6></li>
								    <?php if ($is_merchant) { ?>
								    <li><a class="dropdown-item small text-decoration-none" href="<?php echo base_url('/account/store/edit/' . $store_id . '/' . $user_token); ?>"><?php echo lang('Text.text_my_store', array(), $lang->getFrontEndLocale()); ?></a></li>
								    <li><a class="dropdown-item small text-decoration-none" href="<?php echo base_url('/account/store/products/' . $user_token); ?>"><?php echo lang('Text.text_my_products', array(), $lang->getFrontEndLocale()); ?></a></li>
								    <?php } else { ?>
								    <li><a class="dropdown-item small text-decoration-none" href="<?php echo base_url('/account/store/add/' . $user_token); ?>"><?php echo lang('Text.text_open_store', array(), $lang->getFrontEndLocale()); ?></a></li>
								    <?php } ?>
								    <li><hr class="dropdown-divider"></li>
								    <li><a class="dropdown-item small text-decoration-none" href="<?php echo base_url('/logout'); ?>"><?php echo lang('Text.text_logout', array(), $lang->getFrontEndLocale()); ?></a></li>
								  </ul>
								</div>
    					</li>
    					<?php } else { ?>
      				<li class="list-inline-item"><a href="<?php echo base_url('/register'); ?>" class="link-light text-decoration-none"><?php echo lang('Text.text_register', array(), $lang->getFrontEndLocale()); ?></a></li>
      				<li class="list-inline-item"><a href="<?php echo base_url('/login'); ?>" class="link-light text-decoration-none"><?php echo lang('Text.text_login', array(), $lang->getFrontEndLocale()); ?></a></li>
    					<?php } ?>
      			</ul>
      		</div>
      	</div>
      </div>
      <div class="container">
      	<div class="py-4">
	      	<div class="row">
	      		<div class="col-sm-3">
	      			<?php if ($logo) { ?>
	    				<a href="<?php echo base_url(); ?>"><img src="<?php echo $logo; ?>" alt="<?php echo $website_name; ?>" title="<?php echo $website_name; ?>" /></a>
	    				<?php } else { ?>
	  					<h5><?php echo $website_name; ?></h5>
	    				<?php } ?>
	      		</div>
	      		<div class="col-sm-6">
							<div id="search" class="input-group">
							  <input type="text" name="search" class="form-control" placeholder="<?php echo lang('Text.text_search', array(), $lang->getFrontEndLocale()); ?>" aria-label="<?php echo lang('Text.text_search', array(), $lang->getFrontEndLocale()); ?>" aria-describedby="button-search">
							  <button class="btn btn-outline-light" type="button" id="button-search"><?php echo lang('Button.button_search', array(), $lang->getFrontEndLocale()); ?></button>
							</div>
	      		</div>
	      		<div class="col-sm-3"><?php echo $widget_cart; ?></div>
	      	</div>
      	</div>
      </div>
    </section>
		<!-- /.header -->

		<!-- Header -->
		<section id="menu" class="menu bg-success">
			<?php echo $widget_menu; ?>
    </section>
		<!-- /.header -->

		<!-- Breadcrumb -->
		<?php if ($breadcrumbs) { ?>
		<section id="breadcrumb" class="bg-light p-3 mb-3">
			<div class="container">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb small p-0 m-0">
				  	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				  		<?php if ($breadcrumb['active']) { ?>
				    	<li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
			  			<?php } else { ?>
				    	<li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>" class="text-decoration-none"><?php echo $breadcrumb['text']; ?></a></li>
			  			<?php } ?>
				  	<?php } ?>
				  </ol>
				</nav>
			</div>
	  </section>
		<?php } ?>
		<!-- /.breadcrumb -->

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
