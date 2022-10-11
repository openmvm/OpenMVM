function getURLParam(key) {
    let searchParams = new URLSearchParams(window.location.search);

    if (searchParams.has(key)) {
        let param = searchParams.get(key);

        return param;
    } else {
        return false;
    }
}

function getAdminUrlSegment() {
    let base = $('base').attr('href');
    let currentUrl = window.location.href;
    let urlSegments = currentUrl.replace(base, '');
    let urlSegment = urlSegments.split('/');

    var adminUrlSegment = urlSegment[1];

    return adminUrlSegment;
}

$( document ).ready(function() {
    /* From actions */
    $('body').on('click', '.button-action', function() {
        if (typeof(tinyMCE) !== "undefined") {
            tinyMCE.triggerSave();
        }

        var node = this;
        var dataForm = $(node).attr('data-form');
        var dataFormAction = $(node).attr('data-form-action');
        var dataFormConfirmText = $(node).attr('data-form-confirm-text');
        var dataIcon = $(node).attr('data-icon');
        var dataToastHeadingTitleSuccess = $(node).attr('data-toast-heading-title-success');
        var dataToastHeadingTitleError = $(node).attr('data-toast-heading-title-error');
        var dataToastHeadingIconSuccess = $(node).attr('data-toast-heading-icon-success');
        var dataToastHeadingIconError = $(node).attr('data-toast-heading-icon-error');
        var dataRedirection = $(node).attr('data-redirection');

        $.ajax({
            url: dataFormAction,
            type: 'post',
            dataType: 'json',
            data: $('#' + dataForm).serialize(),
            beforeSend: function() {
                $(node).find('i').removeClass(dataIcon).addClass('fa-spinner fa-spin');

                if (typeof dataFormConfirmText !== 'undefined' && dataFormConfirmText !== false) {
                    if(!confirm(dataFormConfirmText)){
                        // do something
                        // stop the ajax call
                        $(node).find('i').removeClass('fa-spinner fa-spin').addClass(dataIcon);

                        return false;
                    }
                }
            },
            complete: function() {
                $(node).find('i').removeClass('fa-spinner fa-spin').addClass(dataIcon);
            },
            success: function(json) {
                $('.toast-container').remove();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                if (json['error']) {
                    $.each(json['error'], function(key, value){
                        $('#input-' + key).addClass('is-invalid');
                        $('#input-' + key).parent().append('<div class="invalid-feedback">' + value + '</div>');
                    });

                    if (json['error']['toast']) {
                        // Toast
                        html = '<div class="toast-container position-fixed bottom-0 end-0 p-3">'; 
                        html += '    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">'; 
                        html += '        <div class="toast-header text-bg-danger">'; 
                        html += '            <i class="fas ' + dataToastHeadingIconError + ' me-2"></i>';
                        html += '            <strong class="me-auto">'+ dataToastHeadingTitleError + '</strong>'; 
                        html += '            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>'; 
                        html += '        </div>';
                        html += '        <div class="toast-body">'; 
                        html += '            <div>' + json['error']['toast'] + '</div>'; 
                        html += '        </div>'; 
                        html += '    </div>'; 
                        html += '</div>'; 
                    }
                }

                if (json['success']) {
                    if (json['success']['toast']) {
                        // Toast
                        html = '<div class="toast-container position-fixed bottom-0 end-0 p-3">'; 
                        html += '    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">'; 
                        html += '        <div class="toast-header text-bg-success">'; 
                        html += '            <i class="fas ' + dataToastHeadingIconSuccess + ' me-2"></i>';
                        html += '            <strong class="me-auto">'+ dataToastHeadingTitleSuccess + '</strong>'; 
                        html += '            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>'; 
                        html += '        </div>'; 
                        html += '        <div class="toast-body">'; 
                        html += '            <div>' + json['success']['toast'] + '</div>'; 
                        html += '        </div>'; 
                        html += '    </div>'; 
                        html += '</div>'; 
                    }
                }

                // Toast
                if (typeof(html) !== "undefined") {
                    $('body').append(html);  

                    const toastLiveExample = document.getElementById('liveToast');
                    const toast = new bootstrap.Toast(toastLiveExample, {
                        animation: true,
                        autohide: true,
                        delay: 2000,
                    });

                    toast.show();
                }

                if (json['redirect'] && dataRedirection == 'true') {
                    //window.location.href(json['redirect']);
                    window.location.href = json['redirect'];
                }
             
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    /* Image manager */
    $('body').on('click', '[data-image-manager="image"]', function() {
        var node = this;

        var base = $('base').attr('href');

        var title = $(node).attr('data-image-manager-title');
        var dismiss = $(node).attr('data-image-manager-dismiss');

        html = '<div class="modal fade" id="image-manager-modal" tabindex="-1" aria-labelledby="image-manager-modal-label" aria-hidden="true">';
        html += '    <div class="modal-dialog modal-fullscreen">';
        html += '        <div class="modal-content">';
        html += '            <div class="modal-header">';
        html += '                <h5 class="modal-title" id="image-manager-modal-label">' + title + '</h5>';
        html += '                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        html += '            </div>';
        html += '            <div class="modal-body"></div>';
        html += '        </div>';
        html += '    </div>';
        html += '</div>';

        $('body').append(html);

        $.ajax({
            url: base + '/' + getAdminUrlSegment() + '/file_manager/image_manager/workspace?administrator_token=' + getURLParam('administrator_token'),
            dataType: 'html',
            beforeSend: function() {
                
            },
            complete: function() {
                
            },
            success: function(html) {
                $('#image-manager-modal .modal-body').html(html);

                var imageManagerModal = new bootstrap.Modal(document.getElementById('image-manager-modal'), {});

                imageManagerModal.show();

                $('#image-container').on('click', 'img[role="button"]', function() {
                    $(node).find('img').attr('src', $(this).attr('src'));
                    $(node).find('[data-image-manager-target]').val($(this).attr('data-image-manager-dir-path'));

                    imageManagerModal.hide();
                });
            }
        });
    });

    $('body').on('click', '[data-image-manager-remove="image"]', function() {
        $(this).parent().parent().find('img').attr('src', $(this).attr('data-image-manager-placeholder'));
        $(this).parent().parent().find('[data-image-manager-target]').val('');
        //alert($(this).attr('data-image-manager-placeholder'));
    });

    /* Tooltip */
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            container: 'body',
            boundary: document.body
        });
    });
});