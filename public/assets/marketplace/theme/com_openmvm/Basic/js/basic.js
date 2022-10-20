function getURLParam(key) {
    let searchParams = new URLSearchParams(window.location.search);

    if (searchParams.has(key)) {
        let param = searchParams.get(key);

        return param;
    } else {
        return false;
    }
}

$( document ).ready(function() {
    var base = $('base').attr('href');

    /* Search */
	$('#search input[name="search"]').keypress(function (e) {
        var type = $('#search input[name="type"]').val();
        var keyword = $('#search input[name="search"]').val();

		if (e.which == 13) {
            if (type == 'seller') {
                window.location.href = base + '/marketplace/seller/search?keyword=' + keyword;
            } else {
                window.location.href = base + '/marketplace/product/search?keyword=' + keyword;
            }

			return false;
		}
	});

	$('#search').on('click', '#button-search', function() {
        var type = $('#search input[name="type"]').val();
        var keyword = $('#search input[name="search"]').val();

        if (type == 'seller') {
            window.location.href = base + '/marketplace/seller/search?keyword=' + keyword;
        } else {
            window.location.href = base + '/marketplace/product/search?keyword=' + keyword;
        }
	});
	
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

        var userData = $('#' + dataForm).serializeJSON();

        $.ajax({
            url: dataFormAction,
            type: 'post',
            dataType: 'json',
            data: JSON.stringify(userData),
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

    /* Tooltip */
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            container: 'body',
            boundary: document.body
        });
    });
});