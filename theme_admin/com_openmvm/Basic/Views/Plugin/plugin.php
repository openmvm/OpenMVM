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
                <h3 class="card-title"><i class="fas fa-puzzle-piece fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php if ($error_warning) { ?>
        <div class="alert alert-warning alert-dismissible border-0 shadow fade show" role="alert">
            <?php echo $error_warning; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert alert-success alert-dismissible border-0 shadow fade show" role="alert">
            <?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>
        <div class="clearfix mb-3">
            <div class="float-end">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal"><i class="fas fa-upload fa-fw"></i> <?php echo lang('Button.upload'); ?></button>
            </div>
        </div>
        <div class="row">
            <?php foreach ($plugins as $plugin) { ?>
                <div class="col-sm-6 d-flex">
                    <div class="card shadow">
                        <div class="row g-0">
                            <div class="col-md-5"><img src="<?php echo $plugin['plugin_image']; ?>" class="img-fluid rounded-start" alt="<?php echo $plugin['plugin_name']; ?>"></div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <h5 class="p-0 m-0 float-start"><?php echo lang('Text.plugin'); ?>: <?php echo $plugin['plugin_name']; ?></h5>
                                        <div class="btn-group float-end">
                                            <button type="button" class="btn btn-link link-secondary p-0 m-0 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog fa-fw"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end" style="width: 200px;">
                                                <?php if ($plugin['activated']) { ?>
                                                    <li><a href="<?php echo $plugin['deactivate']; ?>" class="dropdown-item"><?php echo lang('Text.deactivate'); ?></a></li>
                                                <?php } else { ?>
                                                <li><a href="<?php echo $plugin['activate']; ?>" class="dropdown-item"><?php echo lang('Text.activate'); ?></a></li>
                                                <?php } ?>
                                                <li><button type="button" class="dropdown-item" id="button-update" data-plugin="<?php echo $plugin['plugin_author'] . ':' . $plugin['plugin_name']; ?>"><?php echo lang('Text.update'); ?></button></li>
                                                <li><a href="<?php echo $plugin['remove']; ?>" class="dropdown-item"><?php echo lang('Text.remove'); ?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="small"><?php echo lang('Text.author'); ?>: <?php if ($plugin['plugin_link']) { ?><a href="<?php echo $plugin['plugin_link']; ?>" target="_blank"><?php echo $plugin['plugin_author']; ?></a><?php } else { ?><?php echo $plugin['plugin_author']; ?><?php } ?></div>
                                    <div class="border-top mt-3 py-3 small"><?php echo $plugin['plugin_description']; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="uploadModalLabel"><?php echo lang('Heading.upload_a_new_plugin'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="text-center my-5">
                <h3 class="mb-5"><?php echo lang('Text.plugin_upload_instruction'); ?></h3>
                <button type="button" class="btn btn-success btn-lg" id="button-upload"><i class="fas fa-upload fa-fw"></i> <?php echo lang('Button.upload'); ?></button>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
$('button[id=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: '<?php echo base_url('/admin/plugin/plugin/upload?administrator_token=' . $administrator_token); ?>',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#uploadModal #button-upload i').removeClass('fa-upload').addClass('fa-spinner fa-spin');
				},
				complete: function() {
					$('#uploadModal #button-upload i').removeClass('fa-spinner fa-spin').addClass('fa-upload');
				},
				success: function(json) {
					if (json['error']) {
						alert(JSON.stringify(json['error']));
					}

					if (json['success']) {
						alert(json['success']);

                        location.reload();
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});

		}
	}, 500);
});
//--></script> 
<script type="text/javascript"><!--
$('button[id=\'button-update\']').on('click', function() {
	var node = this;

	$('#form-update').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-update" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-update input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-update input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: '<?php echo base_url('/admin/plugin/plugin/update?administrator_token=' . $administrator_token . '&plugin='); ?>' + $(node).attr('data-plugin'),
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-update')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					//
				},
				complete: function() {
					//
				},
				success: function(json) {
					if (json['error']) {
						alert(JSON.stringify(json['error']));
					}

					if (json['success']) {
						alert(json['success']);

                        location.reload();
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});

		}
	}, 500);
});
//--></script> 
<?php echo $footer; ?>
