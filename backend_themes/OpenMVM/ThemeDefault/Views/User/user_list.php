<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-user fa-fw"></i> <?php echo $heading_title; ?></h2>
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
    <?php echo form_open(base_url($_SERVER['app.adminDir'] . '/users/' . $administrator_token)); ?>
    <div class="clearfix mb-3">
	    <div class="float-end">
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/users/add/' . $administrator_token); ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_add', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-plus"></i></a>
	      <button type="submit" onclick="return confirm('<?php echo lang('Text.text_confirm', array(), $lang->getBackEndLocale()); ?>')" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_delete', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-trash"></i></button>
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/dashboard/' . $administrator_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
	    </div>
    </div>
		<div class="accordion" id="accordionAdministrator">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingAdministrator">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdministrator" aria-expanded="true" aria-controls="collapseAdministrator">
		        <i class="fas fa-user fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_users', array(), $lang->getBackEndLocale()); ?>
		      </button>
		    </h2>
		    <div id="collapseAdministrator" class="accordion-collapse collapse show" aria-labelledby="headingAdministrator" data-bs-parent="#accordionAdministrator">
		      <div class="accordion-body">
		        <div class="table-responsive">
		          <table class="table table-hover">
		            <caption class="small"><?php echo lang('Caption.caption_list_of_users', array(), $lang->getBackEndLocale()); ?></caption>
		            <thead>
		              <tr>
		                <th scope="col"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
		                <th scope="col"><?php echo lang('Column.column_firstname', array(), $lang->getBackEndLocale()); ?></th>
		                <th scope="col"><?php echo lang('Column.column_lastname', array(), $lang->getBackEndLocale()); ?></th>
		                <th scope="col"><?php echo lang('Column.column_email', array(), $lang->getBackEndLocale()); ?></th>
		                <th scope="col"><?php echo lang('Column.column_user_group', array(), $lang->getBackEndLocale()); ?></th>
		                <th scope="col"><?php echo lang('Column.column_action', array(), $lang->getBackEndLocale()); ?></th>
		              </tr>
		            </thead>
		            <tbody>
		              <?php if ($users) { ?>
		                <?php foreach ($users as $user) { ?>
		                <tr>
		                  <th scope="row">
		                    <?php if (in_array($user['user_id'], $selected)) { ?>
		                    <input type="checkbox" name="selected[]" value="<?php echo $user['user_id']; ?>" checked="checked" />
		                    <?php } else { ?>
		                    <input type="checkbox" name="selected[]" value="<?php echo $user['user_id']; ?>" />
		                    <?php } ?>
		                  </th>
		                  <td><?php echo $user['firstname']; ?></td>
		                  <td><?php echo $user['lastname']; ?></td>
		                  <td><?php echo $user['email']; ?></td>
		                  <td><?php echo $user['user_group']; ?></td>
		                  <td><a href="<?php echo $user['edit']; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo lang('Button.button_edit', array(), $lang->getBackEndLocale()); ?>"><i class="fa fa-edit"></i></a></td>
		                </tr>
		                <?php } ?>
		              <?php } else { ?>
		                <tr>
		                  <td colspan="6" class="text-center text-info"><?php echo lang('Error.error_no_data_found', array(), $lang->getBackEndLocale()); ?></td>
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
