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
                <h3 class="card-title"><i class="fas fa-language fa-fw"></i> <?php echo $heading_title; ?></h3>
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
        <?php echo form_open($action, ['id' => 'form-language-editor']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-list fa-fw"></i> <?php echo lang('Heading.list'); ?></h5> 
                <div class="float-end">
                    <div id="form-add-file" class="float-start dropdown me-1">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdown-menu-button-add" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="dropdown-menu-button-add" style="min-width: 300px;">
                            <fieldset>
                                <div class="input-group">
                                    <input type="text" name="filename" class="form-control" placeholder="<?php echo lang('Entry.filename'); ?>" aria-label="<?php echo lang('Entry.filename'); ?>" aria-describedby="button-add-file">
                                    <button class="btn btn-outline-primary" type="button" id="button-add-file"><i class="fas fa-plus"></i></button>
                                </div>
                            </fieldset>
                        </div>
                    </div> 
                    <button type="button" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt fa-fw" onclick="confirm('<?php echo lang('Text.are_you_sure'); ?>') ? $('#form-language-editor').submit() : false;"></i></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <caption><?php echo lang('Caption.list_of_files'); ?></caption>
                    <thead>
                        <tr>
                            <th scope="col"><input class="form-check-input" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                            <th scope="col"><?php echo lang('Column.file'); ?></th>
                            <th scope="col" class="text-end"><?php echo lang('Column.action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($files) { ?>
                            <?php foreach ($files as $file) { ?>
                            <tr>
                                <th scope="row">
                                    <div class="form-check">
                                        <?php if (in_array($file['file'], $selected)) { ?>
                                        <input class="form-check-input" type="checkbox" name="selected[]" value="<?php echo $file['file']; ?>" id="input-selected-<?php echo $file['file']; ?>" checked="checked">
                                        <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" name="selected[]" value="<?php echo $file['file']; ?>" id="input-selected-<?php echo $file['file']; ?>">
                                        <?php } ?>
                                    </div>                                        
                                </th>
                                <td><?php echo $file['file']; ?></td>
                                <td class="text-end"><a href="<?php echo $file['href']; ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit fa-fw"></i></a></td>
                            </tr>
                            <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td colspan="3" class="text-muted text-center"><?php echo lang('Error.no_data_found'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
$( "#button-add-file" ).on( "click", function() {
	$.ajax({
		url: '<?php echo $add; ?>',
		type: 'post',
		data: $('#form-add-file input[type=\'text\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-add-file i').removeClass('fa-plus').addClass('fa-spinner fa-spin');
		},
		complete: function() {
			$('#button-add-file i').removeClass('fa-spinner fa-spin').addClass('fa-plus');
		},
		success: function(json) {
            if (json['error']) {
                alert(json['error']);
            }

            if (json['success']) {
                alert(json['success']);
                
                var url = $(location).attr('href');

                location = url;
            }
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});
//--></script> 
<?php echo $footer; ?>
