<?php echo $header; ?>
<!-- Content -->
<?php $widget_start_widgets = $widget->getLayoutWidgets('frontend', 'widget_start'); ?>
<?php $widget_end_widgets = $widget->getLayoutWidgets('frontend', 'widget_end'); ?>
<section class="container content mt-3">
	<?php echo $template->render('FrontendThemes', 'Common\widget_page_top', array('widget' => $widget)); ?>
	<div class="row">
		<?php if ($widget_start_widgets && $widget_end_widgets) { ?>
			<?php $class = 'col-sm-6'; ?>
		<?php } elseif ($widget_start_widgets || $widget_end_widgets) { ?>
			<?php $class = 'col-sm-9'; ?>
		<?php } else { ?>
			<?php $class = 'col-sm-12'; ?>
		<?php } ?>

		<?php echo $template->render('FrontendThemes', 'Common\widget_widget_start', array('widget' => $widget)); ?>

		<div class="<?php echo $class; ?>">
			<?php echo $template->render('FrontendThemes', 'Common\widget_content_top', array('widget' => $widget)); ?>

			<!-- Main Content -->
			<div id="main-content" class="main-content">
				<!-- Product -->
				<section id="product" class="product">
					<?php if ($products) { ?>
					<div class="row g-3">
						<?php foreach ($products as $product) { ?>
						<div class="col-sm-2" style="display: flex; align-items: stretch;">
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
					<div id="pagination" class="mt-3">
						<div class="clearfix"><div class="float-end"><?php echo $pager; ?></div></div>
						<div class="clearfix"><div class="text-secondary small float-end"><?php echo $pagination; ?></div></div>
					</div>
					<?php } ?>
				</section>
				<!-- /.product -->
			</div>
			<!-- /.main-content -->

			<?php echo $template->render('FrontendThemes', 'Common\widget_content_bottom', array('widget' => $widget)); ?>
		</div>

		<?php echo $template->render('FrontendThemes', 'Common\widget_widget_end', array('widget' => $widget)); ?>
	</div>
	<?php echo $template->render('FrontendThemes', 'Common\widget_page_bottom', array('widget' => $widget)); ?>
</section>
<!-- /.content -->
<?php echo $footer; ?>
