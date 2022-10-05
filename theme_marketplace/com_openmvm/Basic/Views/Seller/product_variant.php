<div class="mb-3 d-none"><?php echo json_encode($result); ?></div>
<div class="mb-3 d-none"><?php echo json_encode($product_variants); ?></div>
<?php if (!empty($product_variants[0]['variant'])) { ?>
<div class="card mb-3">
	<div class="card-body">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th class="text-nowrap"><?php echo lang('Column.product_variant', [], 'en'); ?></th>
					<th><?php echo lang('Column.sku', [], 'en'); ?></th>
					<th><?php echo lang('Column.quantity', [], 'en'); ?></th>
					<th><?php echo lang('Column.price', [], 'en'); ?></th>
					<th><?php echo lang('Column.weight', [], 'en'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($product_variants as $key => $value) { ?>
				<tr>
					<td class="align-middle"><?php echo $value['key']; ?></td>
					<td class="align-middle">
						<?php foreach ($value['variant'] as $variant) { ?>
						<div class="small"><small><?php echo $variant['option']; ?>: <strong><?php echo $variant['option_value']; ?></strong></small></div>
						<input type="hidden" name="product_variant[<?php echo $key; ?>][option][<?php echo $variant['option_id']; ?>]" value="<?php echo $variant['option_value_id']; ?>" />
						<?php } ?>
					</td>
					<td class="align-middle"><input type="text" name="product_variant[<?php echo $key; ?>][sku]" value="<?php echo $value['sku']; ?>" class="form-control" /></td>
					<td class="align-middle"><input type="text" name="product_variant[<?php echo $key; ?>][quantity]" value="<?php echo $value['quantity']; ?>" class="form-control" /></td>
					<td class="align-middle">
						<div class="input-group">
							<?php if (!empty($default_currency['symbol_left'])) { ?><span class="input-group-text"><?php echo $default_currency['code']; ?> <?php echo $default_currency['symbol_left']; ?></span><?php } ?>
							<input type="number" min="0" step="any" name="product_variant[<?php echo $key; ?>][price]" value="<?php echo $value['price']; ?>" class="form-control" />
							<?php if (!empty($default_currency['symbol_right'])) { ?><span class="input-group-text"><?php echo $default_currency['symbol_right']; ?> <?php echo $default_currency['code']; ?></span><?php } ?>
						</div>
					</td>
					<td class="align-middle">
						<div class="row">
							<div class="col-sm-6"><input type="number" min="0" step="any" name="product_variant[<?php echo $key; ?>][weight]" value="<?php echo $value['weight']; ?>" class="form-control" /></div>
							<div class="col-sm-6">
								<select name="product_variant[<?php echo $key; ?>][weight_class_id]" class="form-select">
									<?php foreach ($weight_classes as $weight_class) { ?>
									<option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
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
