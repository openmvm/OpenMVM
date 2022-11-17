<?php if (!empty($product_variants[0]['variant'])) { ?>
<div class="card">
	<div class="card-body">
		<legend class="border-bottom pb-2 mb-3 clearfix">
			<span class="d-inline-block"><?php echo lang('Text.product_variant_specials', [], $language_lib->getCurrentCode()); ?></span>
            <span id="input-is-product-variant-special-container" class="d-inline-block float-end fs-6 mb-3">
                <div class="form-check form-switch">
                    <input name="is_product_variant_special" class="form-check-input" type="checkbox" role="switch" id="input-is-product-variant-special"<?php if (!empty($is_product_variant_special)) { ?> checked<?php } ?>>
                    <label class="form-check-label" for="input-is-product-variant-special"><?php echo lang('Entry.product_variant_specials', [], $language_lib->getCurrentCode()); ?></label>
                </div>
            </span>
		</legend>
		<div id="product-variant-special-list" class="table-responsive<?php if (empty($is_product_variant_special)) { ?> d-none<?php } ?>">
			<table class="table table-sm small">
				<thead>
					<tr>
						<th>#</th>
						<th class="text-nowrap"><?php echo lang('Column.product_variant', [], $language_lib->getCurrentCode()); ?></th>
						<th class="text-center"><?php echo lang('Column.specials', [], $language_lib->getCurrentCode()); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $product_variant_special_row = 0; ?>
					<?php foreach ($product_variants as $key => $value) { ?>
					<tr>
						<td class="align-top"><?php echo $value['key'] + 1; ?></td>
						<td class="align-top">
							<?php foreach ($value['variant'] as $variant) { ?>
							<div><small><?php echo $variant['option']; ?>: <strong><?php echo $variant['option_value']; ?></strong></small></div>
							<input type="hidden" name="product_variant_special[<?php echo $key; ?>][option][<?php echo $variant['option_id']; ?>]" value="<?php echo $variant['option_value_id']; ?>" />
							<?php } ?>
						</td>
						<td>
							<div id="product-variant-special-<?php echo $value['key']; ?>" class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th><?php echo lang('Column.priority', [], $language_lib->getCurrentCode()); ?></th>
											<th><?php echo lang('Column.price', [], $language_lib->getCurrentCode()); ?></th>
											<th><?php echo lang('Column.date_start', [], $language_lib->getCurrentCode()); ?></th>
											<th><?php echo lang('Column.date_end', [], $language_lib->getCurrentCode()); ?></th>
											<th><?php echo lang('Column.timezone', [], $language_lib->getCurrentCode()); ?></th>
											<th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php if ($value['product_variant_specials']) { ?>
											<?php foreach ($value['product_variant_specials'] as $product_variant_special) { ?>
											<tr id="product-variant-special-<?php echo $key; ?>-<?php echo $product_variant_special_row; ?>">
											 	<td><input size="4" type="number" name="product_variant_special[<?php echo $key; ?>][special][<?php echo $product_variant_special_row; ?>][priority]" value="<?php echo $product_variant_special['priority']; ?>" id="input-product-variant-special-<?php echo $key; ?>-<?php echo $product_variant_special_row; ?>-priority" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.priority', [], $language_lib->getCurrentCode()); ?>" /></td>
											 	<td>
												 	<div class="input-group input-group-sm">
												 	 	<?php if (!empty($default_currency['symbol_left'])) { ?><span class="input-group-text"><?php echo $default_currency['code']; ?> <?php echo $default_currency['symbol_left']; ?></span><?php } ?>
											 	 	 	<input type="number" min="0" name="product_variant_special[<?php echo $key; ?>][special][<?php echo $product_variant_special_row; ?>][price]" value="<?php echo $product_variant_special['price']; ?>" id="input-product-variant-special-<?php echo $key; ?>-<?php echo $product_variant_special_row; ?>-price" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.price', [], $language_lib->getCurrentCode()); ?>" />
													 	<?php if (!empty($default_currency['symbol_right'])) { ?><span class="input-group-text"><?php echo $default_currency['symbol_right']; ?> <?php echo $default_currency['code']; ?></span><?php } ?>
												 	</div>
											 	</td>
											 	<td><input type="datetime-local" name="product_variant_special[<?php echo $key; ?>][special][<?php echo $product_variant_special_row; ?>][date_start]" value="<?php echo $product_variant_special['date_start']; ?>" id="input-product-variant-special-<?php echo $key; ?>-<?php echo $product_variant_special_row; ?>-date-start" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.date_start', [], $language_lib->getCurrentCode()); ?>" /></td>
											 	<td><input type="datetime-local" name="product_variant_special[<?php echo $key; ?>][special][<?php echo $product_variant_special_row; ?>][date_end]" value="<?php echo $product_variant_special['date_end']; ?>" id="input-product-variant-special-<?php echo $key; ?>-<?php echo $product_variant_special_row; ?>-date-end" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.date_end', [], $language_lib->getCurrentCode()); ?>" /></td>
											 	<td>
												 	<select name="product_variant_special[<?php echo $key; ?>][special][<?php echo $product_variant_special_row; ?>][timezone]" id="input-product-variant-special-<?php echo $key; ?>-<?php echo $product_variant_special_row; ?>-timezone" class="form-select form-select-sm">
														<?php foreach ($timezones as $timezone) { ?>
															<?php if ($product_variant_special['timezone'] == $timezone['timezone']) { ?>
													 		<option value="<?php echo $timezone['timezone']; ?>" selected><?php echo $timezone['timezone']; ?> (UTC<?php echo $timezone['offset']; ?>)</option>
															<?php } else { ?>
														 	<option value="<?php echo $timezone['timezone']; ?>"><?php echo $timezone['timezone']; ?> (UTC<?php echo $timezone['offset']; ?>)</option>
															<?php } ?>
														<?php } ?>
												 	</select>
											 	</td>
											 	<td class="text-end align-middle"><button type="button" class="btn btn-danger btn-sm" onclick="removeProductVariantSpecial('<?php echo $key; ?>','<?php echo $product_variant_special_row; ?>');"><i class="fas fa-trash-alt fa-fw"></i></button></td>
											</tr>
											<?php $product_variant_special_row++; ?>
											<?php } ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6" class="text-end align-middle"><button type="button" id="button-add-product-variant-special-<?php echo $value['key']; ?>" class="btn btn-primary btn-sm" onclick="addProductVariantSpecial('<?php echo $value['key']; ?>');"><i class="fas fa-circle-plus fa-fw"></i></button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$('input#input-is-product-variant-special').click(function() {
    if ($('input#input-is-product-variant-special').is(':checked')) {
        $('#product-variant-special-list').removeClass('d-none');
    } else {
        $('#product-variant-special-list').addClass('d-none');
    }
});
//--></script>
<script type="text/javascript"><!--
var product_variant_special_row = '<?php echo $product_variant_special_row; ?>';

function addProductVariantSpecial(key) {
	//let key = key + 1;
	var default_price = $('#input-product-variant-price-' + key).val();

	html = '<tr id="product-variant-special-' + key + '-' + product_variant_special_row + '">';
	html += '	 <td><input size="4" type="number" name="product_variant_special[' + key + '][special][' + product_variant_special_row + '][priority]" value="1" id="input-product-variant-special-' + key + '-' + product_variant_special_row + '-priority" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.priority', [], $language_lib->getCurrentCode()); ?>" /></td>';
	html += '	 <td>';
	html += '		 <div class="input-group input-group-sm">';
	html += '		 	 <?php if (!empty($default_currency['symbol_left'])) { ?><span class="input-group-text"><?php echo $default_currency['code']; ?> <?php echo $default_currency['symbol_left']; ?></span><?php } ?>';
	html += '	 	 	 <input type="number" min="0" name="product_variant_special[' + key + '][special][' + product_variant_special_row + '][price]" value="' + default_price + '" id="input-product-variant-special-' + key + '-' + product_variant_special_row + '-price" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.price', [], $language_lib->getCurrentCode()); ?>" />';
	html += '			 <?php if (!empty($default_currency['symbol_right'])) { ?><span class="input-group-text"><?php echo $default_currency['symbol_right']; ?> <?php echo $default_currency['code']; ?></span><?php } ?>';
	html += '		 </div>';
	html += '	 </td>';
	html += '	 <td><input type="datetime-local" name="product_variant_special[' + key + '][special][' + product_variant_special_row + '][date_start]" value="" id="input-product-variant-special-' + key + '-' + product_variant_special_row + '-date-start" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.date_start', [], $language_lib->getCurrentCode()); ?>" /></td>';
	html += '	 <td><input type="datetime-local" name="product_variant_special[' + key + '][special][' + product_variant_special_row + '][date_end]" value="" id="input-product-variant-special-' + key + '-' + product_variant_special_row + '-date-end" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.date_end', [], $language_lib->getCurrentCode()); ?>" /></td>';
	html += '	 <td>';
	html += '		 <select name="product_variant_special[' + key + '][special][' + product_variant_special_row + '][timezone]" id="input-product-variant-special-' + key + '-' + product_variant_special_row + '-timezone" class="form-select form-select-sm">';
	<?php foreach ($timezones as $timezone) { ?>
	html += '			 <option value="<?php echo $timezone['timezone']; ?>"><?php echo $timezone['timezone']; ?> (UTC<?php echo $timezone['offset']; ?>)</option>';
	<?php } ?>
	html += '		 </select>';
	html += '	 </td>';
	html += '	 <td class="text-end align-middle"><button type="button" class="btn btn-danger btn-sm" onclick="removeProductVariantSpecial(\'' + key + '\',\'' + product_variant_special_row + '\');"><i class="fas fa-trash-alt fa-fw"></i></button></td>';
	html += '</tr>';

	$('#product-variant-special-' + key + ' tbody').append(html);

	product_variant_special_row++;
}

function removeProductVariantSpecial(key, product_variant_special_row) {
	$('#product-variant-special-' + key + '-' + product_variant_special_row).remove();
}
//--></script>
<?php } ?>