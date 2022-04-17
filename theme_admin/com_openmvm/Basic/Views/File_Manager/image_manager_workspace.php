<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="text-start w-50">
                <div class="btn-toolbar" role="toolbar" aria-label="toolbar-image-manager">
                    <div class="btn-group me-2" role="group" aria-label="home">
                        <button type="button" id="button-home" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Text.home'); ?>" onclick="backToHome();"><i class="fas fa-home fa-fw"></i></button>
                    </div>
                    <div class="btn-group me-2" role="group" aria-label="folder">
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdown-folder-add" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-folder-plus fa-fw"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdown-folder-add" style="width: 12rem;">
                                <li class="p-1">
                                    <form id="form-folder">
                                        <div class="input-group">
                                            <input type="text" name="folder_name" id="input-folder-name" class="form-control" placeholder="<?php echo lang('Entry.folder_name'); ?>" aria-label="<?php echo lang('Entry.folder_name'); ?>" aria-describedby="button-folder-add">
                                            <button class="btn btn-outline-dark" type="button" id="button-folder-add" onclick="createDirectory();"><i class="fas fa-plus fa-fw"></i></button>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>                    
                    </div>
                    <div class="btn-group me-2" role="group" aria-label="upload-download">
                        <button type="button" id="button-upload" class="btn btn-outline-dark" onclick="upload();"><i class="fas fa-upload fa-fw"></i></button>
                        <button type="button" id="button-download" class="btn btn-outline-dark" onclick="download();"><i class="fas fa-download fa-fw"></i></button>
                    </div>
                    <div class="btn-group me-2" role="group" aria-label="refresh">
                        <button type="button" id="button-rebuild-cache" class="btn btn-outline-dark" onclick="rebuildCache();"><i class="fas fa-broom fa-fw"></i></button>
                        <button type="button" id="button-refresh" class="btn btn-outline-dark" onclick="refresh($('#input-current-dir').val());"><i class="fas fa-sync-alt fa-fw"></i></button>
                    </div>
                    <div class="btn-group" role="group" aria-label="remove">
                        <button type="button" id="button-remove" class="btn btn-outline-dark" onclick="remove();"><i class="fas fa-trash-alt fa-fw"></i></button>
                    </div>
                </div>                        
            </div>
            <div id="action-container" class="text-end w-50"></div>
        </div>
    </div>
    <div class="card-body">
        <div role="button" id="back-navigator" class="bg-secondary bg-opacity-25 p-2 mb-3" onclick="back();"><i class="fas fa-level-up-alt fa-fw"></i> <span></span></div>
        <div><input type="hidden" value="/" id="input-current-dir" class="form-control" /></div>
        <form id="form-image-manager"><div id="image-container"></div></form>
    </div>
    <div class="card-footer text-muted"><?php echo lang('Caption.list_of_images'); ?></div>
</div>
<script type="text/javascript"><!--
$( document ).ready(function() {
});

refresh();

