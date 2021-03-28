<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-atlas fa-fw"></i> <?php echo $heading_title; ?></h2>
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
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/localisation/geo_zones/' . $administrator_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
	    </div>
    </div>
		<div class="accordion" id="accordionAdministratorGroup">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingAdministratorGroup">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdministratorGroup" aria-expanded="true" aria-controls="collapseAdministratorGroup">
		        <i class="fas fa-atlas fa-fw"></i>&nbsp;&nbsp;<?php echo $heading_title; ?>
		      </button>
		    </h2>
		    <div id="collapseAdministratorGroup" class="accordion-collapse collapse show" aria-labelledby="headingAdministratorGroup" data-bs-parent="#accordionAdministratorGroup">
		      <div class="accordion-body">

		        <ul class="nav nav-tabs" id="geoZoneTab" role="tablist">
		          <li class="nav-item">
		            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.tab_general', array(), $lang->getBackEndLocale()); ?></a>
		          </li>
		        </ul>
		        <div class="tab-content mt-3" id="geoZoneTabContent">
		          <div class="tab-pane show active" id="general" role="tabpanel" aria-labelledby="general-tab">
		            <fieldset>
						  		<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_description', array(), $lang->getBackEndLocale()); ?></h5>
						  		<?php foreach ($languages as $language) { ?>
							  	<div class="form-floating mb-3">
									  <input type="text" name="description[<?php echo $language['language_id']; ?>][name]" value="<?php echo $description[$language['language_id']]['name']; ?>" class="form-control<?php if ($validation->hasError('description.' . $language['language_id'] . '.name')) { ?> is-invalid<?php } ?>" id="input-value" placeholder="<?php echo lang('Entry.entry_name', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-value"><img src="<?php echo base_url('assets/flags/' . $language['image']); ?>" /> <?php echo lang('Entry.entry_name', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('description.' . $language['language_id'] . '.name')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('description.' . $language['language_id'] . '.name'); ?></div>
	                	<?php } ?>
									</div>
						  		<?php } ?>
						  		<hr />
						  		<?php foreach ($languages as $language) { ?>
							  	<div class="form-floating mb-3">
									  <input type="text" name="description[<?php echo $language['language_id']; ?>][description]" value="<?php echo $description[$language['language_id']]['description']; ?>" class="form-control<?php if ($validation->hasError('description.' . $language['language_id'] . '.description')) { ?> is-invalid<?php } ?>" id="input-value" placeholder="<?php echo lang('Entry.entry_description', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-value"><img src="<?php echo base_url('assets/flags/' . $language['image']); ?>" /> <?php echo lang('Entry.entry_description', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('description.' . $language['language_id'] . '.description')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('description.' . $language['language_id'] . '.description'); ?></div>
	                	<?php } ?>
									</div>
						  		<?php } ?>
						  		<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_geo_zones', array(), $lang->getBackEndLocale()); ?></h5>
									<table id="state-to-geo-zone" class="table table-hover">
									  <thead>
									    <tr>
									      <th scope="col"><?php echo lang('Column.column_country', array(), $lang->getBackEndLocale()); ?></th>
									      <th scope="col"><?php echo lang('Column.column_state', array(), $lang->getBackEndLocale()); ?></th>
									      <th scope="col" class="text-end"><?php echo lang('Column.column_action', array(), $lang->getBackEndLocale()); ?></th>
									    </tr>
									  </thead>
									  <tbody>
									  	<?php $state_to_geo_zone_row = 0; ?>
									  	<?php foreach ($state_to_geo_zones as $state_to_geo_zone) { ?>
									    <tr id="state-to-geo-zone-row<?php echo $state_to_geo_zone_row; ?>">
									      <td>
													<div class="form-floating mb-3">
													  <select name="state_to_geo_zone[<?php echo $state_to_geo_zone_row; ?>][country_id]" class="form-select" id="input-state-to-geo-zone-country-id-<?php echo $state_to_geo_zone_row; ?>" aria-label="input-state-to-geo-zone-country-id-<?php echo $state_to_geo_zone_row; ?>" data-index="<?php echo $state_to_geo_zone_row; ?>" data-state-id="<?php echo $state_to_geo_zone['state_id']; ?>" disabled="disabled">
	                            <?php foreach ($countries as $country) { ?>
	                              <?php if ($country['country_id'] == $state_to_geo_zone['country_id']) { ?>
	                                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
	                              <?php } else { ?>
	                                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
	                              <?php } ?>
	                            <?php } ?>
													  </select>
													  <label for="input-state-to-geo-zone-country-id-<?php echo $state_to_geo_zone_row; ?>"><?php echo lang('Entry.entry_country', array(), $lang->getBackEndLocale()); ?></label>
													</div>
									      </td>
									      <td>
													<div class="form-floating mb-3">
													  <select name="state_to_geo_zone[<?php echo $state_to_geo_zone_row; ?>][state_id]" class="form-select" id="input-state-to-geo-zone-state-id-<?php echo $state_to_geo_zone_row; ?>" aria-label="input-state-to-geo-zone-id-<?php echo $state_to_geo_zone_row; ?>" disabled="disabled">
													  </select>
													  <label for="input-state-to-geo-zone-state-id-<?php echo $state_to_geo_zone_row; ?>"><?php echo lang('Entry.entry_state', array(), $lang->getBackEndLocale()); ?></label>
													</div>
									      </td>
									      <td class="text-end"><button type="button" onclick="$('#state-to-geo-zone-row<?php echo $state_to_geo_zone_row; ?>').remove();" data-toggle="tooltip" title="<?php echo lang('Button.button_remove', array(), $lang->getBackEndLocale()); ?>" class="btn btn-danger"><i class="fas fa-minus-circle"></i></button></td>
									    </tr>
									    <?php $state_to_geo_zone_row = $state_to_geo_zone_row + 1 ?>
									  	<?php } ?>
									  </tbody>
									  <tfoot>
									    <tr>
									      <td colspan="2"></td>
									      <td class="text-end"><button type="button" id="button-geo-zone" data-bs-toggle="tooltip" title="<?php echo lang('Button.button_add', array(), $lang->getBackEndLocale()); ?>" class="btn btn-primary"><i class="fas fa-plus-circle"></i></button></td>
									    </tr>
									  </tfoot>
									</table>
		            </fieldset>
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
var state_to_geo_zone_row = <?php echo $state_to_geo_zone_row; ?>;

