<?php if (!empty($product_questions)) { ?>
<div class="table-responsive">
    <table class="table table-borderless table-sm">
        <tbody>
            <?php foreach ($product_questions as $product_question) { ?>
                <tr>
                    <td rowspan="2" class="px-2" style="width: 100px;">
                        <div class="border-end">
                            <div role="button" class="text-secondary text-center small"><i class="fas fa-caret-up fa-2x"></i></div>
                            <div class="text-center small"><strong>12345</strong></div>
                            <div class="text-center small"><?php echo lang('Text.votes', [], $language_lib->getCurrentCode()); ?></div>
                            <div role="button" class="text-secondary text-center small"><i class="fas fa-caret-down fa-2x"></i></div>
                        </div>
                    </td>
                    <td style="width: 100px;"><strong><?php echo lang('Text.question', [], $language_lib->getCurrentCode()); ?>:</strong></td>
                    <td><a href="#" class="link-danger text-decoration-none"><?php echo $product_question['question']; ?></a></td>
                </tr>
                <tr>
                    <td><strong><?php echo lang('Text.answer', [], $language_lib->getCurrentCode()); ?>:</strong></td>
                    <td>
                        <div id="customer-question-<?php echo $product_question['product_question_id']; ?>-answer" class="mb-3">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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