<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-option']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-option" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], $language_lib->getCurrentCode()); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-option" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], $language_lib->getCurrentCode()); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <fieldset>
                    <legend class="border-bottom pb-2 mb-3 fs-6"><?php echo lang('Text.general', [], $language_lib->getCurrentCode()); ?></legend>
                    <div class="mb-3">
                        <?php foreach ($languages as $language) { ?>
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="input-group-name-<?php echo $language['language_id']; ?>"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>
                            <input type="text" name="option_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($option_description[$language['language_id']]['name']) ? $option_description[$language['language_id']]['name'] : ''; ?>" id="input-description-name-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.name', [], $language_lib->getCurrentCode()); ?>" aria-label="<?php echo lang('Entry.name', [], $language_lib->getCurrentCode()); ?>" aria-describedby="input-group-name-<?php echo $language['language_id']; ?>">
                        </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="input-sort-order" class="form-label"><?php echo lang('Entry.sort_order', [], $language_lib->getCurrentCode()); ?></label>
                        <input type="number" name="sort_order" value="<?php echo $sort_order; ?>" class="form-control" id="input-sort-order" placeholder="<?php echo lang('Entry.sort_order', [], $language_lib->getCurrentCode()); ?>">
                    </div>
                    <legend class="border-bottom pb-2 mb-3 fs-6"><?php echo lang('Text.values', [], $language_lib->getCurrentCode()); ?></legend>
                    <div id="option-values">
                        <?php $option_value_row = 0; ?>
                        <?php if (!empty($option_values)) { ?>
                            <?php foreach ($option_values as $option_value) { ?>
                            <div id="option-value-<?php echo $option_value_row; ?>" class="position-relative bg-light pt-3 pe-3 pb-3 ps-3 mb-1">
                                <span role="button" class="position-absolute top-0 end-0 small" onclick="removeOptionValue('<?php echo $option_value_row; ?>');"><i class="fas fa-times fa-fw text-secondary"></i>   </span>
                                <div>
                                    <input type="hidden" name="option_value[<?php echo $option_value_row; ?>][option_value_id]" value="<?php echo $option_value['option_value_id']; ?>" class="form-control" id="input-value-<?php echo $option_value_row; ?>-option-value-id">
                                    <div class="mb-2"><?php echo lang('Entry.name', [], $language_lib->getCurrentCode()); ?></div>
                                    <?php foreach ($languages as $language) { ?>
                                    <div class="input-group mb-1">
                                       <span class="input-group-text" id="input-group-value-name-<?php echo $language['language_id']; ?>"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>
                                       <input type="text" name="option_value[<?php echo $option_value_row; ?>][description][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($option_value['description'][$language['language_id']]['name']) ? $option_value['description'][$language['language_id']]['name'] : ''; ?>" class="form-control" placeholder="<?php echo lang('Entry.name', [], $language_lib->getCurrentCode()); ?>" aria-label="<?php echo lang('Entry.name', [], $language_lib->getCurrentCode()); ?>" aria-describedby="input-group-value-name-<?php echo $language['language_id']; ?>">
                                    </div>
                                    <?php } ?>
                                    <div class="mt-2 mb-3">
                                        <label for="input-value-<?php echo $option_value_row; ?>-sort-order" class="form-label"><?php echo lang('Entry.sort_order', [], $language_lib->getCurrentCode()); ?></label>
                                        <input type="number" name="option_value[<?php echo $option_value_row; ?>][sort_order]" value="<?php echo $option_value['sort_order']; ?>" class="form-control" id="input-value-<?php echo $option_value_row; ?>-sort-order" placeholder="<?php echo lang('Entry.sort_order', [], $language_lib->getCurrentCode()); ?>">
                                    </div>
                                </div>
                            </div>
                            <?php $option_value_row++; ?>
                            <?php } ?>
                        <?php } ?>
                        <div class="d-grid"><button type="button" id="button-option-value-add" class="btn btn-outline-primary" onclick="addOptionValue();"><i class="fas fa-plus-circle"></i> <?php echo lang('Button.value_add', [], $language_lib->getCurrentCode()); ?></button></div>
                    </div>
                </fieldset>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
var option_value_row = '<?php echo $option_value_row; ?>';

function addOptionValue() {
    html = '<div id="option-value-' + option_value_row + '" class="position-relative bg-light pt-3 pe-3 pb-3 ps-3 mb-1">';
    html += '   <span role="button" class="position-absolute top-0 end-0 small" onclick="removeOptionValue(\'' + option_value_row + '\');"><i class="fas fa-times fa-fw text-secondary"></i></span>';
    html += '   <div>';
    html += '       <input type="hidden" name="option_value[' + option_value_row + '][option_value_id]" value="0" class="form-control" id="input-value-' + option_value_row + '-option-value-id">';
        <?php foreach ($languages as $language) { ?>
    html += '       <div class="input-group mb-1">';
    html += '           <span class="input-group-text" id="input-group-value-' + option_value_row + '-name-<?php echo $language['language_id']; ?>"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>';
    html += '           <input type="text" name="option_value[' + option_value_row + '][description][<?php echo $language['language_id']; ?>][name]" value="" class="form-control" placeholder="<?php echo lang('Entry.name', [], $language_lib->getCurrentCode()); ?>" aria-label="<?php echo lang('Entry.name', [], $language_lib->getCurrentCode()); ?>" aria-describedby="input-group-value-' + option_value_row + '-name-<?php echo $language['language_id']; ?>">';
    html += '       </div>';
        <?php } ?>
    html += '       <div class="mb-3">';
    html += '           <label for="input-value-' + option_value_row + '-sort-order" class="form-label"><?php echo lang('Entry.sort_order', [], $language_lib->getCurrentCode()); ?></label>';
    html += '           <input type="number" name="option_value[' + option_value_row + '][sort_order]" class="form-control" id="input-value-' + option_value_row + '-sort-order" placeholder="<?php echo lang('Entry.sort_order', [], $language_lib->getCurrentCode()); ?>">';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';

    $('#button-option-value-add').parent().before(html);

    option_value_row++;
}

function removeOptionValue(option_value_row) {
    $('#option-value-' + option_value_row).remove();
}
//--></script>
<?php echo $footer; ?>
