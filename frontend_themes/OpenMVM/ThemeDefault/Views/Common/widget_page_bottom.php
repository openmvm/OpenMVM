<?php $page_bottom_widgets = $widget->getLayoutWidgets('frontend', 'page_bottom'); ?>
<?php if ($page_bottom_widgets) { ?>
	<div id="widget-page-bottom">
		<?php foreach ($page_bottom_widgets as $key => $value) { ?>
			<?php echo $value; ?>
		<?php } ?>
	</div>
<?php } ?>
