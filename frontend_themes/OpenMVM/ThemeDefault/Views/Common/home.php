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
				<?php if ($debug) { ?>
				<div class="card card-body"><?php echo $debug; ?></div>
				<?php } ?>
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
