<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-seller']); ?>
        <fieldset>
            <div class="mb-3 required">
                <label for="input-store-name" class="form-label"><?php echo lang('Entry.store_name', [], $language_lib->getCurrentCode()); ?></label>
                <input type="text" name="store_name" value="<?php echo $store_name; ?>" id="input-store-name" class="form-control" placeholder="<?php echo lang('Entry.store_name', [], $language_lib->getCurrentCode()); ?>">
                <?php if (!empty($error_store_name)) { ?><div class="text-danger small"><?php echo $error_store_name; ?></div><?php } ?>
            </div>
            <div class="mb-3 required">
                <label for="input-store-description" class="form-label"><?php echo lang('Entry.store_description', [], $language_lib->getCurrentCode()); ?></label>
                <textarea rows="10" name="store_description" id="input-store-description" class="form-control" placeholder="<?php echo lang('Entry.store_description', [], $language_lib->getCurrentCode()); ?>"><?php echo $store_description; ?></textarea>
                <?php if (!empty($error_store_description)) { ?><div class="text-danger small"><?php echo $error_store_description; ?></div><?php } ?>
            </div>
            <div class="mb-3">
                <label for="input-logo" class="form-label"><?php echo lang('Entry.logo', [], $language_lib->getCurrentCode()); ?></label>
                <div class="position-relative d-flex align-items-center border p-1" style="width: 110px; height: 110px;"><a href="javascript:void(0);" id="upload-logo" class="upload"><img src="<?php echo $logo_thumb; ?>" class="mx-auto d-block" /><input type="hidden" name="logo" value="<?php echo $logo; ?>" id="input-logo" class="form-control" /></a><span class="position-absolute bottom-0 start-0 progress-bar"></span></div>
            </div>
            <div class="mb-3">
                <label for="input-cover" class="form-label"><?php echo lang('Entry.cover', [], $language_lib->getCurrentCode()); ?></label>
                <div class="position-relative d-flex align-items-center border p-1" style="width: 110px; height: 110px;"><a href="javascript:void(0);" id="upload-cover" class="upload"><img src="<?php echo $cover_thumb; ?>" class="mx-auto d-block" /><input type="hidden" name="cover" value="<?php echo $cover; ?>" id="input-cover" class="form-control" /></a><span class="position-absolute bottom-0 start-0 progress-bar"></span></div>
            </div>
            <div class="mb-3">
                <label for="input-timezone" class="form-label"><?php echo lang('Entry.timezone', [], $language_lib->getCurrentCode()); ?></label>
                <select name="timezone" id="input-timezone" class="form-select">
                    <?php foreach ($timezones as $tz) { ?>
                        <?php if ($tz['timezone'] == $timezone) { ?>
                        <option value="<?php echo $tz['timezone']; ?>" selected><?php echo $tz['timezone']; ?> (UTC<?php echo $tz['offset']; ?>)</option>
                        <?php } else { ?>
                        <option value="<?php echo $tz['timezone']; ?>"><?php echo $tz['timezone']; ?> (UTC<?php echo $tz['offset']; ?>)</option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </fieldset>
        <div class="buttons clearfix">
            <div class="float-end">
                <button type="button" class="btn btn-primary button-action" data-form="form-seller" data-form-action="<?php echo $action; ?>" data-icon="fa-file-pen" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-file-pen fa-fw"></i> <?php echo lang('Button.edit', [], $language_lib->getCurrentCode()); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
$('.upload').on('click', function() {
    var node = this;

    $('#form-upload').remove();

    $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

    $('#form-upload input[name=\'file\']').trigger('click');

    if (typeof timer != 'undefined') {
        clearInterval(timer);
    }

    timer = setInterval(function() {
        if ($('#form-upload input[name=\'file\']').val() != '') {
            clearInterval(timer);

            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    $(node).parent().find('span.progress-bar').removeAttr( 'style' );

                    xhr.upload.addEventListener("progress", function(evt) {
                          if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $(node).parent().find('span.progress-bar').css('width', percentComplete + '%');
                                console.log(percentComplete);

                                if (percentComplete === 100) {

                                }

                          }
                    }, false);

                    return xhr;
                },
                url: '<?php echo $upload; ?>',
                type: 'post',
                dataType: 'json',
                data: new FormData($('#form-upload')[0]),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(node).button('loading');
                },
                complete: function() {
                    $(node).button('reset');
                },
                success: function(json) {
                    if (json['error']) {
                        alert(JSON.stringify(json['error']));
                    }

                    if (json['success']) {
                        $(node).find('img').attr('src', json['image']['src']);
                        $(node).find('input').val(json['image']['path']);

                        alert(JSON.stringify(json['success']));
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }, 500);
});
//--></script>
<?php echo $footer; ?>
