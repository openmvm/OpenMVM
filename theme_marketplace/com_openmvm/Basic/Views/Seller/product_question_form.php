<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
    </div>
    <div>
        <?php if (!empty($product_question_id)) { ?>
        <h4><?php echo $question; ?></h4>
        <div class="text-secondary mb-5"><?php echo lang('Text.asked_on', [], $language_lib->getCurrentCode()); ?> <?php echo $date_added; ?></div>
        <?php echo form_open('', ['id' => 'form-product-question-answer']); ?>
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
            <div class="mb-3">
                <label for="input-product-question-answer" class="form-label"><?php echo lang('Entry.add_a_written_answer', [], $language_lib->getCurrentCode()); ?></label>
                <textarea name="answer" class="form-control" id="input-answer" rows="5" placeholder="<?php echo lang('Entry.type_your_answer_here', [], $language_lib->getCurrentCode()); ?>"></textarea>
            </div>
        <?php echo form_close(); ?>
        <div class="mb-5"><button type="button" class="btn btn-primary" id="button-answer" onclick="addProductQuestionAnswer();"><i class="fas fa-pencil me-2"></i><?php echo lang('Button.answer', [], $language_lib->getCurrentCode()); ?></button></div>
        <div id="product-question-answer-list"></div>
        <?php } else { ?>
        <?php echo lang('Text.not_found', [], $language_lib->getCurrentCode()); ?>
        <?php } ?>
    </div>
</div>
<script type="text/javascript"><!--
function addProductQuestionAnswer() {
    var inputs = $('#form-product-question-answer').find('select, textarea, input').serializeJSON();

    $.ajax({
        url: '<?php echo $add_product_question_answer; ?>&product_question_id=<?php echo $product_question_id; ?>',
        type: 'post',
        dataType: 'json',
        data: JSON.stringify(inputs),
        beforeSend: function() {
            $('#button-answer').find('i').removeClass('fa-pencil').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            $('#button-answer').find('i').removeClass('fa-spinner fa-spin').addClass('fa-pencil');
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
                    html += '            <i class="fas fa-triangle-exclamation me-2"></i>';
                    html += '            <strong class="me-auto"><?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?></strong>'; 
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
                    html += '            <i class="fas fa-check-circle me-2"></i>';
                    html += '            <strong class="me-auto"><?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?></strong>'; 
                    html += '            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>'; 
                    html += '        </div>'; 
                    html += '        <div class="toast-body">'; 
                    html += '            <div>' + json['success']['toast'] + '</div>'; 
                    html += '        </div>'; 
                    html += '    </div>'; 
                    html += '</div>'; 
                }

                $('#form-product-question-answer')[0].reset();

                getProductQuestionAnswers();
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
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
//--></script>
<script type="text/javascript"><!--
getProductQuestionAnswers();

function getProductQuestionAnswers() {
    $('#product-question-answer-list').html('<div><i class="fas fa-spinner fa-spin"></i></div>');
    $('#product-question-answer-list').load('<?php echo $get_product_question_answers; ?>');
}
//--></script>
<?php echo $footer; ?>
