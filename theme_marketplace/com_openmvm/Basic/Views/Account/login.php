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
                            <input type="text" name="email" value="" id="input-email" class="form-control" placeholder="<?php echo lang('Entry.email'); ?>">
                        </div>
                        <div class="mb-3 required">
                            <label for="input-password" class="form-label"><?php echo lang('Entry.password'); ?></label>
                            <input type="password" name="password" value="" id="input-password" class="form-control" placeholder="<?php echo lang('Entry.password'); ?>">
                        </div>
                    </fieldset>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary button-action" data-form="form-login" data-form-action="<?php echo $action; ?>" data-icon="fa-lock" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-lock fa-fw"></i> <?php echo lang('Button.login', [], 'en'); ?></button>
                    </div>
                    <div class="mt-3"><a href="<?php echo $reset_password; ?>" class="text-decoration-none"><?php echo lang('Text.forgot_password'); ?></a></div>
                    <div class="mt-3"><a href="<?php echo $register; ?>" class="text-decoration-none"><?php echo lang('Text.register'); ?></a></div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>