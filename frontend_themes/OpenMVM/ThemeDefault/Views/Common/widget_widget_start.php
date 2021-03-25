<?php $widget_start_widgets = $widget->getLayoutWidgets('frontend', 'widget_start'); ?>
<?php if ($widget_start_widgets) { ?>
	<?php $check_widget_start = true; ?>
	<div id="widget-widget-start" class="col-sm-3">
		<?php foreach ($widget_start_widgets as $key => $value) { ?>
			<?php echo $value; ?>
		<?php } ?>
	</div>
<?php } ?>
