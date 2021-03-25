<?php
	$pager->setSurroundCount(2);
?>

<nav aria-label="<?php lang('Pager.pageNavigation') ?>">
	<ul class="pagination">
		<?php if ($pager->hasPrevious()) { ?>
			<?php $parse_first = parse_url($pager->getFirst()); ?>
			<li class="page-item">
				<a href="<?php echo base_url(uri_string()) . '?' . $parse_first['query']; ?>" class="page-link" aria-label="<?php echo lang('Pager.first'); ?>">
					<span aria-hidden="true"><?php echo lang('Pager.first'); ?></span>
				</a>
			</li>
			<?php $parse_previous = parse_url($pager->getPrevious()); ?>
			<li class="page-item">
				<a href="<?php echo base_url(uri_string()) . '?' . $parse_previous['query']; ?>" class="page-link" aria-label="<?php echo lang('Pager.previous'); ?>">
					<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
		<?php } ?>

		<?php foreach ($pager->links() as $link) { ?>
			<?php $parse_link = parse_url($link['uri']); ?>
			<li <?php if ($link['active']) { ?>class="page-item active"<?php } ?>>
				<a href="<?php echo base_url(uri_string()) . '?' . $parse_link['query']; ?>" class="page-link">
					<?php echo $link['title']; ?>
				</a>
			</li>
		<?php } ?>

		<?php if ($pager->hasNext()) { ?>
			<?php $parse_next = parse_url($pager->getNext()); ?>
			<li class="page-item">
				<a href="<?php echo base_url(uri_string()) . '?' . $parse_next['query']; ?>" class="page-link" aria-label="<?php echo lang('Pager.next'); ?>">
					<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
			<?php $parse_last = parse_url($pager->getLast()); ?>
			<li class="page-item">
				<a href="<?php echo base_url(uri_string()) . '?' . $parse_last['query']; ?>" class="page-link" aria-label="<?php echo lang('Pager.last'); ?>">
					<span aria-hidden="true"><?php echo lang('Pager.last'); ?></span>
				</a>
			</li>
		<?php } ?>
	</ul>
</nav>
