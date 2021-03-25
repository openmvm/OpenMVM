<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-images fa-fw"></i> <?php echo $heading_title; ?></h2>
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
    <?php echo form_open($action); ?>
    <div class="clearfix mb-3">
	    <div class="float-end">
	      <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_save', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-save"></i></button>
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/frontend_layouts/' . $administrator_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
	    </div>
    </div>
		<div class="accordion" id="accordionAdministratorGroup">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingAdministratorGroup">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdministratorGroup" aria-expanded="true" aria-controls="collapseAdministratorGroup">
		        <i class="fas fa-images fa-fw"></i>&nbsp;&nbsp;<?php echo $heading_title; ?>
		      </button>
		    </h2>
		    <div id="collapseAdministratorGroup" class="accordion-collapse collapse show" aria-labelledby="headingAdministratorGroup" data-bs-parent="#accordionAdministratorGroup">
		      <div class="accordion-body">

		        <ul class="nav nav-tabs" id="frontendLayoutTab" role="tablist">
		          <li class="nav-item">
		            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.tab_general', array(), $lang->getBackEndLocale()); ?></a>
		          </li>
		        </ul>
		        <div class="tab-content mt-3" id="stateTabContent">
		          <div class="tab-pane show active" id="general" role="tabpanel" aria-labelledby="general-tab">
		            <fieldset>
							  	<div class="form-floating mb-3">
									  <input type="text" name="name" value="<?php echo $name; ?>" class="form-control<?php if ($validation->hasError('name')) { ?> is-invalid<?php } ?>" id="input-name" placeholder="<?php echo lang('Entry.entry_name', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-name"><?php echo lang('Entry.entry_name', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('name')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('name'); ?></div>
	                	<?php } ?>
									</div>
		            </fieldset>
		            <div class="table-responsive">
									<table id="route" class="table table-hover">
									  <thead>
									    <tr>
									      <th scope="col"><?php echo lang('Entry.entry_uri_string', array(), $lang->getBackEndLocale()); ?></th>
                  			<th></th>
									    </tr>
									  </thead>
									  <tbody>
									  	<?php $route_row = 0; ?>
									  	<?php foreach ($layout_routes as $layout_route) { ?>
									    <tr id="route-row<?php echo $route_row; ?>">
									      <td>
											  	<div class="form-floating mb-3">
													  <input type="text" name="layout_route[<?php echo $route_row; ?>][route]" value="<?php echo $layout_route['route']; ?>" class="form-control" id="input-layout-route<?php echo $route_row; ?>" placeholder="<?php echo lang('Entry.entry_uri_string', array(), $lang->getBackEndLocale()); ?>">
													  <label for="input-layout-route<?php echo $route_row; ?>"><?php echo lang('Entry.entry_uri_string', array(), $lang->getBackEndLocale()); ?></label>
													</div>
									      </td>
			                  <td class="text-left"><button type="button" onclick="$('#route-row<?php echo $route_row; ?>').remove();" data-bs-toggle="tooltip" title="<?php echo lang('Button.button_remove', array(), $lang->getBackEndLocale()); ?>" class="btn btn-danger"><i class="fas fa-minus-circle"></i></button></td>
									    </tr>
									  	<?php $route_row = $route_row + 1; ?>
									  	<?php } ?>
									  </tbody>
			              <tfoot>
			                <tr>
			                  <td class="text-start"><button type="button" onclick="addRoute();" data-bs-toggle="tooltip" title="<?php echo lang('Button.button_route_add', array(), $lang->getBackEndLocale()); ?>" class="btn btn-primary"><i class="fas fa-plus-circle"></i></button></td>
			                </tr>
			              </tfoot>
									</table>
		            </div>
		          </div>
		        </div>

		      </div>
		    </div>
		  </div>
		</div>
    <?php echo form_close(); ?>
	</section>
  <!-- /.content -->
  <script type="text/javascript"><!--
var route_row = '<?php echo $route_row; ?>';

function addRoute() {
	html  = '<tr id="route-row' + route_row + '">';
	html += '  <td class="text-left">';
	html += '    <div class="form-floating mb-3">';
	html += '      <input type="text" name="layout_route[' + route_row + '][route]" value="" class="form-control" id="input-layout-route' + route_row + '" placeholder="<?php echo lang('Entry.entry_uri_string', array(), $lang->getBackEndLocale()); ?>">';
	html += '      <label for="input-layout-route' + route_row + '"><?php echo lang('Entry.entry_uri_string', array(), $lang->getBackEndLocale()); ?></label>';
	html += '    </div>';
	html += '  </td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#route-row' + route_row + '\').remove();" data-bs-toggle="tooltip" title="<?php echo lang('Button.button_remove', array(), $lang->getBackEndLocale()); ?>" class="btn btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
	html += '</tr>';
	
	$('#route tbody').append(html);
	
	route_row++;
}
//--></script> 
<?php echo $footer; ?>
