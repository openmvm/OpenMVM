<?php if (!empty($seller_faqs)) { ?>
<div id="widget-seller-faq-<?php echo $widget; ?>" class="card shadow rounded-0 mb-3">
    <div class="card-body">
        <div class="lead mb-3"><?php echo lang('Text.frequently_asked_questions', [], $language_lib->getCurrentCode()); ?></div>
        <div>
        	<?php foreach ($seller_faqs as $seller_faq) { ?>
    		<div>
				<a class="link-dark text-decoration-none" data-bs-toggle="collapse" href="#seller-faq-<?php echo $seller_faq['seller_faq_id']; ?>" role="button" aria-expanded="false" aria-controls="seller-faq-<?php echo $seller_faq['seller_faq_id']; ?>">
					<h5><strong><?php echo $seller_faq['question']; ?></strong></h5>
				</a>
				<div class="collapse" id="seller-faq-<?php echo $seller_faq['seller_faq_id']; ?>">
					<div><?php echo $seller_faq['answer']; ?></div>
				</div>
    		</div>
        	<?php } ?>
        </div>
    </div>
</div><?php } ?>
