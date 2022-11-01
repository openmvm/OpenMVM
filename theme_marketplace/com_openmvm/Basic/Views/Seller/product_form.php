<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-product']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-product" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], $language_lib->getCurrentCode()); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-product" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], $language_lib->getCurrentCode()); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <fieldset>
                    <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.general', [], $language_lib->getCurrentCode()); ?></legend>
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
                    <div class="mb-3">
                        <label for="input-category" class="form-label"><?php echo lang('Entry.category', [], $language_lib->getCurrentCode()); ?></label>
                        <select name="category_id_path" class="form-select" id="input-category">
                            <?php foreach ($categories as $category) { ?>
                                <?php if ($category['category_id_path'] == $category_id_path) { ?>
                                <option value="<?php echo $category['category_id_path']; ?>" selected="selected"><?php echo $category['category_path']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $category['category_id_path']; ?>"><?php echo $category['category_path']; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <ul class="nav nav-tabs mb-3" id="product-description-tab" role="tablist">
                        <?php foreach ($languages as $language) { ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="language-<?php echo $language['language_id']; ?>-product-description-tab" data-bs-toggle="tab" data-bs-target="#language-<?php echo $language['language_id']; ?>-product-description-content" type="button" role="tab" aria-controls="language-<?php echo $language['language_id']; ?>-product-description-content" aria-selected="false"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /> <?php echo $language['name']; ?></button>
                        </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <?php foreach ($languages as $language) { ?>
                        <div class="tab-pane fade" id="language-<?php echo $language['language_id']; ?>-product-description-content" role="tabpanel" aria-labelledby="language-<?php echo $language['language_id']; ?>-product-description-tab">
                            <div class="mb-3 required">
                                <label for="input-product-description-name-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.name', [], $language_lib->getCurrentCode()); ?></label>
                                <input type="text" name="product_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($product_description[$language['language_id']]['name']) ? htmlentities($product_description[$language['language_id']]['name']) : ''; ?>" id="input-product-description-name-language-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.name', [], $language_lib->getCurrentCode()); ?>" />
                                <?php if (!empty($error_product_description[$language['language_id']]['name'])) { ?><div class="text-danger small"><?php echo $error_product_description[$language['language_id']]['name']; ?></div><?php } ?>
                            </div>
                            <div class="mb-3 required">
                                <label for="input-product-description-description-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.description', [], $language_lib->getCurrentCode()); ?></label>
                                <textarea name="product_description[<?php echo $language['language_id']; ?>][description]" id="input-product-description-description-language-<?php echo $language['language_id']; ?>" class="form-control editor" placeholder="<?php echo lang('Entry.description', [], $language_lib->getCurrentCode()); ?>"><?php echo isset($product_description[$language['language_id']]['description']) ? htmlentities($product_description[$language['language_id']]['description']) : ''; ?></textarea>
                                <?php if (!empty($error_product_description[$language['language_id']]['description'])) { ?><div class="text-danger small"><?php echo $error_product_description[$language['language_id']]['description']; ?></div><?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="input-product-description-meta-title-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.meta_title', [], $language_lib->getCurrentCode()); ?></label>
                                <input type="text" name="product_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($product_description[$language['language_id']]['meta_title']) ? htmlentities($product_description[$language['language_id']]['meta_title']) : ''; ?>" id="input-product-description-meta-title-language-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.meta_title', [], $language_lib->getCurrentCode()); ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="input-product-description-meta-description-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.meta_description', [], $language_lib->getCurrentCode()); ?></label>
                                <textarea rows="5" name="product_description[<?php echo $language['language_id']; ?>][meta_description]" id="input-product-description-meta-description-language-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.meta_description', [], $language_lib->getCurrentCode()); ?>"><?php echo isset($product_description[$language['language_id']]['meta_description']) ? htmlentities($product_description[$language['language_id']]['meta_description']) : ''; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="input-product-description-meta-keywords-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.meta_keywords', [], $language_lib->getCurrentCode()); ?></label>
                                <input type="text" name="product_description[<?php echo $language['language_id']; ?>][meta_keywords]" value="<?php echo isset($product_description[$language['language_id']]['meta_keywords']) ? htmlentities($product_description[$language['language_id']]['meta_keywords']) : ''; ?>" id="input-product-description-meta-keywords-language-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.meta_keywords', [], $language_lib->getCurrentCode()); ?>" />
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.product_details', [], $language_lib->getCurrentCode()); ?></legend>
                    <div id="input-is-product-variant-container" class="mb-3">
                        <div class="form-check form-switch">
                            <input name="is_product_variant" class="form-check-input" type="checkbox" role="switch" id="input-is-product-variant"<?php if (!empty($is_product_variant)) { ?> checked<?php } ?>>
                            <label class="form-check-label" for="input-is-product-variant"><?php echo lang('Entry.product_variants', [], $language_lib->getCurrentCode()); ?></label>
                        </div>
                    </div>
                    <div id="product-default"<?php if (!empty($is_product_variant)) { ?> class="d-none"<?php } ?>>
                        <div class="mb-3">
                            <label for="input-sku" class="form-label"><?php echo lang('Entry.sku', [], $language_lib->getCurrentCode()); ?></label>
                            <input type="text" name="sku" value="<?php echo $sku; ?>" class="form-control" id="input-sku" placeholder="<?php echo lang('Entry.sku', [], $language_lib->getCurrentCode()); ?>" aria-label="<?php echo lang('Entry.sku', [], $language_lib->getCurrentCode()); ?>" />
                        </div>
                        <div class="mb-3">
                            <label for="input-price" class="form-label"><?php echo lang('Entry.price', [], $language_lib->getCurrentCode()); ?></label>
                            <div class="input-group">
                                <?php if (!empty($default_currency['symbol_left'])) { ?><span class="input-group-text"><?php echo $default_currency['code']; ?> <?php echo $default_currency['symbol_left']; ?></span><?php } ?>
                                <input type="number" min="0" step="any" name="price" value="<?php echo $price; ?>" class="form-control" id="input-price" placeholder="<?php echo lang('Entry.price', [], $language_lib->getCurrentCode()); ?>" aria-label="<?php echo lang('Entry.price', [], $language_lib->getCurrentCode()); ?>" aria-describedby="input-group-price" />
                                <?php if (!empty($default_currency['symbol_right'])) { ?><span class="input-group-text"><?php echo $default_currency['symbol_right']; ?> <?php echo $default_currency['code']; ?></span><?php } ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="input-quantity" class="form-label"><?php echo lang('Entry.quantity', [], $language_lib->getCurrentCode()); ?></label>
                            <input type="number" min="0" name="quantity" value="<?php echo $quantity; ?>" class="form-control" id="input-quantity" placeholder="<?php echo lang('Entry.quantity', [], $language_lib->getCurrentCode()); ?>" aria-label="<?php echo lang('Entry.quantity', [], $language_lib->getCurrentCode()); ?>" />
                        </div>
                        <div class="mb-3">
                            <div class="form-label"><?php echo lang('Entry.requires_shipping', [], $language_lib->getCurrentCode()); ?></div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="requires_shipping" id="input-requires-shipping-yes" value="1"<?php if ($requires_shipping == 1) { ?> checked<?php } ?>>
                                <label class="form-check-label" for="input-requires-shipping-yes"><?php echo lang('Text.yes', [], $language_lib->getCurrentCode()); ?></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="requires_shipping" id="input-requires-shipping-no" value="0"<?php if ($requires_shipping == 0) { ?> checked<?php } ?>>
                                <label class="form-check-label" for="input-requires-shipping-no"><?php echo lang('Text.no', [], $language_lib->getCurrentCode()); ?></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="input-weight" class="form-label"><?php echo lang('Entry.weight', [], $language_lib->getCurrentCode()); ?></label>
                                    <input type="number" min="0" step="any" name="weight" value="<?php echo $weight; ?>" class="form-control" id="input-weight" placeholder="<?php echo lang('Entry.weight', [], $language_lib->getCurrentCode()); ?>" aria-label="<?php echo lang('Entry.weight', [], $language_lib->getCurrentCode()); ?>" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="input-weight-class" class="form-label"><?php echo lang('Entry.weight_class', [], $language_lib->getCurrentCode()); ?></label>
                                    <select name="weight_class_id" class="form-select" id="input-weight-class">
                                        <?php foreach ($weight_classes as $weight_class) { ?>
                                            <?php if ($weight_class['weight_class_id'] == $weight_class_id) { ?>
                                            <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="product-options" class="<?php if (empty($is_product_variant)) { ?>d-none <?php } ?>mb-3">
                        <?php $product_option_row = 0; ?>
                        <?php if (!empty($product_options)) { ?>
                            <?php foreach ($product_options as $product_option) { ?>
                            <div id="product-option-<?php echo $product_option_row; ?>" class="position-relative bg-light mb-1 p-3">
                                <span role="button" class="text-secondary position-absolute top-0 end-0 small" onclick="removeProductOption('<?php echo $product_option_row; ?>');"><span class="fa-stack" style="font-size: 0.5em;"><i class="fas fa-circle fa-stack-2x text-danger"></i><i class="fas fa-times fa-stack-1x text-light"></i></span></span>
                                <div class="row mb-3">
                                    <div class="col-sm-2"><label for="input-option-<?php echo $product_option_row; ?>" class="form-label"><?php echo lang('Entry.option', [], $language_lib->getCurrentCode()); ?></label></div>
                                    <div class="col-sm-10">
                                       <input type="text" name="product_option[<?php echo $product_option_row; ?>][option]" value="<?php echo $product_option['option']; ?>" id="input-option-<?php echo $product_option_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.option', [], $language_lib->getCurrentCode()); ?>">
                                       <input type="hidden" name="product_option[<?php echo $product_option_row; ?>][option_id]" value="<?php echo $product_option['option_id']; ?>" id="input-option-<?php echo $product_option_row; ?>-id" class="form-control" placeholder="<?php echo lang('Entry.option', [], $language_lib->getCurrentCode()); ?>">

                                        <?php if (!empty($product_option['option_value'])) { ?>
                                        <div id="option-values-<?php echo $product_option_row; ?>" class="card mt-1">
                                            <div class="card-body">
                                                <?php foreach ($product_option['option_value'] as $option_value) { ?>
                                                <input type="checkbox" name="product_option[<?php echo $product_option_row; ?>][option_value][]" value="<?php echo $option_value['option_value_id']; ?>" class="btn-check" id="input-option-value-<?php echo $product_option_row; ?>-<?php echo $product_option['option_id']; ?>-<?php echo $option_value['option_value_id']; ?>" autocomplete="off" onclick="setProductOptions();"<?php if (in_array($option_value['option_value_id'], $product_option['product_option_value'])) { ?> checked<?php } ?>>
                                                <label class="btn btn-outline-primary shadow-none" for="input-option-value-<?php echo $product_option_row; ?>-<?php echo $product_option['option_id']; ?>-<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['description']['name']; ?></label>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                            <?php $product_option_row++; ?>
                            <?php } ?>
                        <?php } ?>
                        <div class="d-grid mb-3"><button type="button" class="btn btn-outline-primary" id="button-option-add" onclick="addProductOption();"><i class="fas fa-plus-circle"></i> <?php echo lang('Button.option_add', [], $language_lib->getCurrentCode()); ?></button></div>
                        <div id="product-variants"></div>
                    </div>
                    <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.images', [], $language_lib->getCurrentCode()); ?></legend>
                    <div class="mb-3">
                        <label for="input-main-image" class="form-label"><?php echo lang('Entry.main_image', [], $language_lib->getCurrentCode()); ?></label>
                        <div><a href="javascript:void(0);" id="upload-main-image" class="position-relative d-table-cell upload"><img src="<?php echo $thumb; ?>" class="border p-1" /><span class="progress-bar"></span><input type="hidden" name="main_image" value="<?php echo $main_image; ?>" id="main-image" class="form-control" /></a></div>
                    </div>
                    <div class="mb-3">
                        <label for="input-additional-images" class="form-label"><?php echo lang('Entry.additional_images', [], $language_lib->getCurrentCode()); ?></label>
                        <div id="additional-images" class="clearfix">
                            <?php $additional_image_row = 0; ?>
                            <?php if (!empty($additional_images)) { ?>
                                <?php foreach ($additional_images as $additional_image) { ?>
                                <div class="position-relative float-start me-1"><a href="javascript:void(0);" id="upload-main-image-<?php echo $additional_image_row; ?>" class="position-relative d-table-cell upload"><img src="<?php echo $additional_image['thumb']; ?>" class="border p-1" /><span class="progress-bar"></span><input type="hidden" name="additional_image[<?php echo $additional_image_row; ?>]" value="<?php echo $additional_image['image']; ?>" id="additional-image-<?php echo $additional_image_row; ?>" class="form-control" /></a><span class="position-absolute top-0 end-0" style="z-index: 999999;" onclick="$(this).parent().remove();"><span class="fa-stack" style="font-size: 0.5em;"><i class="fas fa-circle fa-stack-2x text-danger"></i><i class="fas fa-times fa-stack-1x text-light"></i></span></span></div>
                                <?php $additional_image_row++; ?>
                                <?php } ?>
                            <?php } ?>
                            <div role="button" id="button-upload-additional-image" class="float-start border p-1" onclick="addAdditionalImage();"><div class="d-flex justify-content-center align-items-center text-center bg-light" style="width: 100px; height: 100px;"><i class="fas fa-plus-circle fa-2x text-secondary"></i></div></div>
                        </div>
                    </div>
                    <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.downloads', [], $language_lib->getCurrentCode()); ?></legend>
                    <div class="table-responsive">
                        <table id="product-downloads" class="table table-stripped table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo lang('Column.name', [], $language_lib->getCurrentCode()); ?></th>
                                    <th><?php echo lang('Column.filename', [], $language_lib->getCurrentCode()); ?></th>
                                    <th><?php echo lang('Column.mask', [], $language_lib->getCurrentCode()); ?></th>
                                    <th class="text-end"><?php echo lang('Column.upload', [], $language_lib->getCurrentCode()); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $product_download_row = 0; ?>
                                <?php if (!empty($product_downloads)) { ?>
                                    <?php foreach ($product_downloads as $product_download) { ?>
                                    <tr id="row-product-download-<?php echo $product_download_row; ?>">
                                        <td class="align-middle">
                                            <?php foreach ($languages as $language) { ?>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="input-group-product-download-<?php echo $product_download_row; ?>-<?php echo $language['language_id']; ?>"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>
                                                <input type="text" name="product_download[<?php echo $product_download_row; ?>][description][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($product_download['description'][$language['language_id']]['name']) ? $product_download['description'][$language['language_id']]['name'] : ''; ?>" class="form-control" placeholder="<?php echo lang('Entry.name', [], $language_lib->getCurrentCode()); ?>" aria-label="<?php echo lang('Entry.name', [], $language_lib->getCurrentCode()); ?>" aria-describedby="input-group-product-download-<?php echo $product_download_row; ?>-<?php echo $language['language_id']; ?>">
                                            </div>
                                            <?php } ?>
                                        </td>
                                        <td class="align-middle">
                                            <div>
                                                <input type="text" name="product_download[<?php echo $product_download_row; ?>][filename]" value="<?php echo $product_download['filename']; ?>" class="form-control" id="input-product-download-filename-<?php echo $product_download_row; ?>" placeholder="<?php echo lang('Entry.filename', [], $language_lib->getCurrentCode()); ?>" readonly>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div>
                                                <input type="text" name="product_download[<?php echo $product_download_row; ?>][mask]" value="<?php echo $product_download['mask']; ?>" class="form-control" id="input-product-download-mask-<?php echo $product_download_row; ?>" placeholder="<?php echo lang('Entry.mask', [], $language_lib->getCurrentCode()); ?>" readonly>
                                            </div>
                                        </td>
                                        <td class="align-middle text-end"><div class="d-grid"><button type="button" id="button-product-download-upload-<?php echo $product_download_row; ?>" class="btn btn-primary product-download-upload"><i class="fas fa-upload me-2"></i><?php echo lang('Button.upload', [], $language_lib->getCurrentCode()); ?></button><span class="progress-bar mt-2"></span></div></td>
                                    </tr>
                                    <?php $product_download_row++; ?>
                                    <?php } ?>
                                <?php } ?>
                                <tr id="row-product-download-add">
                                    <td colspan="4" class="text-end"><button type="button" id="button-product-download-add" class="btn btn-primary" onclick="addProductDownload();"><i class="fas fa-circle-plus me-2"></i><?php echo lang('Button.add', [], $language_lib->getCurrentCode()); ?></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
    tinymce.init({
    selector: '.editor',
    height: 300,
    });
});
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
    var triggerFirstTabEl = document.querySelector('#product-description-tab li:first-child button')
    new bootstrap.Tab(triggerFirstTabEl).show()
});
//--></script>
<script type="text/javascript"><!--
$('input#input-is-product-variant').click(function() {
    if ($('input#input-is-product-variant').is(':checked')) {
        $('#product-default').addClass('d-none');
        $('#product-options').removeClass('d-none');
    } else {
        $('#product-default').removeClass('d-none');
        $('#product-options').addClass('d-none');
    }
});
//--></script>
<script type="text/javascript"><!--
$('body').on('click', '.upload', function() {
    var node = this;

    $('#form-upload').remove();

    $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

    $('#form-upload input[name=\'file\']').trigger('click');

    if (typeof timer != 'undefined') {
        clearInterval(timer);
    }

    timer = setInterval(function() {
        if ($('#form-upload input[name=\'file\']').val() != '') {
            clearInterval(timer);

            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    $(node).find('span.progress-bar').removeAttr( 'style' );

                    xhr.upload.addEventListener("progress", function(evt) {
                          if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $(node).find('span.progress-bar').css('width', percentComplete + '%');
                                console.log(percentComplete);

                                if (percentComplete === 100) {

                                }

                          }
                    }, false);

                    return xhr;
                },
                url: '<?php echo $upload; ?>',
                type: 'post',
                dataType: 'json',
                data: new FormData($('#form-upload')[0]),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(node).button('loading');
                },
                complete: function() {
                    $(node).button('reset');
                },
                success: function(json) {
                    if (json['error']) {
                        alert(JSON.stringify(json['error']));
                    }

                    if (json['success']) {
                        $(node).find('img').attr('src', json['image']['src']);
                        $(node).find('input').val(json['image']['path']);

                        alert(JSON.stringify(json['success']));
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }, 500);
});
//--></script>
<script type="text/javascript"><!--
var additional_image_row = '<?php echo $additional_image_row; ?>';

function addAdditionalImage() {
    html = '<div class="position-relative float-start me-1"><a href="javascript:void(0);" id="upload-additional-image-' + additional_image_row + '" class="position-relative d-table-cell upload"><img src="<?php echo $placeholder; ?>" class="border p-1" /><span class="progress-bar"></span><input type="hidden" name="additional_image[' + additional_image_row + ']" value="" id="additional-image-' + additional_image_row + '" class="form-control" /></a><span class="position-absolute top-0 end-0" style="z-index: 999999;" onclick="$(this).parent().remove();"><span class="fa-stack" style="font-size: 0.5em;"><i class="fas fa-circle fa-stack-2x text-danger"></i><i class="fas fa-times fa-stack-1x text-light"></i></span></span></div>';

    $('#button-upload-additional-image').before(html);

    additional_image_row++;
}
//--></script>
<script type="text/javascript"><!--
var product_option_row = '<?php echo $product_option_row; ?>';

function addProductOption() {
    html = '<div id="product-option-' + product_option_row +'" class="position-relative bg-light mb-1 p-3">';
    html += '   <span role="button" class="text-secondary position-absolute top-0 end-0 small" onclick="removeProductOption(\'' + product_option_row + '\');"><span class="fa-stack" style="font-size: 0.5em;"><i class="fas fa-circle fa-stack-2x text-danger"></i><i class="fas fa-times fa-stack-1x text-light"></i></span></span>';
    html += '   <div class="row mb-3">';
    html += '       <div class="col-sm-2"><label for="input-option-' + product_option_row + '" class="form-label"><?php echo lang('Entry.option', [], $language_lib->getCurrentCode()); ?></label></div>';
    html += '       <div class="col-sm-10">';
    html += '           <input type="text" name="product_option[' + product_option_row + '][option]" value="" id="input-option-' + product_option_row + '" class="form-control" placeholder="<?php echo lang('Entry.option', [], $language_lib->getCurrentCode()); ?>">';
    html += '           <input type="hidden" name="product_option[' + product_option_row + '][option_id]" value="" id="input-option-' + product_option_row + '-id" class="form-control" placeholder="<?php echo lang('Entry.option', [], $language_lib->getCurrentCode()); ?>">';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';

    $('#button-option-add').parent().before(html);

    productOptionAutocomplete(product_option_row);

    setProductOptions();

    product_option_row++;
}

function removeProductOption(product_option_row) {
    $('#product-option-' + product_option_row).remove();

    setProductOptions();
}

function productOptionAutocomplete(product_option_row) {
    $( 'input[name=\'product_option[' + product_option_row + '][option]\']' ).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '<?php echo $option_autocomplete; ?>&filter_name=' + encodeURIComponent(request.term),
                dataType: 'json',
                data: {
                    filter_name: request.term
                },
                beforeSend: function() {
                    //$('select[name=\'setting_country_id\']').prop('disabled', true);
                },
                complete: function() {
                    //$('select[name=\'setting_country_id\']').prop('disabled', false);
                },
                success: function(json) {
                    if (json['error']) {
                        alert(json['error']);
                    } else {
                        if (json.length) {
                            var none = {
                                    name: '<?php echo lang('Text.none', [], $language_lib->getCurrentCode()); ?>', 
                                    option_id: 0,
                                };

                            json.push(none);       
                            response( json );
                        } else {
                            var json = [
                                {
                                    name: '<?php echo lang('Text.none', [], $language_lib->getCurrentCode()); ?>', 
                                    option_id: 0,
                                }
                            ];

                            response(json);
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        },
        minLength: 0,
        select: function( event, ui ) {
            $('#input-option-' + product_option_row).val(ui.item.name);
            $('#input-option-' + product_option_row + '-id').val(ui.item.option_id);
            $('#input-option-' + product_option_row).autocomplete('close');
            if (ui.item.option_id != 0) {
                getProductOptionValues(ui.item.option_id,product_option_row);
            }

            setProductOptions();

            console.log( 'Selected: ' + ui.item.name + ' aka ' + ui.item.option_id );
            return false;
        }
    }).focus(function () {
        $(this).autocomplete('search');
    }).data('ui-autocomplete')._renderItem = function (ul, item) {
        return $('<li>')
            .data('item.autocomplete', item)
            .append('<a>' + item.name + '</a>')
            .appendTo(ul);
    };
}

$('#product-options .col-sm-10').each(function(index, element) {
    productOptionAutocomplete(index);
});

function getProductOptionValues(option_id,product_option_row) {
    $.ajax({
        url: '<?php echo $get_option; ?>&option_id=' + option_id,
        dataType: 'json',
        data: {
            option_id: option_id
        },
        beforeSend: function() {
            //$('select[name=\'setting_country_id\']').prop('disabled', true);
        },
        complete: function() {
            //$('select[name=\'setting_country_id\']').prop('disabled', false);
        },
        success: function(json) {
            $('#option-values-' + product_option_row).remove();

            if (json['option_values'].length !== 0) {
                html = '<div id="option-values-' + product_option_row + '" class="card mt-1">';
                html += '   <div class="card-body">';
                for (i = 0; i < json['option_values'].length; i++) {
                    option_value = json['option_values'][i];

                    html += '   <input type="checkbox" name="product_option[' + product_option_row + '][option_value][]" value="' + option_value['option_value_id'] + '" class="btn-check" id="input-option-value-' + product_option_row + '-' + json['option_id'] + '-' + option_value['option_value_id'] + '" autocomplete="off" onclick="setProductOptions();">';
                    html += '   <label class="btn btn-outline-primary shadow-none" for="input-option-value-' + product_option_row + '-' + json['option_id'] + '-' + option_value['option_value_id'] + '">' + option_value['name'] + '</label>';
                }
                html += '   </div>';
                html += '</div>';

                $('#input-option-' + product_option_row + '-id').after(html);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

setProductOptions();

function setProductOptions() {
    var product_options = $('#product-options').find('select, textarea, input').serializeJSON();

    $.ajax({
        url: '<?php echo $set_product_options; ?>',
        type: 'post',
        dataType: 'json',
        data: JSON.stringify(product_options),
        beforeSend: function() {
            //$('select[name=\'setting_country_id\']').prop('disabled', true);
        },
        complete: function() {
            //$('select[name=\'setting_country_id\']').prop('disabled', false);
        },
        success: function(json) {
            // Refresh checkout cart
            $( '#product-variants' ).html( '<div class="text-center text-secondary"><i class="fas fa-spinner fa-spin fa-2x"></i></div>' );
            $( '#product-variants' ).load( '<?php echo $product_variant; ?>' );
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
//--></script>
<script type="text/javascript"><!--
var product_download_row = '<?php echo $product_download_row; ?>';

function addProductDownload() {
    html = '<tr id="row-product-download-' + product_download_row + '">';
    html += '   <td class="align-middle">';
    <?php foreach ($languages as $language) { ?>
    html += '       <div class="input-group mb-3">';
    html += '           <span class="input-group-text" id="input-group-product-download-' + product_download_row + '-<?php echo $language['language_id']; ?>"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>';
    html += '           <input type="text" name="product_download[' + product_download_row + '][description][<?php echo $language['language_id']; ?>][name]" value="" class="form-control" placeholder="<?php echo lang('Entry.name', [], $language_lib->getCurrentCode()); ?>" aria-label="<?php echo lang('Entry.name', [], $language_lib->getCurrentCode()); ?>" aria-describedby="input-group-product-download-' + product_download_row + '-<?php echo $language['language_id']; ?>">';
    html += '   </div>';
    <?php } ?>
    html += '   </td>';
    html += '   <td class="align-middle">';
    html += '       <div>';
    html += '           <input type="text" name="product_download[' + product_download_row + '][filename]" value="" class="form-control" id="input-product-download-filename-' + product_download_row + '" placeholder="<?php echo lang('Entry.filename', [], $language_lib->getCurrentCode()); ?>" readonly>';
    html += '       </div>';
    html += '   </td>';
    html += '   <td class="align-middle">';
    html += '       <div>';
    html += '           <input type="text" name="product_download[' + product_download_row + '][mask]" value="" class="form-control" id="input-product-download-mask-' + product_download_row + '" placeholder="<?php echo lang('Entry.mask', [], $language_lib->getCurrentCode()); ?>" readonly>';
    html += '       </div>';
    html += '   </td>';
    html += '   <td class="align-middle text-end"><div class="d-grid"><button type="button" id="button-product-download-upload-' + product_download_row + '" class="btn btn-primary product-download-upload"><i class="fas fa-upload me-2"></i><?php echo lang('Button.upload', [], $language_lib->getCurrentCode()); ?></button><span class="progress-bar mt-2"></span></div></td>';
    html += '</tr>';

    $('#row-product-download-add').before(html);

    product_download_row++;
}
//--></script>
<script type="text/javascript"><!--
$('body').on('click', '.product-download-upload', function() {
    var node = this;

    $('#form-product-download-upload').remove();

    $('body').prepend('<form enctype="multipart/form-data" id="form-product-download-upload" style="display: none;"><input type="file" name="file" /></form>');

    $('#form-product-download-upload input[name=\'file\']').trigger('click');

    if (typeof timer != 'undefined') {
        clearInterval(timer);
    }

    timer = setInterval(function() {
        if ($('#form-product-download-upload input[name=\'file\']').val() != '') {
            clearInterval(timer);

            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    $(node).parent().find('span.progress-bar').removeAttr( 'style' );

                    xhr.upload.addEventListener("progress", function(evt) {
                          if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $(node).parent().find('span.progress-bar').css('width', percentComplete + '%');
                                console.log(percentComplete);

                                if (percentComplete === 100) {

                                }

                          }
                    }, false);

                    return xhr;
                },
                url: '<?php echo $product_download_upload; ?>',
                type: 'post',
                dataType: 'json',
                data: new FormData($('#form-product-download-upload')[0]),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(node).button('loading');
                },
                complete: function() {
                    $(node).button('reset');
                },
                success: function(json) {
                    if (json['error']) {
                        alert(JSON.stringify(json['error']));
                    }

                    if (json['success']) {
                        $(node).parent().parent().parent().find('input[name $= "[filename]"]').val(json['filename']);
                        $(node).parent().parent().parent().find('input[name $= "[mask]"]').val(json['mask']);

                        alert(JSON.stringify(json['success']));
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }, 500);
});
//--></script>
<?php echo $footer; ?>
