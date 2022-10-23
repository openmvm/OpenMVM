<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-product-review']); ?>
        <fieldset>
            <input type="hidden" name="product_review_id" value="<?php echo $product_review_id; ?>" />
            <input type="hidden" name="order_product_id" value="<?php echo $order_product_id; ?>" />
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
            <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>" />
            <div class="mb-3 required">
                <label for="input-rating" class="form-label"><?php echo lang('Entry.rating', [], $language_lib->getCurrentCode()); ?></label>
                <div id="input-rating">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rating" id="input-rating-1" value="1"<?php if ($rating == 1) { ?> checked<?php } ?>>
                        <label class="form-check-label" for="input-rating-1">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rating" id="input-rating-2" value="2"<?php if ($rating == 2) { ?> checked<?php } ?>>
                        <label class="form-check-label" for="input-rating-2">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rating" id="input-rating-3" value="3"<?php if ($rating == 3) { ?> checked<?php } ?>>
                        <label class="form-check-label" for="input-rating-3">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rating" id="input-rating-4" value="4"<?php if ($rating == 4) { ?> checked<?php } ?>>
                        <label class="form-check-label" for="input-rating-4">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rating" id="input-rating-5" value="5"<?php if ($rating == 5) { ?> checked<?php } ?>>
                        <label class="form-check-label" for="input-rating-5">5</label>
                    </div>
                </div>
            </div>
            <div class="mb-3 required">
                <label for="input-title" class="form-label"><?php echo lang('Entry.title', [], $language_lib->getCurrentCode()); ?></label>
                <input type="text" name="title" value="<?php echo $title; ?>" id="input-title" class="form-control" placeholder="<?php echo lang('Entry.title', [], $language_lib->getCurrentCode()); ?>">
            </div>
            <div class="mb-3 required">
                <label for="input-review" class="form-label"><?php echo lang('Entry.review', [], $language_lib->getCurrentCode()); ?></label>
                <textarea name="review" id="input-review" class="form-control" placeholder="<?php echo lang('Entry.review', [], $language_lib->getCurrentCode()); ?>" rows="5"><?php echo $review; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="input-status" class="form-label"><?php echo lang('Entry.status', [], $language_lib->getCurrentCode()); ?></label>
                <select name="status" id="input-status" class="form-select">
                    <?php if ($status) { ?>
                    <option value="0"><?php echo lang('Text.disabled', [], $language_lib->getCurrentCode()); ?></option>
                    <option value="1" selected="selected"><?php echo lang('Text.enabled', [], $language_lib->getCurrentCode()); ?></option>
                    <?php } else { ?>
                    <option value="0" selected="selected"><?php echo lang('Text.disabled', [], $language_lib->getCurrentCode()); ?></option>
                    <option value="1"><?php echo lang('Text.enabled', [], $language_lib->getCurrentCode()); ?></option>
                    <?php } ?>
                </select>
            </div>
        </fieldset>
        <div class="buttons clearfix">
            <div class="float-end">
                <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-product-review" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], $language_lib->getCurrentCode()); ?></span></button>
                <button type="button" class="btn btn-sm btn-success button-action" data-form="form-product-review" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], $language_lib->getCurrentCode()); ?></span></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>
