<?php $page_top_widgets = $widget->getLayoutWidgets('frontend', 'page_top'); ?>
<?php if ($page_top_widgets) { ?>
	<div id="widget-page-top">
		<?php foreach ($page_top_widgets as $key => $value) { ?>
			<?php echo $value; ?>
		<?php } ?>
	</div>
<?php } ?>
