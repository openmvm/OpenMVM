<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo lang('Heading.heading_my_shipping_methods', array(), $lang->getFrontEndLocale()); ?></h1>
  <?php echo form_open($action); ?>
  <div class="clearfix mb-3">
    <div class="float-end">
      <a href="<?php echo base_url('/account/' . $user_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
    </div>
  </div>
	<div class="accordion" id="accordionStoreForm">
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="headingStoreForm">
	      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStoreForm" aria-expanded="true" aria-controls="collapseStoreForm">
	        <i class="fas fa-shipping-fast fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_my_shipping_methods', array(), $lang->getFrontEndLocale()); ?>
	      </button>
	    </h2>
	    <div id="collapseStoreForm" class="accordion-collapse collapse show" aria-labelledby="headingStoreForm" data-bs-parent="#accordionStoreForm">
	      <div class="accordion-body">
				  <table class="table table-hover">
				    <caption class="small"><?php echo lang('Caption.caption_list_of_shipping_methods', array(), $lang->getFrontEndLocale()); ?></caption>
					  <thead>
					    <tr>
					      <th scope="col"><?php echo lang('Column.column_name', array(), $lang->getFrontEndLocale()); ?></th>
					      <th scope="col"><?php echo lang('Column.column_status', array(), $lang->getFrontEndLocale()); ?></th>
					      <th class="text-end" scope="col"><?php echo lang('Column.column_action', array(), $lang->getFrontEndLocale()); ?></th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php if ($shipping_methods) { ?>
					  		<?php foreach ($shipping_methods as $shipping_method) { ?>
						    <tr>
		              <td class="align-middle"><?php echo $shipping_method['name']; ?></td>
		              <td class="align-middle"><?php echo $shipping_method['status']; ?></td>
		              <td class="align-middle text-end"><a href="<?php echo $shipping_method['edit']; ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="<?php echo lang('Button.button_edit', array(), $lang->getFrontEndLocale()); ?>"><i class="fa fa-edit"></i></a></td>
						    </tr>
					  		<?php } ?>
				  		<?php } else { ?>
						    <tr>
						      <td colspan="3" class="text-center text-info"><?php echo lang('Error.error_no_data_found', array(), $lang->getFrontEndLocale()); ?></td>
						    </tr>
				  		<?php } ?>
					  </tbody>
				  </table>
	      </div>
	    </div>
	  </div>
	</div>
  <?php echo form_close(); ?>
</section>
<!-- /.content -->
<?php echo $footer; ?>
