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
                <ul class="nav nav-tabs mb-3" id="content-tab" role="tablist">
                    <?php foreach ($languages as $language) { ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="language-<?php echo $language['language_id']; ?>-content-tab" data-bs-toggle="tab" data-bs-target="#language-<?php echo $language['language_id']; ?>-content-content" type="button" role="tab" aria-controls="language-<?php echo $language['language_id']; ?>-content-content" aria-selected="false"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /> <?php echo $language['name']; ?></button>
                    </li>
                    <?php } ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <?php foreach ($languages as $language) { ?>
                    <div class="tab-pane fade" id="language-<?php echo $language['language_id']; ?>-content-content" role="tabpanel" aria-labelledby="language-<?php echo $language['language_id']; ?>-content-tab">
                        <div class="mb-3">
                            <label for="input-title-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.title'); ?></label>
                            <input type="text" name="content[<?php echo $language['language_id']; ?>][title]" value="<?php echo $content[$language['language_id']]['title']; ?>" id="input-title-language-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.title'); ?>" />
                        </div>
                        <div class="mb-3">
                            <label for="input-content-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.content'); ?></label>
                            <textarea name="content[<?php echo $language['language_id']; ?>][content]" id="input-content-language-<?php echo $language['language_id']; ?>" class="form-control editor" placeholder="<?php echo lang('Entry.content'); ?>"><?php echo $content[$language['language_id']]['content']; ?></textarea>
                        </div>
                    </div>
                    <?php } ?>
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
    height: 600,
    });
});
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
    var triggerFirstTabEl = document.querySelector('#content-tab li:first-child button')
    new bootstrap.Tab(triggerFirstTabEl).show()
});
//--></script>
<?php echo $footer; ?>
