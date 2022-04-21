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
<script src="<?php echo $base; ?>/assets/plugins/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>/assets/plugins/swipenav/js/jquery-swipe-nav-plugin.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>/assets/marketplace/theme/com_openmvm/basic/js/basic.js" type="text/javascript"></script>
<?php if ($scripts) { ?>
	<?php foreach ($scripts as $script) { ?>
		<?php echo $script; ?>
	<?php } ?>
<?php } ?>
<link href="<?php echo $base; ?>/assets/plugins/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<link href="<?php echo $base; ?>/assets/plugins/fontawesome-free-5.15.4-web/css/all.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $base; ?>/assets/plugins/swipenav/css/jquery-swipe-nav.css" rel="stylesheet" media="screen" />
<link href="<?php echo $base; ?>/assets/marketplace/theme/com_openmvm/basic/css/basic.css?v=1.0.1" rel="stylesheet" type="text/css" />
<?php if ($styles) { ?>
	<?php foreach ($styles as $style) { ?>
		<?php echo $style; ?>
	<?php } ?>
<?php } ?>
<?php if ($analytics) { ?>
    <?php foreach ($analytics as $analytic) { ?>
        <?php echo $analytic; ?>
    <?php } ?>
<?php } ?>
</head>
<body class="bg-light">
<div id="header" class="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-1">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php if (!empty($logo)) { ?><img src="<?php echo $logo; ?>" class="logo" /><?php } else { ?><?php echo $marketplace_name; ?><?php } ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php echo $search; ?>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php echo $language; ?>
                    <?php echo $currency; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="small"><?php if ($logged_in) { ?><?php echo sprintf(lang('Text.hello_customer'), $firstname); ?><?php } else { ?><?php echo lang('Text.my_account'); ?><?php } ?></a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <?php if ($logged_in) { ?>
                            <li><h6 class="dropdown-header"><?php echo lang('Text.account'); ?></h6></li>
                            <li><a class="dropdown-item small" href="<?php echo $my_account; ?>"><?php echo lang('Text.my_account'); ?></a></li>
                            <li><a class="dropdown-item small" href="<?php echo $my_orders; ?>"><?php echo lang('Text.my_orders'); ?></a></li>
                            <li><a class="dropdown-item small" href="<?php echo $edit_profile; ?>"><?php echo lang('Text.edit_profile'); ?></a></li>
                            <li><a class="dropdown-item small" href="<?php echo $my_address_book; ?>"><?php echo lang('Text.my_address_book'); ?></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php if ($is_seller) { ?>
                            <li><h6 class="dropdown-header"><?php echo lang('Text.seller'); ?></h6></li>
                            <li><a class="dropdown-item small" href="<?php echo $seller_dashboard; ?>"><?php echo lang('Text.seller_dashboard'); ?></a></li>
                            <li><a class="dropdown-item small" href="<?php echo $seller_edit; ?>"><?php echo lang('Text.seller_edit'); ?></a></li>
                            <li><a class="dropdown-item small" href="<?php echo $seller_product; ?>"><?php echo lang('Text.products'); ?></a></li>
                            <li><a class="dropdown-item small" href="<?php echo $seller_order; ?>"><?php echo lang('Text.orders'); ?></a></li>
                            <li><a class="dropdown-item small" href="<?php echo $seller_geo_zone; ?>"><?php echo lang('Text.geo_zones'); ?></a></li>
                            <li><a class="dropdown-item small" href="<?php echo $seller_shipping_method; ?>"><?php echo lang('Text.shipping_methods'); ?></a></li>
                            <?php } else { ?>
                            <li><a class="dropdown-item small" href="<?php echo $seller_register; ?>"><?php echo lang('Text.become_a_seller'); ?></a></li>
                            <?php } ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item small" href="<?php echo base_url('marketplace/account/logout'); ?>"><?php echo lang('Text.logout'); ?></a></li>
                            <?php } else { ?>
                            <li><a class="dropdown-item small" href="<?php echo base_url('marketplace/account/login'); ?>"><?php echo lang('Text.login'); ?></a></li>
                            <li><a class="dropdown-item small" href="<?php echo base_url('marketplace/account/register'); ?>"><?php echo lang('Text.register'); ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a id="icon-offcanvas-right" class="nav-link position-relative" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fas fa-shopping-cart fa-fw"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="bg-danger py-1 px-1">
        <a class="btn btn-link btn-sm link-light text-decoration-none" data-bs-toggle="offcanvas" href="#offcanvasLeft" role="button" aria-controls="offcanvasLeft"><i class="fas fa-bars fa-fw"></i> <?php echo lang('Button.all'); ?></a>
    </div>
</div>
<?php echo $offcanvas_left; ?>
<?php echo $offcanvas_right; ?>
<?php if ($breadcrumbs) { ?>
<nav class="small p-3 m-0" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php if ($breadcrumb['active']) { ?>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
            <?php } else { ?>
            <li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>" class="text-decoration-none"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
        <?php } ?>
    </ol>
</nav>
<?php } ?>
<?php if ($error_warning) { ?>
<div class="container">
    <div class="alert alert-warning alert-dismissible border-0 shadow fade show" role="alert">
        <?php echo $error_warning; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<?php } ?>
<?php if ($success) { ?>
<div class="container">
    <div class="alert alert-success alert-dismissible border-0 shadow fade show" role="alert">
        <?php echo $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<?php } ?>
<div class="d-none"><?php echo $routes; ?></div>