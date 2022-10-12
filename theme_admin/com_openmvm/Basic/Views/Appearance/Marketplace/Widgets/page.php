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
                <h3 class="card-title"><i class="fas fa-file fa-fw"></i> <?php echo $heading_title; ?></h3>
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
                    <label for="input-username" class="form-label"><?php echo lang('Entry.name'); ?></label>
                    <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" placeholder="<?php echo lang('Entry.name'); ?>">
                    <?php if (!empty($error_name)) { ?><div class="text-danger small"><?php echo $error_name; ?></div><?php } ?>
                </div>
                <div class="mb-3">
                    <label for="input-title" class="form-label"><?php echo lang('Entry.title'); ?></label>
                    <?php foreach ($languages as $language) { ?>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="title-<?php echo $language['language_id']; ?>-title"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>
                        <input type="text" name="title[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($title[$language['language_id']]['title']) ? $title[$language['language_id']]['title'] : ''; ?>" class="form-control" placeholder="<?php echo lang('Entry.title'); ?>" aria-label="<?php echo lang('Entry.title'); ?>" aria-describedby="title-<?php echo $language['language_id']; ?>-title">
                    </div>
                    <?php } ?>
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
                <div class="mb-3">
                    <label for="input-page" class="form-label"><?php echo lang('Entry.page'); ?></label>
                    <div id="pages" class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?php echo lang('Column.page'); ?></th>
                                    <th><?php echo lang('Column.target'); ?></th>
                                    <th class="text-end"><?php echo lang('Column.action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $page_row = 0; ?>
                                <?php if ($pages) { ?>
                                    <?php foreach ($pages as $page) { ?>
                                    <tr id="page-<?php echo $page_row; ?>">
                                        <td>
                                            <input type="text" name="page[<?php echo $page_row; ?>][title]" value="<?php echo $page['title']; ?>" id="input-page-title-<?php echo $page_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.page'); ?>">
                                            <input type="hidden" name="page[<?php echo $page_row; ?>][page_id]" value="<?php echo $page['page_id']; ?>" id="input-page-page-id-<?php echo $page_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.page'); ?>">
                                        </td>
                                        <td>
                                            <select name="page[<?php echo $page_row; ?>][target]" id="input-page-target-<?php echo $page_row; ?>" class="form-select">
                                                <?php if ($page['target'] == 'new') { ?>
                                                <option value="new" selected="selected"><?php echo lang('Text.new_tab'); ?></option>
                                                <option value="current"><?php echo lang('Text.current_tab'); ?></option>
                                                <?php } else { ?>
                                                <option value="new"><?php echo lang('Text.new_tab'); ?></option>
                                                <option value="current" selected="selected"><?php echo lang('Text.current_tab'); ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td class="text-end"><button type="button" id="button-page-<?php echo $page_row; ?>-remove" class="btn btn-danger btn-sm" onclick="$('#page-<?php echo $page_row; ?>').remove();"><i class="fas fa-trash-alt fa-fw"></i></button></td>
                                    </tr>
                                    <?php $page_row++; ?>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><button type="button" id="button-page-add" class="btn btn-primary btn-sm"><i class="fas fa-plus fa-fw"></i></button></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
var page_row = '<?php echo $page_row; ?>';

$( "#button-page-add" ).on( "click", function() {
    html = '<tr id="page-' + page_row + '">';
    html += '    <td>';
    html += '        <input type="text" name="page[' + page_row + '][title]" value="" id="input-page-title-' + page_row + '" class="form-control" placeholder="<?php echo lang('Entry.page'); ?>">';
    html += '        <input type="hidden" name="page[' + page_row + '][page_id]" value="" id="input-page-page-id-' + page_row + '" class="form-control" placeholder="<?php echo lang('Entry.page'); ?>">';
    html += '    </td>';
    html += '    <td>';
    html += '        <select name="page[' + page_row + '][target]" id="input-page-target-' + page_row + '" class="form-select">';
    html += '            <option value="new"><?php echo lang('Text.new_tab'); ?></option>';
    html += '            <option value="current" selected="selected"><?php echo lang('Text.current_tab'); ?></option>';
    html += '        </select>';
    html += '    </td>';
    html += '    <td class="text-end"><button type="button" id="button-page-' + page_row + '-remove" class="btn btn-danger btn-sm" onclick="$(\'#page-' + page_row + '\').remove();"><i class="fas fa-trash-alt fa-fw"></i></button></td>';
    html += '</tr>';

    $('#pages table tbody').append(html);

    pageautocomplete(page_row);

    page_row++;
});

function pageautocomplete(page_row) {
    $( '#input-page-title-' + page_row + '' ).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '<?php echo $page_autocomplete; ?>',
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
                                    page_id: 0,
                                };

                            json.push(none);       
                            response( json );
                        } else {
                            var json = [
                                {
                                    name: '<?php echo lang('Text.none'); ?>', 
                                    page_id: 0,
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
            $('#input-page-title-' + page_row + '').val(ui.item.name);
            $('#input-page-page-id-' + page_row + '').val(ui.item.page_id);
            $('#input-page-name-' + page_row + '').autocomplete('close');
            console.log( 'Selected: ' + ui.item.name + ' aka ' + ui.item.page_id );
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

$('#pages table tbody tr').each(function(index, element) {
    pageautocomplete(index);
});
//--></script>
<?php echo $footer; ?>
