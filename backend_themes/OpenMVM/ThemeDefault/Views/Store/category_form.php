<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-sitemap fa-fw"></i> <?php echo $heading_title; ?></h2>
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
	      <a href="<?php echo base_url($_SERVER['app.adminDir'] . '/categories/' . $administrator_token); ?>" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.button_cancel', array(), $lang->getBackEndLocale()); ?>"><i class="fas fa-long-arrow-alt-left"></i></a>
	    </div>
    </div>
		<div class="accordion" id="accordionAdministratorGroup">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingAdministratorGroup">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdministratorGroup" aria-expanded="true" aria-controls="collapseAdministratorGroup">
		        <i class="fas fa-sitemap fa-fw"></i>&nbsp;&nbsp;<?php echo $heading_title; ?>
		      </button>
		    </h2>
		    <div id="collapseAdministratorGroup" class="accordion-collapse collapse show" aria-labelledby="headingAdministratorGroup" data-bs-parent="#accordionAdministratorGroup">
		      <div class="accordion-body">

		        <ul class="nav nav-tabs" id="categoryTab" role="tablist">
						  <li class="nav-item" role="presentation">
						    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.tab_general', array(), $lang->getBackEndLocale()); ?></button>
						  </li>
						  <li class="nav-item" role="presentation">
						    <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="false"><?php echo lang('Tab.tab_data', array(), $lang->getBackEndLocale()); ?></button>
						  </li>
		        </ul>
		        <div class="tab-content mt-3" id="administratorTabContent">
		          <div class="tab-pane show active" id="general" role="tabpanel" aria-labelledby="general-tab">
		            <fieldset>
		              <ul class="nav nav-tabs" id="languageTab" role="tablist">
		                <?php foreach ($languages as $language) { ?>
									  <li class="nav-item" role="presentation">
									    <button class="nav-link" id="language-<?php echo $language['language_id']; ?>-tab" data-bs-toggle="tab" data-bs-target="#language-<?php echo $language['language_id']; ?>" type="button" role="tab" aria-controls="language-<?php echo $language['language_id']; ?>" aria-selected="false"><?php echo $language['name']; ?></button>
									  </li>
		                <?php } ?>
		              </ul>
		              <div class="tab-content mt-3" id="languageTabContent">
		                <?php foreach ($languages as $language) { ?>
		                  <div class="tab-pane" id="language-<?php echo $language['language_id']; ?>" role="tabpanel" aria-labelledby="language-<?php echo $language['language_id']; ?>-tab">
		                    <fieldset>
											  	<div class="form-floating mb-3">
													  <input type="text" name="description[<?php echo $language['language_id']; ?>][name]" value="<?php echo $description[$language['language_id']]['name']; ?>" class="form-control<?php if ($validation->hasError('description.' . $language['language_id'] . '.name')) { ?> is-invalid<?php } ?>" id="input-description-<?php echo $language['language_id']; ?>-name" placeholder="<?php echo lang('Entry.entry_name', array(), $lang->getFrontEndLocale()); ?>">
													  <label for="input-description-<?php echo $language['language_id']; ?>-name"><?php echo lang('Entry.entry_name', array(), $lang->getFrontEndLocale()); ?></label>
													  <?php if ($validation->hasError('description.' . $language['language_id'] . '.name')) { ?>
						                <div class="text-danger small"><?php echo $validation->getError('description.' . $language['language_id'] . '.name'); ?></div>
						              	<?php } ?>
													</div>
											  	<div class="form-floating mb-3">
													  <textarea name="description[<?php echo $language['language_id']; ?>][description]" class="form-control tinymce" id="input-description-<?php echo $language['language_id']; ?>-description" placeholder="<?php echo lang('Entry.entry_description', array(), $lang->getFrontEndLocale()); ?>"><?php echo $description[$language['language_id']]['description']; ?></textarea>
													  <label for="input-description-<?php echo $language['language_id']; ?>-description"><?php echo lang('Entry.entry_description', array(), $lang->getFrontEndLocale()); ?></label>
													</div>
											  	<div class="form-floating mb-3">
													  <input type="text" name="description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo $description[$language['language_id']]['meta_title']; ?>" class="form-control" id="input-description-<?php echo $language['language_id']; ?>-meta-title" placeholder="<?php echo lang('Entry.entry_meta_title', array(), $lang->getFrontEndLocale()); ?>">
													  <label for="input-description-<?php echo $language['language_id']; ?>-meta-title"><?php echo lang('Entry.entry_meta_title', array(), $lang->getFrontEndLocale()); ?></label>
													</div>
											  	<div class="form-floating mb-3">
													  <textarea style="height: 200px;" name="description[<?php echo $language['language_id']; ?>][meta_description]" class="form-control" id="input-description-<?php echo $language['language_id']; ?>-meta-description" placeholder="<?php echo lang('Entry.entry_meta_description', array(), $lang->getFrontEndLocale()); ?>"><?php echo $description[$language['language_id']]['meta_description']; ?></textarea>
													  <label for="input-description-<?php echo $language['language_id']; ?>-meta-description"><?php echo lang('Entry.entry_meta_description', array(), $lang->getFrontEndLocale()); ?></label>
													</div>
											  	<div class="form-floating mb-3">
													  <input type="text" name="description[<?php echo $language['language_id']; ?>][meta_keywords]" value="<?php echo $description[$language['language_id']]['meta_keywords']; ?>" class="form-control" id="input-description-<?php echo $language['language_id']; ?>-meta-keywords" placeholder="<?php echo lang('Entry.entry_meta_keywords', array(), $lang->getFrontEndLocale()); ?>">
													  <label for="input-description-<?php echo $language['language_id']; ?>-meta-keywords"><?php echo lang('Entry.entry_meta_keywords', array(), $lang->getFrontEndLocale()); ?></label>
													</div>
		                    </fieldset>
		                  </div>
		                <?php } ?>
		              </div>
		            </fieldset>
		          </div>
		          <div class="tab-pane" id="data" role="tabpanel" aria-labelledby="data-tab">
		            <fieldset>
							  	<div class="form-floating mb-3">
									  <input type="text" name="category" value="<?php echo $category; ?>" class="form-control" id="input-parent" placeholder="<?php echo lang('Entry.entry_parent', array(), $lang->getBackEndLocale()); ?>">
		                <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" />
									  <label for="input-parent"><?php echo lang('Entry.entry_parent', array(), $lang->getBackEndLocale()); ?></label>
									</div>
									<div class="form-check mb-3">
									  <input class="form-check-input" type="checkbox" name="top" value="1" id="input-top"<?php if ($top) { ?> checked<?php } ?>>
									  <label class="form-check-label" for="input-top">
									    <?php echo lang('Entry.entry_top', array(), $lang->getBackEndLocale()); ?>
									  </label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="number" name="column" value="<?php echo $column; ?>" class="form-control" id="input-column" placeholder="<?php echo lang('Entry.entry_column', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-column"><?php echo lang('Entry.entry_column', array(), $lang->getBackEndLocale()); ?></label>
									</div>
							  	<div class="form-floating mb-3">
									  <input type="number" name="sort_order" value="<?php echo $sort_order; ?>" class="form-control" id="input-sort-order" placeholder="<?php echo lang('Entry.entry_sort_order', array(), $lang->getBackEndLocale()); ?>">
									  <label for="input-sort-order"><?php echo lang('Entry.entry_sort_order', array(), $lang->getBackEndLocale()); ?></label>
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
$('input[name=\'category\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: '<?php echo base_url($_SERVER['app.adminDir'] . '/categories/autocomplete/' . $administrator_token); ?>',
      type: 'post',
      dataType: 'json',
      data : {
        filter_name : request
      },
      beforeSend: function() {
        //$('#combobox #input-combobox-' + prev_val).after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
      },
      complete: function() {
        //$('.fa-spin').remove();
      },
      success: function(json) {
        json.unshift({
          category_id: 0,
          name: '<?php echo lang('Text.text_none', array(), $lang->getBackEndLocale()); ?>'
        });

        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  },
  'select': function(item) {
    $('input[name=\'category\']').val(item['label']);
    $('input[name=\'parent_id\']').val(item['value']);
  }
});
//--></script>
<script type="text/javascript"><!--
var element = document.querySelector('#languageTab li:first-child button');
var tab = bootstrap.Tab.getInstance(element);
if( !tab )
    tab = new bootstrap.Tab(element);
tab.show();
//--></script>
<?php echo $footer; ?>
