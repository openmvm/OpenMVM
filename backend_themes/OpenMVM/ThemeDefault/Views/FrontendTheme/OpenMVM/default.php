<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-images fa-fw"></i> <?php echo $heading_title; ?></h2>
		<div class="heading-lead lead text-white"><?php echo $lead; ?></div>
	</section>
  <!-- /.heading-container -->

	<!-- Breadcrumb -->
	<?php if ($breadcrumbs) { ?>
	<section id="breadcrumb" class="bg-light p-3 mb-3">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb small p-0 m-0">
		  	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		  		<?php if ($breadcrumb['active']) { ?>
		    	<li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
	  			<?php } else { ?>
		    	<li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
	  			<?php } ?>
		  	<?php } ?>
		  </ol>
		</nav>
  </section>
	<?php } ?>
	<!-- /.breadcrumb -->

	<!-- Notification -->
	<?php if ($success || $error) { ?>
	<section id="notification" class="notification px-3">
		<?php if ($success) { ?>
		<div class="alert alert-success alert-dismissible" role="alert">
		  <?php echo $success; ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<?php } ?>
		<?php if ($error) { ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <?php echo $error; ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<?php } ?>
  </section>
	<?php } ?>
	<!-- /.notification -->

	<!-- Content -->
	<section class="content px-3">
    <?php echo form_open($action); ?>
    <div class="clearfix mb-3">
	    <div class="float-end">
	      <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_save', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-save"></i></button>
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/frontend_themes/' . $administrator_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
	    </div>
    </div>
		<div class="accordion" id="accordionSetting">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingSetting">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
		        <i class="fas fa-edit fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_theme_default_settings', array(), $lang->getBackEndLocale()); ?>
		      </button>
		    </h2>
		    <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionSetting">
		      <div class="accordion-body">
						<ul class="nav nav-tabs mb-3" id="tab-setting" role="tablist">
						  <li class="nav-item" role="presentation">
						    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.tab_general', array(), $lang->getBackEndLocale()); ?></button>
						  </li>
						  <li class="nav-item" role="presentation">
						    <button class="nav-link" id="widget-layouts-tab" data-bs-toggle="tab" data-bs-target="#widget-layouts" type="button" role="tab" aria-controls="widget-layouts" aria-selected="true"><?php echo lang('Tab.tab_widget_layouts', array(), $lang->getBackEndLocale()); ?></button>
						  </li>
						</ul>
						<div class="tab-content" id="myTabContent">
						  <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
						  	<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_general', array(), $lang->getBackEndLocale()); ?></h5>
						  	<div class="form-floating mb-3">
								  <input type="text" name="frontend_theme_openmvm_default_name" value="<?php echo $frontend_theme_openmvm_default_name; ?>" class="form-control<?php if ($validation->hasError('frontend_theme_openmvm_default_name')) { ?> is-invalid<?php } ?>" id="input-name" placeholder="<?php echo lang('Entry.entry_name', array(), $lang->getBackEndLocale()); ?>">
								  <label for="input-name"><?php echo lang('Entry.entry_name', array(), $lang->getBackEndLocale()); ?></label>
								  <?php if ($validation->hasError('frontend_theme_openmvm_default_name')) { ?>
                  <div class="text-danger small"><?php echo $validation->getError('frontend_theme_openmvm_default_name'); ?></div>
                	<?php } ?>
								</div>
						  </div>
						  <div class="tab-pane fade" id="widget-layouts" role="tabpanel" aria-labelledby="widget-layouts-tab">
						  	<div class="row">
						  		<div class="col-sm-2">
										<nav class="nav flex-column nav-pills" id="layoutTab">
											<?php foreach ($layouts as $layout) { ?>
										  <a class="nav-link" id="layout-<?php echo $layout['layout_id']; ?>-tab" data-bs-toggle="tab" data-bs-target="#layout-<?php echo $layout['layout_id']; ?>" type="button" role="tab" aria-controls="layout-<?php echo $layout['layout_id']; ?>" aria-selected="true" aria-current="page" href="#"><?php echo $layout['name']; ?></a>
											<?php } ?>
										</nav>
						  		</div>
						  		<div class="col-sm-10">
										<div class="tab-content" id="myTabContent">
											<?php foreach ($layouts as $layout) { ?>
										  <div class="tab-pane fade" id="layout-<?php echo $layout['layout_id']; ?>" role="tabpanel" aria-labelledby="layout-<?php echo $layout['layout_id']; ?>-tab">
										  	<h5 class="border-bottom border-secondary pb-2 mb-3"><?php echo $layout['name']; ?></h5>
										  	<div id="widget-layout-page-top" class="card card-body mb-3">
										  		<h6 class="border-bottom pb-2 mb-3"><?php echo lang('Text.text_page_top', array(), $lang->getBackEndLocale()); ?></h6>
										  		<?php ${'layout_page_top_row_' . $layout['layout_id']} = 0; ?>
										  		<div id="widget-layout-<?php echo $layout['layout_id']; ?>-page-top-items" class="d-grid">
										  			<?php if (!empty(${'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']}['page_top'])) { ?>
											  			<?php foreach (${'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']}['page_top'] as $key => $value) { ?>
															<div class="input-group mb-3">
																<select name="frontend_theme_openmvm_default_layout_widget_<?php echo $layout['layout_id']; ?>[page_top][<?php echo ${'layout_page_top_row_' . $layout['layout_id']}; ?>]" class="form-select" id="input-widget-layout-<?php echo $layout['layout_id']; ?>-page-top-item-<?php echo ${'layout_page_top_row_' . $layout['layout_id']}; ?>" aria-label="">
																<?php foreach ($widgets as $widget) { ?>
																	<?php if ($widget['widget_items']) { ?>
																		<optgroup label="<?php echo $widget['name']; ?>">
																		<?php foreach ($widget['widget_items'] as $widget_item) { ?>
																			<?php if ($value == $widget_item['widget_id']) { ?>
																			<option value="<?php echo $widget_item['widget_id']; ?>" selected="selected"><?php echo $widget_item['name']; ?></option>
																			<?php } else { ?>
																			<option value="<?php echo $widget_item['widget_id']; ?>"><?php echo $widget_item['name']; ?></option>
																			<?php } ?>
																		<?php } ?>
																	<?php } ?>
																<?php } ?>
																</select>
																<a class="btn btn-danger remove" type="button"><i class="fas fa-minus-circle"></i></a>
															</div>
															<?php ${'layout_page_top_row_' . $layout['layout_id']} = ${'layout_page_top_row_' . $layout['layout_id']} + 1; ?>
											  			<?php } ?>
										  			<?php } ?>
										  			<a id="button-page-top-widget-add-<?php echo $layout['layout_id']; ?>" class="btn btn-primary" onclick="addWidget('<?php echo $layout['layout_id']; ?>', 'page-top');"><i class="fas fa-plus-circle"></i> <?php echo lang('Button.button_widget_add', array(), $lang->getBackEndLocale()); ?></a>
										  			<input type="hidden" value="<?php echo ${'layout_page_top_row_' . $layout['layout_id']}; ?>" id="layout-page-top-row-<?php echo $layout['layout_id']; ?>" />
										  		</div>
										  	</div>
										  	<div class="row">
										  		<div class="col-sm-4">
												  	<div id="widget-layout-widget-start" class="card card-body mb-3">
												  		<h6 class="border-bottom pb-2 mb-3"><?php echo lang('Text.text_widget_start', array(), $lang->getBackEndLocale()); ?></h6>
										  				<?php ${'layout_widget_start_row_' . $layout['layout_id']} = 0; ?>
												  		<div id="widget-layout-<?php echo $layout['layout_id']; ?>-widget-start-items" class="d-grid">
												  			<?php if (!empty(${'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']}['widget_start'])) { ?>
													  			<?php foreach (${'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']}['widget_start'] as $key => $value) { ?>
																	<div class="input-group mb-3">
																		<select name="frontend_theme_openmvm_default_layout_widget_<?php echo $layout['layout_id']; ?>[widget_start][<?php echo ${'layout_widget_start_row_' . $layout['layout_id']}; ?>]" class="form-select" id="input-widget-layout-<?php echo $layout['layout_id']; ?>-widget-start-item-<?php echo ${'layout_widget_start_row_' . $layout['layout_id']}; ?>" aria-label="">
																		<?php foreach ($widgets as $widget) { ?>
																			<?php if ($widget['widget_items']) { ?>
																				<optgroup label="<?php echo $widget['name']; ?>">
																				<?php foreach ($widget['widget_items'] as $widget_item) { ?>
																					<?php if ($value == $widget_item['widget_id']) { ?>
																					<option value="<?php echo $widget_item['widget_id']; ?>" selected="selected"><?php echo $widget_item['name']; ?></option>
																					<?php } else { ?>
																					<option value="<?php echo $widget_item['widget_id']; ?>"><?php echo $widget_item['name']; ?></option>
																					<?php } ?>
																				<?php } ?>
																			<?php } ?>
																		<?php } ?>
																		</select>
																		<a class="btn btn-danger remove" type="button"><i class="fas fa-minus-circle"></i></a>
																	</div>
																	<?php ${'layout_widget_start_row_' . $layout['layout_id']} = ${'layout_widget_start_row_' . $layout['layout_id']} + 1; ?>
													  			<?php } ?>
												  			<?php } ?>
												  			<a id="button-widget-start-widget-add-<?php echo $layout['layout_id']; ?>" class="btn btn-primary" onclick="addWidget('<?php echo $layout['layout_id']; ?>', 'widget-start');"><i class="fas fa-plus-circle"></i> <?php echo lang('Button.button_widget_add', array(), $lang->getBackEndLocale()); ?></a>
										  					<input type="hidden" value="<?php echo ${'layout_widget_start_row_' . $layout['layout_id']}; ?>" id="layout-widget-start-row-<?php echo $layout['layout_id']; ?>" />
												  		</div>
												  	</div>
										  		</div>
										  		<div class="col-sm-4">
												  	<div id="widget-layout-content-top" class="card card-body mb-3">
												  		<h6 class="border-bottom pb-2 mb-3"><?php echo lang('Text.text_content_top', array(), $lang->getBackEndLocale()); ?></h6>
										  				<?php ${'layout_content_top_row_' . $layout['layout_id']} = 0; ?>
												  		<div id="widget-layout-<?php echo $layout['layout_id']; ?>-content-top-items" class="d-grid">
												  			<?php if (!empty(${'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']}['content_top'])) { ?>
													  			<?php foreach (${'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']}['content_top'] as $key => $value) { ?>
																	<div class="input-group mb-3">
																		<select name="frontend_theme_openmvm_default_layout_widget_<?php echo $layout['layout_id']; ?>[content_top][<?php echo ${'layout_content_top_row_' . $layout['layout_id']}; ?>]" class="form-select" id="input-widget-layout-<?php echo $layout['layout_id']; ?>-content-top-item-<?php echo ${'layout_content_top_row_' . $layout['layout_id']}; ?>" aria-label="">
																		<?php foreach ($widgets as $widget) { ?>
																			<?php if ($widget['widget_items']) { ?>
																				<optgroup label="<?php echo $widget['name']; ?>">
																				<?php foreach ($widget['widget_items'] as $widget_item) { ?>
																					<?php if ($value == $widget_item['widget_id']) { ?>
																					<option value="<?php echo $widget_item['widget_id']; ?>" selected="selected"><?php echo $widget_item['name']; ?></option>
																					<?php } else { ?>
																					<option value="<?php echo $widget_item['widget_id']; ?>"><?php echo $widget_item['name']; ?></option>
																					<?php } ?>
																				<?php } ?>
																			<?php } ?>
																		<?php } ?>
																		</select>
																		<a class="btn btn-danger remove" type="button"><i class="fas fa-minus-circle"></i></a>
																	</div>
																	<?php ${'layout_content_top_row_' . $layout['layout_id']} = ${'layout_content_top_row_' . $layout['layout_id']} + 1; ?>
													  			<?php } ?>
												  			<?php } ?>
												  			<a id="button-content-top-widget-add-<?php echo $layout['layout_id']; ?>" class="btn btn-primary" onclick="addWidget('<?php echo $layout['layout_id']; ?>', 'content-top');"><i class="fas fa-plus-circle"></i> <?php echo lang('Button.button_widget_add', array(), $lang->getBackEndLocale()); ?></a>
										  					<input type="hidden" value="<?php echo ${'layout_content_top_row_' . $layout['layout_id']}; ?>" id="layout-content-top-row-<?php echo $layout['layout_id']; ?>" />
												  		</div>
												  	</div>
												  	<div id="widget-layout-content-bottom" class="card card-body mb-3">
												  		<h6 class="border-bottom pb-2 mb-3"><?php echo lang('Text.text_content_bottom', array(), $lang->getBackEndLocale()); ?></h6>
										  				<?php ${'layout_content_bottom_row_' . $layout['layout_id']} = 0; ?>
												  		<div id="widget-layout-<?php echo $layout['layout_id']; ?>-content-bottom-items" class="d-grid">
												  			<?php if (!empty(${'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']}['content_bottom'])) { ?>
													  			<?php foreach (${'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']}['content_bottom'] as $key => $value) { ?>
																	<div class="input-group mb-3">
																		<select name="frontend_theme_openmvm_default_layout_widget_<?php echo $layout['layout_id']; ?>[content_bottom][<?php echo ${'layout_content_bottom_row_' . $layout['layout_id']}; ?>]" class="form-select" id="input-widget-layout-<?php echo $layout['layout_id']; ?>-content-bottom-item-<?php echo ${'layout_content_bottom_row_' . $layout['layout_id']}; ?>" aria-label="">
																		<?php foreach ($widgets as $widget) { ?>
																			<?php if ($widget['widget_items']) { ?>
																				<optgroup label="<?php echo $widget['name']; ?>">
																				<?php foreach ($widget['widget_items'] as $widget_item) { ?>
																					<?php if ($value == $widget_item['widget_id']) { ?>
																					<option value="<?php echo $widget_item['widget_id']; ?>" selected="selected"><?php echo $widget_item['name']; ?></option>
																					<?php } else { ?>
																					<option value="<?php echo $widget_item['widget_id']; ?>"><?php echo $widget_item['name']; ?></option>
																					<?php } ?>
																				<?php } ?>
																			<?php } ?>
																		<?php } ?>
																		</select>
																		<a class="btn btn-danger remove" type="button"><i class="fas fa-minus-circle"></i></a>
																	</div>
																	<?php ${'layout_content_bottom_row_' . $layout['layout_id']} = ${'layout_content_bottom_row_' . $layout['layout_id']} + 1; ?>
													  			<?php } ?>
												  			<?php } ?>
												  			<a id="button-content-bottom-widget-add-<?php echo $layout['layout_id']; ?>" class="btn btn-primary" onclick="addWidget('<?php echo $layout['layout_id']; ?>', 'content-bottom');"><i class="fas fa-plus-circle"></i> <?php echo lang('Button.button_widget_add', array(), $lang->getBackEndLocale()); ?></a>
										  					<input type="hidden" value="<?php echo ${'layout_content_bottom_row_' . $layout['layout_id']}; ?>" id="layout-content-bottom-row-<?php echo $layout['layout_id']; ?>" />
												  		</div>
												  	</div>
										  		</div>
										  		<div class="col-sm-4">
												  	<div id="widget-layout-widget-end" class="card card-body mb-3">
												  		<h6 class="border-bottom pb-2 mb-3"><?php echo lang('Text.text_widget_end', array(), $lang->getBackEndLocale()); ?></h6>
										  				<?php ${'layout_widget_end_row_' . $layout['layout_id']} = 0; ?>
												  		<div id="widget-layout-<?php echo $layout['layout_id']; ?>-widget-end-items" class="d-grid">
												  			<?php if (!empty(${'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']}['widget_end'])) { ?>
													  			<?php foreach (${'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']}['widget_end'] as $key => $value) { ?>
																	<div class="input-group mb-3">
																		<select name="frontend_theme_openmvm_default_layout_widget_<?php echo $layout['layout_id']; ?>[widget_end][<?php echo ${'layout_widget_end_row_' . $layout['layout_id']}; ?>]" class="form-select" id="input-widget-layout-<?php echo $layout['layout_id']; ?>-widget-end-item-<?php echo ${'layout_widget_end_row_' . $layout['layout_id']}; ?>" aria-label="">
																		<?php foreach ($widgets as $widget) { ?>
																			<?php if ($widget['widget_items']) { ?>
																				<optgroup label="<?php echo $widget['name']; ?>">
																				<?php foreach ($widget['widget_items'] as $widget_item) { ?>
																					<?php if ($value == $widget_item['widget_id']) { ?>
																					<option value="<?php echo $widget_item['widget_id']; ?>" selected="selected"><?php echo $widget_item['name']; ?></option>
																					<?php } else { ?>
																					<option value="<?php echo $widget_item['widget_id']; ?>"><?php echo $widget_item['name']; ?></option>
																					<?php } ?>
																				<?php } ?>
																			<?php } ?>
																		<?php } ?>
																		</select>
																		<a class="btn btn-danger remove" type="button"><i class="fas fa-minus-circle"></i></a>
																	</div>
																	<?php ${'layout_widget_end_row_' . $layout['layout_id']} = ${'layout_widget_end_row_' . $layout['layout_id']} + 1; ?>
													  			<?php } ?>
												  			<?php } ?>
												  			<a id="button-widget-end-widget-add-<?php echo $layout['layout_id']; ?>" class="btn btn-primary" onclick="addWidget('<?php echo $layout['layout_id']; ?>', 'widget-end');"><i class="fas fa-plus-circle"></i> <?php echo lang('Button.button_widget_add', array(), $lang->getBackEndLocale()); ?></a>
										  					<input type="hidden" value="<?php echo ${'layout_widget_end_row_' . $layout['layout_id']}; ?>" id="layout-widget-end-row-<?php echo $layout['layout_id']; ?>" />
												  		</div>
												  	</div>
										  		</div>
										  	</div>
										  	<div id="widget-layout-page-bottom" class="card card-body mb-3">
										  		<h6 class="border-bottom pb-2 mb-3"><?php echo lang('Text.text_page_bottom', array(), $lang->getBackEndLocale()); ?></h6>
										  		<?php ${'layout_page_bottom_row_' . $layout['layout_id']} = 0; ?>
										  		<div id="widget-layout-<?php echo $layout['layout_id']; ?>-page-bottom-items" class="d-grid">
										  			<?php if (!empty(${'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']}['page_bottom'])) { ?>
											  			<?php foreach (${'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']}['page_bottom'] as $key => $value) { ?>
															<div class="input-group mb-3">
																<select name="frontend_theme_openmvm_default_layout_widget_<?php echo $layout['layout_id']; ?>[page_bottom][<?php echo ${'layout_page_bottom_row_' . $layout['layout_id']}; ?>]" class="form-select" id="input-widget-layout-<?php echo $layout['layout_id']; ?>-page-bottom-item-<?php echo ${'layout_page_bottom_row_' . $layout['layout_id']}; ?>" aria-label="">
																<?php foreach ($widgets as $widget) { ?>
																	<?php if ($widget['widget_items']) { ?>
																		<optgroup label="<?php echo $widget['name']; ?>">
																		<?php foreach ($widget['widget_items'] as $widget_item) { ?>
																			<?php if ($value == $widget_item['widget_id']) { ?>
																			<option value="<?php echo $widget_item['widget_id']; ?>" selected="selected"><?php echo $widget_item['name']; ?></option>
																			<?php } else { ?>
																			<option value="<?php echo $widget_item['widget_id']; ?>"><?php echo $widget_item['name']; ?></option>
																			<?php } ?>
																		<?php } ?>
																	<?php } ?>
																<?php } ?>
																</select>
																<a class="btn btn-danger remove" type="button"><i class="fas fa-minus-circle"></i></a>
															</div>
															<?php ${'layout_page_bottom_row_' . $layout['layout_id']} = ${'layout_page_bottom_row_' . $layout['layout_id']} + 1; ?>
											  			<?php } ?>
										  			<?php } ?>
										  			<a id="button-page-bottom-widget-add-<?php echo $layout['layout_id']; ?>" class="btn btn-primary" onclick="addWidget('<?php echo $layout['layout_id']; ?>', 'page-bottom');"><i class="fas fa-plus-circle"></i> <?php echo lang('Button.button_widget_add', array(), $lang->getBackEndLocale()); ?></a>
										  			<input type="hidden" value="<?php echo ${'layout_page_bottom_row_' . $layout['layout_id']}; ?>" id="layout-page-bottom-row-<?php echo $layout['layout_id']; ?>" />
										  		</div>
										  	</div>
										  </div>
											<?php } ?>
										</div>
						  		</div>
						  	</div>
						  </div>
						</div>
		      </div>
		    </div>
		  </div>
		</div>
    <?php echo form_close(); ?>
	</section>
  <!-- /.content -->
