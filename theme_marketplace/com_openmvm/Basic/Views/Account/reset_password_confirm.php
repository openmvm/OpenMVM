<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <?php echo form_open($action, ['id' => 'form-reset-password-confirm']); ?>
        <div>
            <div class="card shadow mx-auto" style="max-width: 500px;">
                <div class="card-body">
                    <h3><?php echo $heading_title; ?></h3>
                    <p class="border-bottom text-start pb-3 mb-3"><?php echo $reset_password_confirm_instruction; ?></p>
                    <fieldset>
                        <div class="mb-3 required">
                            <label for="input-email" class="form-label"><?php echo lang('Entry.email'); ?></label>
                            <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" placeholder="<?php echo lang('Entry.email'); ?>">
                            <?php if (!empty($error_email)) { ?><div class="text-danger small"><?php echo $error_email; ?></div><?php } ?>
                        </div>
                        <div class="mb-3 required">
                            <label for="input-password" class="form-label"><?php echo lang('Entry.password'); ?></label>
                            <input type="password" name="password" value="" id="input-password" class="form-control" placeholder="<?php echo lang('Entry.password'); ?>">
                            <?php if (!empty($error_password)) { ?><div class="text-danger small"><?php echo $error_password; ?></div><?php } ?>
                        </div>
                        <div class="mb-3 required">
                            <label for="input-passconf" class="form-label"><?php echo lang('Entry.passconf'); ?></label>
                            <input type="password" name="passconf" value="" id="input-passconf" class="form-control" placeholder="<?php echo lang('Entry.passconf'); ?>">
                            <?php if (!empty($error_passconf)) { ?><div class="text-danger small"><?php echo $error_passconf; ?></div><?php } ?>
                        </div>
                    </fieldset>
                    <div class="d-grid gap-2">
                        <button id="button-reset-password" class="btn btn-primary" type="submit"><?php echo lang('Button.reset_password'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>