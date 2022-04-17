<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-product']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5> <div class="float-end"><button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-save fa-fw"></i></button> <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <fieldset>
                    <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.general'); ?></legend>
                    <div class="mb-3">
                        <label for="input-status" class="form-label"><?php echo lang('Entry.status'); ?></label>
                        <select name="status" id="input-status" class="form-control">
                            <?php if ($status) { ?>
                            <option value="0"><?php echo lang('Text.disabled'); ?></option>
                            <option value="1" selected="selected"><?php echo lang('Text.enabled'); ?></option>
                            <?php } else { ?>
                            <option value="0" selected="selected"><?php echo lang('Text.disabled'); ?></option>
                            <option value="1"><?php echo lang('Text.enabled'); ?></option>
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
                                <label for="input-product-description-name-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.name'); ?></label>
                                <input type="text" name="product_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($product_description[$language['language_id']]['name']) ? htmlentities($product_description[$language['language_id']]['name']) : ''; ?>" id="input-product-description-name-language-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.name'); ?>" />
                                <?php if (!empty($error_product_description[$language['language_id']]['name'])) { ?><div class="text-danger small"><?php echo $error_product_description[$language['language_id']]['name']; ?></div><?php } ?>
                            </div>
                            <div class="mb-3 required">
                                <label for="input-product-description-description-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.description'); ?></label>
                                <textarea name="product_description[<?php echo $language['language_id']; ?>][description]" id="input-product-description-description-language-<?php echo $language['language_id']; ?>" class="form-control editor" placeholder="<?php echo lang('Entry.description'); ?>"><?php echo isset($product_description[$language['language_id']]['description']) ? htmlentities($product_description[$language['language_id']]['description']) : ''; ?></textarea>
                                <?php if (!empty($error_product_description[$language['language_id']]['description'])) { ?><div class="text-danger small"><?php echo $error_product_description[$language['language_id']]['description']; ?></div><?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="input-product-description-meta-title-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.meta_title'); ?></label>
                                <input type="text" name="product_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($product_description[$language['language_id']]['meta_title']) ? htmlentities($product_description[$language['language_id']]['meta_title']) : ''; ?>" id="input-product-description-meta-title-language-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.meta_title'); ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="input-product-description-meta-description-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.meta_description'); ?></label>
                                <textarea rows="5" name="product_description[<?php echo $language['language_id']; ?>][meta_description]" id="input-product-description-meta-description-language-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.meta_description'); ?>"><?php echo isset($product_description[$language['language_id']]['meta_description']) ? htmlentities($product_description[$language['language_id']]['meta_description']) : ''; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="input-product-description-meta-keywords-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.meta_keywords'); ?></label>
                                <input type="text" name="product_description[<?php echo $language['language_id']; ?>][meta_keywords]" value="<?php echo isset($product_description[$language['language_id']]['meta_keywords']) ? htmlentities($product_description[$language['language_id']]['meta_keywords']) : ''; ?>" id="input-product-description-meta-keywords-language-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.meta_keywords'); ?>" />
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.category'); ?></legend>
                    <div class="mb-3">
                        <label for="input-category" class="form-label"><?php echo lang('Entry.category'); ?></label>
                        <select name="category_id_path" class="form-control" id="input-category">
                            <?php foreach ($categories as $category) { ?>
                                <?php if ($category['category_id_path'] == $category_id_path) { ?>
                                <option value="<?php echo $category['category_id_path']; ?>" selected="selected"><?php echo $category['category_path']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $category['category_id_path']; ?>"><?php echo $category['category_path']; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.price'); ?></legend>
                    <div class="mb-3">
                        <label for="input-price" class="form-label"><?php echo lang('Entry.price'); ?></label>
                        <div class="input-group">
                            <span class="input-group-text" id="input-group-price"><?php echo $default_currency_code; ?></span>
                            <input type="number" min="0" step="any" name="price" value="<?php echo $price; ?>" class="form-control" id="input-price" placeholder="<?php echo lang('Entry.price'); ?>" aria-label="<?php echo lang('Entry.price'); ?>" aria-describedby="input-group-price" />
                        </div>
                    </div>
                    <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.weight'); ?></legend>
                    <div class="mb-3">
                        <label for="input-weight" class="form-label"><?php echo lang('Entry.weight'); ?></label>
                        <input type="number" min="0" step="any" name="weight" value="<?php echo $weight; ?>" class="form-control" id="input-weight" placeholder="<?php echo lang('Entry.weight'); ?>" aria-label="<?php echo lang('Entry.weight'); ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="input-weight-class" class="form-label"><?php echo lang('Entry.weight_class'); ?></label>
                        <select name="weight_class_id" class="form-control" id="input-weight-class">
                            <?php foreach ($weight_classes as $weight_class) { ?>
                                <?php if ($weight_class['weight_class_id'] == $weight_class_id) { ?>
                                <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.images'); ?></legend>
                    <div class="mb-3">
                        <label for="input-main-image" class="form-label"><?php echo lang('Entry.main_image'); ?></label>
                        <div><a href="javascript:void(0);" id="upload-main-image" class="position-relative d-table-cell upload"><img src="<?php echo $thumb; ?>" class="border p-1" /><span class="progress-bar"></span><input type="hidden" name="main_image" value="<?php echo $main_image; ?>" id="main-image" class="form-control" /></a></div>
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
$('.upload').on('click', function() {
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
                url: '<?php echo base_url('marketplace/tool/upload'); ?>',
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
<?php echo $footer; ?>
