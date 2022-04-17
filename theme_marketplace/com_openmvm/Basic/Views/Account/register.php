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
                        <input type="text" name="firstname" value="<?php echo $firstname; ?>" id="input-firstname" class="form-control" placeholder="<?php echo lang('Entry.firstname'); ?>">
                        <?php if (!empty($error_firstname)) { ?><div class="text-danger small"><?php echo $error_firstname; ?></div><?php } ?>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-lastname" class="form-label"><?php echo lang('Entry.lastname'); ?></label>
                        <input type="text" name="lastname" value="<?php echo $lastname; ?>" id="input-lastname" class="form-control" placeholder="<?php echo lang('Entry.lastname'); ?>">
                        <?php if (!empty($error_lastname)) { ?><div class="text-danger small"><?php echo $error_lastname; ?></div><?php } ?>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-email" class="form-label"><?php echo lang('Entry.email'); ?></label>
                        <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" placeholder="<?php echo lang('Entry.email'); ?>">
                        <?php if (!empty($error_email)) { ?><div class="text-danger small"><?php echo $error_email; ?></div><?php } ?>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-6">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-username" class="form-label"><?php echo lang('Entry.username'); ?></label>
                        <input type="text" name="username" value="<?php echo $username; ?>" id="input-username" class="form-control" placeholder="<?php echo lang('Entry.username'); ?>">
                        <?php if (!empty($error_username)) { ?><div class="text-danger small"><?php echo $error_username; ?></div><?php } ?>
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
            </div>
        </div>
        <div class="buttons clearfix">
            <div class="float-end"><button type="submit" class="btn btn-primary" id="button-register"><?php echo lang('Button.register'); ?></button></div>
        </div>
        <div class="buttons clearfix mt-3">
            <div class="float-end"><?php echo lang('Text.already_a_member'); ?> <a href="<?php echo $login; ?>"><?php echo lang('Text.please_login'); ?></a></div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>