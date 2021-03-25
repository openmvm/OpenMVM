// Get Admin Segment
function getAdminSegment() {
	var query = String(window.location.href).replace($('base').attr('href'), '').split('/');
	var segment = query[1];
	
	if (segment) {
		return segment;
	} else {
		return '';
	}
}

// Get Administrator Token
function getAdministratorToken() {
	var query = String(window.location.href).replace($('base').attr('href'), '').split('/');
	var token = query.slice(-1)[0].split('?')[0];
	
	if (token) {
		return token;
	} else {
		return '';
	}
}

// General Scripts
$(document).ready(function() {
	// Sidebar
	$('#button-menu').on('click', function(e) {
		e.preventDefault();
		
		$('#sidemenu').toggleClass('active');
	});

	// Set last page opened on the menu
	$('#menu a[href]').on('click', function() {
		sessionStorage.setItem('menu', $(this).attr('href'));
	});

	if (!sessionStorage.getItem('menu')) {
		$('#menu #menu-dashboard').addClass('show');
	} else if (sessionStorage.getItem('menu') && sessionStorage.getItem('menu') != '#'){
		// Sets show and open to selected page in the left column menu.
		$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parent().parent().parent().addClass('show');
	} else {
		sessionStorage.removeItem('menu');
	}

	$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li > a').removeClass('collapsed');
	
	$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('ul').addClass('in');
	
	$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('div').addClass('show');
	
	$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').addClass('selected');
	
	$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parent().parent().parent().parent().children('a.parent').addClass('selected-parent');
	
	$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parent().parent().parent().parent().parent().parent().parent().children('a.parent').addClass('selected-grandparent');
	
	// TinyMCE
	if (typeof window.tinymce !== 'undefined') {
	  var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
		var activeTextArea = null;

	  tinymce.init({
	    selector: '.tinymce',
      setup: function (editor) { // on the setup of the TinyMCE plugin, add a button with the alias 'addImage'
		    editor.ui.registry.addButton('addImage', {
		    	icon: 'image',
		      // text: '',
		      onAction: function (_) {
						activeTextArea = editor; 

						// Create Modal
						$('#tinymceModal').remove();

						html = '';
						html += '<div class="modal fade" id="tinymceModal" aria-labelledby="exampleModalLabel" aria-hidden="true">';
						html += '  <div class="modal-dialog modal-fullscreen">';
						html += '    <div class="modal-content">';
						html += '      <div class="modal-header">';
						html += '        <h5 class="modal-title" id="exampleModalLabel">File Manager</h5>';
						html += '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
						html += '      </div>';
						html += '      <div class="modal-body">';
						html += '        <div id="filemanager-popup-container"></div>';
						html += '      </div>';
						html += '      <div class="modal-footer">';
						html += '        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
						html += '      </div>';
						html += '    </div>';
						html += '  </div>';
						html += '</div>';

						$('body').append(html);

						$('#tinymceModal #filemanager-popup-container').load($('base').attr('href') + '/' + getAdminSegment() + '/filemanager/popup');

						$('#tinymceModal').modal('show');

						$('#tinymceModal').on('click', '#filemanagerPopUp .browse', function(){
						  activeTextArea.insertContent('<img src="' + $(this).attr("data-src") + '" />');

							$('#tinymceModal').modal('hide');
						});
		      }
		    });
      },
		  plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
		  imagetools_cors_hosts: ['picsum.photos'],
		  menubar: 'file edit view insert format tools table help',
		  toolbar: 'undo redo | cut copy paste | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile addImage media template link anchor codesample | ltr rtl',
		  toolbar_sticky: true,
		  autosave_ask_before_unload: true,
		  autosave_interval: '30s',
		  autosave_prefix: '{path}{query}-{id}-',
		  autosave_restore_when_empty: false,
		  autosave_retention: '2m',
		  image_advtab: true,
		  link_list: [
		    { title: 'My page 1', value: 'https://www.tiny.cloud' },
		    { title: 'My page 2', value: 'http://www.moxiecode.com' }
		  ],
		  image_list: [
		    { title: 'My page 1', value: 'https://www.tiny.cloud' },
		    { title: 'My page 2', value: 'http://www.moxiecode.com' }
		  ],
		  image_class_list: [
		    { title: 'None', value: '' },
		    { title: 'Some class', value: 'class-name' }
		  ],
		  importcss_append: true,
		  templates: [
		        { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
		    { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
		    { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
		  ],
		  template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
		  template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
		  height: 400,
		  image_caption: true,
		  quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
		  noneditable_noneditable_class: 'mceNonEditable',
		  toolbar_mode: 'sliding',
		  contextmenu: 'link image imagetools table',
		  skin: useDarkMode ? 'oxide-dark' : 'oxide',
			relative_urls : false,
			remove_script_host : false,
			convert_urls : true,
		  content_css: useDarkMode ? 'dark' : 'default',
		  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
	  });
	}

	// File Manager
	var imageReplaceModal = null;

	$(document).on('click', 'div[data-toggle=\'replace-image\']', function(e){
		var $element = $(this);
		var $target = $element.data("target");

		e.preventDefault();

		// Create Modal
		$('#imageReplaceModal').remove();

		html = '';
		html += '<div class="modal fade" id="imageReplaceModal" aria-labelledby="exampleModalLabel" aria-hidden="true">';
		html += '  <div class="modal-dialog modal-fullscreen">';
		html += '    <div class="modal-content">';
		html += '      <div class="modal-header">';
		html += '        <h5 class="modal-title" id="exampleModalLabel">File Manager</h5>';
		html += '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
		html += '      </div>';
		html += '      <div class="modal-body">';
		html += '        <div id="filemanager-popup-container"></div>';
		html += '      </div>';
		html += '      <div class="modal-footer">';
		html += '        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
		html += '      </div>';
		html += '    </div>';
		html += '  </div>';
		html += '</div>';

		$('body').append(html);

		$('#imageReplaceModal #filemanager-popup-container').load($('base').attr('href') + '/' + getAdminSegment() + '/filemanager/popup');

		$('#imageReplaceModal').modal('show');

		$('#imageReplaceModal').on('click', '#filemanagerPopUp .browse', function(){
			path = $(this).data("path");
			thumb = $(this).data("thumb");
			$('#' + $target).val(path);
			$('#' + $target + '-href').html('<img src="' + thumb + '" class="img-fluid mx-auto my-auto" />');

			$('#imageReplaceModal').modal('hide');
		});
	});

	// Delete Image
	$( document ).on('click','span[data-toggle=\'delete-image\']', function(e) {
		e.preventDefault();
		var target = $(this).data("target");
		var placeholder = $(this).data("replace");

		$('#' + target).val('');
		$('#' + target + '-href').html('<img src="' + placeholder + '" class="img-fluid mx-auto my-auto" />');
		//alert(target);
	});

});

// Autocomplete */
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			var $this = $(this);
			var $dropdown = $('<ul class="dropdown-menu" />');

			this.timer = null;
			this.items = [];

			$.extend(this, option);

			$this.attr('autocomplete', 'off');

			// Focus
			$this.on('focus', function() {
				this.request();
			});

			// Blur
			$this.on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$this.on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				var value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function() {
				var pos = $this.position();

				$dropdown.css({
					top: pos.top + $this.outerHeight(),
					left: pos.left
				});

				$dropdown.show();
			}

			// Hide
			this.hide = function() {
				$dropdown.hide();
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function(json) {
				var html = '';
				var category = {};
				var name;
				var i = 0, j = 0;

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						// update element items
						this.items[json[i]['value']] = json[i];

						if (!json[i]['category']) {
							// ungrouped items
							html += '<li data-value="' + json[i]['value'] + '"><a href="#" class="dropdown-item">' + json[i]['label'] + '</a></li>';
						} else {
							// grouped items
							name = json[i]['category'];
							if (!category[name]) {
								category[name] = [];
							}

							category[name].push(json[i]);
						}
					}

					for (name in category) {
						html += '<li class="dropdown-header">' + name + '</li>';

						for (j = 0; j < category[name].length; j++) {
							html += '<li data-value="' + category[name][j]['value'] + '"><a href="#" class="dropdown-item">&nbsp;&nbsp;&nbsp;' + category[name][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$dropdown.html(html);
			}

			$dropdown.on('click', '> li > a', $.proxy(this.click, this));
			$this.after($dropdown);
		});
	}
})(window.jQuery);
