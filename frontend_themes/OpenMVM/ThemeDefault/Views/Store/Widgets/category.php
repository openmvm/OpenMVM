<?php if ($categories) { ?>
	<?php if ($orientation == 'horizontal') { ?>
		<div class="card card-body border-0 mb-3">
			<h6 class="text-uppercase mb-3"><?php echo lang('Text.text_categories', array(), $lang->getFrontEndLocale()); ?></h6>
			<div class="row g-1">
				<?php foreach ($categories as $category) { ?>
					<div class="col-sm-1" style="display: flex; align-items: stretch;">
						<div class="border rounded small bg-white p-1">
							<div><a href="<?php echo $category['href']; ?>"><img src="<?php echo $category['thumb']; ?>" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>" class="img-fluid" /></a></div>
							<div class="text-center small"><a href="<?php echo $category['href']; ?>" class="link-danger text-decoration-none"><?php echo $category['name']; ?></a></div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } else { ?>
	<div class="card">
	  <div class="card-header">
	    <div class="text-uppercase my-2"><?php echo lang('Text.text_categories', array(), $lang->getFrontEndLocale()); ?></div>
	  </div>
		<div class="list-group list-group-flush small">
			<?php foreach ($categories as $category) { ?>
				<?php if ($category['category_id'] == $category_id) { ?>
		  	<a href="<?php echo $category['href']; ?>" class="list-group-item list-group-item-action active"><strong><?php echo $category['name']; ?></strong></a>
		  		<?php if ($category['children']) { ?>
		  			<?php foreach ($category['children'] as $child) { ?>
		  				<?php if ($child['category_id'] == $child_id) { ?>
		  					<a href="<?php echo $child['href']; ?>" class="list-group-item list-group-item-action ps-4"><i class="fas fa-angle-right"></i> <strong><?php echo $child['name']; ?></strong></a>
	  					<?php } else { ?>
		  					<a href="<?php echo $child['href']; ?>" class="list-group-item list-group-item-action ps-4"><i class="fas fa-angle-right"></i> <?php echo $child['name']; ?></a>
	  					<?php } ?>
		  			<?php } ?>
		  		<?php } ?>
		  	<?php } else { ?>
		  	<a href="<?php echo $category['href']; ?>" class="list-group-item list-group-item-action"><?php echo $category['name']; ?></a>
		  	<?php } ?>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
<?php } ?>
