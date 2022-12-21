<div id="widget-seller-dashboard-latest-order-<?php echo $widget; ?>" class="card shadow rounded-0 mb-3">
	<div class="card-header"><?php echo lang('Text.latest_orders'); ?></div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th><?php echo lang('Column.date_added', [], $language_lib->getCurrentCode()); ?></th>
						<th><?php echo lang('Column.invoice', [], $language_lib->getCurrentCode()); ?></th>
						<th><?php echo lang('Column.name', [], $language_lib->getCurrentCode()); ?></th>
						<th><?php echo lang('Column.products', [], $language_lib->getCurrentCode()); ?></th>
						<th><?php echo lang('Column.total', [], $language_lib->getCurrentCode()); ?></th>
						<th><?php echo lang('Column.order_status', [], $language_lib->getCurrentCode()); ?></th>
						<th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($orders)) { ?>
						<?php foreach ($orders as $order) { ?>
						<tr>
							<td><?php echo $order['date_added']; ?></td>
							<td><?php echo $order['invoice']; ?></td>
							<td><?php echo $order['firstname']; ?> <?php echo $order['lastname']; ?></td>
							<td>
								<?php if (!empty($order['product'])) { ?>
									<?php foreach ($order['product'] as $product) { ?>
									<div>
										<div><?php echo $product['name']; ?></div>
										<div class="small text-secondary"><?php echo $product['price']; ?> X <?php echo $product['quantity']; ?> = <?php echo $product['total']; ?></div>
									</div>
									<?php } ?>
								<?php } ?>
							</td>
							<td><?php echo $order['total']; ?></td>
							<td><?php echo $order['order_status']['name']; ?></td>
							<td class="text-end"><a href="<?php echo $order['info']; ?>" class="btn btn-info btn-sm"><i class="fas fa-eye fa-fw"></i> <?php echo lang('Button.show'); ?></a></td>
						</tr>
						<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="7"><?php echo lang('Text.no_results', [], $language_lib->getCurrentCode()); ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>