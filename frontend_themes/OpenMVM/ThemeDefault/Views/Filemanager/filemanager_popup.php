<div id="filemanagerPopUp" class="card text-center min-vh-100">
  <div class="card-header">
		<div class="clearfix">
			<div class="float-start">
				<div class="btn-group" role="group" aria-label="Home">
					<span id="button-home" class="btn btn-light btn-sm border border-secondary" title="<?php echo lang('Button.button_home', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-home fa-fw"></i></span>
				</div>
				<div class="btn-group dropdown" role="group" aria-label="Folder">
				  <span id="dropdownFolderButton" class="btn btn-light btn-sm border border-secondary dropdown-toggle" data-bs-toggle="dropdown" title="<?php echo lang('Button.button_new_folder', array(), $lang->getFrontEndLocale()); ?>" aria-haspopup="true" aria-expanded="false"><i class="fas fa-folder-plus fa-fw"></i></span>
				  <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton">
						<div class="input-group input-group-sm" style="width: 200px;">
						  <input type="text" id="input-new-folder" class="form-control" placeholder="<?php echo lang('Entry.entry_folder_name', array(), $lang->getFrontEndLocale()); ?>" aria-label="<?php echo lang('Entry.entry_folder_name', array(), $lang->getFrontEndLocale()); ?>" aria-describedby="button-new-folder">
						  <div class="input-group-append">
						    <span id="button-new-folder" class="btn btn-outline-secondary clickable"><i class="fas fa-plus fa-fw"></i></span>
						  </div>
						</div>
				  </div>
				</div>
				<div class="btn-group" role="group" aria-label="Upload">
					<span id="button-upload" class="btn btn-light btn-sm border border-secondary" title="<?php echo lang('Button.button_upload', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-upload fa-fw"></i></span>
					<span id="button-download" class="btn btn-light btn-sm border border-secondary" title="<?php echo lang('Button.button_download', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-download fa-fw"></i></span>
				</div>
				<div class="btn-group" role="group" aria-label="Cache">
					<span id="button-clear-cache" class="btn btn-light btn-sm border border-secondary" title="<?php echo lang('Button.button_rebuild_cache', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-broom fa-fw"></i></span>
					<span id="button-refresh" class="btn btn-light btn-sm border border-secondary" data-toggle="tooltip" data-placement="top" title="<?php echo lang('Button.button_refresh', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-sync fa-fw"></i></span>
				</div>
				<div class="btn-group" role="group" aria-label="Delete">
					<span id="button-delete" class="btn btn-light btn-sm border border-secondary" title="<?php echo lang('Button.button_delete', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-trash-alt fa-fw"></i></span>
				</div>
			</div>
			<div class="float-end"><span id="progress-percentage" class="text-secondary"></span> <progress id="progress" value="0"></progress></div>
		</div>
  </div>
  <div class="card-body">
		<div id="filemanagerContent" style="min-height: 250px;">
			<div id="spinner" class="text-center d-none"><span><i class="fas fa-spinner fa-spin fa-3x"></i><br /><?php echo lang('Text.text_loading', array(), $lang->getFrontEndLocale()); ?></span></div>
		</div> 
  </div>
  <div class="card-footer text-muted">
    2 days ago
  </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function(){
	refresh();
});
--></script>
<script type="text/javascript" language="javascript">
$( "#button-home" ).click(function() {
	refresh();
});
--></script>
<script type="text/javascript" language="javascript">
$( "#button-refresh" ).click(function() {
	var path = $('#input-directory').val();

	refresh(path);
});
--></script>
<script type="text/javascript" language="javascript">
function refresh(path) {
	<?php if ($filemanager_popup !== null) { ?>
		var popup = ' id="filemanager-popup"';
	<?php } else { ?>
		var popup = '';
	<?php } ?>
	<?php if ($filemanager_popup !== null && $filemanager_popup == 'image') { ?>
		var clickable = 'unclickable';
	<?php } else { ?>
		var clickable = 'clickable';
	<?php } ?>

	$.ajax({
		url: '<?php echo base_url('/account/filemanager/contents/' . $user_token); ?>',
		type: 'post',
		dataType: 'json',
    headers : {
      'csrf-token': $('meta[name="csrf-token"]').attr('content')
    },
		data : {
			path : path
		},
		beforeSend: function() {
			$('.fa-sync').addClass('fa-spin');
			$('#spinner').removeClass('d-none');
		},
		complete: function() {
			$('.fa-sync').removeClass('fa-spin');
			$('#spinner').addClass('d-none');
		},
		success: function(json) {
			if (json['error']) {
				alert(json['error']);
			} else {
				html = '<div>';
				if (json['directory'] != null) {
					html += '<div class="small bg-secondary text-light p-2 mb-3"><div class="back clickable" onclick="refresh(\'' + json['directory'] + '\');"><i class="fas fa-level-up-alt"></i> /' + json['path'] + '<input type="hidden" name="directory" value="' + json['path'] + '" id="input-directory" /></div></div>';
				} else {
					if (json['directory'] == undefined) {
						html += '<div class="small bg-secondary text-light p-2 mb-3"><div class="back clickable" onclick="refresh();"><i class="fas fa-level-up-alt"></i> /' + json['path'] + '<input type="hidden" name="directory" value="' + json['path'] + '" id="input-directory" /></div></div>';
					}
				}
				html += '<div' + popup + ' class="filemanager-content bg-light">';
				html += '  <div class="row">';
				if (json['contents'] != null && json['contents'].length != undefined) {
					for (i = 0; i < json['contents'].length; i++) {
						html += '    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 d-flex">';
						html += '      <div id="image-container" class="card w-100 mb-3">';
						html += '        <div class="card-body">';
						html += '          <div class="text-center">';
						if (json['contents'][i]['type'] === 'image') {
						html += '            <div class="clickable browse mb-2 d-flex" data-src="' + json['contents'][i]['source'] + '" data-thumb="' + json['contents'][i]['thumb'] + '" data-path="' + json['contents'][i]['path'] + '"><img src="' + json['contents'][i]['thumb'] + '" class="img-fluid mx-auto my-auto"';
							<?php if ($filemanager_popup !== null && $filemanager_popup == 'image') { ?>
								html += ' onclick="selectImage(\''+ json['contents'][i]['path'] +'\',\''+ json['contents'][i]['source'] +'\');"';
							<?php } ?>
						html += ' /></div>';
						} else if (json['contents'][i]['type'] === 'audio') {
						html += '            <div class="' + clickable + ' browse mb-2 d-flex" data-src="' + json['contents'][i]['source'] + '"><i class="fas fa-music fa-fw fa-3x text-warning mx-auto my-auto"></i></div>';
						} else if (json['contents'][i]['type'] === 'video') {
						html += '            <div class="' + clickable + ' browse mb-2 d-flex" data-src="' + json['contents'][i]['source'] + '"><i class="fas fa-film fa-fw fa-3x text-success mx-auto my-auto"></i></div>';
						} else if (json['contents'][i]['type'] === 'pdf') {
						html += '            <div class="' + clickable + ' browse mb-2 d-flex" data-src="' + json['contents'][i]['source'] + '"><i class="fas fa-file-pdf fa-fw fa-3x text-danger mx-auto my-auto"></i></div>';
						} else if (json['contents'][i]['type'] === 'archive') {
						html += '            <div class="' + clickable + ' browse mb-2 d-flex" data-src="' + json['contents'][i]['source'] + '"><i class="fas fa-file-archive fa-fw fa-3x text-purple mx-auto my-auto"></i></div>';
						} else if (json['contents'][i]['type'] === 'word') {
						html += '            <div class="' + clickable + ' browse mb-2 d-flex" data-src="' + json['contents'][i]['source'] + '"><i class="fas fa-file-word fa-fw fa-3x text-info mx-auto my-auto"></i></div>';
						} else if (json['contents'][i]['type'] === 'excel') {
						html += '            <div class="' + clickable + ' browse mb-2 d-flex" data-src="' + json['contents'][i]['source'] + '"><i class="fas fa-file-excel fa-fw fa-3x text-info mx-auto my-auto"></i></div>';
						} else if (json['contents'][i]['type'] === 'powerpoint') {
						html += '            <div class="' + clickable + ' browse mb-2 d-flex" data-src="' + json['contents'][i]['source'] + '"><i class="fas fa-file-powerpoint fa-fw fa-3x text-info mx-auto my-auto"></i></div>';
						} else if (json['contents'][i]['type'] === 'document') {
						html += '            <div class="' + clickable + ' browse mb-2 d-flex" data-src="' + json['contents'][i]['source'] + '"><i class="fas fa-file-alt fa-fw fa-3x text-purple mx-auto my-auto"></i></div>';
						} else if (json['contents'][i]['type'] === 'directory') {
						html += '            <div class="clickable mb-2 d-flex" onclick="refresh(\'' + json['contents'][i]['path'] + '\');"><i class="fas fa-folder fa-fw fa-3x text-dark mx-auto my-auto"></i></div>';
						} else {
						html += '            <div class="clickable mb-2 d-flex"><i class="fas fa-file-alt fa-fw fa-3x text-purple mx-auto my-auto"></i></div>';
						}
						html += '            <div class="form-check small"><input name="selected[]" value="' + json['contents'][i]['path'] + '" type="checkbox" class="form-check-input" id="' + json['contents'][i]['path'] + '"> <label class="form-check-label" for="' + json['contents'][i]['path'] + '">' + json['contents'][i]['name'] + '</label></div>';
						html += '          </div>';
						html += '        </div>';
						html += '      </div>';
						html += '    </div>';
					}
				}
				html += '  </div>';
				html += '</div>';
				html += '</div>';

				$( "div#filemanagerContent" ).html(html);

				<?php if ($filemanager_popup !== null && $filemanager_popup == 'editor') { ?>
    		selectFile();
      	<?php } ?>
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}
--></script>
<script type="text/javascript" language="javascript">
$( "#button-new-folder" ).click(function() {
	var folder_name = $('#input-new-folder').val();
	var path = $('#input-directory').val();

	if (folder_name != null && folder_name != '') {
		$.ajax({
			url: '<?php echo base_url('/account/filemanager/create_directory/' . $user_token); ?>',
			type: 'post',
			dataType: 'json',
	    headers : {
	      'csrf-token': $('meta[name="csrf-token"]').attr('content')
	    },
			data : {
				folder_name : folder_name,
				path : path
			},
			beforeSend: function() {
				//$('#combobox #input-combobox-' + prev_val).after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
			},
			complete: function() {
				//$('.fa-spin').remove();filemanager-content
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				} else {
					alert(json['success']);
					$('#input-new-folder').val('');
					refresh(path);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	} else {
		alert( '<?php echo lang('Error.error_folder_name', array(), $lang->getFrontEndLocale()); ?>' );
	}

});
--></script>
<script type="text/javascript"><!--
	$('#filemanagerContent').on(
    'drag dragstart dragend dragover dragenter dragleave drop',
    function(e) {
      e.preventDefault();
      e.stopPropagation();
    }
	)
	.on('drop', function(e) {
    e.preventDefault();
		
    droppedFiles = e.originalEvent.dataTransfer.files;

		var path = $('#input-directory').val();

		$('#form-upload').remove();

		$('body').prepend('<form method="post" enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" value="" multiple="multiple" /><input type="hidden" name="path" value="' + path +'" /></form>');

		var $input = $('#form-upload').find('input[type="file"]');
		var ajaxData = new FormData($('#form-upload').get(0));

	  if (droppedFiles) {
	    $.each( droppedFiles, function(i, file) {
	      ajaxData.append( $input.attr('name'), file );
	    });
	  }

		if (typeof timer != 'undefined') {
				clearInterval(timer);
		}

		timer = setInterval(function() {
			clearInterval(timer);

			$.ajax({
				url: '<?php echo base_url('/account/filemanager/upload/' . $user_token); ?>',
				type: 'post',
				dataType: 'json',
	    	headers : {
		      'csrf-token': $('meta[name="csrf-token"]').attr('content')
		    },
				data: ajaxData,
				cache: false,
				contentType: false,
				processData: false,
		    // Custom XMLHttpRequest
		    xhr: function () {
		      var myXhr = $.ajaxSettings.xhr();
		      if (myXhr.upload) {
		        // For handling the progress of the upload
		        myXhr.upload.addEventListener('progress', function (e) {
		          if (e.lengthComputable) {
		          	var ratio = Math.floor((e.loaded / e.total) * 100) + '%';

		            $('progress').attr({
		              value: e.loaded,
		              max: e.total,
		            });

		            $('#progress-percentage').html(ratio);
		          }
		        }, false);
		      }
		      return myXhr;
		    },
				beforeSend: function() {
					$('progress').val(0);
					$('#progress-percentage').html('');
					$('.fa-upload').addClass('fa-spin');
				},
				complete: function() {
					$('.fa-upload').removeClass('fa-spin');
				},
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					} else {
						refresh(json['path']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}, 500);
  });
--></script>
<script type="text/javascript"><!--
$('#button-upload').on('click', function() {
	var path = $('#input-directory').val();

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" value="" multiple="multiple" /><input type="hidden" name="path" value="' + path +'" /></form>');

	$('#form-upload input[name=\'file[]\']').trigger('click');

	if (typeof timer != 'undefined') {
			clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file[]\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: '<?php echo base_url('/account/filemanager/upload/' . $user_token); ?>',
				type: 'post',
				dataType: 'json',
	    	headers : {
		      'csrf-token': $('meta[name="csrf-token"]').attr('content')
		    },
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
		    // Custom XMLHttpRequest
		    xhr: function () {
		      var myXhr = $.ajaxSettings.xhr();
		      if (myXhr.upload) {
		        // For handling the progress of the upload
		        myXhr.upload.addEventListener('progress', function (e) {
		          if (e.lengthComputable) {
		          	var ratio = Math.floor((e.loaded / e.total) * 100) + '%';

		            $('progress').attr({
		              value: e.loaded,
		              max: e.total,
		            });

		            $('#progress-percentage').html(ratio);
		          }
		        }, false);
		      }
		      return myXhr;
		    },
				beforeSend: function() {
					$('.fa-upload').addClass('fa-spin');
				},
				complete: function() {
					$('.fa-upload').removeClass('fa-spin');
				},
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					} else {
						refresh(json['path']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
--></script>
<script type="text/javascript"><!--
$('#button-download').on('click', function(e) {
	var path = $('#input-directory').val();

	if (confirm('<?php echo lang('Text.text_confirm', array(), $lang->getFrontEndLocale()); ?>')) {
		$.ajax({
			url: '<?php echo base_url('/account/filemanager/compress/' . $user_token); ?>',
			type: 'post',
			dataType: 'json',
    	headers : {
	      'csrf-token': $('meta[name="csrf-token"]').attr('content')
	    },
			data: $('input[name^=\'selected\']:checked'),
			beforeSend: function() {
				$('#button-download').prop('disabled', true);
			},
			complete: function() {
				$('#button-download').prop('disabled', false);
			},
			success: function(json) {
				if (json['success']) {
					window.location.href = '<?php echo base_url('/account/filemanager/download/' . $user_token); ?>?archive=' + json['success'];
				} else {
					alert(json['error']);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});
--></script>
<script type="text/javascript"><!--
$('#button-clear-cache').on('click', function(e) {
	var path = $('#input-directory').val();

	if (confirm('<?php echo lang('Text.text_confirm', array(), $lang->getFrontEndLocale()); ?>')) {
		$.ajax({
			url: '<?php echo base_url('/account/filemanager/clear_cache/' . $user_token); ?>',
			type: 'post',
			dataType: 'json',
    	headers : {
	      'csrf-token': $('meta[name="csrf-token"]').attr('content')
	    },
			beforeSend: function() {
				$('#button-clear-cache').prop('disabled', true);
				$('.fa-broom').addClass('fa-spin');
			},
			complete: function() {
				$('#button-clear-cache').prop('disabled', false);
				$('.fa-broom').removeClass('fa-spin');
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				} else {
					refresh(path);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});
--></script>
<script type="text/javascript"><!--
$('#button-delete').on('click', function(e) {
	var path = $('#input-directory').val();

	if (confirm('<?php echo lang('Text.text_confirm', array(), $lang->getFrontEndLocale()); ?>')) {
		$.ajax({
			url: '<?php echo base_url('/account/filemanager/delete/' . $user_token); ?>',
			type: 'post',
			dataType: 'json',
    	headers : {
	      'csrf-token': $('meta[name="csrf-token"]').attr('content')
	    },
			data: $('input[name^=\'selected\']:checked'),
			beforeSend: function() {
				$('#button-delete').prop('disabled', true);
			},
			complete: function() {
				$('#button-delete').prop('disabled', false);
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				} else {
					refresh(path);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});
--></script>
<?php if ($filemanager_popup !== null && $filemanager_popup == 'editor') { ?>
<script type="text/javascript" language="javascript">
function selectFile() {
	$(document).on("click","div.browse",function(){
		item_url = $(this).data("src");
		var args = top.tinymce.activeEditor.windowManager.getParams();
		win = (args.window);
		input = (args.input);
		win.document.getElementById(input).value = item_url;
		top.tinymce.activeEditor.windowManager.close();
	});
}
--></script>
<script type="text/javascript" language="javascript">
$("#filemanagerContent").click(function (e) {
  //activeTextArea.insertContent('&nbsp; <img src="' + $(this).attr("src") + '" /> &nbsp;');
  activeTextArea.insertContent('&nbsp; Click! &nbsp;');

	myModal.hide();
});
--></script>
<?php } ?>
