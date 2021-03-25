<?php $content_bottom_widgets = $widget->getLayoutWidgets('frontend', 'content_bottom'); ?>
<?php if ($content_bottom_widgets) { ?>
	<div id="widget-content-bottom">
		<?php foreach ($content_bottom_widgets as $key => $value) { ?>
			<?php echo $value; ?>
		<?php } ?>
	</div>
<?php } ?>
