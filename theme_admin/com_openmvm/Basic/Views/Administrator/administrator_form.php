<?php echo $header; ?><?php echo $column_left; ?>
<div class="container-fluid">
    <div id="content" class="content">
        <?php if ($breadcrumbs) { ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <?php if ($breadcrumb['active']) { ?>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
                    <?php } else { ?>
                    <li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                    <?php } ?>
                <?php } ?>
            </ol>
        </nav>
        <?php } ?>
        <div class="card border-0 shadow heading mb-3">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-user-tie fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php if ($error_warning) { ?>
        <div class="alert alert-warning alert-dismissible border-0 shadow fade show" role="alert">
            <?php echo $error_warning; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert alert-success alert-dismissible border-0 shadow fade show" role="alert">
            <?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>
        <?php echo form_open($action, ['id' => 'form-administrator']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5> <div class="float-end"><button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-save fa-fw"></i></button> <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3">
                        <label for="input-administrator-group" class="form-label"><?php echo lang('Entry.administrator_group'); ?></label>
                        <select name="administrator_group_id" id="input-administrator-group" class="form-control">
                            <?php foreach ($administrator_groups as $administrator_group) { ?>
                                <?php if ($administrator_group['administrator_group_id'] == $administrator_group_id) { ?>
                                <option value="<?php echo $administrator_group['administrator_group_id']; ?>" selected="selected"><?php echo $administrator_group['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $administrator_group['administrator_group_id']; ?>"><?php echo $administrator_group['name']; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="input-avatar" class="form-label"><?php echo lang('Entry.avatar'); ?></label>
                        <div class="card" style="width: 110px;">
                            <div class="card-body bg-secondary bg-opacity-10 p-1">
                                <div class="d-flex align-items-center mb-1" style="height: 100px;" data-image-manager="image" data-image-manager-dismiss="<?php echo lang('Button.close'); ?>" data-image-manager-title="<?php echo lang('Heading.image_manager'); ?>" role="button"><img src="<?php echo $avatar_thumb; ?>" class="mx-auto d-block" /><input type="hidden" name="avatar" value="<?php echo $avatar; ?>" id="input-image" class="form-control" placeholder="<?php echo lang('Entry.image'); ?>" data-image-manager-target="image" style="width: 200px;" /></div>
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-danger" data-image-manager-remove="image" data-image-manager-placeholder="<?php echo $placeholder; ?>"><i class="fas fa-trash-alt fa-fw"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="mb-3">
                        <label for="input-status" class="form-label"><?php echo lang('Entry.status'); ?></label>
                        <select name="status" id="input-status" class="form-control">
                            <?php if ($status) { ?>
                            <option value="0"><?php echo lang('Text.disabled'); ?></option>
                            <option value="1" selected="selected"><?php echo lang('Text.enabled'); ?></option>
                            <?php } else { ?>
                            <option value="0" selected="selected"><?php echo lang('Text.disabled'); ?></option>
                            <option value="1"><?php echo lang('Text.enabled'); ?></option>
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
