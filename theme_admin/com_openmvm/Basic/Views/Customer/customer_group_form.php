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
                <h3 class="card-title"><i class="fas fa-user fa-fw"></i> <?php echo $heading_title; ?></h3>
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
        <?php echo form_open($action, ['id' => 'form-customer-group']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5> <div class="float-end"><button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-save fa-fw"></i></button> <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-name" class="form-label"><?php echo lang('Entry.name'); ?></label>
                        <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" placeholder="<?php echo lang('Entry.name'); ?>">
                        <?php if (!empty($error_name)) { ?><div class="text-danger small"><?php echo $error_name; ?></div><?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="input-email-verification" class="form-label"><?php echo lang('Entry.email_verification'); ?></label>
                        <select name="email_verification" id="input-email-verification" class="form-control">
                            <?php if ($email_verification) { ?>
                            <option value="0"><?php echo lang('Text.no'); ?></option>
                            <option value="1" selected="selected"><?php echo lang('Text.yes'); ?></option>
                            <?php } else { ?>
                            <option value="0" selected="selected"><?php echo lang('Text.no'); ?></option>
                            <option value="1"><?php echo lang('Text.yes'); ?></option>
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