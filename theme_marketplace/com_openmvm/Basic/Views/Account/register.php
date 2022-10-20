<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-register']); ?>
        <div class="row vertical-divider">
            <div class="col-sm-6">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-firstname" class="form-label"><?php echo lang('Entry.firstname', [], $language_lib->getCurrentCode()); ?></label>
                        <input type="text" name="firstname" value="" id="input-firstname" class="form-control" placeholder="<?php echo lang('Entry.firstname', [], $language_lib->getCurrentCode()); ?>">
                    </div>
                    <div class="mb-3 required">
                        <label for="input-lastname" class="form-label"><?php echo lang('Entry.lastname', [], $language_lib->getCurrentCode()); ?></label>
                        <input type="text" name="lastname" value="" id="input-lastname" class="form-control" placeholder="<?php echo lang('Entry.lastname', [], $language_lib->getCurrentCode()); ?>">
                    </div>
                    <div class="mb-3 required">
                        <label for="input-email" class="form-label"><?php echo lang('Entry.email', [], $language_lib->getCurrentCode()); ?></label>
                        <input type="text" name="email" value="" id="input-email" class="form-control" placeholder="<?php echo lang('Entry.email', [], $language_lib->getCurrentCode()); ?>">
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-6">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-username" class="form-label"><?php echo lang('Entry.username', [], $language_lib->getCurrentCode()); ?></label>
                        <input type="text" name="username" value="" id="input-username" class="form-control" placeholder="<?php echo lang('Entry.username', [], $language_lib->getCurrentCode()); ?>">
                    </div>
                    <div class="mb-3 required">
                        <label for="input-password" class="form-label"><?php echo lang('Entry.password', [], $language_lib->getCurrentCode()); ?></label>
                        <input type="password" name="password" value="" id="input-password" class="form-control" placeholder="<?php echo lang('Entry.password', [], $language_lib->getCurrentCode()); ?>">
                    </div>
                    <div class="mb-3 required">
                        <label for="input-passconf" class="form-label"><?php echo lang('Entry.passconf', [], $language_lib->getCurrentCode()); ?></label>
                        <input type="password" name="passconf" value="" id="input-passconf" class="form-control" placeholder="<?php echo lang('Entry.passconf', [], $language_lib->getCurrentCode()); ?>">
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="buttons clearfix">
            <div class="float-end">
                <button type="button" class="btn btn-primary button-action" data-form="form-register" data-form-action="<?php echo $action; ?>" data-icon="fa-file-pen" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-file-pen fa-fw"></i> <?php echo lang('Button.register', [], $language_lib->getCurrentCode()); ?></button>
            </div>
        </div>
        <div class="buttons clearfix mt-3">
            <div class="float-end"><?php echo lang('Text.already_a_member', [], $language_lib->getCurrentCode()); ?> <a href="<?php echo $login; ?>"><?php echo lang('Text.please_login', [], $language_lib->getCurrentCode()); ?></a></div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>