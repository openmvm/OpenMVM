<div id="widget-link-<?php echo $widget; ?>">
	<?php if (!empty($title)) { ?>
	<h4 class="mb-3"><?php echo $title; ?></h4>
	<?php } ?>
	<?php if ($links) { ?>
		<?php foreach ($links as $link) { ?>
			<?php if (!empty($link['url'])) { ?>
			<div class="mb-2"><a href="<?php echo $link['url']; ?>" class="text-decoration-none link-light"<?php if ($link['target'] == 'new') { ?> target="_blank"<?php } ?>><?php echo $link['text']; ?></a></div>
			<?php } else { ?>
			<div class="mb-2"><?php echo $link['text']; ?></div>
			<?php } ?>
		<?php } ?>
	<?php } ?>
</div>