<?php if (!empty($product_reviews)) { ?>
    <?php foreach ($product_reviews as $product_review) { ?>
    <div class="border-bottom pb-3 mb-3">
        <div><?php echo $product_review['customer']; ?></div>
        <div>
            <div class="d-inline-block me-3">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <?php if ($i <= $product_review['rating']) { ?>
                    <i class="fas fa-star text-danger"></i>
                    <?php } else { ?>
                    <i class="far fa-star text-danger"></i>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="d-inline-block"><strong><?php echo $product_review['title']; ?></strong></div>
        </div>
        <div class="text-secondary small"><?php echo lang('Text.reviewed_on'); ?> <?php echo $product_review['date_modified']; ?></div>
        <?php if (!empty($product_review['product_options'])) { ?>
        <div class="hstack gap-2 text-secondary small">
            <?php $total_product_review_product_options = count($product_review['product_options']); ?>
            <?php foreach ($product_review['product_options'] as $key => $value) { ?>
            <div><?php echo $value['description'][$language_lib->getCurrentId()]['name']; ?>: <?php echo $value['option_value']['description'][$language_lib->getCurrentId()]['name']; ?></div>
                <?php if ($key <= ($total_product_review_product_options - 2)) { ?><div class="vr"></div><?php } ?>
            <?php } ?>
        </div>
        <?php } ?>
        <div class="mt-3"><?php echo $product_review['review']; ?></div>
    </div>
    <?php } ?>
<?php } else { ?>
<div class="text-secondary"><?php echo lang('Text.no_reviews', [], $language_lib->getCurrentCode()); ?></div>
<?php } ?>
