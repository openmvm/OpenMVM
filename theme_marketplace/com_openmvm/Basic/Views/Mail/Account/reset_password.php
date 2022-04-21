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
</head>
<body class="bg-light">
	<p><?php echo $greeting; ?></p>
	<p><?php echo $header; ?></p>
	<p style="text-align: center;"><a href="<?php echo $link; ?>"><?php echo lang('Button.reset_password'); ?></a></p>
	<p><?php echo $footer; ?></p>
	<p><?php echo lang('Mail.reset_password_thank_you'); ?><br /><?php echo sprintf(lang('Mail.reset_password_thank_you_from'), $marketplace_name); ?></p>
</body>
</html>