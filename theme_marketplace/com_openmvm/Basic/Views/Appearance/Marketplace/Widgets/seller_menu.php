<div id="widget-seller-menu-<?php echo $widget; ?>" class="mb-3">
	<div class="lead pb-2 mb-3 border-bottom border-secondary"><?php echo lang('Text.seller_menu', [], $language_lib->getCurrentCode()); ?></div>
	<div class="list-group shadow rounded-0">
		<a href="<?php echo $url_seller_dashboard; ?>" class="list-group-item list-group-item-action" aria-current="true"><?php echo lang('Text.seller_dashboard', [], $language_lib->getCurrentCode()); ?></a>
		<a href="<?php echo $url_seller_edit; ?>" class="list-group-item list-group-item-action" aria-current="true"><?php echo lang('Text.seller_edit', [], $language_lib->getCurrentCode()); ?></a>
		<a href="<?php echo $url_seller_category; ?>" class="list-group-item list-group-item-action" aria-current="true"><?php echo lang('Text.categories', [], $language_lib->getCurrentCode()); ?></a>
		<a href="<?php echo $url_seller_product; ?>" class="list-group-item list-group-item-action" aria-current="true"><?php echo lang('Text.products', [], $language_lib->getCurrentCode()); ?></a>
		<a href="<?php echo $url_seller_option; ?>" class="list-group-item list-group-item-action" aria-current="true"><?php echo lang('Text.options', [], $language_lib->getCurrentCode()); ?></a>
		<a href="<?php echo $url_seller_order; ?>" class="list-group-item list-group-item-action" aria-current="true"><?php echo lang('Text.orders', [], $language_lib->getCurrentCode()); ?></a>
		<a href="<?php echo $url_seller_product_question; ?>" class="list-group-item list-group-item-action" aria-current="true"><?php echo lang('Text.questions', [], $language_lib->getCurrentCode()); ?></a>
		<a href="<?php echo $url_seller_localisation_geo_zone; ?>" class="list-group-item list-group-item-action" aria-current="true"><?php echo lang('Text.geo_zones', [], $language_lib->getCurrentCode()); ?></a>
		<a href="<?php echo $url_seller_component_shipping_method; ?>" class="list-group-item list-group-item-action" aria-current="true"><?php echo lang('Text.shipping_methods', [], $language_lib->getCurrentCode()); ?></a>
	</div>	
</div>
