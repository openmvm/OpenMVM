<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-address']); ?>
        <fieldset>
            <div class="mb-3 required">
                <label for="input-firstname" class="form-label"><?php echo lang('Entry.firstname'); ?></label>
                <input type="text" name="firstname" value="<?php echo $firstname; ?>" id="input-firstname" class="form-control" placeholder="<?php echo lang('Entry.firstname'); ?>">
                <?php if (!empty($error_firstname)) { ?><div class="text-danger small"><?php echo $error_firstname; ?></div><?php } ?>
            </div>
            <div class="mb-3 required">
                <label for="input-lastname" class="form-label"><?php echo lang('Entry.lastname'); ?></label>
                <input type="text" name="lastname" value="<?php echo $lastname; ?>" id="input-lastname" class="form-control" placeholder="<?php echo lang('Entry.lastname'); ?>">
                <?php if (!empty($error_lastname)) { ?><div class="text-danger small"><?php echo $error_lastname; ?></div><?php } ?>
            </div>
            <div class="mb-3 required">
                <label for="input-address-1" class="form-label"><?php echo lang('Entry.address_1'); ?></label>
                <textarea rows="5" name="address_1" id="input-address-1" class="form-control" placeholder="<?php echo lang('Entry.address_1'); ?>"><?php echo $address_1; ?></textarea>
                <?php if (!empty($error_address_1)) { ?><div class="text-danger small"><?php echo $error_address_1; ?></div><?php } ?>
            </div>
            <div class="mb-3">
                <label for="input-address-2" class="form-label"><?php echo lang('Entry.address_2'); ?></label>
                <textarea rows="5" name="address_2" id="input-address-2" class="form-control" placeholder="<?php echo lang('Entry.address_2'); ?>"><?php echo $address_2; ?></textarea>
            </div>
            <div class="mb-3 required">
                <label for="input-city" class="form-label"><?php echo lang('Entry.city'); ?></label>
                <input type="text" name="city" value="<?php echo $city; ?>" id="input-city" class="form-control" placeholder="<?php echo lang('Entry.city'); ?>">
                <?php if (!empty($error_city)) { ?><div class="text-danger small"><?php echo $error_city; ?></div><?php } ?>
            </div>
            <div class="mb-3 required">
                <label for="input-country" class="form-label"><?php echo lang('Entry.country'); ?></label>
                <select name="country_id" id="input-country" class="form-control">
                    <option value=""><?php echo lang('Text.please_select'); ?></option>
                    <?php foreach ($countries as $country) { ?>
                        <?php if ($country['country_id'] == $country_id) { ?>
                        <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if (!empty($error_country)) { ?><div class="text-danger small"><?php echo $error_country; ?></div><?php } ?>
            </div>
            <div class="mb-3 required">
                <label for="input-zone" class="form-label"><?php echo lang('Entry.zone'); ?></label>
                <select name="zone_id" id="input-zone" class="form-control"></select>
                <?php if (!empty($error_zone)) { ?><div class="text-danger small"><?php echo $error_zone; ?></div><?php } ?>
            </div>
            <div class="mb-3 required">
                <label for="input-telephone" class="form-label"><?php echo lang('Entry.telephone'); ?></label>
                <input type="text" name="telephone" value="<?php echo $telephone; ?>" id="input-telephone" class="form-control" placeholder="<?php echo lang('Entry.telephone'); ?>">
                <?php if (!empty($error_telephone)) { ?><div class="text-danger small"><?php echo $error_telephone; ?></div><?php } ?>
            </div>
        </fieldset>
        <div class="buttons clearfix">
            <div class="float-end">
                <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-address" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                <button type="button" class="btn btn-sm btn-success button-action" data-form="form-address" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
$('select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: '<?php echo base_url(); ?>' + '/marketplace/localisation/country/get_country?country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').prop('disabled', true);
		},
		complete: function() {
			$('select[name=\'country_id\']').prop('disabled', false);
		},
		success: function(json) {
			html = '<option value=""><?php echo lang('Text.please_select'); ?></option>';
			
			if (json['zones'] && json['zones'] != '') {
				for (i = 0; i < json['zones'].length; i++) {
                    zone = json['zones'][i];

					html += '<option value="' + zone['zone_id'] + '"';
					
					if (zone['zone_id'] == '<?php echo $zone_id; ?>') {
						html += ' selected="selected"';
					}
					
					html += '>' + zone['name'] + '</option>';
				}
			} else {
				html += '<option value="" selected="selected"><?php echo lang('Text.none'); ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script> 
<?php echo $footer; ?>
