<div class="card mb-5"><div class="card-body"><?php echo $instruction; ?></div></div>
<div class="mb-3"><?php echo lang('Text.checkout_confirm', [], $language_lib->getCurrentCode()); ?></div>
<div class="d-grid gap-2 mb-5"><button type="button" class="btn btn-primary" id="button-checkout-confirm"><i class="fas fa-check fa-fw"></i> <?php echo lang('Button.confirm', [], $language_lib->getCurrentCode()); ?></button></div>
<script type="text/javascript"><!--
$('#button-checkout-confirm').on('click', function() {
	$.ajax({
		url: '<?php echo $confirm; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-checkout-confirm i').removeClass('fa-check').addClass('fa-spinner fa-spin');
		},
		complete: function() {
			$('#button-checkout-confirm i').removeClass('fa-spinner fa-spin').addClass('fa-check');
		},
		success: function(json) {
			if (json['error']) {
				alert('Error!');
			}

			if (json['success']) {
				alert('Success!');
				
				window.location.replace(json['redirect']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//--></script>
