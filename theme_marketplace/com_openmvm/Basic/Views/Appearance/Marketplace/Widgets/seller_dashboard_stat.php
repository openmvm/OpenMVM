<div id="widget-seller-dashboard-stat-<?php echo $widget; ?>" class="mb-3">
	<div class="row">
		<div class="col-sm-6 col-md-4 col-lg-3">
			<div class="card shadow rounded-0 mb-3">
				<div class="card-header d-flex align-items-center">
					<div class="me-auto"><?php echo lang('Text.total_revenue', [], $language_lib->getCurrentCode()); ?></div>
					<div class="dropdown">
						<button class="btn btn-link btn-sm dropdown-toggle link-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
						<ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
							<li><a class="dropdown-item" href="<?php echo $url_seller_order; ?>"><?php echo lang('Text.view_order_history', [], $language_lib->getCurrentCode()); ?></a></li>
						</ul>
					</div>					
				</div>
				<div class="card-body d-flex align-items-center">
					<i class="fas fa-sack-dollar fa-3x fa-fw me-auto text-secondary"></i> <span class="d-inline-block fs-4 me-0"><?php echo $total_revenue; ?></span>
				</div>
			</div>			
		</div>
		<div class="col-sm-6 col-md-4 col-lg-3">
			<div class="card shadow rounded-0 mb-3">
				<div class="card-header d-flex align-items-center">
					<div class="me-auto"><?php echo lang('Text.wallet_balance', [], $language_lib->getCurrentCode()); ?></div>
					<div class="dropdown">
						<button class="btn btn-link btn-sm dropdown-toggle link-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
						<ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
							<li><a class="dropdown-item" href="<?php echo $url_account_wallet; ?>"><?php echo lang('Text.view_transaction_history', [], $language_lib->getCurrentCode()); ?></a></li>
							<li><a class="dropdown-item" href="#"><?php echo lang('Text.withdraw_money', [], $language_lib->getCurrentCode()); ?></a></li>
						</ul>
					</div>					
				</div>
				<div class="card-body d-flex align-items-center">
					<i class="fas fa-wallet fa-3x fa-fw me-auto text-secondary"></i> <span class="d-inline-block fs-4 me-0"><?php echo $wallet_balance; ?></span>
				</div>
			</div>			
		</div>
		<div class="col-sm-6 col-md-4 col-lg-3">
			<div class="card shadow rounded-0 mb-3">
				<div class="card-header d-flex align-items-center">
					<div class="me-auto"><?php echo lang('Text.total_orders', [], $language_lib->getCurrentCode()); ?></div>
					<div class="dropdown">
						<button class="btn btn-link btn-sm dropdown-toggle link-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
						<ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
							<li><a class="dropdown-item" href="<?php echo $url_seller_order; ?>"><?php echo lang('Text.view_order_history', [], $language_lib->getCurrentCode()); ?></a></li>
						</ul>
					</div>					
				</div>
				<div class="card-body d-flex align-items-center">
					<i class="fas fa-basket-shopping fa-3x fa-fw me-auto text-secondary"></i> <span class="d-inline-block fs-4 me-0"><?php echo $total_orders; ?></span>
				</div>
			</div>			
		</div>
		<div class="col-sm-6 col-md-4 col-lg-3">
			<div class="card shadow rounded-0 mb-3">
				<div class="card-header d-flex align-items-center">
					<div class="me-auto"><?php echo lang('Text.total_sold_quantity', [], $language_lib->getCurrentCode()); ?></div>
					<div class="dropdown">
						<button class="btn btn-link btn-sm dropdown-toggle link-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
						<ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
							<li><a class="dropdown-item" href="<?php echo $url_seller_order; ?>"><?php echo lang('Text.view_order_history', [], $language_lib->getCurrentCode()); ?></a></li>
						</ul>
					</div>					
				</div>
				<div class="card-body d-flex align-items-center">
					<i class="fas fa-boxes-stacked fa-3x fa-fw me-auto text-secondary"></i> <span class="d-inline-block fs-4 me-0"><?php echo $total_sold_quantity; ?></span>
				</div>
			</div>			
		</div>
	</div>
</div>