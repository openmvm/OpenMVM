<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="en" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="en" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="ltr" lang="en">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php if (!empty($favicon)) { ?>
<link rel="shortcut icon" href="<?php echo $favicon; ?>"/>
<?php } ?>
<script src="<?php echo $base; ?>/assets/plugins/jquery/jquery-3.6.0.min.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>/assets/plugins/jquery/jquery-ui-1.13.0/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>/assets/plugins/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>/assets/plugins/swipenav/js/jquery-swipe-nav-plugin.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>/assets/admin/theme/com_openmvm/basic/js/basic.js" type="text/javascript"></script>
<?php if ($scripts) { ?>
	<?php foreach ($scripts as $script) { ?>
		<?php echo $script; ?>
	<?php } ?>
<?php } ?>
<link href="<?php echo $base; ?>/assets/plugins/jquery/jquery-ui-1.13.0/jquery-ui.min.css" rel="stylesheet" media="screen" />
<link href="<?php echo $base; ?>/assets/plugins/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<link href="<?php echo $base; ?>/assets/plugins/fontawesome-free-5.15.4-web/css/all.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $base; ?>/assets/plugins/swipenav/css/jquery-swipe-nav.css" rel="stylesheet" media="screen" />
<?php if ($styles) { ?>
	<?php foreach ($styles as $style) { ?>
		<?php echo $style; ?>
	<?php } ?>
<?php } ?>
<link href="<?php echo $base; ?>/assets/admin/theme/com_openmvm/basic/css/basic.css" rel="stylesheet" type="text/css" />
</head>
<body class="open">
	<div class="container-fluid">
		<div id="header" class="header">
			<div class="top-menu clearfix">
				<a href="javascript:void(0);" id="menuBtn" class="toggle float-start" data-bs-toggle="collapse" data-bs-target="#columnLeftContent" aria-controls="columnLeftContent" aria-expanded="false" aria-label="Toggle navigation">
					<i class="fas fa-bars"></i>
				</a>
				<h3 class="float-start"><?php echo lang('Text.administrator'); ?></h3>
				<div class="float-end">
					<div class="btn-group">
						<a href="<?php echo base_url(); ?>" class="btn btn-link link-secondary text-decoration-none" target="_blank"><?php echo lang('Button.open_marketplace'); ?></a>
						<button type="button" class="btn btn-link link-secondary text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $welcome; ?></button>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a href="<?php echo $profile; ?>" class="dropdown-item" type="button"><?php echo lang('Text.my_profile'); ?></a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a href="<?php echo base_url('admin/administrator/logout'); ?>" class="dropdown-item" type="button"><?php echo lang('Button.logout'); ?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>