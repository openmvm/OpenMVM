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
<script src="<?php echo $base; ?>/assets/plugins/jquery/jquery-3.6.1.min.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>/assets/plugins/jquery/jquery-ui-1.13.2/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>/assets/plugins/jquery/jquery-serializejson/jquery.serializejson.min.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>/assets/plugins/bootstrap-5.3.0-alpha1-dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>/assets/plugins/swipenav/js/jquery-swipe-nav-plugin.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>/assets/admin/theme/com_openmvm/basic/js/basic.js" type="text/javascript"></script>
<?php if ($scripts) { ?>
	<?php foreach ($scripts as $script) { ?>
		<?php echo $script; ?>
	<?php } ?>
<?php } ?>
<link href="<?php echo $base; ?>/assets/plugins/jquery/jquery-ui-1.13.2/jquery-ui.min.css" rel="stylesheet" media="screen" />
<link href="<?php echo $base; ?>/assets/plugins/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<link href="<?php echo $base; ?>/assets/plugins/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet" type="text/css" />
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
				<div class="float-start">
					<h3 class="d-none d-md-inline"><?php echo lang('Text.administrator'); ?></h3>
				</div>
				<div class="float-end">
					<button type="button" data-environment="<?php if ($environment === 'production') { ?>production<?php } else { ?>development<?php } ?>" class="btn btn-primary d-inline" id="button-environment"><i class="fas <?php if ($environment === 'production') { ?>fa-check<?php } else { ?>fa-circle-minus<?php } ?> fa-fw"></i><span class="d-none d-sm-inline ms-2"><?php echo lang('Button.production', [], 'en'); ?></span></button>
					<div class="btn-group">
						<a href="<?php echo base_url(); ?>" class="btn btn-link link-secondary text-decoration-none d-inline-block" target="_blank"><i class="fas fa-home fa-fw"></i><span class="d-none d-sm-inline ms-2"><?php echo lang('Button.marketplace'); ?></span></a>
						<button type="button" class="btn btn-link link-secondary text-decoration-none d-inline-block dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-tie fa-fw"></i><span class="d-none d-sm-inline ms-2"><?php echo $welcome; ?></span></button>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a href="<?php echo $profile; ?>" class="dropdown-item" type="button"><?php echo lang('Text.my_profile'); ?></a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a href="<?php echo base_url(env('app.adminUrlSegment') . '/administrator/logout'); ?>" class="dropdown-item" type="button"><?php echo lang('Button.logout'); ?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript"><!--
$('body').on('click', '#button-environment', function() {
	var environment = $('#button-environment').attr('data-environment');
	var code = 'setting';
	var key = 'setting_environment';

	if (environment === 'production') {
		var value = 'development';
	} else {
		var value = 'production';
	}

	$.ajax({
		url: '<?php echo $update_setting_value; ?>',
		method: 'post',
		dataType: 'json',
		data: {
			code: code,
			key: key,
			value: value
		},
		beforeSend: function() {
			if (environment === 'production') {
				$('#button-environment i').removeClass('fa-check').addClass('fa-spinner fa-spin');
			} else {
				$('#button-environment i').removeClass('fa-circle-minus').addClass('fa-spinner fa-spin');
			}
		},
		complete: function() {
		},
		success: function(json) {
			if (environment === 'production') {
				$('#button-environment i').removeClass('fa-spinner fa-spin').addClass('fa-circle-minus');
			} else {
				$('#button-environment i').removeClass('fa-spinner fa-spin').addClass('fa-check');
			}

			if (environment === 'production') {
				set_environment = 'development';
			} else {
				set_environment = 'production';
			}

			$('#button-environment').attr('data-environment', set_environment);

			setEnvironment(set_environment);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

function setEnvironment(environment) {
	$.ajax({
		url: '<?php echo $set_environment; ?>',
		method: 'post',
		dataType: 'json',
		data: {
			environment: environment
		},
		beforeSend: function() {
		},
		complete: function() {
		},
		success: function(json) {
			window.location.reload(true);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}
//--></script> 
