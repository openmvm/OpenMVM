<div class="card">
	<div class="card-body">
		<h4 class="border-bottom pb-2 mb-3"><?php echo lang('Text.answers', [], $language_lib->getCurrentCode()); ?></h4>
		<?php if (!empty($product_question_answers)) { ?>
		<div>
			<?php $total_product_question_answer = count($product_question_answers); ?>
			<?php foreach ($product_question_answers as $key => $value) { ?>
			<div class="mb-3">
				<div class="mb-1"><?php echo $value['answer']; ?></div>
				<div class="text-secondary">
					<?php if (!empty($value['seller_id'])) { ?>
						<?php echo $value['seller']['store_name']; ?> &middot; <?php echo lang('Text.seller', [], $language_lib->getCurrentCode()); ?>
					<?php } else { ?>
						<?php echo $value['customer']['firstname']; ?> &middot; <?php echo lang('Text.customer', [], $language_lib->getCurrentCode()); ?>
					<?php } ?>
					&middot; <?php echo $value['date_added']; ?>
				</div>
			</div>
				<?php if ($key <= $total_product_question_answer - 2) { ?>
				<hr />
				<?php } ?>
			<?php } ?>
		</div>
		<?php } else { ?>
		<div class="text-secondary"><?php echo lang('Text.not_found', [], $language_lib->getCurrentCode()); ?></div>
		<?php } ?>		
	</div>
</div>
