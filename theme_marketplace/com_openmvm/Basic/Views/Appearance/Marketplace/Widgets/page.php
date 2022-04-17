<?php if ($pages) { ?>
<div id="widget-page-<?php echo $widget; ?>">
	<div class="title mb-3"><?php echo $title; ?></div>
	<ul class="list-unstyled">
		<?php foreach ($pages as $page) { ?>
		<li><a href="<?php echo $page['href']; ?>"<?php if ($page['target'] == 'new') { ?> target="_blank"<?php } ?>><?php echo $page['title']; ?></a></li>
		<?php } ?>
	</ul>
</div>
<?php } ?>
