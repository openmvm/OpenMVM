<?php if ($seller_categories) { ?>
<div id="widget-seller-category-<?php echo $widget; ?>" class="card shadow rounded-0 mb-3">
    <div class="card-body">
        <div class="lead mb-3"><?php echo lang('Text.categories', [], $language_lib->getCurrentCode()); ?></div>
		<?php if ($display == 'grid') { ?>
			<?php $seller_categories = array_chunk($seller_categories, $column); ?>
			<?php $column_width = 12 / $column; ?>
			<?php foreach ($seller_categories as $seller_category) { ?>
				<div class="row g-3 mb-3">
				<?php foreach ($seller_category as $cat) { ?>
					<div class="col-sm-<?php echo $column_width; ?> d-flex">
						<div class="card w-100">
							<div class="card-body">
								<h4 class="mb-3"><a href="<?php echo $cat['href']; ?>" class="link-dark text-decoration-none"><strong><?php echo $cat['name']; ?></strong></a></h4>
								<div class="d-flex align-items-center"><a href="<?php echo $cat['href']; ?>"><img src="<?php echo $cat['image']; ?>" alt="<?php echo $cat['name']; ?>" title="<?php echo $cat['name']; ?>" class="img-fluid mx-auto d-block" /></a></div>
								<div class="mt-3"><a href="<?php echo $cat['href']; ?>" title="<?php echo $cat['name']; ?>" class="text-decoration-none"><?php echo lang('Text.shop_now', [], $language_lib->getCurrentCode()); ?></a></div>
							</div>
						</div>
					</div>
				<?php } ?>
				</div>
			<?php } ?>
		<?php } elseif ($display == 'list') { ?>
		<?php } ?>
    </div>
</div>
<?php } ?>