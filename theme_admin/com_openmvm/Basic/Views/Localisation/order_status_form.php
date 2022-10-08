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
                <h3 class="card-title"><i class="fas fa-clipboard-list fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-order-status']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-order-status" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-order-status" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <fieldset>
                    <ul class="nav nav-tabs mb-3" id="description-tab" role="tablist">
                        <?php foreach ($languages as $language) { ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="language-<?php echo $language['language_id']; ?>-tab" data-bs-toggle="tab" data-bs-target="#language-<?php echo $language['language_id']; ?>-tab-pane" type="button" role="tab" aria-controls="language-<?php echo $language['language_id']; ?>-tab-pane" aria-selected="false"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /> <?php echo $language['name']; ?></button>
                        </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content" id="description-tab-content">
                        <?php foreach ($languages as $language) { ?>
                        <div class="tab-pane fade" id="language-<?php echo $language['language_id']; ?>-tab-pane" role="tabpanel" aria-labelledby="language-<?php echo $language['language_id']; ?>-tab" tabindex="0">
                            <div class="mb-3 required">
                                <label for="input-name" class="form-label"><?php echo lang('Entry.name'); ?></label>
                                <input type="text" name="description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($description[$language['language_id']]['name']) ? $description[$language['language_id']]['name'] : ''; ?>" class="form-control" id="input-description-name-<?php echo $language['language_id']; ?>" placeholder="<?php echo lang('Entry.name'); ?>" aria-label="<?php echo lang('Entry.name'); ?>" aria-describedby="description-name-<?php echo $language['language_id']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-description-message-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.default_message'); ?></label>
                                <textarea name="description[<?php echo $language['language_id']; ?>][message]" id="input-description-message-<?php echo $language['language_id']; ?>" class="form-control editor" placeholder="<?php echo lang('Entry.default_message'); ?>"><?php echo isset($description[$language['language_id']]['message']) ? $description[$language['language_id']]['message'] : ''; ?></textarea>
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
    var triggerFirstTabEl = document.querySelector('#description-tab li:first-child button')
    new bootstrap.Tab(triggerFirstTabEl).show()
});
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
    tinymce.init({
    selector: '.editor',
    height: 300,
    });
});
//--></script>
<?php echo $footer; ?>
