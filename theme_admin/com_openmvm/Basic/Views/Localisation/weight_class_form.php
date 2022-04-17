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
                <h3 class="card-title"><i class="fas fa-weight fa-fw"></i> <?php echo $heading_title; ?></h3>
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
        <?php echo form_open($action, ['id' => 'form-weight-class']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5> <div class="float-end"><button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-save fa-fw"></i></button> <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-title" class="form-label"><?php echo lang('Entry.title'); ?></label>
                        <?php foreach ($languages as $language) { ?>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon-title-<?php echo $language['language_id']; ?>"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>
                                <input type="text" name="description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($description[$language['language_id']]['title']) ? $description[$language['language_id']]['title'] : ''; ?>" class="form-control" placeholder="<?php echo lang('Entry.title'); ?>" aria-label="<?php echo lang('Entry.title'); ?>" aria-describedby="basic-addon-title-<?php echo $language['language_id']; ?>">
                            </div>
                            <?php if (!empty($error_description[$language['language_id']]['title'])) { ?><div class="text-danger small"><?php echo $error_description[$language['language_id']]['title']; ?></div><?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-unit" class="form-label"><?php echo lang('Entry.unit'); ?></label>
                        <?php foreach ($languages as $language) { ?>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon-unit-<?php echo $language['language_id']; ?>"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>
                                <input type="text" name="description[<?php echo $language['language_id']; ?>][unit]" value="<?php echo isset($description[$language['language_id']]['unit']) ? $description[$language['language_id']]['unit'] : ''; ?>" class="form-control" placeholder="<?php echo lang('Entry.unit'); ?>" aria-label="<?php echo lang('Entry.unit'); ?>" aria-describedby="basic-addon-unit-<?php echo $language['language_id']; ?>">
                            </div>
                            <?php if (!empty($error_description[$language['language_id']]['unit'])) { ?><div class="text-danger small"><?php echo $error_description[$language['language_id']]['unit']; ?></div><?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-value" class="form-label"><?php echo lang('Entry.value'); ?></label>
                        <input type="number" min="0" step="any" name="value" value="<?php echo $value; ?>" id="input-value" class="form-control" placeholder="<?php echo lang('Entry.value'); ?>">
                        <?php if (!empty($error_value)) { ?><div class="text-danger small"><?php echo $error_value; ?></div><?php } ?>
                    </div>
                </fieldset>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>
