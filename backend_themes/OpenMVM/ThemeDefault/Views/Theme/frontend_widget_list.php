<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-puzzle-piece fa-fw"></i> <?php echo $heading_title; ?></h2>
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
		<div class="accordion" id="accordionAdministratorGroup">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingAdministratorGroup">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdministratorGroup" aria-expanded="true" aria-controls="collapseAdministratorGroup">
		        <i class="fas fa-puzzle-piece fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_frontend_widgets', array(), $lang->getBackEndLocale()); ?>
		      </button>
		    </h2>
		    <div id="collapseAdministratorGroup" class="accordion-collapse collapse show" aria-labelledby="headingAdministratorGroup" data-bs-parent="#accordionAdministratorGroup">
		      <div class="accordion-body">
						<div class="table-responsive">
						  <table class="table table-hover">
						    <caption class="small"><?php echo lang('Caption.caption_list_of_frontend_widgets', array(), $lang->getBackEndLocale()); ?></caption>
							  <thead>
							    <tr>
							      <th scope="col"><?php echo lang('Column.column_name', array(), $lang->getBackEndLocale()); ?></th>
							      <th class="text-end" scope="col"><?php echo lang('Column.column_action', array(), $lang->getBackEndLocale()); ?></th>
							    </tr>
							  </thead>
							  <tbody>
							  	<?php if ($frontend_widgets) { ?>
							  		<?php foreach ($frontend_widgets as $frontend_widget) { ?>
									    <tr>
					              <td class="align-middle"><strong><?php echo $frontend_widget['name']; ?></strong></td>
					              <td class="align-middle text-end">
					              	<?php if ($frontend_widget['installed']) { ?>
					              	<a href="<?php echo $frontend_widget['add']; ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_add', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-plus"></i></a>
				              		<?php } else { ?>
				              		<button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_add', array(), $lang->getBackEndLocale()); ?>" disabled><i class="fas fa-plus"></i></button>
				              		<?php } ?>
					              	<?php if (!$frontend_widget['installed']) { ?>
					              	<a href="<?php echo $frontend_widget['install']; ?>" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_install', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-object-group"></i></a>
				              		<?php } else { ?>
					              	<a href="<?php echo $frontend_widget['uninstall']; ?>" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_uninstall', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-object-ungroup"></i></a>
				              		<?php } ?>
					              </td>
									    </tr>
		                  <?php if ($frontend_widget['frontend_widget_items']) { ?>
		                    <?php foreach ($frontend_widget['frontend_widget_items'] as $frontend_widget_item) { ?>
		                      <tr>
		                        <td><span class="align-middle">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-puzzle-piece fa-fw"></i>&nbsp;&nbsp;<?php echo $frontend_widget_item['name']; ?></span></td>
		                        <td class="text-end">
		                          <a href="<?php echo $frontend_widget_item['edit']; ?>" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_edit', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-pencil-alt"></i></a> <a href="<?php echo $frontend_widget_item['delete']; ?>" class="btn btn-warning" onclick="return confirm('<?php echo lang('Text.text_confirm', array(), $lang->getBackEndLocale()); ?>')" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_delete', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-trash"></i></a>
		                        </td>
		                      </tr>
		                    <?php } ?>
		                  <?php } ?>
							  		<?php } ?>
						  		<?php } else { ?>
								    <tr>
								      <td colspan="2" class="text-center text-info"><?php echo lang('Error.error_no_data_found', array(), $lang->getBackEndLocale()); ?></td>
								    </tr>
						  		<?php } ?>
							  </tbody>
						  </table>
						</div>
		      </div>
		    </div>
		  </div>
		</div>
    <?php echo form_close(); ?>
	</section>
  <!-- /.content -->
<?php echo $footer; ?>
