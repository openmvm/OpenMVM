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
                <h3 class="card-title"><i class="fas fa-coins fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-currency']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-currency" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-currency" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-name" class="form-label"><?php echo lang('Entry.name'); ?></label>
                        <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" placeholder="<?php echo lang('Entry.name'); ?>">
                        <?php if (!empty($error_name)) { ?><div class="text-danger small"><?php echo $error_name; ?></div><?php } ?>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-code" class="form-label"><?php echo lang('Entry.code'); ?></label>
                        <input type="text" name="code" value="<?php echo $code; ?>" id="input-code" class="form-control" placeholder="<?php echo lang('Entry.code'); ?>">
                        <?php if (!empty($error_code)) { ?><div class="text-danger small"><?php echo $error_code; ?></div><?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="input-symbol-left" class="form-label"><?php echo lang('Entry.symbol_left'); ?></label>
                        <input type="text" name="symbol_left" value="<?php echo $symbol_left; ?>" id="input-symbol-left" class="form-control" placeholder="<?php echo lang('Entry.symbol_left'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="input-symbol-right" class="form-label"><?php echo lang('Entry.symbol_right'); ?></label>
                        <input type="text" name="symbol_right" value="<?php echo $symbol_right; ?>" id="input-symbol-right" class="form-control" placeholder="<?php echo lang('Entry.symbol_right'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="input-decimal-place" class="form-label"><?php echo lang('Entry.decimal_place'); ?></label>
                        <input type="number" min="0" max="9" name="decimal_place" value="<?php echo $decimal_place; ?>" id="input-decimal-place" class="form-control" placeholder="<?php echo lang('Entry.decimal_place'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="input-value" class="form-label"><?php echo lang('Entry.value'); ?></label>
                        <input type="number" min="0" step="any" name="value" value="<?php echo $value; ?>" id="input-value" class="form-control" placeholder="<?php echo lang('Entry.value'); ?>">
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
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>
