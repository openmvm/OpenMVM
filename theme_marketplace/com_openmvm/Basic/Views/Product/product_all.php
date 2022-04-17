<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php foreach ($categories as $category) { ?>
            <div><a href="<?php echo $category['href']; ?>"><?php echo $category['category_path']; ?></a></div>
        <?php } ?>
    </div>
</div>
<?php echo $footer; ?>
