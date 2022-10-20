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
                <h3 class="card-title"><i class="fas fa-file fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-page']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-page" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-page" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3">
                        <label for="input-sort-order" class="form-label"><?php echo lang('Entry.sort_order'); ?></label>
                        <input type="number" name="sort_order" value="<?php echo $sort_order; ?>" id="input-sort-order" class="form-control" placeholder="<?php echo lang('Entry.sort_order'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="input-status" class="form-label"><?php echo lang('Entry.status'); ?></label>
                        <select name="status" id="input-status" class="form-select">
                            <?php if ($status) { ?>
                            <option value="0"><?php echo lang('Text.disabled'); ?></option>
                            <option value="1" selected="selected"><?php echo lang('Text.enabled'); ?></option>
                            <?php } else { ?>
                            <option value="0" selected="selected"><?php echo lang('Text.disabled'); ?></option>
                            <option value="1"><?php echo lang('Text.enabled'); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <ul class="nav nav-tabs" id="description-tab" role="tablist">
                        <?php foreach ($languages as $language) { ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="language-<?php echo $language['language_id']; ?>-tab" data-bs-toggle="tab" data-bs-target="#language-<?php echo $language['language_id']; ?>" type="button" role="tab" aria-controls="language-<?php echo $language['language_id']; ?>" aria-selected="false"><img src="<?php echo base_url() . '/assets/flags/' . $language['code'] . '.png'; ?>" /> <?php echo $language['name']; ?></button>
                        </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content" id="description-tab-content">
                        <?php foreach ($languages as $language) { ?>
                        <div class="tab-pane fade" id="language-<?php echo $language['language_id']; ?>" role="tabpanel" aria-labelledby="language-<?php echo $language['language_id']; ?>-tab">
                            <div class="mb-3 required">
                                <label for="input-title-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.title'); ?></label>
                                <input type="text" name="description[<?php echo $language['language_id']; ?>][title]" value="<?php echo ($description ? $description[$language['language_id']]['title'] : ''); ?>" id="input-title-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.title'); ?>">
                                <?php if (!empty($error_description[$language['language_id']]['title'])) { ?><div class="text-danger small"><?php echo $error_description[$language['language_id']]['title']; ?></div><?php } ?>
                            </div>
                            <div class="mb-3 required">
                                <label for="input-description-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.description'); ?></label>
                                <textarea rows="5" name="description[<?php echo $language['language_id']; ?>][description]" id="input-description-<?php echo $language['language_id']; ?>" class="form-control editor" placeholder="<?php echo lang('Entry.description'); ?>"><?php echo ($description ? $description[$language['language_id']]['description'] : ''); ?></textarea>
                                <?php if (!empty($error_description[$language['language_id']]['description'])) { ?><div class="text-danger small"><?php echo $error_description[$language['language_id']]['description']; ?></div><?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </fieldset>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
    tinymce.init({
    selector: '.editor',
    height: 300,
    });
});
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
    var triggerFirstTabEl = document.querySelector('#description-tab li:first-child button')
    new bootstrap.Tab(triggerFirstTabEl).show()
});
//--></script>
<?php echo $footer; ?>
