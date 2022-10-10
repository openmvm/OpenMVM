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
<link href="<?php echo $base; ?>/assets/plugins/bootstrap-5.2.2-dist/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="<?php echo $base; ?>/assets/plugins/bootstrap-5.2.2-dist/js/bootstrap.min.js" type="text/javascript"></script>
<link href="<?php echo $base; ?>/assets/plugins/fontawesome-free-6.2.0-web/css/all.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $base; ?>/assets/admin/theme/com_openmvm/Basic/css/basic.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $base; ?>/assets/admin/theme/com_openmvm/Basic/js/basic.js" type="text/javascript"></script>
</head>
<body>
    <div class="d-flex align-items-center vh-100">
        <?php echo form_open($action, ['id' => 'form-login', 'class' => 'mx-auto']); ?>
        <div class="card shadow mb-3">
            <h3 class="card-header"><?php echo $title; ?></h3>
            <div class="card-body">
                <div class="mb-3 required">
                    <label for="input-username" class="form-label"><?php echo lang('Entry.username'); ?></label>
                    <input type="text" name="username" value="" id="input-username" class="form-control" placeholder="<?php echo lang('Entry.username'); ?>">
                </div>
                <div class="mb-3 required">
                    <label for="input-password" class="form-label"><?php echo lang('Entry.password'); ?></label>
                    <input type="password" name="password" value="" id="input-password" class="form-control" placeholder="<?php echo lang('Entry.password'); ?>">
                </div>
                <div class="d-grid">
                    <button type="button" class="btn btn-primary button-action mb-3" data-form="form-login" data-form-action="<?php echo $action; ?>" data-icon="fa-lock" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-lock fa-fw"></i> <?php echo lang('Button.login', [], 'en'); ?></button>
                    <a href="<?php echo $base; ?>" class="btn btn-outline-success" target="_blank"><i class="fas fa-home fa-fw"></i> <?php echo lang('Text.homepage'); ?></a>
                </div>
            </div>
        </div>
        
        <div><?php echo $copyrights; ?></div>
        <?php echo form_close(); ?>
    </div>
</body>
</html>