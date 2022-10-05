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
                <h3 class="card-title"><i class="fas fa-globe-americas fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-country']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-country" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-country" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
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
                    <div class="mb-3">
                        <label for="input-iso-code-2" class="form-label"><?php echo lang('Entry.iso_code_2'); ?></label>
                        <input type="text" name="iso_code_2" value="<?php echo $iso_code_2; ?>" id="input-iso-code-2" class="form-control" placeholder="<?php echo lang('Entry.iso_code_2'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="input-iso-code-3" class="form-label"><?php echo lang('Entry.iso_code_3'); ?></label>
                        <input type="text" name="iso_code_3" value="<?php echo $iso_code_3; ?>" id="input-iso-code-3" class="form-control" placeholder="<?php echo lang('Entry.iso_code_3'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="input-dialing-code" class="form-label"><?php echo lang('Entry.dialing_code'); ?></label>
                        <input type="text" name="dialing_code" value="<?php echo $dialing_code; ?>" id="input-dialing-code" class="form-control" placeholder="<?php echo lang('Entry.dialing_code'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="input-postal-code-required" class="form-label"><?php echo lang('Entry.postal_code_required'); ?></label>
                        <select name="postal_code_required" id="input-postal-code-required" class="form-control">
                            <?php if ($postal_code_required) { ?>
                            <option value="0"><?php echo lang('Text.no'); ?></option>
                            <option value="1" selected="selected"><?php echo lang('Text.yes'); ?></option>
                            <?php } else { ?>
                            <option value="0" selected="selected"><?php echo lang('Text.no'); ?></option>
                            <option value="1"><?php echo lang('Text.yes'); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="input-sort-order" class="form-label"><?php echo lang('Entry.sort_order'); ?></label>
                        <input type="number" name="sort_order" value="<?php echo $sort_order; ?>" id="input-sort-order" class="form-control" placeholder="<?php echo lang('Entry.sort_order'); ?>">
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
                </fieldset>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>
