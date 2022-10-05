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
<link href="<?php echo $base; ?>/assets/plugins/bootstrap-5.2.0-dist/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="<?php echo $base; ?>/assets/plugins/bootstrap-5.2.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
<link href="<?php echo $base; ?>/assets/plugins/fontawesome-free-6.2.0-web/css/all.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $base; ?>/assets/admin/theme/com_openmvm/Basic/css/basic.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $base; ?>/assets/admin/theme/com_openmvm/Basic/js/basic.js" type="text/javascript"></script>
</head>
<body>
    <div class="d-flex align-items-center vh-100">
        <div class="mx-auto">
            <div class="card shadow mb-5">
                <h3 class="card-header"><?php echo $title; ?></h3>
                <div class="card-body">
                    <div class="text-success text-center mb-3"><?php echo lang('Success.logout'); ?></div>
                    <div class="text-center">[ <a href="<?php echo base_url(env('app.adminUrlSegment') . '/administrator/login'); ?>"><?php echo lang('Button.login'); ?></a> ]</div>
                </div>
            </div>
            <div><?php echo $copyrights; ?></div>
        </div>
    </div>
</body>
</html>