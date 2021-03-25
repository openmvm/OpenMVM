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
  <body class="bg-dark">
  	<!-- Container Fluid -->
  	<div id="container-fluid" class="container-fluid">
  		<div class="d-flex align-items-center justify-content-center min-vh-100">
  			<div>
					<div class="card mb-5" style="width: 20rem;">
					  <div class="card-body">
	    				<?php echo form_open(base_url($_SERVER['app.adminDir'] . '/login')); ?>
					    <h5 class="card-title text-center mb-3"><?php echo $heading_title; ?></h5>
							<!-- Notification -->
							<?php if ($success || $error) { ?>
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
							<?php } ?>
							<!-- /.notification -->
					  	<div class="form-floating mb-3">
							  <input type="text" name="username" value="<?php echo $username; ?>" class="form-control<?php if ($validation->hasError('username')) { ?> is-invalid<?php } ?>" id="input-username" placeholder="<?php echo lang('Entry.entry_username', array(), $lang->getBackEndLocale()); ?>">
							  <label for="input-username"><?php echo lang('Entry.entry_username', array(), $lang->getBackEndLocale()); ?></label>
							  <?php if ($validation->hasError('username')) { ?>
	              <div class="text-danger small"><?php echo $validation->getError('username'); ?></div>
	            	<?php } ?>
							</div>
					  	<div class="form-floating mb-3">
							  <input type="password" name="password" value="<?php echo $password; ?>" class="form-control<?php if ($validation->hasError('password')) { ?> is-invalid<?php } ?>" id="input-password" placeholder="<?php echo lang('Entry.entry_password', array(), $lang->getBackEndLocale()); ?>">
							  <label for="input-password"><?php echo lang('Entry.entry_password', array(), $lang->getBackEndLocale()); ?></label>
							  <?php if ($validation->hasError('password')) { ?>
	              <div class="text-danger small"><?php echo $validation->getError('password'); ?></div>
	            	<?php } ?>
							</div>
							<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
	            <div class="d-grid gap-2 my-2">
	            	<button type="submit" id="button-login" class="btn btn-primary"><?php echo lang('Button.button_login', array(), $lang->getBackEndLocale()); ?></button>
	          	</div>
	    				<?php echo form_close(); ?>
					  </div>
					</div>  			
		  		<!-- Footer -->
					<div class="text-light copyright text-center small"><?php echo sprintf(lang('Text.text_copyright', array(), $lang->getBackEndLocale()), date("Y",now()), $website_name); ?></div>
					<div class="text-light powered text-center small"><?php echo lang('Text.text_powered', array(), $lang->getBackEndLocale()); ?></div>
					<div class="text-muted text-center small mt-3"><?php echo sprintf(lang('Text.text_page_rendered_in_seconds', array(), $lang->getBackEndLocale()), '{elapsed_time}'); ?></div>
		  		<!-- /.footer -->
  			</div>
  		</div>
		</div>
  	<!-- /.container-fluid -->
	</body>
</html>
