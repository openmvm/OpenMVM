<?php echo $header; ?>
<div class="container-fluid">
    <div id="content" class="content">
        <h1><?php echo $heading_title; ?></h1>
        <div class="border-bottom pb-3 mb-3"><?php echo $description; ?></div>
        <div>
            <?php if ($products) { ?>
            <div class="row g-3">
                <?php foreach ($products as $product) { ?>
                <div class="col-sm-3 d-flex">
                    <div class="card">
                        <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                        <div class="card-body">
                            <a href="<?php echo $product['href']; ?>" class="card-title" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
                            <div class="my-3"><?php echo $product['price']; ?></div>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="<?php echo $product['href']; ?>" class="btn btn-primary"><?php echo lang('Button.details'); ?></a>
                        </div>
                    </div>                
                </div>
                <?php } ?>
            </div>
            <?php } else { ?>
            <div class="text-secondary text-center my-5"><?php echo lang('Error.no_data_found'); ?></div>
            <?php } ?>
        </div>
    </div>
</div>
<?php echo $footer; ?>