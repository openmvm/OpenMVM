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
            url: base + '/admin/file_manager/image_manager/workspace?administrator_token=' + getURLParam('administrator_token'),
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