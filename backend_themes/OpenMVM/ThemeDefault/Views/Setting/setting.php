<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-cog fa-fw"></i> <?php echo $heading_title; ?></h2>
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
    <?php echo form_open(base_url($_SERVER['app.adminDir'] . '/setting/' . $administrator_token)); ?>
    <div class="clearfix mb-3">
	    <div class="float-end">
	      <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_save', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-save"></i></button>
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/dashboard/' . $administrator_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
	    </div>
    </div>
		<div class="accordion" id="accordionSetting">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingSetting">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
		        <i class="fas fa-edit fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_edit_setting', array(), $lang->getBackEndLocale()); ?>
		      </button>
		    </h2>
		    <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionSetting">
		      <div class="accordion-body">
						<ul class="nav nav-tabs mb-3" id="tab-setting" role="tablist">
						  <li class="nav-item" role="presentation">
						    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.tab_general', array(), $lang->getBackEndLocale()); ?></button>
						  </li>
						  <li class="nav-item" role="presentation">
						    <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="false"><?php echo lang('Tab.tab_data', array(), $lang->getBackEndLocale()); ?></button>
						  </li>
						  <li class="nav-item" role="presentation">
						    <button class="nav-link" id="options-tab" data-bs-toggle="tab" data-bs-target="#options" type="button" role="tab" aria-controls="options" aria-selected="false"><?php echo lang('Tab.tab_options', array(), $lang->getBackEndLocale()); ?></button>
						  </li>
						  <li class="nav-item" role="presentation">
						    <button class="nav-link" id="localisation-tab" data-bs-toggle="tab" data-bs-target="#localisation" type="button" role="tab" aria-controls="localisation" aria-selected="false"><?php echo lang('Tab.tab_localisation', array(), $lang->getBackEndLocale()); ?></button>
						  </li>
						  <li class="nav-item" role="presentation">
						    <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab" aria-controls="images" aria-selected="false"><?php echo lang('Tab.tab_images', array(), $lang->getBackEndLocale()); ?></button>
						  </li>
						</ul>
						<div class="tab-content" id="myTabContent">
						  <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
						  	<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_general', array(), $lang->getBackEndLocale()); ?></h5>
						  	<div class="form-floating mb-3">
								  <input type="text" name="setting_website_name" value="<?php echo $setting_website_name; ?>" class="form-control<?php if ($validation->hasError('setting_website_name')) { ?> is-invalid<?php } ?>" id="input-website-name" placeholder="<?php echo lang('Entry.entry_website_name', array(), $lang->getBackEndLocale()); ?>">
								  <label for="input-website-name"><?php echo lang('Entry.entry_website_name', array(), $lang->getBackEndLocale()); ?></label>
								  <?php if ($validation->hasError('setting_website_name')) { ?>
                  <div class="text-danger small"><?php echo $validation->getError('setting_website_name'); ?></div>
                	<?php } ?>
								</div>
								<ul class="nav nav-tabs mb-3" id="languageTab" role="tablist">
									<?php foreach ($languages as $language) { ?>
								  <li class="nav-item" role="presentation">
								    <button class="nav-link" id="language-<?php echo $language['language_id']; ?>-tab" data-bs-toggle="tab" data-bs-target="#language-<?php echo $language['language_id']; ?>" type="button" role="tab" aria-controls="language-<?php echo $language['language_id']; ?>" aria-selected="false"><?php echo $language['name']; ?></button>
								  </li>
									<?php } ?>
								</ul>
								<div class="tab-content" id="languageTabContent">
									<?php foreach ($languages as $language) { ?>
								  <div class="tab-pane fade" id="language-<?php echo $language['language_id']; ?>" role="tabpanel" aria-labelledby="language-<?php echo $language['language_id']; ?>-tab">
								  	<div class="form-floating mb-3">
										  <textarea name="setting_description[<?php echo $language['language_id']; ?>]" class="form-control tinymce" id="input-description-<?php echo $language['language_id']; ?>" placeholder="<?php echo lang('Entry.entry_description', array(), $lang->getBackEndLocale()); ?>"><?php echo $setting_description[$language['language_id']]; ?></textarea>
										  <label for="input-description-<?php echo $language['language_id']; ?>"><?php echo lang('Entry.entry_description', array(), $lang->getBackEndLocale()); ?></label>
										</div>
								  </div>
									<?php } ?>
								</div>
						  	<h5 class="border-bottom border-dark pb-2 mt-5 mb-3"><?php echo lang('Text.text_metadata', array(), $lang->getBackEndLocale()); ?></h5>
						  	<div class="form-floating mb-3">
								  <input type="text" name="setting_meta_title" value="<?php echo $setting_meta_title; ?>" class="form-control<?php if ($validation->hasError('setting_meta_title')) { ?> is-invalid<?php } ?>" id="input-meta-title" placeholder="<?php echo lang('Entry.entry_meta_title', array(), $lang->getBackEndLocale()); ?>">
								  <label for="input-meta-title"><?php echo lang('Entry.entry_meta_title', array(), $lang->getBackEndLocale()); ?></label>
								  <?php if ($validation->hasError('setting_meta_title')) { ?>
                  <div class="text-danger small"><?php echo $validation->getError('setting_meta_title'); ?></div>
                	<?php } ?>
								</div>
						  	<div class="form-floating mb-3">
								  <textarea style="height: 200px" name="setting_meta_description" class="form-control<?php if ($validation->hasError('setting_meta_description')) { ?> is-invalid<?php } ?>" id="input-meta-description" placeholder="<?php echo lang('Entry.entry_meta_description', array(), $lang->getBackEndLocale()); ?>"><?php echo $setting_meta_description; ?></textarea>
								  <label for="input-meta-description"><?php echo lang('Entry.entry_meta_description', array(), $lang->getBackEndLocale()); ?></label>
								  <?php if ($validation->hasError('setting_meta_description')) { ?>
                  <div class="text-danger small"><?php echo $validation->getError('setting_meta_description'); ?></div>
                	<?php } ?>
								</div>
						  	<div class="form-floating mb-3">
								  <input type="text" name="setting_meta_keywords" value="<?php echo $setting_meta_keywords; ?>" class="form-control<?php if ($validation->hasError('setting_meta_keywords')) { ?> is-invalid<?php } ?>" id="input-meta-keywords" placeholder="<?php echo lang('Entry.entry_meta_keywords', array(), $lang->getBackEndLocale()); ?>">
								  <label for="input-meta-keywords"><?php echo lang('Entry.entry_meta_keywords', array(), $lang->getBackEndLocale()); ?></label>
								  <?php if ($validation->hasError('setting_meta_keywords')) { ?>
                  <div class="text-danger small"><?php echo $validation->getError('setting_meta_keywords'); ?></div>
                	<?php } ?>
								</div>
						  	<h5 class="border-bottom border-dark pb-2 mt-5 mb-3"><?php echo lang('Text.text_themes', array(), $lang->getBackEndLocale()); ?></h5>
								<div class="form-floating mb-3">
								  <select name="setting_backend_theme" class="form-select" id="input-backend-theme" aria-label="backend-theme">
								    <option value="" selected><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>
								    <?php foreach ($backend_themes as $backend_theme) { ?>
								    <option value="<?php echo $backend_theme['id']; ?>"<?php if ($backend_theme['id'] == $setting_backend_theme) { ?> selected<?php } ?>><?php echo $backend_theme['name']; ?></option>
								    <?php } ?>
								  </select>
								  <label for="input-backend-theme"><?php echo lang('Entry.entry_backend_theme', array(), $lang->getBackEndLocale()); ?></label>
								</div>
								<div class="form-floating">
								  <select name="setting_frontend_theme" class="form-select" id="input-frontend-theme" aria-label="frontend-theme">
								    <option value="" selected><?php echo lang('Text.text_select', array(), $lang->getBackEndLocale()); ?></option>
								    <?php foreach ($frontend_themes as $frontend_theme) { ?>
								    <option value="<?php echo $frontend_theme['id']; ?>"<?php if ($frontend_theme['id'] == $setting_frontend_theme) { ?> selected<?php } ?>><?php echo $frontend_theme['name']; ?></option>
								    <?php } ?>
								  </select>
								  <label for="input-frontend-theme"><?php echo lang('Entry.entry_frontend_theme', array(), $lang->getBackEndLocale()); ?></label>
								</div>
						  </div>
						  <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">...</div>
						  <div class="tab-pane fade" id="options" role="tabpanel" aria-labelledby="options-tab">
		            <fieldset>
							  	<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_administrator', array(), $lang->getBackEndLocale()); ?></h5>
									<div class="form-floating mb-3">
									  <select name="setting_default_administrator_group_id" class="form-select" id="input-default-administrator-group-id" aria-label="administrator-default-group-id">
			                <?php foreach ($administrator_groups as $administrator_group) { ?>
			                  <?php if ($administrator_group['administrator_group_id'] == $setting_default_administrator_group_id) { ?>
			                    <option value="<?php echo $administrator_group['administrator_group_id']; ?>" selected="selected"><?php echo $administrator_group['name']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $administrator_group['administrator_group_id']; ?>"><?php echo $administrator_group['name']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-default-administrator-group-id"><?php echo lang('Entry.entry_administrator_group', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_user', array(), $lang->getBackEndLocale()); ?></h5>
									<div class="form-floating mb-3">
									  <select name="setting_default_user_group_id" class="form-select" id="input-default-user-group-id" aria-label="user-default-group-id">
			                <?php foreach ($user_groups as $user_group) { ?>
			                  <?php if ($user_group['user_group_id'] == $setting_default_user_group_id) { ?>
			                    <option value="<?php echo $user_group['user_group_id']; ?>" selected="selected"><?php echo $user_group['name']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $user_group['user_group_id']; ?>"><?php echo $user_group['name']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-default-user-group-id"><?php echo lang('Entry.entry_user_group', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_data_results', array(), $lang->getBackEndLocale()); ?></h5>
							  	<div class="form-floating mb-3">
									  <input type="number" name="setting_backend_items_per_page" value="<?php echo $setting_backend_items_per_page; ?>" class="form-control<?php if ($validation->hasError('setting_backend_items_per_page')) { ?> is-invalid<?php } ?>" id="input-backend-items-per-page" placeholder="<?php echo lang('Entry.entry_backend_items_per_page', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-backend-items-per-page"><?php echo lang('Entry.entry_backend_items_per_page', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('setting_backend_items_per_page')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('setting_backend_items_per_page'); ?></div>
	                	<?php } ?>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="number" name="setting_frontend_items_per_page" value="<?php echo $setting_frontend_items_per_page; ?>" class="form-control<?php if ($validation->hasError('setting_frontend_items_per_page')) { ?> is-invalid<?php } ?>" id="input-frontend-items-per-page" placeholder="<?php echo lang('Entry.entry_frontend_items_per_page', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-frontend-items-per-page"><?php echo lang('Entry.entry_frontend_items_per_page', array(), $lang->getBackEndLocale()); ?></label>
									  <?php if ($validation->hasError('setting_frontend_items_per_page')) { ?>
	                  <div class="text-danger small"><?php echo $validation->getError('setting_frontend_items_per_page'); ?></div>
	                	<?php } ?>
									</div>
		            </fieldset>
						  </div>
						  <div class="tab-pane fade" id="localisation" role="tabpanel" aria-labelledby="localisation-tab">
			          <fieldset>
						  		<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_language', array(), $lang->getBackEndLocale()); ?></h5>
									<div class="form-floating mb-3">
									  <select name="setting_frontend_language" class="form-select" id="input-frontend-language" aria-label="user-frontend-language">
			                <?php foreach ($languages as $language) { ?>
			                  <?php if ($language['code'] == $setting_frontend_language) { ?>
			                    <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-frontend-language"><?php echo lang('Entry.entry_frontend_language', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="setting_backend_language" class="form-select" id="input-backend-language" aria-label="user-backend-language">
			                <?php foreach ($languages as $language) { ?>
			                  <?php if ($language['code'] == $setting_backend_language) { ?>
			                    <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-backend-language"><?php echo lang('Entry.entry_backend_language', array(), $lang->getBackEndLocale()); ?></label>
									</div>
						  		<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_currency', array(), $lang->getBackEndLocale()); ?></h5>
									<div class="form-floating mb-3">
									  <select name="setting_frontend_currency" class="form-select" id="input-frontend-currency" aria-label="user-frontend-currency">
			                <?php foreach ($currencies as $currency) { ?>
			                  <?php if ($currency['code'] == $setting_frontend_currency) { ?>
			                    <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-frontend-currency"><?php echo lang('Entry.entry_frontend_currency', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="setting_backend_currency" class="form-select" id="input-backend-currency" aria-label="user-backend-currency">
			                <?php foreach ($currencies as $currency) { ?>
			                  <?php if ($currency['code'] == $setting_backend_currency) { ?>
			                    <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-backend-currency"><?php echo lang('Entry.entry_backend_currency', array(), $lang->getBackEndLocale()); ?></label>
									</div>
						  		<h5 class="border-bottom border-dark pb-2 mb-3"><?php echo lang('Text.text_weight', array(), $lang->getBackEndLocale()); ?></h5>
									<div class="form-floating mb-3">
									  <select name="setting_frontend_weight_class_id" class="form-select" id="input-frontend-weight-class-id" aria-label="user-frontend-weight-class-id">
			                <?php foreach ($weight_classes as $weight_class) { ?>
			                  <?php if ($weight_class['weight_class_id'] == $setting_frontend_weight_class_id) { ?>
			                    <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-frontend-weight-class-id"><?php echo lang('Entry.entry_frontend_weight_class', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-floating mb-3">
									  <select name="setting_backend_weight_class_id" class="form-select" id="input-backend-weight-class-id" aria-label="user-backend-weight-class-id">
			                <?php foreach ($weight_classes as $weight_class) { ?>
			                  <?php if ($weight_class['weight_class_id'] == $setting_backend_weight_class_id) { ?>
			                    <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
			                  <?php } else { ?>
			                    <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
			                  <?php } ?>
			                <?php } ?>
									  </select>
									  <label for="input-backend-weight-class-id"><?php echo lang('Entry.entry_backend_weight_class', array(), $lang->getBackEndLocale()); ?></label>
									</div>
		            </fieldset>
						  </div>
						  <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
			          <fieldset>
			            <div class="form-group mb-3">
										<h5><?php echo lang('Entry.entry_logo', array(), $lang->getBackEndLocale()); ?></h5>
		                <div class="image-container">
		                  <div id="input-logo-href" class="image-thumb clickable d-flex" data-toggle="replace-image" data-target="input-logo" data-replace="<?php echo $placeholder; ?>" data-locale="<?php echo $lang->getBackEndLocale(); ?>"><img src="<?php echo $thumb_logo; ?>" class="img-fluid mx-auto my-auto" /></div>
		                  <input type="hidden" name="setting_logo" value="<?php echo $logo; ?>" id="input-logo" class="form-control">
		                  <div class="d-grid gap-2 mt-2">
		                  	<span class="btn btn-danger" data-toggle="delete-image" data-target="input-logo" data-replace="<?php echo $placeholder; ?>"><i class="fas fa-trash-alt"></i></span>
		                	</div>
		                </div>
			            </div>
			          </fieldset>
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
var element = document.querySelector('#languageTab li:first-child button');
var tab = bootstrap.Tab.getInstance(element);
if( !tab )
    tab = new bootstrap.Tab(element);
tab.show();
--></script>
<?php echo $footer; ?>
