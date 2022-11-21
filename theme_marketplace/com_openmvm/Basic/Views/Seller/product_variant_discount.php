<?php if (!empty($product_variants[0]['variant'])) { ?>
<div class="card">
	<div class="card-body">
		<legend class="border-bottom pb-2 mb-3 clearfix">
			<span class="d-inline-block"><?php echo lang('Text.product_variant_discounts', [], $language_lib->getCurrentCode()); ?></span>
            <span id="input-is-product-variant-discount-container" class="d-inline-block float-end fs-6 mb-3">
                <div class="form-check form-switch">
                    <input name="is_product_variant_discount" class="form-check-input" type="checkbox" role="switch" id="input-is-product-variant-discount"<?php if (!empty($is_product_variant_discount)) { ?> checked<?php } ?>>
                    <label class="form-check-label" for="input-is-product-variant-discount"><?php echo lang('Entry.product_variant_discounts', [], $language_lib->getCurrentCode()); ?></label>
                </div>
            </span>
		</legend>
		<div id="product-variant-discount-list" class="table-responsive<?php if (empty($is_product_variant_discount)) { ?> d-none<?php } ?>">
			<table class="table table-sm small">
				<thead>
					<tr>
						<th>#</th>
						<th class="text-nowrap"><?php echo lang('Column.product_variant', [], $language_lib->getCurrentCode()); ?></th>
						<th class="text-center"><?php echo lang('Column.discounts', [], $language_lib->getCurrentCode()); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $product_variant_discount_row = 0; ?>
					<?php foreach ($product_variants as $key => $value) { ?>
					<tr>
						<td class="align-top"><?php echo $value['key'] + 1; ?></td>
						<td class="align-top">
							<?php foreach ($value['variant'] as $variant) { ?>
							<div><small><?php echo $variant['option']; ?>: <strong><?php echo $variant['option_value']; ?></strong></small></div>
							<input type="hidden" name="product_variant_discount[<?php echo $key; ?>][option][<?php echo $variant['option_id']; ?>]" value="<?php echo $variant['option_value_id']; ?>" />
							<?php } ?>
						</td>
						<td>
							<div id="product-variant-discount-<?php echo $value['key']; ?>" class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th><?php echo lang('Column.priority', [], $language_lib->getCurrentCode()); ?></th>
											<th><?php echo lang('Column.min_quantity', [], $language_lib->getCurrentCode()); ?></th>
											<th><?php echo lang('Column.max_quantity', [], $language_lib->getCurrentCode()); ?></th>
											<th><?php echo lang('Column.price', [], $language_lib->getCurrentCode()); ?></th>
											<th><?php echo lang('Column.date_start', [], $language_lib->getCurrentCode()); ?></th>
											<th><?php echo lang('Column.date_end', [], $language_lib->getCurrentCode()); ?></th>
											<th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php if ($value['product_variant_discounts']) { ?>
											<?php foreach ($value['product_variant_discounts'] as $product_variant_discount) { ?>
											<tr id="product-variant-discount-<?php echo $key; ?>-<?php echo $product_variant_discount_row; ?>">
											 	<td><input size="4" type="number" name="product_variant_discount[<?php echo $key; ?>][discount][<?php echo $product_variant_discount_row; ?>][priority]" value="<?php echo $product_variant_discount['priority']; ?>" id="input-product-variant-discount-<?php echo $key; ?>-<?php echo $product_variant_discount_row; ?>-priority" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.priority', [], $language_lib->getCurrentCode()); ?>" /></td>
											 	<td><input size="4" type="number" name="product_variant_discount[<?php echo $key; ?>][discount][<?php echo $product_variant_discount_row; ?>][min_quantity]" value="<?php echo $product_variant_discount['min_quantity']; ?>" id="input-product-variant-discount-<?php echo $key; ?>-<?php echo $product_variant_discount_row; ?>-min-quantity" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.min_quantity', [], $language_lib->getCurrentCode()); ?>" /></td>
											 	<td><input size="4" type="number" name="product_variant_discount[<?php echo $key; ?>][discount][<?php echo $product_variant_discount_row; ?>][max_quantity]" value="<?php echo $product_variant_discount['max_quantity']; ?>" id="input-product-variant-discount-<?php echo $key; ?>-<?php echo $product_variant_discount_row; ?>-max-quantity" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.max_quantity', [], $language_lib->getCurrentCode()); ?>" /></td>
											 	<td>
												 	<div class="input-group input-group-sm">
												 	 	<?php if (!empty($default_currency['symbol_left'])) { ?><span class="input-group-text"><?php echo $default_currency['code']; ?> <?php echo $default_currency['symbol_left']; ?></span><?php } ?>
											 	 	 	<input type="number" min="0" name="product_variant_discount[<?php echo $key; ?>][discount][<?php echo $product_variant_discount_row; ?>][price]" value="<?php echo $product_variant_discount['price']; ?>" id="input-product-variant-discount-<?php echo $key; ?>-<?php echo $product_variant_discount_row; ?>-price" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.price', [], $language_lib->getCurrentCode()); ?>" />
													 	<?php if (!empty($default_currency['symbol_right'])) { ?><span class="input-group-text"><?php echo $default_currency['symbol_right']; ?> <?php echo $default_currency['code']; ?></span><?php } ?>
												 	</div>
											 	</td>
											 	<td><input type="datetime-local" name="product_variant_discount[<?php echo $key; ?>][discount][<?php echo $product_variant_discount_row; ?>][date_start]" value="<?php echo $product_variant_discount['date_start']; ?>" id="input-product-variant-discount-<?php echo $key; ?>-<?php echo $product_variant_discount_row; ?>-date-start" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.date_start', [], $language_lib->getCurrentCode()); ?>" /></td>
											 	<td><input type="datetime-local" name="product_variant_discount[<?php echo $key; ?>][discount][<?php echo $product_variant_discount_row; ?>][date_end]" value="<?php echo $product_variant_discount['date_end']; ?>" id="input-product-variant-discount-<?php echo $key; ?>-<?php echo $product_variant_discount_row; ?>-date-end" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.date_end', [], $language_lib->getCurrentCode()); ?>" /></td>
											 	<td class="text-end align-middle"><button type="button" class="btn btn-danger btn-sm" onclick="removeProductVariantDiscount('<?php echo $key; ?>','<?php echo $product_variant_discount_row; ?>');"><i class="fas fa-trash-alt fa-fw"></i></button></td>
											</tr>
											<?php $product_variant_discount_row++; ?>
											<?php } ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="7" class="text-end align-middle"><button type="button" id="button-add-product-variant-discount-<?php echo $value['key']; ?>" class="btn btn-primary btn-sm" onclick="addProductVariantDiscount('<?php echo $value['key']; ?>');"><i class="fas fa-circle-plus fa-fw"></i></button></td>
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
$('input#input-is-product-variant-discount').click(function() {
    if ($('input#input-is-product-variant-discount').is(':checked')) {
        $('#product-variant-discount-list').removeClass('d-none');
    } else {
        $('#product-variant-discount-list').addClass('d-none');
    }
});
//--></script>
<script type="text/javascript"><!--
var product_variant_discount_row = '<?php echo $product_variant_discount_row; ?>';

function addProductVariantDiscount(key) {
	//let key = key + 1;
	var default_price = $('#input-product-variant-price-' + key).val();

	html = '<tr id="product-variant-discount-' + key + '-' + product_variant_discount_row + '">';
	html += '	 <td><input size="4" type="number" name="product_variant_discount[' + key + '][discount][' + product_variant_discount_row + '][priority]" value="1" id="input-product-variant-discount-' + key + '-' + product_variant_discount_row + '-priority" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.priority', [], $language_lib->getCurrentCode()); ?>" /></td>';
	html += '	 <td><input size="4" type="number" name="product_variant_discount[' + key + '][discount][' + product_variant_discount_row + '][min_quantity]" value="1" id="input-product-variant-discount-' + key + '-' + product_variant_discount_row + '-min-quantity" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.min_quantity', [], $language_lib->getCurrentCode()); ?>" /></td>';
	html += '	 <td><input size="4" type="number" name="product_variant_discount[' + key + '][discount][' + product_variant_discount_row + '][max_quantity]" value="1" id="input-product-variant-discount-' + key + '-' + product_variant_discount_row + '-max-quantity" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.max_quantity', [], $language_lib->getCurrentCode()); ?>" /></td>';
	html += '	 <td>';
	html += '		 <div class="input-group input-group-sm">';
	html += '		 	 <?php if (!empty($default_currency['symbol_left'])) { ?><span class="input-group-text"><?php echo $default_currency['code']; ?> <?php echo $default_currency['symbol_left']; ?></span><?php } ?>';
	html += '	 	 	 <input type="number" min="0" name="product_variant_discount[' + key + '][discount][' + product_variant_discount_row + '][price]" value="' + default_price + '" id="input-product-variant-discount-' + key + '-' + product_variant_discount_row + '-price" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.price', [], $language_lib->getCurrentCode()); ?>" />';
	html += '			 <?php if (!empty($default_currency['symbol_right'])) { ?><span class="input-group-text"><?php echo $default_currency['symbol_right']; ?> <?php echo $default_currency['code']; ?></span><?php } ?>';
	html += '		 </div>';
	html += '	 </td>';
	html += '	 <td><input type="datetime-local" name="product_variant_discount[' + key + '][discount][' + product_variant_discount_row + '][date_start]" value="" id="input-product-variant-discount-' + key + '-' + product_variant_discount_row + '-date-start" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.date_start', [], $language_lib->getCurrentCode()); ?>" /></td>';
	html += '	 <td><input type="datetime-local" name="product_variant_discount[' + key + '][discount][' + product_variant_discount_row + '][date_end]" value="" id="input-product-variant-discount-' + key + '-' + product_variant_discount_row + '-date-end" class="form-control form-control-sm" placeholder="<?php echo lang('Entry.date_end', [], $language_lib->getCurrentCode()); ?>" /></td>';
	html += '	 <td class="text-end align-middle"><button type="button" class="btn btn-danger btn-sm" onclick="removeProductVariantDiscount(\'' + key + '\',\'' + product_variant_discount_row + '\');"><i class="fas fa-trash-alt fa-fw"></i></button></td>';
	html += '</tr>';

	$('#product-variant-discount-' + key + ' tbody').append(html);

	product_variant_discount_row++;
}

function removeProductVariantDiscount(key, product_variant_discount_row) {
	$('#product-variant-discount-' + key + '-' + product_variant_discount_row).remove();
}
//--></script>
<?php } ?>