<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo lang('Heading.heading_my_products', array(), $lang->getFrontEndLocale()); ?></h1>
  <?php echo form_open($action); ?>
  <div class="clearfix mb-3">
    <div class="float-end">
      <a href="<?php echo base_url('/account/store/products/add/' . $user_token); ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_add', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-plus"></i></a>
      <button type="submit" onclick="return confirm('<?php echo lang('Text.text_confirm', array(), $lang->getFrontEndLocale()); ?>')" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_delete', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-trash"></i></button>
      <a href="<?php echo base_url('/account/' . $user_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
    </div>
  </div>
	<div class="accordion" id="accordionStoreForm">
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="headingStoreForm">
	      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStoreForm" aria-expanded="true" aria-controls="collapseStoreForm">
	        <i class="fas fa-boxes fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_my_products', array(), $lang->getFrontEndLocale()); ?>
	      </button>
	    </h2>
	    <div id="collapseStoreForm" class="accordion-collapse collapse show" aria-labelledby="headingStoreForm" data-bs-parent="#accordionStoreForm">
	      <div class="accordion-body">
					<div class="table-responsive">
					  <table class="table table-hover">
					    <caption class="small"><?php echo lang('Caption.caption_list_of_products', array(), $lang->getFrontEndLocale()); ?></caption>
						  <thead>
						    <tr>
						      <th style="width: 1px;" scope="col"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
						      <th scope="col"><?php echo lang('Column.column_image', array(), $lang->getFrontEndLocale()); ?></th>
						      <th scope="col"><?php echo lang('Column.column_name', array(), $lang->getFrontEndLocale()); ?></th>
						      <th scope="col"><?php echo lang('Column.column_quantity', array(), $lang->getFrontEndLocale()); ?></th>
						      <th scope="col"><?php echo lang('Column.column_price', array(), $lang->getFrontEndLocale()); ?></th>
						      <th scope="col"><?php echo lang('Column.column_status', array(), $lang->getFrontEndLocale()); ?></th>
						      <th class="text-end" scope="col"><?php echo lang('Column.column_action', array(), $lang->getFrontEndLocale()); ?></th>
						    </tr>
						  </thead>
						  <tbody>
						  	<?php if ($products) { ?>
						  		<?php foreach ($products as $product) { ?>
							    <tr>
							      <th class="align-middle" scope="row">
			                <?php if (in_array($product['product_id'], $selected)) { ?>
			                <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
			                <?php } else { ?>
			                <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
			                <?php } ?>
							      </th>
			              <td class="align-middle"><img src="<?php echo $product['thumb']; ?>" class="border border-secondary" /></td>
			              <td class="align-middle"><?php echo $product['name']; ?></td>
			              <td class="align-middle"><?php echo $product['quantity']; ?></td>
			              <td class="align-middle"><?php echo $product['price']; ?></td>
			              <td class="align-middle"><?php echo $product['status']; ?></td>
			              <td class="align-middle text-end"><a href="<?php echo $product['view']; ?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="<?php echo lang('Button.button_view', array(), $lang->getFrontEndLocale()); ?>" target="_blank"><i class="fa fa-eye"></i></a> <a href="<?php echo $product['edit']; ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="<?php echo lang('Button.button_edit', array(), $lang->getFrontEndLocale()); ?>"><i class="fa fa-edit"></i></a></td>
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
  <?php echo form_close(); ?>
</section>
<!-- /.content -->
<?php echo $footer; ?>
