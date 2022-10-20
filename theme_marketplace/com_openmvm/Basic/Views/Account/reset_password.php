<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <?php echo form_open($action, ['id' => 'form-reset-password']); ?>
        <div>
            <div class="card shadow mx-auto" style="max-width: 500px;">
                <div class="card-body">
                    <h3><?php echo $heading_title; ?></h3>
                    <p class="border-bottom text-start pb-3 mb-3"><?php echo $reset_password_instruction; ?></p>
                    <fieldset>
                        <div class="mb-3 required">
                            <label for="input-email" class="form-label"><?php echo lang('Entry.email', [], $language_lib->getCurrentCode()); ?></label>
                            <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" placeholder="<?php echo lang('Entry.email', [], $language_lib->getCurrentCode()); ?>">
                            <?php if (!empty($error_email)) { ?><div class="text-danger small"><?php echo $error_email; ?></div><?php } ?>
                        </div>
                    </fieldset>
                    <div class="d-grid gap-2">
                        <button id="button-reset-password" class="btn btn-primary" type="submit"><?php echo lang('Button.reset_password', [], $language_lib->getCurrentCode()); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>