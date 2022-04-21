<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-profile']); ?>
        <fieldset>
            <div class="mb-3 required">
                <label for="input-username" class="form-label"><?php echo lang('Entry.username'); ?></label>
                <input type="text" name="username" value="<?php echo $username; ?>" id="input-username" class="form-control" placeholder="<?php echo lang('Entry.username'); ?>">
                <?php if (!empty($error_username)) { ?><div class="text-danger small"><?php echo $error_username; ?></div><?php } ?>
            </div>
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
                <label for="input-telephone" class="form-label"><?php echo lang('Entry.telephone'); ?></label>
                <input type="text" name="telephone" value="<?php echo $telephone; ?>" id="input-telephone" class="form-control" placeholder="<?php echo lang('Entry.telephone'); ?>">
                <?php if (!empty($error_telephone)) { ?><div class="text-danger small"><?php echo $error_telephone; ?></div><?php } ?>
            </div>
            <div class="mb-3 required">
                <label for="input-email" class="form-label"><?php echo lang('Entry.email'); ?></label>
                <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" placeholder="<?php echo lang('Entry.email'); ?>">
                <?php if (!empty($error_email)) { ?><div class="text-danger small"><?php echo $error_email; ?></div><?php } ?>
            </div>
        </fieldset>
        <div class="buttons clearfix">
            <div class="float-end"><button type="submit" class="btn btn-primary" id="button-profile"><?php echo lang('Button.edit'); ?></button></div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>