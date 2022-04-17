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
                <h3 class="card-title"><i class="fas fa-code fa-fw"></i> <?php echo $heading_title; ?></h3>
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
        <?php echo form_open($action, ['id' => 'form-widget']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5> <div class="float-end"><button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-save fa-fw"></i></button> <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <div class="mb-3 required">
                    <label for="input-username" class="form-label"><?php echo lang('Entry.name'); ?></label>
                    <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" placeholder="<?php echo lang('Entry.name'); ?>">
                    <?php if (!empty($error_name)) { ?><div class="text-danger small"><?php echo $error_name; ?></div><?php } ?>
                </div>
                <div class="mb-3 required">
                    <label for="input-height" class="form-label"><?php echo lang('Entry.height'); ?></label>
                    <div class="input-group mb-3">
                        <input type="number" name="height" value="<?php echo $height; ?>" class="form-control" placeholder="<?php echo lang('Entry.height'); ?>" aria-label="<?php echo lang('Entry.height'); ?>" aria-describedby="addon-height">
                        <span class="input-group-text" id="addon-height">px</span>
                    </div>
                </div>
                <div class="mb-3 required">
                    <label for="input-background-color" class="form-label"><?php echo lang('Entry.background_color'); ?></label>
                    <input type="color" name="background_color" value="<?php echo $background_color; ?>" id="input-background-color" class="form-control" placeholder="<?php echo lang('Entry.background_color'); ?>" title="<?php echo $background_color; ?>">
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
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>
