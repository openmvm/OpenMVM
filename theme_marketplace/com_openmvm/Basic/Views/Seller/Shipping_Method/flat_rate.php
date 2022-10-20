<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-shipping-method']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo lang('Heading.edit', [], $language_lib->getCurrentCode()); ?></h5> <div class="float-end"><button type="submit" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.save', [], $language_lib->getCurrentCode()); ?>"><i class="fas fa-save fa-fw"></i></button> <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.cancel', [], $language_lib->getCurrentCode()); ?>"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-rate" class="form-label"><?php echo lang('Entry.rate', [], $language_lib->getCurrentCode()); ?></label>
                        <input type="number" step="any" min="0" name="rate" value="<?php echo $rate; ?>" id="input-rate" class="form-control" placeholder="<?php echo lang('Entry.rate', [], $language_lib->getCurrentCode()); ?>">
                        <?php if (!empty($error_rate)) { ?><div class="text-danger small"><?php echo $error_rate; ?></div><?php } ?>
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
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>
