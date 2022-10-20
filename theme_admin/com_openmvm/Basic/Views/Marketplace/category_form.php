<?php echo $header; ?><?php echo $column_left; ?>
<div class="container-fluid">
    <div id="content" class="content">
        <?php if ($breadcrumbs) { ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <?php if ($breadcrumb['active']) { ?>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
                    <?php } else { ?>
                    <li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                    <?php } ?>
                <?php } ?>
            </ol>
        </nav>
        <?php } ?>
        <div class="card border-0 shadow heading mb-3">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-bars fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-category']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-category" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-category" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="categoryTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.general'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="false"><?php echo lang('Tab.data'); ?></button>
                    </li>
                </ul>
                <div class="tab-content" id="categoryTabContent">
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <ul class="nav nav-tabs mb-3" id="language-tab" role="tablist">
                            <?php foreach ($languages as $language) { ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="language-tab-<?php echo $language['language_id']; ?>" data-bs-toggle="tab" data-bs-target="#language-<?php echo $language['language_id']; ?>" type="button" role="tab" aria-controls="language-<?php echo $language['language_id']; ?>" aria-selected="true"><img src="<?php echo base_url() . '/assets/flags/' . $language['code'] . '.png'; ?>" /> <?php echo $language['name']; ?></button>
                            </li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content" id="language-tab-content">
                            <?php foreach ($languages as $language) { ?>
                            <div class="tab-pane fade" id="language-<?php echo $language['language_id']; ?>" role="tabpanel" aria-labelledby="language-tab-<?php echo $language['language_id']; ?>">
                                <fieldset>
                                    <div class="mb-3 required">
                                        <label for="input-name-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.name'); ?></label>
                                        <input type="text" name="category_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($category_description[$language['language_id']]['name']) ? $category_description[$language['language_id']]['name']: ''; ?>" id="input-name-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.name'); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="input-description-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.description'); ?></label>
                                        <textarea rows="10" name="category_description[<?php echo $language['language_id']; ?>][description]" id="input-description-<?php echo $language['language_id']; ?>" class="form-control editor" placeholder="<?php echo lang('Entry.description'); ?>"><?php echo isset($category_description[$language['language_id']]['description']) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea>
                                    </div>
                                    <div class="mb-3 required">
                                        <label for="input-meta-title-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.meta_title'); ?></label>
                                        <input type="text" name="category_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($category_description[$language['language_id']]['meta_title']) ? $category_description[$language['language_id']]['meta_title'] : ''; ?>" id="input-meta-title-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.meta_title'); ?>">
                                        <?php if (!empty($error_category_description[$language['language_id']]['meta_title'])) { ?><div class="text-danger small"><?php echo $error_category_description[$language['language_id']]['meta_title']; ?></div><?php } ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="input-meta-description-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.meta_description'); ?></label>
                                        <textarea rows="5" name="category_description[<?php echo $language['language_id']; ?>][meta_description]" id="input-meta-description-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.meta_description'); ?>"><?php echo isset($category_description[$language['language_id']]['meta_description']) ? $category_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="input-meta-keywords-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.meta_keywords'); ?></label>
                                        <input type="text" name="category_description[<?php echo $language['language_id']; ?>][meta_keywords]" value="<?php echo isset($category_description[$language['language_id']]['meta_keywords']) ? $category_description[$language['language_id']]['meta_keywords'] : ''; ?>" id="input-meta-keywords-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.meta_keywords'); ?>">
                                    </div>
                                </fieldset>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">
                        <fieldset>
                            <div class="mb-3">
                                <label for="input-parent" class="form-label"><?php echo lang('Entry.parent'); ?></label>
                                <input type="text" name="parent" value="<?php echo $parent; ?>" id="input-parent" class="form-control" placeholder="<?php echo lang('Entry.parent'); ?>">
                                <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" id="input-parent-id" class="form-control" placeholder="<?php echo lang('Entry.parent'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-image" class="form-label"><?php echo lang('Entry.image'); ?></label>
                                <div class="card" style="width: 110px;">
                                    <div class="card-body bg-secondary bg-opacity-10 p-1">
                                        <div class="d-flex align-items-center mb-1" style="height: 100px;" data-image-manager="image" data-image-manager-dismiss="<?php echo lang('Button.close'); ?>" data-image-manager-title="<?php echo lang('Heading.image_manager'); ?>" role="button"><img src="<?php echo $thumb; ?>" class="mx-auto d-block" /><input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" class="form-control" placeholder="<?php echo lang('Entry.image'); ?>" data-image-manager-target="image"></div>
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-danger" data-image-manager-remove="image" data-image-manager-placeholder="<?php echo $placeholder; ?>"><i class="fas fa-trash-alt fa-fw"></i></button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="input-sort-order" class="form-label"><?php echo lang('Entry.sort_order'); ?></label>
                                <input type="number" name="sort_order" value="<?php echo $sort_order; ?>" id="input-sort-order" class="form-control" placeholder="<?php echo lang('Entry.sort_order'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-status" class="form-label"><?php echo lang('Entry.status'); ?></label>
                                <select name="status" id="input-status" class="form-select">
                                    <?php if ($status) { ?>
                                    <option value="0"><?php echo lang('Text.disabled'); ?></option>
                                    <option value="1" selected="selected"><?php echo lang('Text.enabled'); ?></option>
                                    <?php } else { ?>
                                    <option value="0" selected="selected"><?php echo lang('Text.disabled'); ?></option>
                                    <option value="1"><?php echo lang('Text.enabled'); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                </div>
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
    var triggerFirstTabEl = document.querySelector('#language-tab li:first-child button')
    new bootstrap.Tab(triggerFirstTabEl).show()
});
//--></script>
<script type="text/javascript"><!--
$( '#input-parent' ).autocomplete({
    source: function (request, response) {
        $.ajax({
            url: '<?php echo base_url(); ?>' + '/<?php echo env('app.adminUrlSegment'); ?>/marketplace/category/autocomplete?administrator_token=<?php echo $administrator_token; ?>',
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
                                name: '<?php echo lang('Text.none'); ?>', 
                                category_id: 0,
                            };

                        json.push(none);       
                        response( json );
                    } else {
                        var json = [
                            {
                                name: '<?php echo lang('Text.none'); ?>', 
                                category_id: 0,
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
        $('#input-parent').val(ui.item.name);
        $('#input-parent-id').val(ui.item.category_id);
        $('#input-parent').autocomplete('close');
        console.log( 'Selected: ' + ui.item.name + ' aka ' + ui.item.category_id );
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
//--></script>
<?php echo $footer; ?>
