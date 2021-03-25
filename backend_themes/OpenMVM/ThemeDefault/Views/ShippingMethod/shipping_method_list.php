<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-shipping-fast fa-fw"></i> <?php echo $heading_title; ?></h2>
		<div class="heading-lead lead text-white"><?php echo $lead; ?></div>
	</section>
  <!-- /.heading-container -->

	<!-- Breadcrumb -->
	<?php if ($breadcrumbs) { ?>
	<section id="breadcrumb" class="bg-light p-3 mb-3">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb small p-0 m-0">
		  	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		  		<?php if ($breadcrumb['active']) { ?>
		    	<li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
	  			<?php } else { ?>
		    	<li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
	  			<?php } ?>
		  	<?php } ?>
		  </ol>
		</nav>
  </section>
	<?php } ?>
	<!-- /.breadcrumb -->

	<!-- Notification -->
	<?php if ($success || $error) { ?>
	<section id="notification" class="notification px-3">
		<?php if ($success) { ?>
		<div class="alert alert-success alert-dismissible" role="alert">
		  <?php echo $success; ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<?php } ?>
		<?php if ($error) { ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <?php echo $error; ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<?php } ?>
  </section>
	<?php } ?>
	<!-- /.notification -->

	<!-- Content -->
	<section class="content px-3">
    <div class="clearfix mb-3">
	    <div class="float-end">
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/dashboard/' . $administrator_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
	    </div>
    </div>
		<div class="accordion" id="accordionAdministrator">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingAdministrator">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdministrator" aria-expanded="true" aria-controls="collapseAdministrator">
		        <i class="fas fa-shipping-fast fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_shipping_methods', array(), $lang->getBackEndLocale()); ?>
		      </button>
		    </h2>
		    <div id="collapseAdministrator" class="accordion-collapse collapse show" aria-labelledby="headingAdministrator" data-bs-parent="#accordionAdministrator">
		      <div class="accordion-body">
						<div class="table-responsive">
						  <table class="table table-hover">
						    <caption class="small"><?php echo lang('Caption.caption_list_of_shipping_methods', array(), $lang->getBackEndLocale()); ?></caption>
							  <thead>
							    <tr>
							      <th scope="col"><?php echo lang('Column.column_name', array(), $lang->getBackEndLocale()); ?></th>
							      <th scope="col"><?php echo lang('Column.column_link', array(), $lang->getBackEndLocale()); ?></th>
							      <th scope="col"><?php echo lang('Column.column_status', array(), $lang->getBackEndLocale()); ?></th>
							      <th scope="col"><?php echo lang('Column.column_sort_order', array(), $lang->getBackEndLocale()); ?></th>
							      <th class="text-end" scope="col"><?php echo lang('Column.column_action', array(), $lang->getBackEndLocale()); ?></th>
							    </tr>
							  </thead>
							  <tbody>
							  	<?php if ($shipping_methods) { ?>
							  		<?php foreach ($shipping_methods as $shipping_method) { ?>
								    <tr>
				              <td class="align-middle"><?php echo $shipping_method['name']; ?></td>
				              <td class="align-middle"><?php echo $shipping_method['link']; ?></td>
				              <td class="align-middle"><?php echo $shipping_method['status']; ?></td>
				              <td class="align-middle"><?php echo $shipping_method['sort_order']; ?></td>
				              <td class="align-middle text-end">
				              	<?php if ($shipping_method['installed']) { ?>
				              	<a href="<?php echo $shipping_method['edit']; ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_edit', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-edit"></i></a>
			              		<?php } else { ?>
			              		<button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_edit', array(), $lang->getBackEndLocale()); ?>" disabled><i class="fas fa-edit"></i></button>
			              		<?php } ?>
				              	<?php if (!$shipping_method['installed']) { ?>
				              	<a href="<?php echo $shipping_method['install']; ?>" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_install', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-object-group"></i></a>
			              		<?php } else { ?>
				              	<a href="<?php echo $shipping_method['uninstall']; ?>" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_uninstall', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-object-ungroup"></i></a>
			              		<?php } ?>
				              </td>
								    </tr>
							  		<?php } ?>
						  		<?php } else { ?>
								    <tr>
								      <td colspan="5" class="text-center text-info"><?php echo lang('Error.error_no_data_found', array(), $lang->getBackEndLocale()); ?></td>
								    </tr>
						  		<?php } ?>
							  </tbody>
						  </table>
						</div>
		      </div>
		    </div>
		  </div>
		</div>
	</section>
  <!-- /.content -->
<?php echo $footer; ?>
