<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo lang('Heading.heading_checkout', array(), $lang->getFrontEndLocale()); ?></h1>
	<div class="row">
		<div class="col-sm-8">
			<div id="widget-payment-address" class="mb-3"></div>
			<div id="widget-shipping-address" class="mb-3"></div>
			<div id="widget-shipping-method" class="mb-3"></div>
			<div id="widget-payment-method" class="mb-3"></div>
		</div>
		<div class="col-sm-4">
			<div id="widget-checkout-cart" class="mb-3"></div>
		</div>
	</div>
</section>
<!-- /.content -->
<script type="text/javascript"><!--
$('#widget-payment-address').load('<?php echo base_url('/order/checkout/widget/payment_address'); ?>');
$('#widget-shipping-address').load('<?php echo base_url('/order/checkout/widget/shipping_address'); ?>');
$('#widget-shipping-method').load('<?php echo base_url('/order/checkout/widget/shipping_method'); ?>');
$('#widget-payment-method').load('<?php echo base_url('/order/checkout/widget/payment_method'); ?>');
$('#widget-checkout-cart').load('<?php echo base_url('/order/checkout/widget/checkout_cart'); ?>');
//--></script> 
<?php echo $footer; ?>
