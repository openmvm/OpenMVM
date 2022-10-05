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
                <h3 class="card-title"><i class="fas fa-globe fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-geo-zone']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-geo-zone" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-geo-zone" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-name" class="form-label"><?php echo lang('Entry.name'); ?></label>
                        <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" placeholder="<?php echo lang('Entry.name'); ?>">
                        <?php if (!empty($error_name)) { ?><div class="text-danger small"><?php echo $error_name; ?></div><?php } ?>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-description" class="form-label"><?php echo lang('Entry.description'); ?></label>
                        <textarea rows="5" name="description" id="input-description" class="form-control" placeholder="<?php echo lang('Entry.description'); ?>"><?php echo $description; ?></textarea>
                    </div>
                </fieldset>
                <fieldset>
                    <legend><?php echo lang('Text.geo_zones'); ?></legend>
                    <div id="zone-to-geo-zones" class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col"><?php echo lang('Column.country'); ?></th>
                                    <th scope="col"><?php echo lang('Column.zone'); ?></th>
                                    <th scope="col" class="text-end"><?php echo lang('Column.action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $zone_to_geo_zone_row = 0; ?>
                            <?php foreach ($zone_to_geo_zones as $zone_to_geo_zone) { ?>
                                <tr id="zone-to-geo-zone-<?php echo $zone_to_geo_zone_row; ?>">
                                    <td>
                                        <select name="zone_to_geo_zone[<?php echo $zone_to_geo_zone_row; ?>][country_id]" class="form-control" id="input-zone-to-geo-zone-country-<?php echo $zone_to_geo_zone_row; ?>" data-index="<?php echo $zone_to_geo_zone_row; ?>" data-zone-id="<?php echo $zone_to_geo_zone['zone_id']; ?>" disabled="disabled">
                                            <?php foreach ($countries as $country) { ?>
                                                <?php if ($country['country_id'] == $zone_to_geo_zone['country_id']) { ?>
                                                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                                <?php } else { ?>
                                                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="zone_to_geo_zone[<?php echo $zone_to_geo_zone_row; ?>][zone_id]" class="form-control" id="input-zone-to-geo-zone-zone-<?php echo $zone_to_geo_zone_row; ?>" disabled="disabled"><option value="0"><?php echo lang('Text.all_zones'); ?></option></select>
                                    </td>
                                    <td class="text-end"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-minus-circle" onclick="$('#zone-to-geo-zone-<?php echo $zone_to_geo_zone_row; ?>').remove();"></i></button></td>
                                </tr>
                                <?php $zone_to_geo_zone_row++; ?>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td class="text-end"><button type="button" id="button-add" class="btn btn-primary"><i class="fas fa-plus-circle"></i> <?php echo lang('Button.add'); ?></button></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </fieldset>
           </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
var zone_to_geo_zone_row = '<?php echo $zone_to_geo_zone_row; ?>';

$( "#button-add" ).on( "click", function() {
    html = '<tr id="zone-to-geo-zone-' + zone_to_geo_zone_row + '">';
    html += '    <td>';
    html += '        <select name="zone_to_geo_zone[' + zone_to_geo_zone_row + '][country_id]" class="form-control" id="input-zone-to-geo-zone-country-' + zone_to_geo_zone_row + '" data-index="' + zone_to_geo_zone_row + '">';
    <?php foreach ($countries as $country) { ?>
    html += '            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>';
    <?php } ?>
    html += '        </select>';
    html += '    </td>';
    html += '    <td><select name="zone_to_geo_zone[' + zone_to_geo_zone_row + '][zone_id]" class="form-control" id="input-zone-to-geo-zone-zone-' + zone_to_geo_zone_row + '"><option value="0"><?php echo lang('Text.all_zones'); ?></option></select></td>';
    html += '    <td class="text-end"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-minus-circle" onclick="$(\'#zone-to-geo-zone-' + zone_to_geo_zone_row + '\').remove();"></i></button></td>';
    html += '</tr>';

    $('#zone-to-geo-zones table tbody').append(html);

    $('#input-zone-to-geo-zone-country-' + zone_to_geo_zone_row).trigger('change');

    zone_to_geo_zone_row++;
});

$('#zone-to-geo-zones').on('change', 'select[name$=\'[country_id]\']', function() {
	var element = this;
	
	if (element.value) { 
		$.ajax({
			url: '<?php echo $country_request; ?>&country_id=' + element.value,
			dataType: 'json',
			beforeSend: function() {
				$(element).prop('disabled', true);
				//$('button[form=\'form-geo-zone\']').prop('disabled', true);
			},
			complete: function() {
				$(element).prop('disabled', false);
				//$('button[form=\'form-geo-zone\']').prop('disabled', false);
			},
			success: function(json) {
				html = '<option value="0"><?php echo lang('Text.all_zones'); ?></option>';
				
				if (json['zones'] && json['zones'] != '') {	
					for (i = 0; i < json['zones'].length; i++) {
                        zone = json['zones'][i];

                        html += '<option value="' + zone['zone_id'] + '"';

                        if (zone['zone_id'] == $(element).attr('data-zone-id')) {
                            html += ' selected="selected"';
                        }

                        html += '>' + zone['name'] + '</option>';
					}
				}
	
				$('select[name=\'zone_to_geo_zone[' + $(element).attr('data-index') + '][zone_id]\']').html(html);
				
				$('select[name=\'zone_to_geo_zone[' + $(element).attr('data-index') + '][zone_id]\']').prop('disabled', false);
				
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
