<div class="mb-3"><?php echo $bank; ?></div>
<div class="alert alert-info alert-dismissible mb-3" role="alert">
  <?php echo lang('Text.text_review_order', array(), $lang->getFrontEndLocale()); ?>
</div>
<div class="d-grid gap-2">
  <button type="submit" class="btn btn-success btn-sm" id="button-confirm"><?php echo lang('Button.button_confirm', array(), $lang->getFrontEndLocale()); ?></button>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({
		url: '<?php echo base_url('/payment_method/bank_transfer/confirm'); ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-confirm').button('loading');
		},
		complete: function() {
			$('#button-confirm').button('reset');
		},
		success: function(json) {
			if (json['redirect']) {
				location = json['redirect'];	
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//--></script>
