<div id="widget-cart" class="widget-cart">
	<div class="dropdown d-grid gap-2">
	  <button class="btn btn-outline-warning dropdown-toggle text-lowercase" type="button" id="dropdownShoppingCart" data-bs-toggle="dropdown" aria-expanded="false">
	    <i class="fas fa-shopping-cart"></i> <span id="total-item"><?php echo $total_item; ?></span> <?php echo lang('Text.text_items', array(), $lang->getFrontEndLocale()); ?> <span id="total-value"><?php echo $total_value; ?></span>
	  </button>
	  <div class="dropdown-menu p-3" aria-labelledby="dropdownShoppingCart">
	    <div id="widget-cart-content" class="small">
	    	<?php if ($stores) { ?>
	  			<h5><?php echo lang('Text.text_your_cart', array(), $lang->getFrontEndLocale()); ?></h5>
	    		<?php foreach ($stores as $store) { ?>
    			<div class="border-top border-danger pt-3 mb-3">
    				<div class="bg-light p-2"><img src="<?php echo $store['thumb']; ?>" alt="<?php echo $store['name']; ?>" title="<?php echo $store['name']; ?>" /> <?php echo $store['name']; ?></div>
    				<div class="mb-3">
    					<table class="table table-hover">
    						<?php foreach ($store['products'] as $product) { ?>
    						<tr>
    							<td class="ps-2"><img src="<?php echo $product['thumb']; ?>" class="border border-secondary" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></td>
    							<td class="small">
    								<div><?php echo $product['name']; ?></div>
    								<div><?php echo $product['quantity']; ?> X <?php echo $product['price']; ?></div>
  								</td>
  								<td class="text-end small">
  									<div><?php echo $product['total']; ?></div>
  								</td>
    						</tr>
    						<?php } ?>
    					</table>
    					<table class="table table-hover">
    						<?php foreach ($store['totals'] as $total) { ?>
    						<tr>
  								<td class="small">
  									<div><?php echo $total['title']; ?></div>
  								</td>
  								<td class="text-end small">
  									<div><?php echo $total['text']; ?></div>
  								</td>
    						</tr>
    						<?php } ?>
    					</table>
    				</div>
						<?php echo form_open_multipart(base_url('/checkout/' . $user_token), 'id="form-checkout' . $store['store_id'] . '"'); ?>
						<input type="hidden" name="checkout_store_id" value="<?php echo $store['store_id']; ?>" />
			  		<div class="d-grid gap-2">
			  			<button type="submit" class="btn btn-primary btn-sm"><?php echo lang('Button.button_checkout', array(), $lang->getFrontEndLocale()); ?></button>
			  		</div>
						<?php echo form_close(); ?>
    			</div>
	    		<?php } ?>
		    	<hr />
					<table class="table table-hover">
						<tr>
							<td>
								<div><strong><?php echo lang('Text.text_total', array(), $lang->getFrontEndLocale()); ?></strong></div>
							</td>
							<td class="text-end">
								<div><strong><?php echo $total_value; ?></strong></div>
							</td>
						</tr>
					</table>
					<?php echo form_open_multipart(base_url('/checkout/' . $user_token), 'id="form-checkout-all"'); ?>
		  		<div class="d-grid gap-2">
					  <button type="submit" class="btn btn-success btn-sm"><?php echo lang('Button.button_checkout_all', array(), $lang->getFrontEndLocale()); ?></button>
		  			<a href="<?php echo base_url('/cart'); ?>" class="btn btn-danger btn-sm"><?php echo lang('Button.button_shopping_cart', array(), $lang->getFrontEndLocale()); ?></a>
		  		</div>
					<?php echo form_close(); ?>
    		<?php } else { ?>
    			<?php echo lang('Text.text_empty_shopping_cart', array(), $lang->getFrontEndLocale()); ?>
    		<?php } ?>
		    </div>
	  </div>
	</div>
</div>
