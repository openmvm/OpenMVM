<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo lang('Heading.heading_address_book', array(), $lang->getFrontEndLocale()); ?></h1>
  <?php echo form_open(base_url('/account/address/' . $user_token)); ?>
  <div class="clearfix mb-3">
    <div class="float-end">
      <a href="<?php echo base_url('/account/address/add/' . $user_token); ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_add', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-plus"></i></a>
      <button type="submit" onclick="return confirm('<?php echo lang('Text.text_confirm', array(), $lang->getFrontEndLocale()); ?>')" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_delete', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-trash"></i></button>
      <a href="<?php echo base_url('/account/' . $user_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getFrontEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
    </div>
  </div>
	<div class="accordion" id="accordionAddress">
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="headingAddress">
	      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddress" aria-expanded="true" aria-controls="collapseAddress">
	        <i class="fas fa-address-book fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_address_book', array(), $lang->getFrontEndLocale()); ?>
	      </button>
	    </h2>
	    <div id="collapseAddress" class="accordion-collapse collapse show" aria-labelledby="headingAddress" data-bs-parent="#accordionAddress">
	      <div class="accordion-body">
					<div class="table-responsive">
					  <table class="table table-hover">
					    <caption class="small"><?php echo lang('Caption.caption_list_of_addresses', array(), $lang->getFrontEndLocale()); ?></caption>
						  <thead>
						    <tr>
						      <th style="width: 1px;" scope="col"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
						      <th scope="col"><?php echo lang('Column.column_address', array(), $lang->getFrontEndLocale()); ?></th>
						      <th class="text-end" scope="col"><?php echo lang('Column.column_action', array(), $lang->getFrontEndLocale()); ?></th>
						    </tr>
						  </thead>
						  <tbody>
						  	<?php if ($user_addresses) { ?>
						  		<?php foreach ($user_addresses as $user_address) { ?>
							    <tr>
							      <th class="align-middle" scope="row">
			                <?php if (in_array($user_address['user_address_id'], $selected)) { ?>
			                <input type="checkbox" name="selected[]" value="<?php echo $administrator['administrator_id']; ?>" checked="checked" />
			                <?php } else { ?>
			                <input type="checkbox" name="selected[]" value="<?php echo $administrator['administrator_id']; ?>" />
			                <?php } ?>
							      </th>
			              <td class="align-middle"><?php echo $user_address['address']; ?></td>
			              <td class="align-middle text-end"><a href="<?php echo $user_address['edit']; ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="<?php echo lang('Button.button_edit', array(), $lang->getFrontEndLocale()); ?>"><i class="fa fa-edit"></i></a></td>
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
