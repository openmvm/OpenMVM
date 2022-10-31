<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <div class="row">
            <div class="col-sm-3">
                <div class="text-center">
                    <div class="mb-3"><img src="<?php echo $thumb; ?>" class="border p-1" /></div>
                    <div class="mb-3"><a href="<?php echo $product_url; ?>" class="link-danger text-decoration-none"><?php echo $product_name; ?></a></div>
                    <div class="mb-3"><a href="<?php echo $store_url; ?>" class="link-secondary text-decoration-none"><?php echo $store_name; ?></a></div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="border-bottom pb-3 mb-3">
                    <h3><?php echo $heading_title; ?></h3>
                    <div class="text-secondary"><?php echo lang('Text.asked_on', [], $language_lib->getCurrentCode()); ?> <?php echo $date_added; ?></div>
                </div>
                <?php if ($logged_in) { ?>
                    <?php echo form_open('', ['id' => 'form-customer-question-answer']); ?>
                    <fieldset>
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                        <div class="mb-3">
                            <label for="input-customer-question-answer" class="form-label"><?php echo lang('Entry.add_a_written_answer', [], $language_lib->getCurrentCode()); ?></label>
                            <textarea name="answer" class="form-control" id="input-answer" rows="3"></textarea>
                        </div>
                    </fieldset>
                    <div>
                        <button type="button" class="btn btn-primary" id="button-answer" onclick="addCustomerQuestionAnswer();"><i class="fas fa-pencil me-2"></i><?php echo lang('Button.answer', [], $language_lib->getCurrentCode()); ?></button>
                    </div>
                    <?php echo form_close(); ?>
                <?php } else { ?>
                <div><?php echo lang('Text.please_login_to_answer_question', ['login' => '<a href="' . $login . '" class="text-decoration-none">' . strtolower(lang('Text.login', [], $language_lib->getCurrentCode())) . '</a>'], $language_lib->getCurrentCode()); ?></div>
                <?php } ?>
            </div>
        </div>
        <div class="border-top pt-3 mt-5">
            <h4 class="mb-3"><?php echo lang('Text.answers', [], $language_lib->getCurrentCode()); ?></h4>
            <div id="customer-question-answer-list"></div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
function addCustomerQuestionAnswer() {
    var inputs = $('#form-customer-question-answer').find('select, textarea, input').serializeJSON();

    $.ajax({
        url: '<?php echo $add_customer_question_answer; ?>',
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

                $('#form-customer-question-answer')[0].reset();

                getCustomerQuestionAnswers();
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
getCustomerQuestionAnswers();

function getCustomerQuestionAnswers() {
    $('#customer-question-answer-list').html('<div><i class="fas fa-spinner fa-spin"></i></div>');
    $('#customer-question-answer-list').load('<?php echo $get_customer_question_answers; ?>');
}
//--></script>
<?php echo $footer; ?>
