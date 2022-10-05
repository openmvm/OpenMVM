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
                <h3 class="card-title"><i class="fas fa-list fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-widget']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-widget" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-widget" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3 required">
                    <label for="input-name" class="form-label"><?php echo lang('Entry.name'); ?></label>
                    <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" placeholder="<?php echo lang('Entry.name'); ?>">
                    <?php if (!empty($error_name)) { ?><div class="text-danger small"><?php echo $error_name; ?></div><?php } ?>
                </div>
                <div class="mb-3">
                    <label for="input-display" class="form-label"><?php echo lang('Entry.display'); ?></label>
                    <select name="display" id="input-display" class="form-control">
                        <?php if ($display == 'grid') { ?>
                        <option value="grid" selected="selected"><?php echo lang('Text.grid'); ?></option>
                        <?php } else { ?>
                        <option value="grid"><?php echo lang('Text.grid'); ?></option>
                        <?php } ?>
                        <?php if ($display == 'list') { ?>
                        <option value="list" selected="selected"><?php echo lang('Text.list'); ?></option>
                        <?php } else { ?>
                        <option value="list"><?php echo lang('Text.list'); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3 required">
                    <label for="input-column" class="form-label"><?php echo lang('Entry.column'); ?></label>
                    <input type="number" name="column" value="<?php echo $column; ?>" id="input-column" class="form-control" placeholder="<?php echo lang('Entry.column'); ?>">
                </div>
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
                <div class="mb-3">
                    <label for="input-category" class="form-label"><?php echo lang('Entry.category'); ?></label>
                    <div id="categories" class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills me-3 w-25" id="category-tab" role="tablist" aria-orientation="vertical">
                            <?php $category_row = 1; ?>
                            <?php if ($categories) { ?>
                                <?php foreach ($categories as $category) { ?>
                                <button class="nav-link mb-2" id="category-<?php echo $category_row; ?>-tab" data-bs-toggle="pill" data-bs-target="#category-<?php echo $category_row; ?>" type="button" role="tab" aria-controls="category-<?php echo $category_row; ?>" aria-selected="false"><i class="fas fa-minus-circle fa-fw" onclick="$('#category-<?php echo $category_row; ?>-tab').remove(); $('#category-<?php echo $category_row; ?>').remove(); var triggerFirstTabEl = document.querySelector('#categories #category-tab button.nav-link:first-child'); new bootstrap.Tab(triggerFirstTabEl).show();"></i> <span><?php echo $category['name']; ?></span></button>
                                <?php $category_row++; ?>
                                <?php } ?>
                            <?php } ?>
                            <button type="button" id="button-category-add" class="btn btn-secondary"><i class="fas fa-plus fa-fw"></i> <?php echo lang('Button.add'); ?></button>
                        </div>
                        <div class="tab-content w-100" id="category-tab-content">
                            <?php $category_row = 1; ?>
                            <?php if ($categories) { ?>
                                <?php foreach ($categories as $category) { ?>
                                <div class="tab-pane fade" id="category-<?php echo $category_row; ?>" role="tabpanel" aria-labelledby="category-<?php echo $category_row; ?>-tab">
                                    <h5 class="border-bottom pb-3 mb-3"><?php echo lang('Text.main_category'); ?></h5>
                                    <div class="mb-3">
                                        <label for="input-category-name-<?php echo $category_row; ?>" class="form-label"><?php echo lang('Entry.category'); ?></label>
                                        <input type="text" name="category[<?php echo $category_row; ?>][name]" value="<?php echo $category['name']; ?>" id="input-category-name-<?php echo $category_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.category'); ?>">
                                        <input type="hidden" name="category[<?php echo $category_row; ?>][category_id]" value="<?php echo $category['category_id']; ?>" id="input-category-category-id-<?php echo $category_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.category'); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="input-category-image-<?php echo $category_row; ?>" class="form-label"><?php echo lang('Entry.image'); ?></label>
                                        <select name="category[<?php echo $category_row; ?>][image]" id="category-image-<?php echo $category_row; ?>" class="form-control">
                                            <?php if ($category['image']) { ?>
                                            <option value="1" selected="selected"><?php echo lang('Text.yes'); ?></option>
                                            <option value="0"><?php echo lang('Text.no'); ?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo lang('Text.yes'); ?></option>
                                            <option value="0" selected="selected"><?php echo lang('Text.no'); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="input-category-width-<?php echo $category_row; ?>" class="form-label"><?php echo lang('Entry.width'); ?></label>
                                        <input type="number" name="category[<?php echo $category_row; ?>][width]" value="<?php echo $category['width']; ?>" id="category-width-<?php echo $category_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.width'); ?>" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="input-category-sort-order-<?php echo $category_row; ?>" class="form-label"><?php echo lang('Entry.sort_order'); ?></label>
                                        <input type="number" name="category[<?php echo $category_row; ?>][sort_order]" value="<?php echo $category['sort_order']; ?>" id="category-sort-order-<?php echo $category_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.sort_order'); ?>" />
                                    </div>
                                    <h5 class="border-bottom pb-3 mb-3 mt-5"><?php echo lang('Text.sub_category'); ?></h5>
                                    <div class="mb-3">
                                        <label for="input-category-show-sub-categories-<?php echo $category_row; ?>" class="form-label"><?php echo lang('Entry.show'); ?></label>
                                        <select name="category[<?php echo $category_row; ?>][show_sub_categories]" id="category-sub-category-show-<?php echo $category_row; ?>" class="form-control">
                                            <?php if ($category['show_sub_categories']) { ?>
                                            <option value="1" selected="selected"><?php echo lang('Text.yes'); ?></option>
                                            <option value="0"><?php echo lang('Text.no'); ?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo lang('Text.yes'); ?></option>
                                            <option value="0" selected="selected"><?php echo lang('Text.no'); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="input-category-limit-sub-categories-<?php echo $category_row; ?>" class="form-label"><?php echo lang('Entry.limit'); ?></label>
                                        <input type="number" name="category[<?php echo $category_row; ?>][limit_sub_categories]" value="<?php echo $category['limit_sub_categories']; ?>" id="category-limit-sub-categories-<?php echo $category_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.limit'); ?>" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="input-category-image-sub-categories-<?php echo $category_row; ?>" class="form-label"><?php echo lang('Entry.image'); ?></label>
                                        <select name="category[<?php echo $category_row; ?>][image_sub_categories]" id="category-sub-category-image-<?php echo $category_row; ?>" class="form-control">
                                            <?php if ($category['image_sub_categories']) { ?>
                                            <option value="1" selected="selected"><?php echo lang('Text.yes'); ?></option>
                                            <option value="0"><?php echo lang('Text.no'); ?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo lang('Text.yes'); ?></option>
                                            <option value="0" selected="selected"><?php echo lang('Text.no'); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php $category_row++; ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
var category_row = '<?php echo $category_row; ?>';

$( "#button-category-add" ).on( "click", function() {
    html = '<div class="tab-pane fade" id="category-' + category_row + '" role="tabpanel" aria-labelledby="category-' + category_row + '-tab">';
    html += '    <h5 class="border-bottom pb-3 mb-3"><?php echo lang('Text.main_category'); ?></h5>';
    html += '    <div class="mb-3">';
    html += '        <label for="input-category-name-' + category_row + '" class="form-label"><?php echo lang('Entry.category'); ?></label>';
    html += '        <input type="text" name="category[' + category_row + '][name]" value="" id="input-category-name-' + category_row + '" class="form-control" placeholder="<?php echo lang('Entry.category'); ?>">';
    html += '        <input type="hidden" name="category[' + category_row + '][category_id]" value="" id="input-category-category-id-' + category_row + '" class="form-control" placeholder="<?php echo lang('Entry.category'); ?>">';
    html += '    </div>';
    html += '    <div class="mb-3">';
    html += '        <label for="input-category-image-' + category_row + '" class="form-label"><?php echo lang('Entry.image'); ?></label>';
    html += '        <select name="category[' + category_row + '][image]" id="category-image-' + category_row + '" class="form-control">';
    html += '            <option value="1"><?php echo lang('Text.yes'); ?></option>';
    html += '            <option value="0"><?php echo lang('Text.no'); ?></option>';
    html += '        </select>';
    html += '    </div>';
    html += '    <div class="mb-3">';
    html += '        <label for="input-category-width-' + category_row + '" class="form-label"><?php echo lang('Entry.width'); ?></label>';
    html += '        <input type="number" name="category[' + category_row + '][width]" value="<?php echo $category['width']; ?>" id="category-width-' + category_row + '" class="form-control" placeholder="<?php echo lang('Entry.width'); ?>" />';
    html += '    </div>';
    html += '    <div class="mb-3">';
    html += '        <label for="input-category-sort-order-' + category_row + '" class="form-label"><?php echo lang('Entry.sort_order'); ?></label>';
    html += '        <input type="number" name="category[' + category_row + '][sort_order]" value="" id="category-sort-order-' + category_row + '" class="form-control" placeholder="<?php echo lang('Entry.sort_order'); ?>" />';
    html += '    </div>';
    html += '    <h5 class="border-bottom pb-3 mb-3 mt-5"><?php echo lang('Text.sub_category'); ?></h5>';
    html += '    <div class="mb-3">';
    html += '        <label for="input-category-show-sub-categories-' + category_row + '" class="form-label"><?php echo lang('Entry.show'); ?></label>';
    html += '        <select name="category[' + category_row + '][show_sub_categories]" id="category-sub-category-show-' + category_row + '" class="form-control">';
    html += '            <option value="1"><?php echo lang('Text.yes'); ?></option>';
    html += '            <option value="0"><?php echo lang('Text.no'); ?></option>';
    html += '        </select>';
    html += '    </div>';
    html += '    <div class="mb-3">';
    html += '        <label for="input-category-limit-sub-categories-' + category_row + '" class="form-label"><?php echo lang('Entry.limit'); ?></label>';
    html += '        <input type="number" name="category[' + category_row + '][limit_sub_categories]" value="" id="category-limit-sub-categories-' + category_row + '" class="form-control" placeholder="<?php echo lang('Entry.limit'); ?>" />';
    html += '    </div>';
    html += '    <div class="mb-3">';
    html += '        <label for="input-category-image-sub-categories-' + category_row + '" class="form-label"><?php echo lang('Entry.image'); ?></label>';
    html += '        <select name="category[' + category_row + '][image_sub_categories]" id="category-sub-category-image-' + category_row + '" class="form-control">';
    html += '            <option value="1"><?php echo lang('Text.yes'); ?></option>';
    html += '            <option value="0"><?php echo lang('Text.no'); ?></option>';
    html += '        </select>';
    html += '    </div>';
    html += '</div>';

    $('#categories #category-tab-content').append(html);

    $('#categories #category-tab').find('#button-category-add').before('<button class="nav-link mb-2" id="category-' + category_row + '-tab" data-bs-toggle="pill" data-bs-target="#category-' + category_row + '" type="button" role="tab" aria-controls="category-' + category_row + '" aria-selected="false"><i class="fas fa-minus-circle fa-fw" onclick="$(\'#category-' + category_row + '-tab\').remove(); $(\'#category-' + category_row + '\').remove(); var triggerFirstTabEl = document.querySelector(\'#categories #category-tab button.nav-link:first-child\'); new bootstrap.Tab(triggerFirstTabEl).show();"></i> <span><?php echo lang('Tab.category'); ?> ' + category_row + '</span></button>');

    var triggerFirstTabEl = document.querySelector('#categories #category-' + category_row + '-tab');
    new bootstrap.Tab(triggerFirstTabEl).show();

    categoryautocomplete(category_row);

    category_row++;
});

function categoryautocomplete(category_row) {
    $( '#input-category-name-' + category_row + '' ).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '<?php echo base_url(); ?>' + '/admin/marketplace/category/autocomplete?administrator_token=<?php echo $administrator_token; ?>',
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
            $('#input-category-name-' + category_row + '').val(ui.item.name);
            $('#category-' + category_row + '-tab > span').html(ui.item.name);
            $('#input-category-category-id-' + category_row + '').val(ui.item.category_id);
            $('#input-category-name-' + category_row + '').autocomplete('close');
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
}

$('#categories #category-tab-content .tab-pane').each(function(index, element) {
    categoryautocomplete(index + 1);
});
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
    var triggerFirstTabEl = document.querySelector('#categories #category-tab button.nav-link:first-child')
    new bootstrap.Tab(triggerFirstTabEl).show()
});
//--></script>
<?php echo $footer; ?>
