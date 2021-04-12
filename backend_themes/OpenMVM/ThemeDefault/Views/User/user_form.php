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
    <?php echo form_open($action); ?>
    <div class="clearfix mb-3">
	    <div class="float-end">
	      <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_save', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-save"></i></button>
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/administrators/' . $administrator_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
	    </div>
    </div>
		<div class="accordion" id="accordionAdministratorGroup">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingAdministratorGroup">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdministratorGroup" aria-expanded="true" aria-controls="collapseAdministratorGroup">
		        <i class="fas fa-user fa-fw"></i>&nbsp;&nbsp;<?php echo $heading_title; ?>
		      </button>
		    </h2>
		    <div id="collapseAdministratorGroup" class="accordion-collapse collapse show" aria-labelledby="headingAdministratorGroup" data-bs-parent="#accordionAdministratorGroup">
		      <div class="accordion-body">

			      <ul class="nav nav-tabs mb-3" id="userTab" role="tablist">
			        <li class="nav-item">
			          <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.tab_general', array(), $lang->getBackEndLocale()); ?></button>
			        </li>
			        <li class="nav-item">
			          <button class="nav-link" id="addresses-tab" data-bs-toggle="tab" data-bs-target="#addresses" type="button" role="tab" aria-controls="addresses" aria-selected="true"><?php echo lang('Tab.tab_addresses', array(), $lang->getBackEndLocale()); ?></button>
			        </li>
			      </ul>
			      <div class="tab-content mt-3" id="userTabContent">
			        <div class="tab-pane show active" id="general" role="tabpanel" aria-labelledby="general-tab">
			          <fieldset>
									<div class="form-floating mb-3">
									  <select name="user_group_id" class="form-select" id="input-user-group-id" aria-label="user-group-id">
			                <?php foreach ($user_groups as $user_group) { ?>
			                  <?php if ($user_group['user_group_id'] == $user_group_id) { ?>
			                    <option value="<?php echo $user_group['user_group_id']; ?>" selected="selected"><?php echo $user_group['name']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $user_group['user_group_id']; ?>"><?php echo $user_group['name']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-user-group-id"><?php echo lang('Entry.entry_user_group', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="username" value="<?php echo $username; ?>" class="form-control<?php if ($validation->hasError('username')) { ?> is-invalid<?php } ?>" id="input-username" placeholder="<?php echo lang('Entry.entry_username', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-username"><?php echo lang('Entry.entry_username', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('username')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('username'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="firstname" value="<?php echo $firstname; ?>" class="form-control<?php if ($validation->hasError('firstname')) { ?> is-invalid<?php } ?>" id="input-firstname" placeholder="<?php echo lang('Entry.entry_firstname', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-firstname"><?php echo lang('Entry.entry_firstname', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('firstname')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('firstname'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="lastname" value="<?php echo $lastname; ?>" class="form-control<?php if ($validation->hasError('lastname')) { ?> is-invalid<?php } ?>" id="input-lastname" placeholder="<?php echo lang('Entry.entry_lastname', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-lastname"><?php echo lang('Entry.entry_lastname', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('lastname')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('lastname'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="text" name="email" value="<?php echo $email; ?>" class="form-control<?php if ($validation->hasError('email')) { ?> is-invalid<?php } ?>" id="input-email" placeholder="<?php echo lang('Entry.entry_email', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-email"><?php echo lang('Entry.entry_email', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('email')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('email'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="password" name="password" value="<?php echo $password; ?>" class="form-control<?php if ($validation->hasError('password')) { ?> is-invalid<?php } ?>" id="input-password" placeholder="<?php echo lang('Entry.entry_password', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-password"><?php echo lang('Entry.entry_password', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('password')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('password'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="password" name="passconf" value="<?php echo $passconf; ?>" class="form-control<?php if ($validation->hasError('passconf')) { ?> is-invalid<?php } ?>" id="input-passconf" placeholder="<?php echo lang('Entry.entry_passconf', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-passconf"><?php echo lang('Entry.entry_passconf', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('passconf')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('passconf'); ?></div>
	                	<?php } ?>
									</div>
									<div class="form-floating mb-3">
									  <select name="status" class="form-select" id="input-status" aria-label="status">
		                  <?php if ($status) { ?>
		                    <option value="1" selected><?php echo lang('Text.text_enabled', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0"><?php echo lang('Text.text_disabled', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="1"><?php echo lang('Text.text_enabled', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0" selected><?php echo lang('Text.text_disabled', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-status"><?php echo lang('Entry.entry_status', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="approved" class="form-select" id="input-approved" aria-label="status">
		                  <?php if ($approved) { ?>
		                    <option value="1" selected><?php echo lang('Text.text_yes', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0"><?php echo lang('Text.text_no', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } else { ?>
		                    <option value="1"><?php echo lang('Text.text_yes', array(), $lang->getBackEndLocale()); ?></option>
		                    <option value="0" selected><?php echo lang('Text.text_no', array(), $lang->getBackEndLocale()); ?></option>
		                  <?php } ?>
									  </select>
									  <label for="input-approved"><?php echo lang('Entry.entry_approved', array(), $lang->getBackEndLocale()); ?></label>
									</div>
			          </fieldset>
			        </div>
			        <div class="tab-pane" id="addresses" role="tabpanel" aria-labelledby="addresses-tab">
			          <div class="row">
			            <div class="col-sm-2">
			              <div class="nav flex-column nav-pills" id="user-address-pills-tab" role="tablist" aria-orientation="vertical">
			                <?php $user_address_row = 1; ?>
			                <?php foreach ($user_addresses as $user_address) { ?>
			                  <a class="nav-link" id="user-address-pills-<?php echo $user_address_row; ?>-tab" data-bs-toggle="pill" data-bs-target="#user-address-pills-<?php echo $user_address_row; ?>" role="tab" aria-controls="user-address-pills-<?php echo $user_address_row; ?>" aria-selected="false"><i class="fas fa-minus-circle fa-fw" onclick="removeUserAddress('<?php echo $user_address_row; ?>');"></i> <?php echo lang('Tab.tab_address', array(), $lang->getBackEndLocale()); ?> <?php echo $user_address_row; ?></a>
			                  <?php $user_address_row++; ?>
			                <?php } ?>
			                <a href="javascript:void(0);" class="btn btn-secondary btn-block mt-3" id="user-address-pills-add-tab" onclick="addUserAddress();"><i class="fa fa-plus fa-fw"></i></a>
			              </div>
			            </div>
			            <div id="user-addresses" class="col-sm-10">
			              <div class="tab-content" id="user-address-pills-tabContent">
			                <?php $user_address_row = 1; ?>
			                <?php foreach ($user_addresses as $user_address) { ?>
			                  <input type="hidden" name="user_address[<?php echo $user_address_row; ?>][user_address_id]" value="<?php echo $user_address['user_address_id']; ?>" />
			                  <div class="tab-pane fade" id="user-address-pills-<?php echo $user_address_row; ?>" role="tabpanel" aria-labelledby="user-address-pills-<?php echo $user_address_row; ?>-tab">
			                    <fieldset>
												  	<div class="form-floating mb-3">
														  <input type="text" name="user_address[<?php echo $user_address_row; ?>][firstname]" value="<?php echo $user_address['firstname']; ?>" class="form-control" id="input-user-address-firstname-<?php echo $user_address_row; ?>" placeholder="<?php echo lang('Entry.entry_firstname', array(), $lang->getBackEndLocale()); ?>">
														  <label for="input-user-address-firstname-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_firstname', array(), $lang->getBackEndLocale()); ?></label>
														</div>
												  	<div class="form-floating mb-3">
														  <input type="text" name="user_address[<?php echo $user_address_row; ?>][lastname]" value="<?php echo $user_address['lastname']; ?>" class="form-control" id="input-user-address-lastname-<?php echo $user_address_row; ?>" placeholder="<?php echo lang('Entry.entry_lastname', array(), $lang->getBackEndLocale()); ?>">
														  <label for="input-user-address-lastname-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_lastname', array(), $lang->getBackEndLocale()); ?></label>
														</div>
												  	<div class="form-floating mb-3">
														  <textarea style="height: 100px" name="user_address[<?php echo $user_address_row; ?>][address_1]" class="form-control" id="input-user-address-address-1-<?php echo $user_address_row; ?>" placeholder="<?php echo lang('Entry.entry_address_1', array(), $lang->getFrontEndLocale()); ?>"><?php echo $address_1; ?></textarea>
														  <label for="input-user-address-address-1-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_address_1', array(), $lang->getFrontEndLocale()); ?></label>
														</div>
												  	<div class="form-floating mb-3">
														  <textarea style="height: 100px" name="user_address[<?php echo $user_address_row; ?>][address_2]" class="form-control" id="input-user-address-address-2-<?php echo $user_address_row; ?>" placeholder="<?php echo lang('Entry.entry_address_2', array(), $lang->getFrontEndLocale()); ?>"><?php echo $address_2; ?></textarea>
														  <label for="input-user-address-address-2-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_address_2', array(), $lang->getFrontEndLocale()); ?></label>
														</div>
														<div class="form-floating mb-3">
														  <select name="user_address[<?php echo $user_address_row; ?>][country_id]" class="form-select" id="input-user-address-country-id-<?php echo $user_address_row; ?>" aria-label="input-user-address-country-id-<?php echo $user_address_row; ?>">
		                            <?php foreach ($countries as $country) { ?>
		                              <?php if ($country['country_id'] == $user_address['country_id']) { ?>
		                                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
		                              <?php } else { ?>
		                                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
		                              <?php } ?>
		                            <?php } ?>
														  </select>
														  <label for="input-user-address-country-id-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_country', array(), $lang->getBackEndLocale()); ?></label>
														</div>
														<div id="state-id-container-<?php echo $user_address_row; ?>" class="form-floating mb-3">
														  <select name="user_address[<?php echo $user_address_row; ?>][state_id]" class="form-select" id="input-user-address-state-id-<?php echo $user_address_row; ?>" aria-label="input-user-address-state-id-<?php echo $user_address_row; ?>">
														  </select>
														  <label for="input-user-address-state-id-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_state', array(), $lang->getBackEndLocale()); ?></label>
														</div>
												  	<div id="state-container-<?php echo $user_address_row; ?>" class="form-floating mb-3">
														  <input type="text" name="user_address[<?php echo $user_address_row; ?>][state]" value="<?php echo $user_address['state']; ?>" class="form-control" id="input-user-address-state-<?php echo $user_address_row; ?>" placeholder="<?php echo lang('Entry.entry_state', array(), $lang->getFrontEndLocale()); ?>">
														  <label for="input-user-address-state-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_state', array(), $lang->getFrontEndLocale()); ?></label>
														</div>
														<div id="city-id-container-<?php echo $user_address_row; ?>" class="form-floating mb-3">
														  <select name="user_address[<?php echo $user_address_row; ?>][city_id]" class="form-select" id="input-user-address-city-id-<?php echo $user_address_row; ?>" aria-label="input-user-address-city-id-<?php echo $user_address_row; ?>">
														  </select>
														  <label for="input-user-address-city-id-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_city', array(), $lang->getBackEndLocale()); ?></label>
														</div>
												  	<div id="city-container-<?php echo $user_address_row; ?>" class="form-floating mb-3">
														  <input type="text" name="user_address[<?php echo $user_address_row; ?>][city]" value="<?php echo $user_address['city']; ?>" class="form-control" id="input-user-address-city-<?php echo $user_address_row; ?>" placeholder="<?php echo lang('Entry.entry_city', array(), $lang->getFrontEndLocale()); ?>">
														  <label for="input-user-address-city-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_city', array(), $lang->getFrontEndLocale()); ?></label>
														</div>
														<div id="district-id-container-<?php echo $user_address_row; ?>" class="form-floating mb-3">
														  <select name="user_address[<?php echo $user_address_row; ?>][district_id]" class="form-select" id="input-user-address-district-id-<?php echo $user_address_row; ?>" aria-label="input-user-address-district-id-<?php echo $user_address_row; ?>">
														  </select>
														  <label for="input-user-address-district-id-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_district', array(), $lang->getBackEndLocale()); ?></label>
														</div>
												  	<div id="district-container-<?php echo $user_address_row; ?>" class="form-floating mb-3">
														  <input type="text" name="user_address[<?php echo $user_address_row; ?>][district]" value="<?php echo $user_address['district']; ?>" class="form-control" id="input-user-address-district-<?php echo $user_address_row; ?>" placeholder="<?php echo lang('Entry.entry_district', array(), $lang->getFrontEndLocale()); ?>">
														  <label for="input-user-address-district-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_district', array(), $lang->getFrontEndLocale()); ?></label>
														</div>
												  	<div class="form-floating mb-3">
														  <input type="text" name="user_address[<?php echo $user_address_row; ?>][postal_code]" value="<?php echo $user_address['postal_code']; ?>" class="form-control" id="input-user-address-postal-code-<?php echo $user_address_row; ?>" placeholder="<?php echo lang('Entry.entry_postal_code', array(), $lang->getBackEndLocale()); ?>">
														  <label for="input-user-address-postal-code-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_postal_code', array(), $lang->getBackEndLocale()); ?></label>
														</div>
												  	<div class="form-floating mb-3">
														  <input type="text" name="user_address[<?php echo $user_address_row; ?>][telephone]" value="<?php echo $user_address['telephone']; ?>" class="form-control" id="input-user-address-telephone-<?php echo $user_address_row; ?>" placeholder="<?php echo lang('Entry.entry_telephone', array(), $lang->getBackEndLocale()); ?>">
														  <label for="input-user-address-telephone-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_telephone', array(), $lang->getBackEndLocale()); ?></label>
														</div>
														<div class="form-floating mb-3">
														  <select name="user_address[<?php echo $user_address_row; ?>][is_default]" class="form-select" id="input-user-address-is-default-<?php echo $user_address_row; ?>" aria-label="input-user-address-is-default-<?php echo $user_address_row; ?>">
		                            <?php if ($user_address['user_address_id'] == $user_address_id) { ?>
		                              <option value="1" selected="selected"><?php echo lang('Text.text_yes', array(), $lang->getBackEndLocale()); ?></option>
		                              <option value="0"><?php echo lang('Text.text_no', array(), $lang->getBackEndLocale()); ?></option>
		                            <?php } else { ?>
		                              <option value="1"><?php echo lang('Text.text_yes', array(), $lang->getBackEndLocale()); ?></option>
		                              <option value="0" selected="selected"><?php echo lang('Text.text_no', array(), $lang->getBackEndLocale()); ?></option>
		                            <?php } ?>
														  </select>
														  <label for="input-user-address-is-default-<?php echo $user_address_row; ?>"><?php echo lang('Entry.entry_default_address', array(), $lang->getBackEndLocale()); ?></label>
														</div>
			                    </fieldset>
			                  </div>
			                  <script type="text/javascript"><!--
			                    $( document ).ready(function() {
			                      selectCountry(<?php echo $user_address_row; ?>, <?php echo $user_address['state_id']; ?>);
			                      selectState(<?php echo $user_address_row; ?>, <?php echo $user_address['city_id']; ?>);
			                      selectCity(<?php echo $user_address_row; ?>, <?php echo $user_address['district_id']; ?>);
			                    });
			                  --></script>
			                  <?php $user_address_row++; ?>
			                <?php } ?>
			              </div>
			            </div>
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
var element = document.querySelector('#user-address-pills-tab a:first-child');
var tab = bootstrap.Tab.getInstance(element);
if( !tab )
    tab = new bootstrap.Tab(element);
tab.show();

var user_address_row = '<?php echo $user_address_row; ?>';

function addUserAddress() {
  html = '<div class="tab-pane fade" id="user-address-pills-' + user_address_row + '" role="tabpanel" aria-labelledby="user-address-pills-' + user_address_row + '-tab">';
  html += '  <legend class="border-bottom border-info mb-3"><?php echo lang('Legend.legend_address', array(), $lang->getBackEndLocale()); ?> ' + user_address_row + '</legend>';
  html += '  <fieldset>';
	html += '		 <div class="form-floating mb-3">';
	html += '		   <input type="text" name="user_address[' + user_address_row + '][firstname]" value="" class="form-control" id="input-user-address-firstname-' + user_address_row + '" placeholder="<?php echo lang('Entry.entry_firstname', array(), $lang->getBackEndLocale()); ?>">';
	html += '		   <label for="input-user-address-firstname-' + user_address_row + '"><?php echo lang('Entry.entry_firstname', array(), $lang->getBackEndLocale()); ?></label>';
	html += '		 </div>';
	html += '		 <div class="form-floating mb-3">';
	html += '		   <input type="text" name="user_address[' + user_address_row + '][lastname]" value="" class="form-control" id="input-user-address-lastname-' + user_address_row + '" placeholder="<?php echo lang('Entry.entry_lastname', array(), $lang->getBackEndLocale()); ?>">';
	html += '		   <label for="input-user-address-lastname-' + user_address_row + '"><?php echo lang('Entry.entry_lastname', array(), $lang->getBackEndLocale()); ?></label>';
	html += '		 </div>';
	html += '		 <div class="form-floating mb-3">';
	html += '		   <textarea style="height: 100px" name="user_address[' + user_address_row + '][address_1]" class="form-control" id="input-user-address-address-1-[' + user_address_row + '" placeholder="<?php echo lang('Entry.entry_address_1', array(), $lang->getFrontEndLocale()); ?>"></textarea>';
	html += '		   <label for="input-user-address-address-1-[' + user_address_row + '"><?php echo lang('Entry.entry_address_1', array(), $lang->getFrontEndLocale()); ?></label>';
	html += '		 </div>';
	html += '		 <div class="form-floating mb-3">';
	html += '		   <textarea style="height: 100px" name="user_address[' + user_address_row + '][address_2]" class="form-control" id="input-user-address-address-2-[' + user_address_row + '" placeholder="<?php echo lang('Entry.entry_address_2', array(), $lang->getFrontEndLocale()); ?>"></textarea>';
	html += '		   <label for="input-user-address-address-2-[' + user_address_row + '"><?php echo lang('Entry.entry_address_2', array(), $lang->getFrontEndLocale()); ?></label>';
	html += '		 </div>';
	html += '    <div class="form-floating mb-3">';
	html += '      <select name="user_address[' + user_address_row + '][country_id]" class="form-select" id="input-user-address-country-id-' + user_address_row + '" aria-label="input-user-address-country-id-' + user_address_row + '">';
  <?php foreach ($countries as $country) { ?>
    html += '        <option value="<?php echo $country['country_id']; ?>"><?php echo addslashes($country['name']); ?></option>';
  <?php } ?>
	html += '      </select>';
	html += '      <label for="input-user-address-country-id-' + user_address_row + '"><?php echo lang('Entry.entry_country', array(), $lang->getBackEndLocale()); ?></label>';
	html += '    </div>';
	html += '    <div id="state-id-container-' + user_address_row + '" class="form-floating mb-3">';
	html += '      <select name="user_address[' + user_address_row + '][state_id]" class="form-select" id="input-user-address-state-id-' + user_address_row + '" aria-label="input-user-address-state-id-' + user_address_row + '">';
	html += '      </select>';
	html += '      <label for="input-user-address-state-id-' + user_address_row + '"><?php echo lang('Entry.entry_state', array(), $lang->getBackEndLocale()); ?></label>';
	html += '    </div>';
	html += '		 <div id="state-container-' + user_address_row + '" class="form-floating mb-3">';
	html += '		   <input type="text" name="user_address[' + user_address_row + '][state]" value="" class="form-control" id="input-user-address-state-' + user_address_row + '" placeholder="<?php echo lang('Entry.entry_state', array(), $lang->getBackEndLocale()); ?>">';
	html += '		   <label for="input-user-address-state-' + user_address_row + '"><?php echo lang('Entry.entry_state', array(), $lang->getBackEndLocale()); ?></label>';
	html += '		 </div>';
	html += '    <div id="city-id-container-' + user_address_row + '" class="form-floating mb-3">';
	html += '      <select name="user_address[' + user_address_row + '][city_id]" class="form-select" id="input-user-address-city-id-' + user_address_row + '" aria-label="input-user-address-city-id-' + user_address_row + '">';
	html += '      </select>';
	html += '      <label for="input-user-address-city-id-' + user_address_row + '"><?php echo lang('Entry.entry_city', array(), $lang->getBackEndLocale()); ?></label>';
	html += '    </div>';
	html += '		 <div id="city-container-' + user_address_row + '" class="form-floating mb-3">';
	html += '		   <input type="text" name="user_address[' + user_address_row + '][city]" value="" class="form-control" id="input-user-address-city-' + user_address_row + '" placeholder="<?php echo lang('Entry.entry_city', array(), $lang->getBackEndLocale()); ?>">';
	html += '		   <label for="input-user-address-city-' + user_address_row + '"><?php echo lang('Entry.entry_city', array(), $lang->getBackEndLocale()); ?></label>';
	html += '		 </div>';
	html += '    <div id="district-id-container-' + user_address_row + '" class="form-floating mb-3">';
	html += '      <select name="user_address[' + user_address_row + '][district_id]" class="form-select" id="input-user-address-district-id-' + user_address_row + '" aria-label="input-user-address-district-id-' + user_address_row + '">';
	html += '      </select>';
	html += '      <label for="input-user-address-district-id-' + user_address_row + '"><?php echo lang('Entry.entry_district', array(), $lang->getBackEndLocale()); ?></label>';
	html += '    </div>';
	html += '		 <div id="district-container-' + user_address_row + '" class="form-floating mb-3">';
	html += '		   <input type="text" name="user_address[' + user_address_row + '][district]" value="" class="form-control" id="input-user-address-district-' + user_address_row + '" placeholder="<?php echo lang('Entry.entry_district', array(), $lang->getBackEndLocale()); ?>">';
	html += '		   <label for="input-user-address-district-' + user_address_row + '"><?php echo lang('Entry.entry_district', array(), $lang->getBackEndLocale()); ?></label>';
	html += '		 </div>';
	html += '		 <div class="form-floating mb-3">';
	html += '		   <input type="text" name="user_address[' + user_address_row + '][postal_code]" value="" class="form-control" id="input-user-address-postal-code-' + user_address_row + '" placeholder="<?php echo lang('Entry.entry_postal_code', array(), $lang->getBackEndLocale()); ?>">';
	html += '		   <label for="input-user-address-postal-code-' + user_address_row + '"><?php echo lang('Entry.entry_postal_code', array(), $lang->getBackEndLocale()); ?></label>';
	html += '		 </div>';
	html += '		 <div class="form-floating mb-3">';
	html += '		   <input type="text" name="user_address[' + user_address_row + '][telephone]" value="" class="form-control" id="input-user-address-telephone-' + user_address_row + '" placeholder="<?php echo lang('Entry.entry_telephone', array(), $lang->getBackEndLocale()); ?>">';
	html += '		   <label for="input-user-address-telephone-' + user_address_row + '"><?php echo lang('Entry.entry_telephone', array(), $lang->getBackEndLocale()); ?></label>';
	html += '		 </div>';
	html += '    <div class="form-floating mb-3">';
	html += '      <select name="is_default" class="form-select" id="input-is-default" aria-label="is-default">';
  html += '        <option value="1"><?php echo lang('Text.text_yes', array(), $lang->getBackEndLocale()); ?></option>';
  html += '        <option value="0" selected="selected"><?php echo lang('Text.text_no', array(), $lang->getBackEndLocale()); ?></option>';
	html += '      </select>';
	html += '      <label for="input-is-default"><?php echo lang('Entry.entry_default_address', array(), $lang->getBackEndLocale()); ?></label>';
	html += '    </div>';
  html += '  </fieldset>';
  html += '</div>';

  $('#user-addresses .tab-content').append(html);

  $('#user-address-pills-add-tab').before('<a class="nav-link" id="user-address-pills-' + user_address_row + '-tab" data-bs-toggle="pill" data-bs-target="#user-address-pills-' + user_address_row + '" role="tab" aria-controls="user-address-pills-' + user_address_row + '" aria-selected="false"><i class="fas fa-minus-circle fa-fw" onclick="removeUserAddress(\'' + user_address_row + '\');"></i> <?php echo lang('Tab.tab_address', array(), $lang->getBackEndLocale()); ?> ' + user_address_row + '</a>');

  $('#user-address-pills-' + user_address_row + '-tab').tab('show');

  $('select[class="form-control is-default"]').on('change', function() {
    $('select[class="form-control is-default"]').not(this).val(0);
  });

  selectCountry(user_address_row, 0);
  selectState(user_address_row, 0);
  selectCity(user_address_row, 0);
  selectDistrict(user_address_row);

  user_address_row++;
}

function removeUserAddress(user_address_row) {
  $('#user-address-pills-' + user_address_row + '-tab').remove();
  $('#user-address-pills-' + user_address_row).remove();
  $('#user-address-pills-tab a:first').tab('show');
}
--></script>
<script type="text/javascript"><!--
$('select[class="form-control is-default"]').on('change', function() {
  $('select[class="form-control is-default"]').not(this).val(0);
});
--></script>
<script type="text/javascript"><!--
function selectCountry(user_address_row, state_id) {
  $('select[name=\'user_address[' + user_address_row + '][country_id]\']').on('change', function() {
    $.ajax({
      url: '<?php echo base_url($_SERVER['app.adminDir'] . '/localisation/countries/get_country/' . $administrator_token); ?>',
      type: 'post',
      dataType: 'json',
      data : {
        country_id : $('select[name=\'user_address[' + user_address_row + '][country_id]\']').val()
      },
      beforeSend: function() {
        $('select[name=\'user_address[' + user_address_row + '][country_id]\']').prop('disabled', true);
      },
      complete: function() {
        $('select[name=\'user_address[' + user_address_row + '][country_id]\']').prop('disabled', false);
      },
      success: function(json) {
	    	if (json['state_input_type'] == 'select_box') {
	    		$('#state-container-' + user_address_row).addClass('d-none');

	        html = '<option value=""><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>';
	        
	        if (json['states'] && json['states'] != '') {
	          for (i = 0; i < json['states'].length; i++) {
	            state = json['states'][i];

	            html += '<option value="' + state['state_id'] + '"';
	            
	            if (state['state_id'] == state_id) {
	              html += ' selected="selected"';
	            }
	            
	            html += '>' + state['name'] + '</option>';
	          }
	        } else {
	          html += '<option value="0" selected="selected"><?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?></option>';
	        }
	        
    		  $('#state-id-container-' + user_address_row).removeClass('d-none');
	        $('select[name=\'user_address[' + user_address_row + '][state_id]\']').html(html);
	        $('select[name=\'user_address[' + user_address_row + '][state_id]\']').trigger('change');
	    	} else {
	    		$('#state-id-container-' + user_address_row).addClass('d-none');
	    		$('#state-container-' + user_address_row).removeClass('d-none');
	    	}
		      
	    	if (json['city_input_type'] == 'select_box') {
	    		$('#city-container-' + user_address_row).addClass('d-none');
	    		$('#city-id-container-' + user_address_row).removeClass('d-none');
	    	} else {
	    		$('#city-id-container-' + user_address_row).addClass('d-none');
	    		$('#city-container-' + user_address_row).removeClass('d-none');
	    	}
		      
	    	if (json['district_input_type'] == 'select_box') {
	    		$('#district-container-' + user_address_row).addClass('d-none');
	    		$('#district-id-container-' + user_address_row).removeClass('d-none');
	    	} else {
	    		$('#district-id-container-' + user_address_row).addClass('d-none');
	    		$('#district-container-' + user_address_row).removeClass('d-none');
	    	}
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  });

  $('select[name=\'user_address[' + user_address_row + '][country_id]\']').trigger('change');
}
//--></script> 
<script type="text/javascript"><!--
function selectState(user_address_row, city_id) {
  $('select[name=\'user_address[' + user_address_row + '][state_id]\']').on('change', function() {
    setTimeout(function(){
      var state_id = $('select[name=\'user_address[' + user_address_row + '][state_id]\']').val();
      $.ajax({
        url: '<?php echo base_url($_SERVER['app.adminDir'] . '/localisation/states/get_state/' . $administrator_token); ?>',
        type: 'post',
        dataType: 'json',
        data : {
          state_id : state_id
        },
        beforeSend: function() {
          $('select[name=\'user_address[' + user_address_row + '][state_id]\']').prop('disabled', true);
          $('select[name=\'user_address[' + user_address_row + '][city_id]\']').prop('disabled', true);
        },
        complete: function() {
          $('select[name=\'user_address[' + user_address_row + '][state_id]\']').prop('disabled', false);
          $('select[name=\'user_address[' + user_address_row + '][city_id]\']').prop('disabled', false);
        },
        success: function(json) {
          html = '<option value=""><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>';
          
          if (json['cities'] && json['cities'] != '') {
            for (i = 0; i < json['cities'].length; i++) {
              city = json['cities'][i];

              html += '<option value="' + city['city_id'] + '"';
              
              if (city['city_id'] == city_id) {
                html += ' selected="selected"';
              }
              
              html += '>' + city['name'] + '</option>';
            }
          } else {
            html += '<option value="0" selected="selected"><?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?></option>';
          }
          
	        if (json['state_input_type'] == 'select_box') {
	          $('input[name=\'user_address[' + user_address_row + '][state]\']').val(json['name']);
	        }
          $('select[name=\'user_address[' + user_address_row + '][city_id]\']').html(html);
          $('select[name=\'user_address[' + user_address_row + '][city_id]\']').trigger('change');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    }, 200);
  });

  $('select[name=\'user_address[' + user_address_row + '][state_id]\']').trigger('change');
}
//--></script> 
<script type="text/javascript"><!--
function selectCity(user_address_row, district_id) {
  $('select[name=\'user_address[' + user_address_row + '][city_id]\']').on('change', function() {
    setTimeout(function(){
      var city_id = $('select[name=\'user_address[' + user_address_row + '][city_id]\']').val();
      $.ajax({
        url: '<?php echo base_url($_SERVER['app.adminDir'] . '/localisation/cities/get_city/' . $administrator_token); ?>',
        type: 'post',
        dataType: 'json',
        data : {
          city_id : city_id
        },
        beforeSend: function() {
          $('select[name=\'user_address[' + user_address_row + '][city_id]\']').prop('disabled', true);
          $('select[name=\'user_address[' + user_address_row + '][district_id]\']').prop('disabled', true);
        },
        complete: function() {
          $('select[name=\'user_address[' + user_address_row + '][city_id]\']').prop('disabled', false);
          $('select[name=\'user_address[' + user_address_row + '][district_id]\']').prop('disabled', false);
        },
        success: function(json) {
          html = '<option value=""><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>';
          
          if (json['districts'] && json['districts'] != '') {
            for (i = 0; i < json['districts'].length; i++) {
              district = json['districts'][i];

              html += '<option value="' + district['district_id'] + '"';
              
              if (district['district_id'] == district_id) {
                html += ' selected="selected"';
              }
              
              html += '>' + district['name'] + '</option>';
            }
          } else {
            html += '<option value="0" selected="selected"><?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?></option>';
          }
          
	        if (json['city_input_type'] == 'select_box') {
	        	$('input[name=\'user_address[' + user_address_row + '][city]\']').val(json['name']);
	        }
          $('select[name=\'user_address[' + user_address_row + '][district_id]\']').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    }, 400);
  });

  $('select[name=\'user_address[' + user_address_row + '][city_id]\']').trigger('change');
}
//--></script> 
<script type="text/javascript"><!--
function selectDistrict(user_address_row) {
  $('select[name=\'user_address[' + user_address_row + '][district_id]\']').on('change', function() {
    setTimeout(function(){
      var district_id = $('select[name=\'user_address[' + user_address_row + '][district_id]\']').val();
      $.ajax({
        url: '<?php echo base_url($_SERVER['app.adminDir'] . '/localisation/districts/get_district/' . $administrator_token); ?>',
        type: 'post',
        dataType: 'json',
        data : {
          district_id : district_id
        },
        beforeSend: function() {
          $('select[name=\'user_address[' + user_address_row + '][district_id]\']').prop('disabled', true);
        },
        complete: function() {
          $('select[name=\'user_address[' + user_address_row + '][district_id]\']').prop('disabled', false);
        },
        success: function(json) {
	        if (json['district_input_type'] == 'select_box') {
	        	$('input[name=\'user_address[' + user_address_row + '][district]\']').val(json['name']);
	        }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    }, 400);
  });

  $('select[name=\'user_address[' + user_address_row + '][district_id]\']').trigger('change');
}
//--></script> 
<?php echo $footer; ?>
