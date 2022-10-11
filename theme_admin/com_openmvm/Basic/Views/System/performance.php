<?php echo $header; ?><?php echo $column_left; ?>
<div class="container-fluid">
    <div id="content" class="content">
        <?php if ($breadcrumbs) { ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <?php if ($breadcrumb['active']) { ?>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
                    <?php } else { ?>
                    <li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                    <?php } ?>
                <?php } ?>
            </ol>
        </nav>
        <?php } ?>
        <div class="card border-0 shadow heading mb-3">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-wrench fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-performance']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo lang('Heading.edit'); ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-performance" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-performance" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <fieldset>
                    <legend class="lead border-bottom border-warning pb-2 mb-3 clearfix">
                        <span class="float-start"><?php echo lang('Text.cache', [], 'en'); ?></span>
                        <button type="button" class="btn btn-outline-primary btn-sm float-end" id="button-clear-cache"><i class="fas fa-broom fa-fw"></i> <?php echo lang('Button.clear_cache', [], 'en'); ?></button>
                    </legend>
                    <div class="mb-3 required">
                        <label for="input-cache-ttl" class="form-label"><?php echo lang('Entry.cache_ttl'); ?></label>
                        <input type="number" min="0" name="performance_cache_ttl" value="<?php echo $performance_cache_ttl; ?>" id="input-cache-ttl" class="form-control" placeholder="<?php echo lang('Entry.cache_ttl'); ?>">
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="performance_cache_status" value="1" role="switch" id="input-cache-status"<?php echo isset($performance_cache_status) ? ' checked' : ''; ?>>
                            <label class="form-check-label" for="input-cache-status"><?php echo lang('Entry.cache_status', [], 'en'); ?></label>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
$('#button-clear-cache').on('click', function() {
	$.ajax({
		url: '<?php echo $clear_cache; ?>',
        method: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-clear-cache').prop('disabled', true);
            $('#button-clear-cache i').removeClass('fa-broom').addClass('fa-spinner fa-spin');
		},
		complete: function() {
			$('#button-clear-cache').prop('disabled', false);
            $('#button-clear-cache i').removeClass('fa-spinner fa-spin').addClass('fa-broom');
		},
		success: function(json) {
            $('.toast-container').remove();
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            if (json['success']) {
                if (json['success']['toast']) {
                    // Toast
                    html = '<div class="toast-container position-fixed bottom-0 end-0 p-3">'; 
                    html += '    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">'; 
                    html += '        <div class="toast-header text-bg-success">'; 
                    html += '            <i class="fas fa-check fa-fw me-2"></i>';
                    html += '            <strong class="me-auto"><?php echo lang('Text.success', [], 'en'); ?></strong>'; 
                    html += '            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>'; 
                    html += '        </div>';
                    html += '        <div class="toast-body">'; 
                    html += '            <div>' + json['success']['toast'] + '</div>'; 
                    html += '        </div>';
                    html += '    </div>'; 
                    html += '</div>'; 
                }
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

            if (json['redirect'] && dataRedirection == 'true') {
                //window.location.href(json['redirect']);
                window.location.href = json['redirect'];
            }
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//--></script> 
<?php echo $footer; ?>