<script type="text/javascript"><!--
var element = document.querySelector('#layoutTab a:first-child');
var tab = bootstrap.Tab.getInstance(element);
if( !tab )
    tab = new bootstrap.Tab(element);
tab.show();
--></script>
<script type="text/javascript"><!--
function addWidget(layout_id, position) {
  var row = parseInt(document.getElementById('layout-' + position + '-row-' + layout_id).value, 10);
  row = isNaN(row) ? 0 : row;

  position_key = position.replace('-', '_');

	html = '<div class="input-group mb-3">';
	html += '<select name="frontend_theme_openmvm_default_layout_widget_' + layout_id + '[' + position_key + '][' + row + ']" class="form-select" id="input-widget-layout-' + layout_id + '-' + position + '-item-' + row + '" aria-label="">';
	<?php foreach ($widgets as $widget) { ?>
		<?php if ($widget['widget_items']) { ?>
			html += '<optgroup label="<?php echo $widget['name']; ?>">';
			<?php foreach ($widget['widget_items'] as $widget_item) { ?>
			html += '<option value="<?php echo $widget_item['widget_id']; ?>"><?php echo $widget_item['name']; ?></option>';
			<?php } ?>
		<?php } ?>
	<?php } ?>
	html += '</select>';
	html += '<a class="btn btn-danger remove" type="button"><i class="fas fa-minus-circle"></i></a>';
	html += '</div>';

	$('#button-' + position + '-widget-add-' + layout_id).before(html);

  row++;
  document.getElementById('layout-' + position + '-row-' + layout_id).value = row;

	remove();
}
--></script>
<script type="text/javascript"><!--
function remove() {
	$('.remove').on('click', function() {
		$(this).parent().remove();
	});
}
--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	remove();
});
--></script>
<?php echo $footer; ?>
