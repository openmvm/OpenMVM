<h6 class="text-uppercase mb-3"><?php echo lang('Text.text_latest_products', array(), $lang->getFrontEndLocale()); ?></h6>
<?php if ($products) { ?>
<div class="row g-3">
	<?php foreach ($products as $product) { ?>
	<div class="col-sm-3" style="display: flex; align-items: stretch;">
		<div id="product-container" class="card">
			<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
			<div class="card-body small">
				<div class="card-title"><a href="<?php echo $product['href']; ?>" class="link-danger text-decoration-none"><?php echo $product['name']; ?></a></div>
				<div class="card-text"><?php echo $product['price']; ?></div>
		  	<div class="text-secondary small my-2"><i class="fas fa-store"></i> <?php echo $product['store']; ?></div>
			</div>
		  <div class="card-footer text-center d-none">
				<div class="btn-group btn-group-sm" role="group" aria-label="Basic mixed styles example">
				  <button type="button" class="btn btn-outline-secondary"><i class="fas fa-shopping-cart"></i> <small><?php echo lang('Button.button_add_to_cart', array(), $lang->getFrontEndLocale()); ?></small></button>
				  <button type="button" class="btn btn-outline-secondary"><i class="fas fa-heart"></i></button>
				  <button type="button" class="btn btn-outline-secondary"><i class="fas fa-sync"></i></button>
				</div>
		  </div>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>
