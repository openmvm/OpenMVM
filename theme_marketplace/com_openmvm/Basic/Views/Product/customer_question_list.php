<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <div class="border-bottom pb-3 mb-3 d-flex align-items-center">
            <img src="<?php echo $thumb; ?>" class="border p-1" />
            <div class="ms-5">
                <h3 class="p-0 m-0"><a href="<?php echo $product_url; ?>" class="link-danger text-decoration-none"><?php echo $product_name; ?></a></h3>
                <div><a href="<?php echo $store_url; ?>" class="link-secondary text-decoration-none"><?php echo $store_name; ?></a></div>
            </div>
        </div>
        <h3 class="mb-5"><?php echo $heading_title; ?></h3>
        <?php if (!empty($customer_questions)) { ?>
        <div class="table-responsive">
            <table class="table table-borderless table-sm">
                <tbody>
                    <?php foreach ($customer_questions as $customer_question) { ?>
                        <tr>
                            <td rowspan="2" class="px-2" style="width: 100px;">
                                <div class="border-end">
                                    <div role="button" class="text-secondary text-center small" onclick="voteProductQuestion('<?php echo $customer_question['product_question_id']; ?>', 1)"><i class="fas fa-caret-up fa-2x"></i></div>
                                    <div class="text-center small"><strong id="product-question-vote-<?php echo $customer_question['product_question_id']; ?>"><?php echo $customer_question['sum_vote']; ?></strong></div>
                                    <div class="text-center small"><?php echo lang('Text.votes', [], $language_lib->getCurrentCode()); ?></div>
                                    <div role="button" class="text-secondary text-center small" onclick="voteProductQuestion('<?php echo $customer_question['product_question_id']; ?>', -1)"><i class="fas fa-caret-down fa-2x"></i></div>
                                </div>
                            </td>
                            <td style="width: 100px;"><strong><?php echo lang('Text.question', [], $language_lib->getCurrentCode()); ?>:</strong></td>
                            <td><a href="<?php echo $customer_question['href']; ?>" class="link-danger text-decoration-none"><?php echo $customer_question['question']; ?></a></td>
                        </tr>
                        <tr>
                            <td><strong><?php echo lang('Text.answer', [], $language_lib->getCurrentCode()); ?>:</strong></td>
                            <td>
                                <div id="customer-question-<?php echo $customer_question['product_question_id']; ?>-answer" class="mb-3">
                                    <?php foreach($customer_question['answer'] as $customer_question_answer) { ?>
                                    <div>
                                        <div><?php echo $customer_question_answer['answer']; ?></div>
                                        <div class="text-secondary">
                                            <?php echo lang('Text.by', [], $language_lib->getCurrentCode()); ?> 
                                            <?php if (!empty($customer_question_answer['seller_id'])) { ?>
                                                <?php echo $customer_question_answer['seller']['store_name']; ?> &middot; <?php echo lang('Text.seller', [], $language_lib->getCurrentCode()); ?>
                                            <?php } else { ?>
                                                <?php echo $customer_question_answer['customer']['firstname']; ?> &middot; <?php echo lang('Text.customer', [], $language_lib->getCurrentCode()); ?>
                                            <?php } ?>
                                            &middot; <?php echo $customer_question_answer['date_added']; ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div id="customer-question-<?php echo $customer_question['product_question_id']; ?>-answer-next"></div>
                                    <input type="hidden" name="page" value="1" id="input-product-question-<?php echo $customer_question['product_question_id']; ?>-answer-page" />
                                    <?php if ($customer_question['total_answer'] > 1) { ?>
                                    <div class="mt-1" id="button-product-question-<?php echo $customer_question['product_question_id']; ?>-answer"><a role="button" class="text-decoration-none" onclick="getProductQuestionAnswers('<?php echo $customer_question['product_question_id']; ?>');"><i class="fas fa-angle-down me-2"></i><?php echo lang('Button.see_more_answers', [], $language_lib->getCurrentCode()); ?> (<span id="total-product-question-<?php echo $customer_question['product_question_id']; ?>-answers-next-page"><?php echo $customer_question['total_answer'] - 1; ?></span>)</a></div>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } else { ?>
        <div class="text-secondary"><?php echo lang('Text.not_found', [], $language_lib->getCurrentCode()); ?></div>
        <?php } ?>
    </div>
    <?php if (!empty($customer_questions)) { ?>
    <script type="text/javascript"><!--
    function voteProductQuestion(product_question_id, vote) {
        $.ajax({
            url: '<?php echo $vote_customer_question; ?>',
            type: 'post',
            data: {
                product_question_id: product_question_id,
                vote: vote
            },
            dataType: 'json',
            beforeSend: function() {
                $('#product-question-vote-' + product_question_id).html('<i class="fas fa-spinner fa-spin"></i>');
            },
            complete: function() {
            },
            success: function(json) {
                if (json['error']) {
                    alert(json['error']);
                }

                $('#product-question-vote-' + product_question_id).html(json['sum_vote']);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    //--></script>
    <script type="text/javascript"><!--
    function getProductQuestionAnswers(product_question_id) {
        var page = $('#input-product-question-' + product_question_id + '-answer-page').val();

        $.ajax({
            url: '<?php echo $get_customer_question_answers; ?>',
            type: 'post',
            data: {
                product_question_id: product_question_id,
                page: page
            },
            dataType: 'json',
            beforeSend: function() {
                $('#button-product-question-' + product_question_id + '-answer > a > i').removeClass('fa-angle-down').addClass('fa-spinner fa-spin');
            },
            complete: function() {
                $('#button-product-question-' + product_question_id + '-answer > a > i').removeClass('fa-spinner fa-spin').addClass('fa-angle-down');
            },
            success: function(json) {
                $('#input-product-question-' + product_question_id + '-answer-page').val(json['page']);

                if (json['product_question_answers'].length > 0) {
                    html = '';
                    for (i = 0; i < json['product_question_answers'].length; i++) {
                        if (i <= json['product_question_answers'].length - 1) {
                            html += '<hr />';
                        }

                        product_question_answer = json['product_question_answers'][i];

                        html += '<div>';
                        html += '    <div>' + product_question_answer['answer'] + '</div>';
                        html += '    <div class="text-secondary">';
                        html += '        <?php echo lang('Text.by', [], $language_lib->getCurrentCode()); ?>'; 
                                if (product_question_answer['seller_id'] !== 0) {
                        html += '        ' + product_question_answer['seller']['store_name'] + ' &middot; <?php echo lang('Text.seller', [], $language_lib->getCurrentCode()); ?>';
                                } else {
                        html += '        ' + product_question_answer['customer']['firstname'] + ' &middot; <?php echo lang('Text.customer', [], $language_lib->getCurrentCode()); ?>';
                                }
                        html += '        &middot; ' + product_question_answer['date_added'] + ' ';
                        html += '    </div>';
                        html += '</div>';
                    }

                    $('#customer-question-' + product_question_id + '-answer-next').append(html);

                    if (json['next_page_total_product_question_answers'] > 0) {
                        $('#total-product-question-' + product_question_id + '-answers-next-page').html(json['next_page_total_product_question_answers']);
                    } else {
                        $('#button-product-question-' + product_question_id + '-answer').remove();
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    //--></script>
    <?php } ?>
</div>
<?php echo $footer; ?>
