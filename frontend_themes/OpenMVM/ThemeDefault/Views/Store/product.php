<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<div class="card bg-white mb-3">
	  <div class="card-body">
	    <div class="row">
	    	<div class="col-sm-5">
	    		<div>
	    			<div class="border border-secondary"><img src="<?php echo $image; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" /></div>
	    		</div>
	    	</div>
	    	<div class="col-sm-7">
	    		<div id="product">
	    			<div class="product-name mb-5"><h4><?php echo $heading_title; ?></h4></div>
	    			<div class="product-price mb-5"><h2 class="text-danger"><?php echo $price; ?></h2></div>
	    			<div class="product-quantity">
	    				<div class="row">
	    					<div class="col-sm-4">
									<div class="input-group mb-3">
									  <button class="btn btn-outline-secondary minus" type="button" id="button-addon2"><i class="fas fa-minus"></i></button>
									  <input type="number" min="1" step="1" name="quantity" value="1" class="form-control value" aria-label="Amount (to the nearest dollar)">
									  <button class="btn btn-outline-secondary plus" type="button" id="button-addon2"><i class="fas fa-plus"></i></button>
									</div>	    				
	    					</div>
	    				</div>
	    			</div>
	    			<div class="product-add-to-cart">
	    				<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
	    				<input type="hidden" name="store_id" value="<?php echo $store_id; ?>" />
	    				<button type="button" class="btn btn-outline-primary" id="button-cart"><i class="fas fa-shopping-cart"></i> <?php echo lang('Button.button_add_to_cart', array(), $lang->getFrontEndLocale()); ?></button>
	    			</div>
	    		</div>
	    	</div>
	    </div>
	  </div>
	</div>	
	<div class="card card-body mb-3">
		<div class="store clearfix">
			<div class="logo float-start me-3"><img src="<?php echo $logo; ?>" alt="<?php echo $store_name; ?>" title="<?php echo $store_name; ?>" /></div>
			<div class="name float-start"><strong><?php echo $store_name; ?></strong></div>
		</div>
	</div>
	<div class="card card-body mb-3">
		<h5 class="mb-3"><?php echo lang('Text.text_product_description', array(), $lang->getFrontEndLocale()); ?></h5>
		<div><?php echo $description; ?></div>
	</div>
</section>
<!-- /.content -->
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
	$.ajax({
		url: '<?php echo base_url('/cart/add'); ?>',
		type: 'post',
		data: $('#product input[type=\'number\'], #product input[type=\'hidden\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert-dismissible, .product-add-to-cart .text-danger').remove();

			if (json['success']) {
				$('#breadcrumb').after('<section id="notification" class="container notification px-3"><div class="alert alert-success alert-dismissible" role="alert">' + json['success'] + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></section>');

				$('#widget-cart span#total-item').html(json['total_item']);
				$('#widget-cart span#total-value').html(json['total_value']);

				$('html, body').animate({ scrollTop: 0 }, 'slow');

				$('#widget-cart .dropdown-menu').load('<?php echo base_url('/widget/cart/info'); ?> #widget-cart-content');
			}
		},
    error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
	});
});
//--></script> 
<?php echo $footer; ?>
