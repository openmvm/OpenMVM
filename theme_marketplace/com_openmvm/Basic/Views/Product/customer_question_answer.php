<?php if (!empty($customer_question_answers)) { ?>
    <?php $total_customer_question_answers = count($customer_question_answers); ?>
    <?php foreach($customer_question_answers as $key => $value) { ?>
    <div>
        <div><?php echo $value['answer']; ?></div>
        <div class="text-secondary mb-3">
            <?php echo lang('Text.by', [], $language_lib->getCurrentCode()); ?> 
            <?php if (!empty($value['seller_id']) && $value['product_seller_id'] == $value['seller_id']) { ?>
                <span class="text-dark"><?php echo $value['seller']['store_name']; ?></span> &middot; <?php echo lang('Text.seller', [], $language_lib->getCurrentCode()); ?>
            <?php } else { ?>
                <span class="text-dark"><?php echo $value['customer']['firstname']; ?></span> &middot; <?php echo lang('Text.customer', [], $language_lib->getCurrentCode()); ?>
            <?php } ?>
            &middot; <?php echo $value['date_added']; ?>
        </div>
        <div>
            <div>
                <?php if ($value['total_customer_question_answer_votes'] > 0) { ?>
                <span id="customer-question-answer-<?php echo $value['product_question_answer_id']; ?>-vote-text" class="text-secondary small me-3"><?php echo lang('Text.people_found_this_answer_helpful', ['helpful' => $value['total_helpful_customer_question_answer_votes'], 'total' => $value['total_customer_question_answer_votes']], $language_lib->getCurrentCode()); ?></span>
                <?php } else { ?>
                <span id="customer-question-answer-<?php echo $value['product_question_answer_id']; ?>-vote-text" class="text-secondary small me-3"><?php echo lang('Text.do_you_find_this_helpful', [], $language_lib->getCurrentCode()); ?></span>
                <?php } ?>
                <button type="button" class="btn btn-outline-secondary btn-sm me-2" id="button-customer-question-answer-<?php echo $value['product_question_answer_id']; ?>-vote-1" onclick="voteCustomerQuestionAnswer('<?php echo $value['product_question_answer_id']; ?>', '1');"><?php echo lang('Button.yes', [], $language_lib->getCurrentCode()); ?></button> <button type="button" class="btn btn-outline-secondary btn-sm" id="button-customer-question-answer-<?php echo $value['product_question_answer_id']; ?>-vote-0" onclick="voteCustomerQuestionAnswer('<?php echo $value['product_question_answer_id']; ?>', '0');"><?php echo lang('Button.no', [], $language_lib->getCurrentCode()); ?></button>
                <span class="mx-3 d-none">&middot;</span>
                <a role="button" class="link-danger text-decoration-none small d-none"><?php echo lang('Button.report_abuse', [], $language_lib->getCurrentCode()); ?></a>
            </div>
        </div>
    </div>
        <?php if ($key <= ($total_customer_question_answers - 2)) { ?>
        <hr />
        <?php } ?>
    <?php } ?>
<script type="text/javascript"><!--
function voteCustomerQuestionAnswer(product_question_answer_id, vote) {
    $.ajax({
        url: '<?php echo $vote_customer_question_answer; ?>',
        type: 'post',
        dataType: 'json',
        data: {
            product_question_answer_id: product_question_answer_id,
            vote: vote
        },
        beforeSend: function() {
            $('#button-customer-question-answer-' + product_question_answer_id + '-vote-' + vote).html('<i class="fas fa-spinner fa-spin"></i>');
        },
        complete: function() {
            if (vote == 1) {
                $('#button-customer-question-answer-' + product_question_answer_id + '-vote-1').html('<?php echo lang('Text.yes', [], $language_lib->getCurrentCode()); ?>');
            } else {
                $('#button-customer-question-answer-' + product_question_answer_id + '-vote-0').html('<?php echo lang('Text.no', [], $language_lib->getCurrentCode()); ?>');
            }
        },
        success: function(json) {
            $('#customer-question-answer-' + product_question_answer_id + '-vote-text').html(json['vote_text']);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            alert(xhr.responseText);
        }
    });
}
//--></script>
<?php } else { ?>
<div><?php echo lang('Text.not_found', [], $language_lib->getCurrentCode()); ?></div>
<?php } ?>
