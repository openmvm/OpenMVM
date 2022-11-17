<div class="mb-3 d-none"><?php echo json_encode($result); ?></div>
<div class="mb-3 d-none"><?php echo json_encode($product_variants); ?></div>
<?php if (!empty($product_variants[0]['variant'])) { ?>
<div class="card mb-3">
	<div class="card-body">
		<legend class="border-bottom pb-2 mb-3"><?php echo lang('Text.product_variants', [], $language_lib->getCurrentCode()); ?></legend>
		<table class="table small">
			<thead>
				<tr>
					<th>#</th>
					<th class="text-nowrap"><?php echo lang('Column.product_variant', [], $language_lib->getCurrentCode()); ?></th>
					<th><?php echo lang('Column.sku', [], $language_lib->getCurrentCode()); ?></th>
					<th><?php echo lang('Column.quantity', [], $language_lib->getCurrentCode()); ?></th>
					<th><?php echo lang('Column.minimum_purchase', [], $language_lib->getCurrentCode()); ?></th>
					<th><?php echo lang('Column.price', [], $language_lib->getCurrentCode()); ?></th>
					<th><?php echo lang('Column.weight', [], $language_lib->getCurrentCode()); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($product_variants as $key => $value) { ?>
				<tr>
					<td class="align-middle"><?php echo $value['key'] + 1; ?></td>
					<td class="align-middle">
						<?php foreach ($value['variant'] as $variant) { ?>
						<div><small><?php echo $variant['option']; ?>: <strong><?php echo $variant['option_value']; ?></strong></small></div>
						<input type="hidden" name="product_variant[<?php echo $key; ?>][option][<?php echo $variant['option_id']; ?>]" value="<?php echo $variant['option_value_id']; ?>" />
						<?php } ?>
					</td>
					<td class="align-middle"><input type="text" name="product_variant[<?php echo $key; ?>][sku]" value="<?php echo $value['sku']; ?>" id="input-product-variant-sku-<?php echo $value['key']; ?>" class="form-control form-control-sm" /></td>
					<td class="align-middle"><input type="number" name="product_variant[<?php echo $key; ?>][quantity]" value="<?php echo $value['quantity']; ?>" id="input-product-variant-quantity-<?php echo $value['key']; ?>" class="form-control form-control-sm" /></td>
					<td class="align-middle"><input type="number" name="product_variant[<?php echo $key; ?>][minimum_purchase]" value="<?php echo $value['minimum_purchase']; ?>" id="input-product-variant-minimum-purchase-<?php echo $value['key']; ?>" class="form-control form-control-sm" /></td>
					<td class="align-middle">
						<div class="input-group input-group-sm">
							<?php if (!empty($default_currency['symbol_left'])) { ?><span class="input-group-text"><?php echo $default_currency['code']; ?> <?php echo $default_currency['symbol_left']; ?></span><?php } ?>
							<input type="number" min="0" step="any" name="product_variant[<?php echo $key; ?>][price]" value="<?php echo $value['price']; ?>" id="input-product-variant-price-<?php echo $value['key']; ?>" class="form-control" />
							<?php if (!empty($default_currency['symbol_right'])) { ?><span class="input-group-text"><?php echo $default_currency['symbol_right']; ?> <?php echo $default_currency['code']; ?></span><?php } ?>
						</div>
					</td>
					<td class="align-middle">
						<div class="row">
							<div class="col-sm-6"><input type="number" min="0" step="any" name="product_variant[<?php echo $key; ?>][weight]" value="<?php echo $value['weight']; ?>" id="input-product-variant-weight-<?php echo $value['key']; ?>" class="form-control form-control-sm" /></div>
							<div class="col-sm-6">
								<select name="product_variant[<?php echo $key; ?>][weight_class_id]" id="input-product-variant-weight-class-id-<?php echo $value['key']; ?>" class="form-select form-select-sm">
									<?php foreach ($weight_classes as $weight_class) { ?>
										<?php if ($weight_class['weight_class_id'] == $value['weight_class_id']) { ?>
										<option value="<?php echo $weight_class['weight_class_id']; ?>" selected><?php echo $weight_class['title']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php } ?>
