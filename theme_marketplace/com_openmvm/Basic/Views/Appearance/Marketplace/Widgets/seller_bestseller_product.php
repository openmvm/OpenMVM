<?php if (!empty($products)) { ?>
<div id="widget-seller-bestseller-product-<?php echo $widget; ?>" class="card shadow rounded-0 mb-3">
    <div class="card-body">
        <div class="lead mb-3"><?php echo lang('Text.bestseller_products', [], $language_lib->getCurrentCode()); ?></div>
        <div class="row g-3">
            <?php foreach ($products as $product) { ?>
            <div class="col-sm-3 d-flex">
                <div class="card w-100">
                    <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                    <div class="card-body">
                        <a href="<?php echo $product['href']; ?>" class="card-title" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
                        <div class="my-3">
                            <?php if (!empty($product['product_option'])) { ?>
                                <?php if (!empty($product['product_variant_special'])) { ?>
                                <div><span class="text-secondary me-2"><s><?php echo $product['min_price']; ?></s> - <s><?php echo $product['max_price']; ?></s></span><span><?php echo $product['special_min_price']; ?> - <?php echo $product['special_max_price']; ?></span></div>
                                <?php } else { ?>
                                <div><?php echo $product['min_price']; ?> - <?php echo $product['max_price']; ?></div>
                                <?php } ?>
                            <?php } else { ?>
                            <div><?php if ($product['special']) { ?><s class="text-secondary me-2"><?php echo $product['price']; ?></s><?php echo $product['special']; ?><?php } else { ?><?php echo $product['price']; ?><?php } ?></div>
                            <?php } ?>
                        </div>
                        <a href="<?php echo $product['href']; ?>" class="btn btn-primary"><?php echo lang('Button.details', [], $language_lib->getCurrentCode()); ?></a>
                    </div>
                </div>                
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>
