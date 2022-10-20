<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-shipping-method']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo lang('Heading.edit', [], $language_lib->getCurrentCode()); ?></h5> <div class="float-end"><button type="submit" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.save', [], $language_lib->getCurrentCode()); ?>"><i class="fas fa-save fa-fw"></i></button> <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.cancel', [], $language_lib->getCurrentCode()); ?>"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3">
                        <label for="input-status" class="form-label"><?php echo lang('Entry.status', [], $language_lib->getCurrentCode()); ?></label>
                        <select name="status" id="input-status" class="form-select">
                            <?php if ($status) { ?>
                            <option value="0"><?php echo lang('Text.disabled', [], $language_lib->getCurrentCode()); ?></option>
                            <option value="1" selected="selected"><?php echo lang('Text.enabled', [], $language_lib->getCurrentCode()); ?></option>
                            <?php } else { ?>
                            <option value="0" selected="selected"><?php echo lang('Text.disabled', [], $language_lib->getCurrentCode()); ?></option>
                            <option value="1"><?php echo lang('Text.enabled', [], $language_lib->getCurrentCode()); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.rates', [], $language_lib->getCurrentCode()); ?></legend>
                    <div id="rates" class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?php echo lang('Column.country', [], $language_lib->getCurrentCode()); ?></th>
                                    <th><?php echo lang('Column.zone', [], $language_lib->getCurrentCode()); ?></th>
                                    <th><?php echo lang('Column.rate', [], $language_lib->getCurrentCode()); ?></th>
                                    <th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $rate_row = 0; ?>
                                <?php foreach ($rates as $rate) { ?>
                                <tr id="rate-<?php echo $rate_row; ?>">
                                    <td>
                                        <select name="rate[<?php echo $rate_row; ?>][country_id]" class="form-select" id="input-rate-country-<?php echo $rate_row; ?>" data-index="<?php echo $rate_row; ?>" data-zone-id="<?php echo $rate['zone_id']; ?>" disabled="disabled">
                                            <?php foreach ($countries as $country) { ?>
                                                <?php if ($country['country_id'] == $rate['country_id']) { ?>
                                                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                                <?php } else { ?>
                                                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="rate[<?php echo $rate_row; ?>][zone_id]" class="form-select" id="input-rate-zone-<?php echo $rate_row; ?>" disabled="disabled"><option value="0"><?php echo lang('Text.all_zones', [], $language_lib->getCurrentCode()); ?></option></select>
                                    </td>
                                    <td><input type="number" step="any" min="0" name="rate[<?php echo $rate_row; ?>][rate]" value="<?php echo $rate['rate']; ?>" id="input-rate-rate-<?php echo $rate_row; ?>" class="form-control" /></td>
                                    <td class="text-end"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-minus-circle fa-fw" onclick="$('#rate-<?php echo $rate_row; ?>').remove();"></i></button></td>
                                </tr>
                                <?php $rate_row++; ?>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-end"><button type="button" id="button-add-rate" class="btn btn-primary btn-sm"><i class="fas fa-plus fa-fw"></i></button></td>
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
var rate_row = '<?php echo $rate_row; ?>';

$( "#button-add-rate" ).on( "click", function() {
    html = '<tr id="rate-' + rate_row + '">';
    html += '    <td>';
    html += '        <select name="rate[' + rate_row + '][country_id]" class="form-select" id="input-rate-country-' + rate_row + '" data-index="' + rate_row + '">';
    <?php foreach ($countries as $country) { ?>
    html += '            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>';
    <?php } ?>
    html += '        </select>';
    html += '    </td>';
    html += '    <td><select name="rate[' + rate_row + '][zone_id]" class="form-select" id="input-rate-zone-' + rate_row + '"><option value="0"><?php echo lang('Text.all_zones', [], $language_lib->getCurrentCode()); ?></option></select></td>';
    html += '    <td><input type="number" step="any" min="0" name="rate[' + rate_row + '][rate]" value="" id="input-rate-rate-' + rate_row + '" class="form-control" /></td>';
    html += '    <td class="text-end"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-minus-circle fa-fw" onclick="$(\'#rate-' + rate_row + '\').remove();"></i></button></td>';
    html += '</tr>';

    $('#rates table tbody').append(html);

    $('#input-rate-country-' + rate_row).trigger('change');

    rate_row++;
});

$('#rates').on('change', 'select[name$=\'[country_id]\']', function() {
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
                html = '<option value="0"><?php echo lang('Text.all_zones', [], $language_lib->getCurrentCode()); ?></option>';
                
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
    
                $('select[name=\'rate[' + $(element).attr('data-index') + '][zone_id]\']').html(html);
                
                $('select[name=\'rate[' + $(element).attr('data-index') + '][zone_id]\']').prop('disabled', false);
                
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
