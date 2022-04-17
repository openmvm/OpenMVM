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
                <h3 class="card-title"><i class="fas fa-exclamation-triangle fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <div class="card border-0 shadow mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card card-body bg-light">
                            <?php if ($files) { ?>
                            <div class="d-grid gap-2">
                                <?php foreach ($files as $file) { ?>
                                    <div data-file="<?php echo $file; ?>" class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" id="<?php echo $file; ?>" class="btn btn-primary btn-sm" onclick="getError('<?php echo $file; ?>');"><?php echo $file; ?></button>
                                        <button type="button" id="button-delete-<?php echo str_replace('.', '-', $file); ?>" class="btn btn-danger btn-sm" onclick="deleteError('<?php echo $file; ?>');"><i class="fas fa-trash fa-fw"></i></button>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="card card-body bg-light">
                            <div id="error-container" class="vh-100" style="overflow-y: auto;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
<?php if ($latest_error) { ?>
    getError('<?php echo $latest_error; ?>');
<?php } ?>

function getError(file) {
	$.ajax({
		url: '<?php echo $get_error; ?>',
		type: 'post',
		dataType: 'json',
		data: 'file=' + file,
		beforeSend: function() {
		},
		complete: function() {
		},
		success: function(json) {
			if (json['contents']) {
                $('#error-container').html(json['contents']);
            } else {
                $('#error-container').html('<div class="text-success"><?php echo lang('Text.no_errors'); ?></div>');
            }
		}
	});
}
//--></script>
<script type="text/javascript"><!--
function deleteError(file) {
	$.ajax({
		url: '<?php echo $delete_error; ?>',
		type: 'post',
		dataType: 'json',
		data: 'file=' + file,
		beforeSend: function() {
            $('#button-delete-' + file.replace('.', '-') + ' i').removeClass('fa-trash').addClass('fa-spinner fa-spin');
		},
		complete: function() {
            $('#button-delete-' + file.replace('.', '-') + ' i').removeClass('fa-spinner fa-spin').addClass('fa-trash');
		},
		success: function(json) {
			if (json['success']) {
                $('[data-file="' + file + '"]').remove();
            }

			if (json['latest_error']) {
                getError(json['latest_error']);
            } else {
                $('#error-container').html('');
            }
		}
	});
}
//--></script>
<?php echo $footer; ?>
