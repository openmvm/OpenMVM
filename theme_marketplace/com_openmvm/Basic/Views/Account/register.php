<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-register']); ?>
        <div class="row vertical-divider">
            <div class="col-sm-6">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-firstname" class="form-label"><?php echo lang('Entry.firstname'); ?></label>
                        <input type="text" name="firstname" value="" id="input-firstname" class="form-control" placeholder="<?php echo lang('Entry.firstname'); ?>">
                    </div>
                    <div class="mb-3 required">
                        <label for="input-lastname" class="form-label"><?php echo lang('Entry.lastname'); ?></label>
                        <input type="text" name="lastname" value="" id="input-lastname" class="form-control" placeholder="<?php echo lang('Entry.lastname'); ?>">
                    </div>
                    <div class="mb-3 required">
                        <label for="input-email" class="form-label"><?php echo lang('Entry.email'); ?></label>
                        <input type="text" name="email" value="" id="input-email" class="form-control" placeholder="<?php echo lang('Entry.email'); ?>">
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-6">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-username" class="form-label"><?php echo lang('Entry.username'); ?></label>
                        <input type="text" name="username" value="" id="input-username" class="form-control" placeholder="<?php echo lang('Entry.username'); ?>">
                    </div>
                    <div class="mb-3 required">
                        <label for="input-password" class="form-label"><?php echo lang('Entry.password'); ?></label>
                        <input type="password" name="password" value="" id="input-password" class="form-control" placeholder="<?php echo lang('Entry.password'); ?>">
                    </div>
                    <div class="mb-3 required">
                        <label for="input-passconf" class="form-label"><?php echo lang('Entry.passconf'); ?></label>
                        <input type="password" name="passconf" value="" id="input-passconf" class="form-control" placeholder="<?php echo lang('Entry.passconf'); ?>">
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="buttons clearfix">
            <div class="float-end">
                <button type="button" class="btn btn-primary button-action" data-form="form-register" data-form-action="<?php echo $action; ?>" data-icon="fa-file-pen" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-file-pen fa-fw"></i> <?php echo lang('Button.register', [], 'en'); ?></button>
            </div>
        </div>
        <div class="buttons clearfix mt-3">
            <div class="float-end"><?php echo lang('Text.already_a_member'); ?> <a href="<?php echo $login; ?>"><?php echo lang('Text.please_login'); ?></a></div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>