<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-seller-faq']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-seller-faq" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], $language_lib->getCurrentCode()); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-seller-faq" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], $language_lib->getCurrentCode()); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="seller-faq-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.general'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="false"><?php echo lang('Tab.data'); ?></button>
                    </li>
                </ul>
                <div class="tab-content" id="seller-faq-tab-content">
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <ul class="nav nav-tabs mb-3" id="language-tab" role="tablist">
                            <?php foreach ($languages as $language) { ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="language-tab-<?php echo $language['language_id']; ?>" data-bs-toggle="tab" data-bs-target="#language-<?php echo $language['language_id']; ?>" type="button" role="tab" aria-controls="language-<?php echo $language['language_id']; ?>" aria-selected="true"><img src="<?php echo base_url() . '/assets/flags/' . $language['code'] . '.png'; ?>" /> <?php echo $language['name']; ?></button>
                            </li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content" id="language-tab-content">
                            <?php foreach ($languages as $language) { ?>
                            <div class="tab-pane fade" id="language-<?php echo $language['language_id']; ?>" role="tabpanel" aria-labelledby="language-tab-<?php echo $language['language_id']; ?>">
                                <fieldset>
                                    <div class="mb-3 required">
                                        <label for="input-question-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.question'); ?></label>
                                        <input type="text" name="seller_faq_description[<?php echo $language['language_id']; ?>][question]" value="<?php echo isset($seller_faq_description[$language['language_id']]['question']) ? $seller_faq_description[$language['language_id']]['question']: ''; ?>" id="input-question-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.question'); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="input-answer-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.answer'); ?></label>
                                        <textarea rows="10" name="seller_faq_description[<?php echo $language['language_id']; ?>][answer]" id="input-answer-<?php echo $language['language_id']; ?>" class="form-control editor" placeholder="<?php echo lang('Entry.answer'); ?>"><?php echo isset($seller_faq_description[$language['language_id']]['answer']) ? $seller_faq_description[$language['language_id']]['answer'] : ''; ?></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">
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
                        </fieldset>
                    </div>
                </div>
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
    var triggerFirstTabEl = document.querySelector('#language-tab li:first-child button')
    new bootstrap.Tab(triggerFirstTabEl).show()
});
//--></script>
<?php echo $footer; ?>
