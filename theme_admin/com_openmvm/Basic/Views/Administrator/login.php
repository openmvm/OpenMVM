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
<link href="<?php echo $base; ?>/assets/plugins/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="<?php echo $base; ?>/assets/plugins/bootstrap-5.1.3-dist/js/bootstrap.min.js" type="text/javascript"></script>
<link href="<?php echo $base; ?>/assets/plugins/fontawesome-free-5.15.4-web/css/all.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $base; ?>/assets/admin/theme/openmvm/default/css/default.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $base; ?>/assets/admin/theme/openmvm/default/js/default.js" type="text/javascript"></script>
</head>
<body>
    <div class="d-flex align-items-center vh-100">
        <?php echo form_open($action, ['id' => 'form-login', 'class' => 'mx-auto']); ?>
        <div class="card shadow mb-5">
            <h3 class="card-header"><?php echo $title; ?></h3>
            <div class="card-body">
                <?php if ($error_warning) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo $error_warning; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <div class="mb-3 required">
                    <label for="input-username" class="form-label"><?php echo lang('Entry.username'); ?></label>
                    <input type="text" name="username" value="" id="input-username" class="form-control" placeholder="<?php echo lang('Entry.username'); ?>">
                    <?php if ($validation->hasError('username')) { ?><div class="text-danger small"><?php echo $validation->getError('username'); ?></div><?php } ?>
                </div>
                <div class="mb-3 required">
                    <label for="input-password" class="form-label"><?php echo lang('Entry.password'); ?></label>
                    <input type="password" name="password" value="" id="input-password" class="form-control" placeholder="<?php echo lang('Entry.password'); ?>">
                    <?php if ($validation->hasError('password')) { ?><div class="text-danger small"><?php echo $validation->getError('password'); ?></div><?php } ?>
                </div>
                <div class="clearfix">
                    <button type="submit" id="button-login" class="btn btn-outline-primary float-end"><?php echo lang('Button.login'); ?></button>
                </div>
            </div>
        </div>
        <div><?php echo $copyrights; ?></div>
        <?php echo form_close(); ?>
    </div>
</body>
</html>