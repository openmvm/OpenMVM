<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo $heading_title; ?></h1>
  <div class="clearfix mb-3">
    <div class="float-end">
      <a href="<?php echo base_url('/account/' . $user_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
    </div>
  </div>
	<div class="accordion" id="accordionOrder">
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="headingOrder">
	      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrder" aria-expanded="true" aria-controls="collapseOrder">
	        <i class="fas fa-clipboard-list fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_my_orders', array(), $lang->getFrontEndLocale()); ?>
	      </button>
	    </h2>
	    <div id="collapseOrder" class="accordion-collapse collapse show" aria-labelledby="headingOrder" data-bs-parent="#accordionOrder">
	      <div class="accordion-body">
					<div class="table-responsive">
					  <table class="table table-hover">
					    <caption class="small"><?php echo lang('Caption.caption_list_of_orders', array(), $lang->getFrontEndLocale()); ?></caption>
						  <thead>
						    <tr>
						      <th scope="col"><?php echo lang('Column.column_order_id', array(), $lang->getFrontEndLocale()); ?></th>
						      <th scope="col"><?php echo lang('Column.column_name', array(), $lang->getFrontEndLocale()); ?></th>
						      <th scope="col"><?php echo lang('Column.column_product', array(), $lang->getFrontEndLocale()); ?></th>
						      <th scope="col"><?php echo lang('Column.column_status', array(), $lang->getFrontEndLocale()); ?></th>
						      <th scope="col"><?php echo lang('Column.column_total', array(), $lang->getFrontEndLocale()); ?></th>
						      <th scope="col"><?php echo lang('Column.column_date_added', array(), $lang->getFrontEndLocale()); ?></th>
						      <th class="text-end" scope="col"><?php echo lang('Column.column_action', array(), $lang->getFrontEndLocale()); ?></th>
						    </tr>
						  </thead>
						  <tbody>
						  	<?php if ($orders) { ?>
						  		<?php foreach ($orders as $order) { ?>
							    <tr>
			              <td class="align-middle"><?php echo $order['order_id']; ?></td>
			              <td class="align-middle"><?php echo $order['name']; ?></td>
			              <td class="align-middle"><?php echo $order['products']; ?></td>
			              <td class="align-middle"><?php echo $order['status']; ?></td>
			              <td class="align-middle"><?php echo $order['total']; ?></td>
			              <td class="align-middle"><?php echo $order['date_added']; ?></td>
			              <td class="align-middle text-end"><a href="<?php echo $order['view']; ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="<?php echo lang('Button.button_view', array(), $lang->getFrontEndLocale()); ?>"><i class="fa fa-eye"></i></a></td>
							    </tr>
						  		<?php } ?>
					  		<?php } else { ?>
							    <tr>
							      <td colspan="7" class="text-center text-info"><?php echo lang('Error.error_no_data_found', array(), $lang->getFrontEndLocale()); ?></td>
							    </tr>
					  		<?php } ?>
						  </tbody>
					  </table>
					</div>
					<div class="clearfix"><div class="float-end"><?php echo $pager; ?></div></div>
					<div class="clearfix"><div class="text-secondary small float-end"><?php echo $pagination; ?></div></div>			
	      </div>
	    </div>
	  </div>
	</div>
</section>
<!-- /.content -->
<?php echo $footer; ?>
