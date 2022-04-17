<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-shipping-method']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo lang('Heading.edit'); ?></h5> <div class="float-end"><button type="submit" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.save'); ?>"><i class="fas fa-save fa-fw"></i></button> <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.cancel'); ?>"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3">
                        <label for="input-status" class="form-label"><?php echo lang('Entry.status'); ?></label>
                        <select name="status" id="input-status" class="form-control">
                            <?php if ($status) { ?>
                            <option value="0"><?php echo lang('Text.disabled'); ?></option>
                            <option value="1" selected="selected"><?php echo lang('Text.enabled'); ?></option>
                            <?php } else { ?>
                            <option value="0" selected="selected"><?php echo lang('Text.disabled'); ?></option>
                            <option value="1"><?php echo lang('Text.enabled'); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.rates'); ?></legend>
                    <div id="rates" class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills me-3 w-25" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <?php $rate_row = 1; ?>
                            <?php foreach ($rates as $rate) { ?>
                            <button class="nav-link mb-2" id="v-pills-<?php echo $rate_row; ?>-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?php echo $rate_row; ?>" type="button" role="tab" aria-controls="v-pills-<?php echo $rate_row; ?>" aria-selected="false"><?php echo lang('Tab.rate'); ?> <?php echo $rate_row; ?></button>
                            <?php $rate_row++; ?>
                            <?php } ?>
                            <button class="btn btn-secondary" id="button-add-rate" type="button"><i class="fas fa-plus-circle fa-fw"></i>&nbsp;<?php echo lang('Button.add'); ?>&nbsp;<?php echo lang('Button.rate'); ?></button>
                        </div>
                        <div class="tab-content w-100" id="v-pills-tabContent">
                            <?php $rate_row = 1; ?>
                            <?php $weight_row = 1; ?>
                            <?php foreach ($rates as $rate) { ?>
                            <div class="tab-pane fade" id="v-pills-<?php echo $rate_row; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $rate_row; ?>-tab">
                                <h5 class="border-bottom pb-3 mb-3"><?php echo lang('Tab.rate'); ?> <?php echo $rate_row; ?></h5>
                                <fieldset>
                                <div class="mb-3 required">
                                    <label for="input-rate-country-<?php echo $rate_row; ?>" class="form-label"><?php echo lang('Entry.country'); ?></label>
                                    <select name="rate[<?php echo $rate_row; ?>][country_id]" class="form-control" id="input-rate-country-<?php echo $rate_row; ?>" data-index="<?php echo $rate_row; ?>" data-zone-id="<?php echo $rate['zone_id']; ?>" disabled="disabled">
                                        <?php foreach ($countries as $country) { ?>
                                            <?php if ($country['country_id'] == $rate['country_id']) { ?>
                                            <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="input-rate-zone-<?php echo $rate_row; ?>" class="form-label"><?php echo lang('Entry.zone'); ?></label>
                                    <select name="rate[<?php echo $rate_row; ?>][zone_id]" class="form-control" id="input-rate-zone-<?php echo $rate_row; ?>"><option value="0"><?php echo lang('Text.all_zones'); ?></option></select>
                                </div>
                                <legend class="lead border-bottom pb-2"><?php echo lang('Text.rates'); ?></legend>
                                <div id="weights-<?php echo $rate_row; ?>" class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('Column.weight'); ?></th>
                                                <th><?php echo lang('Column.rate'); ?></th>
                                                <th class="text-end"><?php echo lang('Column.action'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($rate['weight']) { ?>
                                                <?php foreach ($rate['weight'] as $weight) { ?>
                                                <tr id="weight-<?php echo $rate_row; ?>-<?php echo $weight_row; ?>">
                                                    <td><input type="number" step="any" min="0" name="rate[<?php echo $rate_row; ?>][weight][<?php echo $weight_row; ?>][weight]" value="<?php echo $weight['weight']; ?>" id="input-weight-weigth<?php echo $rate_row; ?>-<?php echo $weight_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.weight'); ?>" /></td>
                                                    <td><input type="number" step="any" min="0" name="rate[<?php echo $rate_row; ?>][weight][<?php echo $weight_row; ?>][rate]" value="<?php echo $weight['rate']; ?>" id="input-weight-rate<?php echo $rate_row; ?>-<?php echo $weight_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.rate'); ?>" /></td>
                                                    <td class="text-end"><button type="button" class="btn btn-danger btn-sm" onclick="$('#weight-<?php echo $rate_row; ?>-<?php echo $weight_row; ?>').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>
                                                </tr>
                                                <?php $weight_row++; ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td class="text-end"><button type="button" id="button-add-weight-<?php echo $rate_row; ?>" data-weight-row="<?php echo $weight_row; ?>" class="btn btn-primary btn-sm" onclick="addWeight(<?php echo $rate_row; ?>);"><i class="fas fa-plus fa-fw"><i></button></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                </fieldset>
                            </div>
                            <?php $rate_row++; ?>
                            <?php } ?>
                        </div>
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
    html = '<div class="tab-pane fade" id="v-pills-' + rate_row + '" role="tabpanel" aria-labelledby="v-pills-' + rate_row + '-tab">';
    html += '    <h5 class="border-bottom pb-3 mb-3"><?php echo lang('Tab.rate'); ?> ' + rate_row + '</h5>';
    html += '    <fieldset>';
    html += '    <div class="mb-3 required">';
    html += '        <label for="input-rate-country-' + rate_row + '" class="form-label"><?php echo lang('Entry.country'); ?></label>';
    html += '        <select name="rate[' + rate_row + '][country_id]" class="form-control" id="input-rate-country-' + rate_row + '" data-index="' + rate_row + '">';
    <?php foreach ($countries as $country) { ?>
    html += '            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>';
    <?php } ?>
    html += '        </select>';
    html += '    </div>';
    html += '    <div class="mb-3">';
    html += '        <label for="input-rate-zone-' + rate_row + '" class="form-label"><?php echo lang('Entry.zone'); ?></label>';
    html += '        <select name="rate[' + rate_row + '][zone_id]" class="form-control" id="input-rate-zone-' + rate_row + '"><option value="0"><?php echo lang('Text.all_zones'); ?></option></select>';
    html += '    </div>';
    html += '    <legend class="lead border-bottom pb-2"><?php echo lang('Text.rates'); ?></legend>';
    html += '    <div id="weights-' + rate_row + '" class="table-responsive">';
    html += '        <table class="table">';
    html += '            <thead>';
    html += '                <tr>';
    html += '                    <th><?php echo lang('Column.weight'); ?></th>';
    html += '                    <th><?php echo lang('Column.rate'); ?></th>';
    html += '                    <th class="text-end"><?php echo lang('Column.action'); ?></th>';
    html += '                </tr>';
    html += '            </thead>';
    html += '            <tbody>';
    html += '            </tbody>';
    html += '            <tfoot>';
    html += '                <tr>';
    html += '                    <td colspan="2"></td>';
    html += '                    <td class="text-end"><button type="button" id="button-add-weight-' + rate_row + '" class="btn btn-primary btn-sm" onclick="addWeight(' + rate_row + ');"><i class="fas fa-plus fa-fw"><i></button></td>';
    html += '                </tr>';
    html += '            </tfoot>';
    html += '        </table>';
    html += '    </div>';
    html += '    </fieldset>';
    html += '</div>';

    $('#rates #v-pills-tabContent').append(html);

    $('#rates #v-pills-tab').find('#button-add-rate').before('<button class="nav-link mb-2" id="v-pills-' + rate_row + '-tab" data-bs-toggle="pill" data-bs-target="#v-pills-' + rate_row + '" type="button" role="tab" aria-controls="v-pills-' + rate_row + '" aria-selected="false"><i class="fas fa-minus-circle fa-fw" onclick="$(\'#v-pills-' + rate_row + '-tab\').remove(); $(\'#v-pills-' + rate_row + '\').remove(); var triggerFirstTabEl = document.querySelector(\'#rates #v-pills-tab button:first-child\'); new bootstrap.Tab(triggerFirstTabEl).show();"></i> <?php echo lang('Tab.rate'); ?> ' + rate_row + '</button>');

    var triggerFirstTabEl = document.querySelector('#rates #v-pills-' + rate_row + '-tab');
    new bootstrap.Tab(triggerFirstTabEl).show();

    $('#input-rate-country-' + rate_row).trigger('change');

    //addWeight(rate_row, weight_row);

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
<script type="text/javascript"><!--
var weight_row = '<?php echo $weight_row; ?>';

function addWeight(rate_row) {
    html = '<tr id="weight-' + rate_row + '-' + weight_row + '">';
    html += '    <td><input type="number" step="any" min="0" name="rate[' + rate_row + '][weight][' + weight_row + '][weight]" id="input-weight-weigth' + rate_row + '-' + weight_row + '" class="form-control" placeholder="<?php echo lang('Entry.weight'); ?>" /></td>';
    html += '    <td><input type="number" step="any" min="0" name="rate[' + rate_row + '][weight][' + weight_row + '][rate]" id="input-weight-rate' + rate_row + '-' + weight_row + '" class="form-control" placeholder="<?php echo lang('Entry.rate'); ?>" /></td>';
    html += '    <td class="text-end"><button type="button" class="btn btn-danger btn-sm" onclick="$(\'#weight-' + rate_row + '-' + weight_row + '\').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>';
    html += '</tr>';

    $('#weights-' + rate_row + ' table tbody').append(html);

    weight_row++;
};
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
    var triggerFirstTabEl = document.querySelector('#rates #v-pills-tab button:first-child')
    new bootstrap.Tab(triggerFirstTabEl).show()
});
//--></script>
<?php echo $footer; ?>
