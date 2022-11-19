<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-register']); ?>
        <div class="row">
            <div class="col-sm-12">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-store-name" class="form-label"><?php echo lang('Entry.store_name', [], $language_lib->getCurrentCode()); ?></label>
                        <input type="text" name="store_name" value="<?php echo $store_name; ?>" id="input-store-name" class="form-control" placeholder="<?php echo lang('Entry.store_name', [], $language_lib->getCurrentCode()); ?>">
                    </div>
                    <div class="mb-3 required">
                        <label for="input-store-description" class="form-label"><?php echo lang('Entry.store_description', [], $language_lib->getCurrentCode()); ?></label>
                        <textarea rows="10" name="store_description" value="" id="input-store-description" class="form-control" placeholder="<?php echo lang('Entry.store_description', [], $language_lib->getCurrentCode()); ?>"><?php echo $store_description; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="input-logo" class="form-label"><?php echo lang('Entry.logo', [], $language_lib->getCurrentCode()); ?></label>
                        <div class="position-relative d-flex align-items-center border p-1" style="width: 110px; height: 110px;"><a href="javascript:void(0);" id="upload-logo" class="upload"><img src="<?php echo $logo_thumb; ?>" class="mx-auto d-block" /><input type="hidden" name="logo" value="<?php echo $logo; ?>" id="input-logo" class="form-control" /></a><span class="position-absolute bottom-0 start-0 progress-bar"></span></div>
                    </div>
                    <div class="mb-3">
                        <label for="input-cover" class="form-label"><?php echo lang('Entry.cover', [], $language_lib->getCurrentCode()); ?></label>
                        <div class="position-relative d-flex align-items-center border p-1" style="width: 110px; height: 110px;"><a href="javascript:void(0);" id="upload-cover" class="upload"><img src="<?php echo $cover_thumb; ?>" class="mx-auto d-block" /><input type="hidden" name="cover" value="<?php echo $cover; ?>" id="input-cover" class="form-control" /></a><span class="position-absolute bottom-0 start-0 progress-bar"></span></div>
                    </div>
                    <div class="mb-3">
                        <label for="input-timezone" class="form-label"><?php echo lang('Entry.timezone', [], $language_lib->getCurrentCode()); ?></label>
                        <select name="timezone" id="input-timezone" class="form-select">
                            <?php foreach ($timezones as $tz) { ?>
                            <option value="<?php echo $tz['timezone']; ?>"><?php echo $tz['timezone']; ?> (UTC<?php echo $tz['offset']; ?>)</option>
                            <?php } ?>
                        </select>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="buttons clearfix">
            <div class="float-end">
                <button type="button" class="btn btn-primary button-action" data-form="form-register" data-form-action="<?php echo $action; ?>" data-icon="fa-file-pen" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-file-pen fa-fw"></i> <?php echo lang('Button.register', [], $language_lib->getCurrentCode()); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>