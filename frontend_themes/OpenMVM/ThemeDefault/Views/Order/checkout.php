<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo lang('Heading.heading_checkout', array(), $lang->getFrontEndLocale()); ?></h1>
	<div class="row">
		<div class="col-sm-8">
			<div class="accordion mb-3" id="accordionPaymentAddress">
			  <div class="accordion-item">
			    <h2 class="accordion-header" id="headingPaymentAddress">
			      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePaymentAddress" aria-expanded="true" aria-controls="collapsePaymentAddress">
			        <?php echo lang('Text.text_payment_address', array(), $lang->getFrontEndLocale()); ?>
			      </button>
			    </h2>
			    <div id="collapsePaymentAddress" class="accordion-collapse collapse show" aria-labelledby="headingPaymentAddress" data-bs-parent="#accordionPaymentAddress">
			      <div class="accordion-body">
			       <div id="widget-payment-address"></div>
			      </div>
			    </div>
			  </div>
			</div>
			<div class="accordion mb-3" id="accordionShippingAddress">
			  <div class="accordion-item">
			    <h2 class="accordion-header" id="headingShippingAddress">
			      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShippingAddress" aria-expanded="true" aria-controls="collapseShippingAddress">
			        <?php echo lang('Text.text_shipping_address', array(), $lang->getFrontEndLocale()); ?>
			      </button>
			    </h2>
			    <div id="collapseShippingAddress" class="accordion-collapse collapse show" aria-labelledby="headingShippingAddress" data-bs-parent="#accordionShippingAddress">
			      <div class="accordion-body">
							<div id="widget-shipping-address"></div>
			      </div>
			    </div>
			  </div>
			</div>
			<div class="accordion mb-3" id="accordionShippingMethod">
			  <div class="accordion-item">
			    <h2 class="accordion-header" id="headingShippingMethod">
			      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShippingMethod" aria-expanded="true" aria-controls="collapseShippingMethod">
			        <?php echo lang('Text.text_shipping_method', array(), $lang->getFrontEndLocale()); ?>
			      </button>
			    </h2>
			    <div id="collapseShippingMethod" class="accordion-collapse collapse show" aria-labelledby="headingShippingMethod" data-bs-parent="#accordionShippingMethod">
			      <div class="accordion-body">
							<div id="widget-shipping-method"></div>
							<div id="widget-shipping-method-spinner-container" class="h1 text-center d-none"><i class="fas fa-spinner fa-spin"></i></div>
			      </div>
			    </div>
			  </div>
			</div>
			<div class="accordion mb-3" id="accordionPaymentMethod">
			  <div class="accordion-item">
			    <h2 class="accordion-header" id="headingPaymentMethod">
			      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePaymentMethod" aria-expanded="true" aria-controls="collapsePaymentMethod">
			        <?php echo lang('Text.text_payment_method', array(), $lang->getFrontEndLocale()); ?>
			      </button>
			    </h2>
			    <div id="collapsePaymentMethod" class="accordion-collapse collapse show" aria-labelledby="headingPaymentMethod" data-bs-parent="#accordionPaymentMethod">
			      <div class="accordion-body">
							<div id="widget-payment-method"></div>
							<div id="widget-payment-method-spinner-container" class="h1 text-center d-none"><i class="fas fa-spinner fa-spin"></i></div>
			      </div>
			    </div>
			  </div>
			</div>
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