function refresh(current_dir = '', action_type = '') {
    $.ajax({
        url: '<?php echo $refresh; ?>&current_dir=' + current_dir,
        type: 'post',
        dataType: 'json',
        beforeSend: function() {
            $('#button-refresh i').removeClass('fa-sync-alt').addClass('fa-spinner fa-spin');
            $('#image-container').html('<div class="text-center"><i class="fas fa-spinner fa-fw fa-spin fa-5x"></i></div>');
            if (action_type == 'rebuild_cache') {
                $('#action-container').html('<i class="fas fa-spinner fa-spin fa-fw"></i> <?php echo lang('Text.rebuilding_cache'); ?>. <?php echo lang('Text.please_wait'); ?>');
            } else {
                $('#action-container').html('<i class="fas fa-spinner fa-spin fa-fw"></i> <?php echo lang('Text.refreshing'); ?>. <?php echo lang('Text.please_wait'); ?>');
            }
        },
        complete: function() {
            $('#button-refresh i').removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
            $('#action-container').html('');
        },
        success: function(json) {
            html = '<div class="row g-3">';
            for (i = 0; i < json['contents'].length; i++) {
                content = json['contents'][i];

                html += '<div class="col-sm-2 d-flex">';
                html += '    <div class="card w-100">';
                html += '        <div class="card-body">';
                html += '            <div class="image-manager-thumbnail position-relative w-100">';
                if (content['type'] == 'file') {
                    html += '            <img src="' + content['thumb'] + '" class="img-fluid position-absolute top-50 start-50 translate-middle" title="' + content['dir_path'] + '" data-image-manager-dir-path="' + content['dir_path'] + '" role="button" />';
                } else {
                    html += '            <a href="javascript:void(0);" onclick="refresh(\'' + current_dir + '/' + content['fullname'] + '\');"><i class="fas fa-folder fa-fw fa-5x position-absolute top-50 start-50 translate-middle" title="' + content['fullname'] + '"></i></a>';
                }
                html += '            </div>';
                html += '            <div class="form-check mt-3" title="' + content['fullname'] + '">';
                html += '                <input name="filename[]" value="' + content['fullname'] + '" class="form-check-input" type="checkbox" value="" id="input-image-manager-check-' + i + '">';
                html += '                <label class="form-check-label small text-break text-wrap" for="input-image-manager-check-' + i + '">' + content['name'] + '</label>';
                html += '            </div>';
                html += '        </div>';
                html += '        <div class="card-footer text-muted text-end small">';
                html += '            <div class="small">' + content['size'] + ' KB</div>';
                html += '            <div class="small">' + content['mime_type'] + '</div>';
                html += '            <div class="small">' + content['date'] + '</div>';
                html += '        </div>';
                html += '    </div>';
                html += '</div>';
            }
            html += '</div>';

            $('#image-container').html(html);

            $('#input-current-dir').val(current_dir);
            $('#back-navigator span').html(current_dir);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function backToHome() {
    refresh();
}

function createDirectory() {
    $.ajax({
        url: '<?php echo $create_directory; ?>&current_dir=' + $('#input-current-dir').val(),
        type: 'post',
        dataType: 'json',
        data: $('#form-folder input[type=\'text\']'),
        beforeSend: function() {
            //$('#button-rebuild-cache i').removeClass('fa-broom').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            //$('#button-rebuild-cache i').removeClass('fa-spinner fa-spin').addClass('fa-broom');
        },
        success: function(json) {
            if (json['error']) {
                alert(json['error']);
            }
            
            if (json['success']) {
                alert(json['success']);

                $('#input-folder-name').val('');

                refresh($('#input-current-dir').val());
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function upload() {
    var node = this;

    $('#form-upload').remove();

    $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" multiple /></form>');

    $('#form-upload input[name=\'file[]\']').trigger('click');

    if (typeof timer != 'undefined') {
        clearInterval(timer);
    }

    timer = setInterval(function() {
        if ($('#form-upload input[name=\'file[]\']').val() != '') {
            clearInterval(timer);

            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    $('#action-container').html('<div id="progress-bar" class="border small p-1"><div id="progress-percentage" class="text-muted text-center small"></div><div class="bg-success" style="height: 2px; width: 0%;"></div></div>');

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
                url: '<?php echo $upload; ?>&current_dir=' + $('#input-current-dir').val(),
                type: 'post',
                dataType: 'json',
                data: new FormData($('#form-upload')[0]),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    //$(node).button('loading');
                },
                complete: function() {
                    //$(node).button('reset');
                },
                success: function(json) {
                    refresh($('#input-current-dir').val());
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }, 500);
}

function download() {
    if (confirm('<?php echo lang('Text.are_you_sure'); ?>')) {
        $.ajax({
            url: '<?php echo $compress; ?>&current_dir=' + $('#input-current-dir').val(),
            type: 'post',
            dataType: 'json',
            data: $('#form-image-manager input[name=\'filename[]\']:checked'),
            beforeSend: function() {
                $('#button-download i').removeClass('fa-download').addClass('fa-spinner fa-spin');
            },
            complete: function() {
                $('#button-download i').removeClass('fa-spinner fa-spin').addClass('fa-download');
            },
            success: function(json) {
                //alert(json['alert']);
                window.location.href = '<?php echo $download; ?>&archive=' + json['archive'];
                //refresh($('#input-current-dir').val());
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}

function rebuildCache() {
    if (confirm('<?php echo lang('Text.are_you_sure'); ?>')) {
        $.ajax({
            url: '<?php echo $rebuild_cache; ?>',
            dataType: 'json',
            beforeSend: function() {
                $('#button-rebuild-cache i').removeClass('fa-broom').addClass('fa-spinner fa-spin');
            },
            complete: function() {
                $('#button-rebuild-cache i').removeClass('fa-spinner fa-spin').addClass('fa-broom');
            },
            success: function(json) {
                refresh('', 'rebuild_cache');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}

function remove() {
    if (confirm('<?php echo lang('Text.are_you_sure'); ?>')) {
        $.ajax({
            url: '<?php echo $remove; ?>&current_dir=' + $('#input-current-dir').val(),
            type: 'post',
            dataType: 'json',
            data: $('#form-image-manager input[name=\'filename[]\']:checked'),
            beforeSend: function() {
                $('#button-remove i').removeClass('fa-trash-alt').addClass('fa-spinner fa-spin');
            },
            complete: function() {
                $('#button-remove i').removeClass('fa-spinner fa-spin').addClass('fa-trash-alt');
            },
            success: function(json) {
                //alert(json['alert']);
                refresh($('#input-current-dir').val());
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}

function back() {
    current_dir = $('#input-current-dir').val();

    dirs = current_dir.split('/');

    dirs.pop();

    refresh(dirs.join('/'));
}
//--></script> 
