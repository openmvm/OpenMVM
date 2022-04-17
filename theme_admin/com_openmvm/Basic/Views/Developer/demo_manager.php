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
                <h3 class="card-title"><i class="fas fa-wrench fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo lang('Heading.edit'); ?></h5> <div class="float-end"><a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-3"><h5><?php echo lang('Text.demo_manager_upload_message'); ?></h5></div>
                        <div class="text-danger text-center mb-5"><h6><?php echo lang('Text.demo_manager_upload_warning'); ?></h6></div>
                        <div class="text-center"><button type="button" id="button-upload" class="btn btn-primary" onclick="upload();"><i class="fas fa-upload fa-fw"></i> <?php echo lang('Button.upload'); ?></button></div>
                        <div id="action-container"></div>
                    </div>
                </div>
                <div id="progress-text"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
function upload() {
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
                    $('#action-container').html('<div id="progress-bar" class="border small p-1 mt-3"><div id="progress-percentage" class="text-muted text-center small"></div><div class="bg-success" style="height: 2px; width: 0%;"></div></div>');

                    xhr.upload.addEventListener("progress", function(evt) {
                          if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $('#action-container').find('#progress-percentage').html(percentComplete + '%');
                                $('#action-container').find('#progress-bar .bg-success').css('width', percentComplete + '%');
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
                    $('#button-upload i').removeClass('fa-upload').addClass('fa-spinner fa-spin');
                    $('#progress-text').append('<div class="my-3"><strong><?php echo lang('Text.installing_demo_data'); ?></strong></div><div id="upload" class="mb-2"><em><?php echo lang('Text.uploading'); ?></em> <i class="fas fa-spinner fa-spin"></i></div>');
                },
                complete: function() {
                    $('#button-upload i').removeClass('fa-spinner fa-spin').addClass('fa-upload');
                },
                success: function(json) {
                    if (json['zipfile']) {
                        extract(json['zipfile']);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }, 500);
}

function extract(zipfile) {
    $.ajax({
        url: '<?php echo $extract; ?>',
        type: 'post',
        dataType: 'json',
        data: {
            zipfile: zipfile
        },
        beforeSend: function() {
            $('#upload i').removeClass('fa-spinner fa-spin').addClass('fa-check');
            $('#progress-text').append('<div id="extract" class="mb-2"><em><?php echo lang('Text.extracting'); ?> (' + zipfile + ')</em> <i class="fas fa-spinner fa-spin"></i></div>');
        },
        complete: function() {
            //$('#button-rebuild-cache i').removeClass('fa-spinner fa-spin').addClass('fa-broom');
        },
        success: function(json) {
            if (json['error']) {
                $('#progress-text').append('<div class="mb-2"><em>' + json['error'] + '</em></div>');
            }

            importSql();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function importSql() {
    $.ajax({
        url: '<?php echo $import_sql; ?>',
        type: 'post',
        dataType: 'json',
        data: {},
        beforeSend: function() {
            $('#extract i').removeClass('fa-spinner fa-spin').addClass('fa-check');
            $('#progress-text').append('<div id="import-database" class="mb-2"><em><?php echo lang('Text.importing_database'); ?></em> <i class="fas fa-spinner fa-spin"></i></div>');
        },
        complete: function() {
            //$('#button-rebuild-cache i').removeClass('fa-spinner fa-spin').addClass('fa-broom');
        },
        success: function(json) {
            if (json['error']) {
                $('#progress-text').append('<div class="mb-2"><em>' + json['error'] + '</em></div>');
            }

            $('#import-database i').removeClass('fa-spinner fa-spin').addClass('fa-check');
            $('#progress-text').append('<div class="mb-2"><em><?php echo lang('Success.demo_data_install'); ?></em></div>');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
//--></script> 
<?php echo $footer; ?>
