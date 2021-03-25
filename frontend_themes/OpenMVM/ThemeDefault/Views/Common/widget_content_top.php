<?php $content_top_widgets = $widget->getLayoutWidgets('frontend', 'content_top'); ?>
<?php if ($content_top_widgets) { ?>
	<div id="widget-content-top">
		<?php foreach ($content_top_widgets as $key => $value) { ?>
			<?php echo $value; ?>
		<?php } ?>
	</div>
<?php } ?>
