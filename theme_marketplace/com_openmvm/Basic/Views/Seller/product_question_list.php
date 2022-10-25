<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><?php echo lang('Column.date_added', [], $language_lib->getCurrentCode()); ?></th>
                    <th><?php echo lang('Column.question', [], $language_lib->getCurrentCode()); ?></th>
                    <th><?php echo lang('Column.answer', [], $language_lib->getCurrentCode()); ?></th>
                    <th><?php echo lang('Column.product', [], $language_lib->getCurrentCode()); ?></th>
                    <th><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($product_questions) { ?>
                    <?php foreach ($product_questions as $product_question) { ?>
                    <tr>
                        <td><?php echo $product_question['date_added']; ?></td>
                        <td><?php echo $product_question['question']; ?></td>
                        <td><?php echo $product_question['total_answer']; ?></td>
                        <td><?php echo $product_question['product']; ?></td>
                        <td><a href="<?php echo $product_question['edit']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-pencil me-2"></i><?php echo lang('Button.give_an_answer', [], $language_lib->getCurrentCode()); ?></a></td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                <tr>
                    <td colspan="5" class="text-secondary"><?php echo lang('Text.not_found', [], $language_lib->getCurrentCode()); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php echo $footer; ?>
