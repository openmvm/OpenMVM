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
                <h3 class="card-title"><i class="fas fa-link fa-fw"></i> <?php echo $heading_title; ?></h3>
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
                    <label for="input-link" class="form-label"><?php echo lang('Entry.link'); ?></label>
                    <div id="links" class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?php echo lang('Column.text'); ?></th>
                                    <th><?php echo lang('Column.url'); ?></th>
                                    <th><?php echo lang('Column.target'); ?></th>
                                    <th class="text-end"><?php echo lang('Column.action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $link_row = 0; ?>
                                <?php if ($links) { ?>
                                    <?php foreach ($links as $link) { ?>
                                    <tr id="link-<?php echo $link_row; ?>">
                                        <td>
                                            <?php foreach ($languages as $language) { ?>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="language-<?php echo $link_row; ?>-<?php echo $language['language_id']; ?>-addon"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>
                                                <input type="text" name="link[<?php echo $link_row; ?>][<?php echo $language['language_id']; ?>][text]" value="<?php echo $link[$language['language_id']]['text']; ?>" class="form-control" id="input-language-<?php echo $link_row; ?>-<?php echo $language['language_id']; ?>-text" placeholder="<?php echo lang('Entry.text'); ?>" aria-label="<?php echo lang('Entry.text'); ?>" aria-describedby="language-<?php echo $link_row; ?>-<?php echo $language['language_id']; ?>-addon">
                                            </div>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php foreach ($languages as $language) { ?>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="language-<?php echo $link_row; ?>-<?php echo $language['language_id']; ?>-addon"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>
                                                <input type="text" name="link[<?php echo $link_row; ?>][<?php echo $language['language_id']; ?>][url]" value="<?php echo $link[$language['language_id']]['url']; ?>" class="form-control" id="input-language-<?php echo $link_row; ?>-<?php echo $language['language_id']; ?>-url" placeholder="<?php echo lang('Entry.url'); ?>" aria-label="<?php echo lang('Entry.url'); ?>" aria-describedby="language-<?php echo $link_row; ?>-<?php echo $language['language_id']; ?>-addon">
                                            </div>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php foreach ($languages as $language) { ?>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="input-language-<?php echo $link_row; ?>-<?php echo $language['language_id']; ?>-target"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></label>
                                                <select name="link[<?php echo $link_row; ?>][<?php echo $language['language_id']; ?>][target]" class="form-select" id="input-language-<?php echo $link_row; ?>-<?php echo $language['language_id']; ?>-target">
                                                    <?php if ($link[$language['language_id']]['target'] == 'current') { ?>
                                                    <option value="current" selected="selected"><?php echo lang('Text.current_tab'); ?></option>
                                                    <option value="new"><?php echo lang('Text.new_tab'); ?></option>
                                                    <?php } else { ?>
                                                    <option value="current"><?php echo lang('Text.current_tab'); ?></option>
                                                    <option value="new" selected="selected"><?php echo lang('Text.new_tab'); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <?php } ?>
                                        </td>
                                        <td class="text-end"><button type="button" id="button-link-<?php echo $link_row; ?>-remove" class="btn btn-danger btn-sm" onclick="$('#link-<?php echo $link_row; ?>').remove();"><i class="fas fa-trash-alt fa-fw"></i></button></td>
                                    </tr>
                                    <?php $link_row++; ?>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><button type="button" id="button-link-add" class="btn btn-primary btn-sm"><i class="fas fa-plus fa-fw"></i></button></td>
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
var link_row = '<?php echo $link_row; ?>';

$( "#button-link-add" ).on( "click", function() {
    html = '<tr id="link-' + link_row + '">';
    html += '    <td>';
    <?php foreach ($languages as $language) { ?>
    html += '<div class="input-group mb-3">';
    html += '    <span class="input-group-text" id="language-' + link_row + '-<?php echo $language['language_id']; ?>-addon"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>';
    html += '    <input type="text" name="link[' + link_row + '][<?php echo $language['language_id']; ?>][text]" value="" class="form-control" id="input-language-' + link_row + '-<?php echo $language['language_id']; ?>-text" placeholder="<?php echo lang('Entry.text'); ?>" aria-label="<?php echo lang('Entry.text'); ?>" aria-describedby="language-' + link_row + '-<?php echo $language['language_id']; ?>-addon">';
    html += '</div>';
    <?php } ?>
    html += '    </td>';
    html += '    <td>';
    <?php foreach ($languages as $language) { ?>
    html += '<div class="input-group mb-3">';
    html += '    <span class="input-group-text" id="language-' + link_row + '-<?php echo $language['language_id']; ?>-addon"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>';
    html += '    <input type="text" name="link[' + link_row + '][<?php echo $language['language_id']; ?>][url]" value="" class="form-control" id="input-language-' + link_row + '-<?php echo $language['language_id']; ?>-url" placeholder="<?php echo lang('Entry.url'); ?>" aria-label="<?php echo lang('Entry.url'); ?>" aria-describedby="language-' + link_row + '-<?php echo $language['language_id']; ?>-addon">';
    html += '</div>';
    <?php } ?>
    html += '    </td>';
    html += '    <td>';
    <?php foreach ($languages as $language) { ?>
    html += '        <div class="input-group mb-3">';
    html += '            <label class="input-group-text" for="input-language-' + link_row + '-<?php echo $language['language_id']; ?>-target"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></label>';
    html += '            <select name="link[' + link_row + '][<?php echo $language['language_id']; ?>][target]" class="form-select" id="input-language-' + link_row + '-<?php echo $language['language_id']; ?>-target">';
    html += '                <option value="current"><?php echo lang('Text.current_tab'); ?></option>';
    html += '                <option value="new"><?php echo lang('Text.new_tab'); ?></option>';
    html += '            </select>';
    html += '        </div>';
    <?php } ?>
    html += '    </td>';
    html += '    <td class="text-end"><button type="button" id="button-link-' + link_row + '-remove" class="btn btn-danger btn-sm" onclick="$(\'#link-' + link_row + '\').remove();"><i class="fas fa-trash-alt fa-fw"></i></button></td>';
    html += '</tr>';

    $('#links table tbody').append(html);

    link_row++;
});
//--></script>
<?php echo $footer; ?>