$('#button-geo-zone').on('click', function() {
	html  = '<tr id="state-to-geo-zone-row' + state_to_geo_zone_row + '">';
	html += '  <td>';
	html += '    <div class="form-floating mb-3">';
	html += '      <select name="state_to_geo_zone[' + state_to_geo_zone_row + '][country_id]" class="form-select" id="input-state-to-geo-zone-country-id-' + state_to_geo_zone_row + '" aria-label="input-state-to-geo-zone-country-id-' + state_to_geo_zone_row + '" data-index="' + state_to_geo_zone_row + '">';
	<?php foreach ($countries as $country) { ?>
	html += '        <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>';
	<?php } ?>
	html += '      </select>';
	html += '      <label for="input-state-to-geo-zone-country-id-' + state_to_geo_zone_row + '"><?php echo lang('Entry.entry_country', array(), $lang->getBackEndLocale()); ?></label>';
	html += '    </div>';
	html += '  </td>';
	html += '  <td>';
	html += '    <div class="form-floating mb-3">';
	html += '      <select name="state_to_geo_zone[' + state_to_geo_zone_row + '][state_id]" class="form-select" id="input-state-to-geo-zone-state-id-' + state_to_geo_zone_row + '" aria-label="input-state-to-geo-zone-id-' + state_to_geo_zone_row + '">';
	html += '      </select>';
	html += '      <label for="input-state-to-geo-zone-state-id-' + state_to_geo_zone_row + '"><?php echo lang('Entry.entry_state', array(), $lang->getBackEndLocale()); ?></label>';
	html += '    </div>';
	html += '  </td>';
	html += '  <td class="text-end"><button type="button" onclick="$(\'#state-to-geo-zone-row' + state_to_geo_zone_row + '\').remove();" data-bs-toggle="tooltip" title="<?php echo lang('Button.button_remove', array(), $lang->getBackEndLocale()); ?>" class="btn btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
	html += '</tr>';
	
	$('#state-to-geo-zone tbody').append(html);
	
	$('select[name=\'state_to_geo_zone[' + state_to_geo_zone_row + '][country_id]\']').trigger('change');
			
	state_to_geo_zone_row++;
});

$('#state-to-geo-zone').on('change', 'select[name$=\'[country_id]\']', function() {
	var element = this;
	
	if (element.value) { 
		$.ajax({
			url: '<?php echo base_url($_SERVER['app.adminDir'] . '/localisation/countries/get_country/' . $administrator_token); ?>',
      type: 'post',
			dataType: 'json',
      data : {
        country_id : element.value
      },
			beforeSend: function() {
				$(element).prop('disabled', true);
			},
			complete: function() {
				$(element).prop('disabled', false);
			},
			success: function(json) {
				html = '<option value="0"><?php echo lang('Text.text_all_states', array(), $lang->getBackEndLocale()); ?></option>';
				
				if (json['states'] && json['states'] != '') {	
					for (i = 0; i < json['states'].length; i++) {
						html += '<option value="' + json['states'][i]['state_id'] + '"';
	
						if (json['states'][i]['state_id'] == $(element).attr('data-state-id')) {
							html += ' selected="selected"';
						}
	
						html += '>' + json['states'][i]['name'] + '</option>';
					}
				}
	
				$('select[name=\'state_to_geo_zone[' + $(element).attr('data-index') + '][state_id]\']').html(html);
				
				$('select[name=\'state_to_geo_zone[' + $(element).attr('data-index') + '][state_id]\']').prop('disabled', false);
				
				$('select[name$=\'[country_id]\']:disabled:first').trigger('change');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});

$('select[name$=\'[country_id]\']:disabled:first').trigger('change');
//--></script>
<?php echo $footer; ?>
