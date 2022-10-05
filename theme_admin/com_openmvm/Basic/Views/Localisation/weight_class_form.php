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
        <?php echo form_open($action, ['id' => 'form-weight-class']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-weight-class" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-weight-class" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-title" class="form-label"><?php echo lang('Entry.title'); ?></label>
                        <?php foreach ($languages as $language) { ?>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon-title-<?php echo $language['language_id']; ?>"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>
                                <input type="text" name="description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($description[$language['language_id']]['title']) ? $description[$language['language_id']]['title'] : ''; ?>" class="form-control" id="input-title-<?php echo $language['language_id']; ?>" placeholder="<?php echo lang('Entry.title'); ?>" aria-label="<?php echo lang('Entry.title'); ?>" aria-describedby="basic-addon-title-<?php echo $language['language_id']; ?>">
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-unit" class="form-label"><?php echo lang('Entry.unit'); ?></label>
                        <?php foreach ($languages as $language) { ?>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon-unit-<?php echo $language['language_id']; ?>"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></span>
                                <input type="text" name="description[<?php echo $language['language_id']; ?>][unit]" value="<?php echo isset($description[$language['language_id']]['unit']) ? $description[$language['language_id']]['unit'] : ''; ?>" class="form-control" id="input-unit-<?php echo $language['language_id']; ?>" placeholder="<?php echo lang('Entry.unit'); ?>" aria-label="<?php echo lang('Entry.unit'); ?>" aria-describedby="basic-addon-unit-<?php echo $language['language_id']; ?>">
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-value" class="form-label"><?php echo lang('Entry.value'); ?></label>
                        <input type="number" min="0" step="any" name="value" value="<?php echo $value; ?>" id="input-value" class="form-control" placeholder="<?php echo lang('Entry.value'); ?>">
                    </div>
                </fieldset>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>
