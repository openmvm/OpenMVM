<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container">
    <a class="navbar-brand" href="<?php echo base_url(); ?>"><i class="fas fa-home"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if ($categories) { ?>
        	<?php foreach ($categories as $category) { ?>
        		<?php if ($category['children']) { ?>
		        <li class="nav-item dropdown">
		          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown<?php echo $category['category_id']; ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
		            <?php echo $category['name']; ?>
		          </a>
		          <ul class="dropdown-menu" aria-labelledby="navbarDropdown<?php echo $category['category_id']; ?>">
		          	<?php foreach ($category['children'] as $child) { ?>
		            <li><a class="dropdown-item" href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
		          	<?php } ?>
							  <li><hr class="dropdown-divider"></li>
							  <li><a class="dropdown-item" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
		          </ul>
		        </li>
        		<?php } else { ?>
		        <li class="nav-item">
		          <a class="nav-link" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
		        </li>
        		<?php } ?>
        	<?php } ?>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>