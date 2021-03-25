<?php $widget_end_widgets = $widget->getLayoutWidgets('frontend', 'widget_end'); ?>
<?php if ($widget_end_widgets) { ?>
	<?php $check_widget_end = true; ?>
	<div id="widget-widget-end" class="col-sm-3">
		<?php foreach ($widget_end_widgets as $key => $value) { ?>
			<?php echo $value; ?>
		<?php } ?>
	</div>
<?php } ?>
