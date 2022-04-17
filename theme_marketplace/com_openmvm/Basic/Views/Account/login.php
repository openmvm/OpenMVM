<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <?php echo form_open($action, ['id' => 'form-login']); ?>
        <div>
            <div class="card shadow mx-auto" style="max-width: 300px;">
                <div class="card-body">
                    <h3 class="border-bottom text-start pb-3 mb-3"><?php echo $heading_title; ?></h3>
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
                    </fieldset>
                    <div class="d-grid gap-2">
                        <button id="button-login" class="btn btn-primary" type="submit"><?php echo lang('Button.login'); ?></button>
                    </div>
                    <div class="mt-3"><a href="<?php echo $register; ?>" class="text-decoration-none"><?php echo lang('Text.register'); ?></a></div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>