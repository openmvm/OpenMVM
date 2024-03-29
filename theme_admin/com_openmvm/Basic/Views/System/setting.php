<?php echo $header; ?><?php echo $column_left; ?>
<div class="container-fluid">
    <div id="content" class="content">
        <?php if ($breadcrumbs) { ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <?php if ($breadcrumb['active']) { ?>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
                    <?php } else { ?>
                    <li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                    <?php } ?>
                <?php } ?>
            </ol>
        </nav>
        <?php } ?>
        <div class="card border-0 shadow heading mb-3">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-wrench fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-setting']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo lang('Heading.edit'); ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-setting" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-setting" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="tab-setting" role="tablist">
                    <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.general'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="false"><?php echo lang('Tab.data'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="options-tab" data-bs-toggle="tab" data-bs-target="#options" type="button" role="tab" aria-controls="options" aria-selected="false"><?php echo lang('Tab.options'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="localisation-tab" data-bs-toggle="tab" data-bs-target="#localisation" type="button" role="tab" aria-controls="localisation" aria-selected="false"><?php echo lang('Tab.localisation'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="appearance-tab" data-bs-toggle="tab" data-bs-target="#appearance" type="button" role="tab" aria-controls="appearance" aria-selected="false"><?php echo lang('Tab.appearance'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="order-status-tab" data-bs-toggle="tab" data-bs-target="#order-status" type="button" role="tab" aria-controls="order-status" aria-selected="false"><?php echo lang('Tab.order_statuses'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="mail-tab" data-bs-toggle="tab" data-bs-target="#mail" type="button" role="tab" aria-controls="mail" aria-selected="false"><?php echo lang('Tab.mail'); ?></button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <fieldset>
                            <div class="mb-3 required">
                                <label for="input-marketplace-name" class="form-label"><?php echo lang('Entry.marketplace_name'); ?></label>
                                <input type="text" name="setting_marketplace_name" value="<?php echo $setting_marketplace_name; ?>" id="input-marketplace-name" class="form-control" placeholder="<?php echo lang('Entry.marketplace_name'); ?>">
                            </div>
                            <ul class="nav nav-tabs mb-3" id="description-tab" role="tablist">
                                <?php foreach ($languages as $language) { ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="language-<?php echo $language['language_id']; ?>-description-tab" data-bs-toggle="tab" data-bs-target="#language-<?php echo $language['language_id']; ?>-description-content" type="button" role="tab" aria-controls="language-<?php echo $language['language_id']; ?>-description-content" aria-selected="false"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /> <?php echo $language['name']; ?></button>
                                </li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <?php foreach ($languages as $language) { ?>
                                <div class="tab-pane fade" id="language-<?php echo $language['language_id']; ?>-description-content" role="tabpanel" aria-labelledby="language-<?php echo $language['language_id']; ?>-description-tab">
                                    <div class="mb-3 required">
                                        <label for="input-marketplace-description-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.description'); ?></label>
                                        <textarea name="setting_marketplace_description_<?php echo $language['language_id']; ?>" id="input-marketplace-description-language-<?php echo $language['language_id']; ?>" class="form-control editor" placeholder="<?php echo lang('Entry.description'); ?>"><?php echo ${'setting_marketplace_description_' . $language['language_id']}; ?></textarea>
                                    </div>
                                    <div class="mb-3 required">
                                        <label for="input-marketplace-meta-title-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.meta_title'); ?></label>
                                        <input type="text" name="setting_marketplace_meta_title_<?php echo $language['language_id']; ?>" value="<?php echo ${'setting_marketplace_meta_title_' . $language['language_id']}; ?>" id="input-marketplace-meta-title-language-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.meta_title'); ?>" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="input-marketplace-meta-description-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.meta_description'); ?></label>
                                        <textarea rows="5" name="setting_marketplace_meta_description_<?php echo $language['language_id']; ?>" id="input-marketplace-meta-description-language-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.meta_description'); ?>"><?php echo ${'setting_marketplace_meta_description_' . $language['language_id']}; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="input-marketplace-meta-keywords-language-<?php echo $language['language_id']; ?>" class="form-label"><?php echo lang('Entry.meta_keywords'); ?></label>
                                        <input type="text" name="setting_marketplace_meta_keywords_<?php echo $language['language_id']; ?>" value="<?php echo ${'setting_marketplace_meta_keywords_' . $language['language_id']}; ?>" id="input-marketplace-meta-keywords-language-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.meta_keywords'); ?>" />
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </fieldset>
                    </div>
                    <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">
                        <fieldset>
                            <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.images'); ?></legend>
                            <div class="mb-3">
                                <label for="input-logo" class="form-label"><?php echo lang('Entry.logo'); ?></label>
                                <div class="card" style="width: 110px;">
                                    <div class="card-body bg-secondary bg-opacity-10 p-1">
                                        <div class="d-flex align-items-center mb-1" style="height: 100px;" data-image-manager="image" data-image-manager-dismiss="<?php echo lang('Button.close'); ?>" data-image-manager-title="<?php echo lang('Heading.image_manager'); ?>" role="button"><img src="<?php echo $logo_thumb; ?>" class="mx-auto d-block" /><input type="hidden" name="setting_logo" value="<?php echo $setting_logo; ?>" id="input-image" class="form-control" placeholder="<?php echo lang('Entry.image'); ?>" data-image-manager-target="image" style="width: 200px;" /></div>
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-danger" data-image-manager-remove="image" data-image-manager-placeholder="<?php echo $placeholder; ?>"><i class="fas fa-trash-alt fa-fw"></i></button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="input-favicon" class="form-label"><?php echo lang('Entry.favicon'); ?></label>
                                <div class="card" style="width: 110px;">
                                    <div class="card-body bg-secondary bg-opacity-10 p-1">
                                        <div class="d-flex align-items-center mb-1" style="height: 100px;" data-image-manager="image" data-image-manager-dismiss="<?php echo lang('Button.close'); ?>" data-image-manager-title="<?php echo lang('Heading.image_manager'); ?>" role="button"><img src="<?php echo $favicon_thumb; ?>" class="mx-auto d-block" /><input type="hidden" name="setting_favicon" value="<?php echo $setting_favicon; ?>" id="input-image" class="form-control" placeholder="<?php echo lang('Entry.image'); ?>" data-image-manager-target="image" style="width: 200px;" /></div>
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-danger" data-image-manager-remove="image" data-image-manager-placeholder="<?php echo $placeholder; ?>"><i class="fas fa-trash-alt fa-fw"></i></button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.copyrights'); ?></legend>
                            <div class="mb-3">
                                <label for="input-copyright-name" class="form-label"><?php echo lang('Entry.name'); ?></label>
                                <input type="text" name="setting_copyright_name" value="<?php echo $setting_copyright_name; ?>" id="input-copyright-name" class="form-control" placeholder="<?php echo lang('Entry.name'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-copyright-year" class="form-label"><?php echo lang('Entry.year'); ?></label>
                                <input type="text" name="setting_copyright_year" value="<?php echo $setting_copyright_year; ?>" id="input-copyright-year" class="form-control" placeholder="<?php echo lang('Entry.year'); ?>">
                            </div>
                            <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.contacts'); ?></legend>
                            <div class="mb-3">
                                <label for="input-address-1" class="form-label"><?php echo lang('Entry.address_1'); ?></label>
                                <textarea rows="5" name="setting_address_1" id="input-address-1" class="form-control"><?php echo $setting_address_1; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="input-address-2" class="form-label"><?php echo lang('Entry.address_2'); ?></label>
                                <textarea rows="5" name="setting_address_2" id="input-address-2" class="form-control"><?php echo $setting_address_2; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="input-country" class="form-label"><?php echo lang('Entry.country'); ?></label>
                                <select name="setting_country_id" id="input-country" class="form-select">
                                    <option value=""><?php echo lang('Text.please_select'); ?></option>
                                    <?php foreach ($countries as $country) { ?>
                                        <?php if ($country['country_id'] == $setting_country_id) { ?>
                                        <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="input-zone" class="form-label"><?php echo lang('Entry.zone'); ?></label>
                                <select name="setting_zone_id" id="input-zone" class="form-select"></select>
                            </div>
                            <div class="mb-3">
                                <label for="input-city" class="form-label"><?php echo lang('Entry.city'); ?></label>
                                <input type="text" name="setting_city" value="<?php echo $setting_city; ?>" id="input-city" class="form-control" placeholder="<?php echo lang('Entry.city'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-telephone" class="form-label"><?php echo lang('Entry.telephone'); ?></label>
                                <input type="text" name="setting_telephone" value="<?php echo $setting_telephone; ?>" id="input-telephone" class="form-control" placeholder="<?php echo lang('Entry.telephone'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-email" class="form-label"><?php echo lang('Entry.email'); ?></label>
                                <input type="text" name="setting_email" value="<?php echo $setting_email; ?>" id="input-email" class="form-control" placeholder="<?php echo lang('Entry.email'); ?>">
                            </div>
                        </fieldset>
                    </div>
                    <div class="tab-pane fade" id="options" role="tabpanel" aria-labelledby="options-tab">
                        <fieldset>
                            <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.administrator'); ?></legend>
                            <div class="mb-3">
                                <label for="input-administrator-group" class="form-label"><?php echo lang('Entry.administrator_group'); ?></label>
                                <select name="setting_administrator_group_id" id="input-administrator-group" class="form-select">
                                    <?php foreach ($administrator_groups as $administrator_group) { ?>
                                        <?php if ($administrator_group['administrator_group_id'] == $setting_administrator_group_id) { ?>
                                        <option value="<?php echo $administrator_group['administrator_group_id']; ?>" selected="selected"><?php echo $administrator_group['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $administrator_group['administrator_group_id']; ?>"><?php echo $administrator_group['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.customer'); ?></legend>
                            <div class="mb-3">
                                <label for="input-customer-group" class="form-label"><?php echo lang('Entry.customer_group'); ?></label>
                                <select name="setting_customer_group_id" id="input-customer-group" class="form-select">
                                    <?php foreach ($customer_groups as $customer_group) { ?>
                                        <?php if ($customer_group['customer_group_id'] == $setting_customer_group_id) { ?>
                                        <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.order'); ?></legend>
                            <div class="mb-3">
                                <label for="input-order-invoice-prefix" class="form-label"><?php echo lang('Entry.invoice_prefix'); ?></label>
                                <input type="text" name="setting_order_invoice_prefix" value="<?php echo $setting_order_invoice_prefix; ?>" id="input-order-invoice-prefix" class="form-control" placeholder="<?php echo lang('Entry.invoice_prefix'); ?>">
                            </div>
                        </fieldset>
                    </div>
                    <div class="tab-pane fade" id="localisation" role="tabpanel" aria-labelledby="localisation-tab">
                        <fieldset>
                            <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.language'); ?></legend>
                            <div class="mb-3">
                                <label for="input-admin-language" class="form-label"><?php echo lang('Entry.admin_language'); ?></label>
                                <select name="setting_admin_language_id" id="input-admin-language" class="form-select">
                                    <?php foreach ($languages as $language) { ?>
                                        <?php if ($language['language_id'] == $setting_admin_language_id) { ?>
                                        <option value="<?php echo $language['language_id']; ?>" selected="selected"><?php echo $language['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="input-marketplace-language" class="form-label"><?php echo lang('Entry.marketplace_language'); ?></label>
                                <select name="setting_marketplace_language_id" id="input-marketplace-language" class="form-select">
                                    <?php foreach ($languages as $language) { ?>
                                        <?php if ($language['language_id'] == $setting_marketplace_language_id) { ?>
                                        <option value="<?php echo $language['language_id']; ?>" selected="selected"><?php echo $language['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.currency'); ?></legend>
                            <div class="mb-3">
                                <label for="input-admin-currency" class="form-label"><?php echo lang('Entry.admin_currency'); ?></label>
                                <select name="setting_admin_currency_id" id="input-admin-currency" class="form-select">
                                    <?php foreach ($currencies as $currency) { ?>
                                        <?php if ($currency['currency_id'] == $setting_admin_currency_id) { ?>
                                        <option value="<?php echo $currency['currency_id']; ?>" selected="selected"><?php echo $currency['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $currency['currency_id']; ?>"><?php echo $currency['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="input-marketplace-currency" class="form-label"><?php echo lang('Entry.marketplace_currency'); ?></label>
                                <select name="setting_marketplace_currency_id" id="input-marketplace-currency" class="form-select">
                                    <?php foreach ($currencies as $currency) { ?>
                                        <?php if ($currency['currency_id'] == $setting_marketplace_currency_id) { ?>
                                        <option value="<?php echo $currency['currency_id']; ?>" selected="selected"><?php echo $currency['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $currency['currency_id']; ?>"><?php echo $currency['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.weight_class'); ?></legend>
                            <div class="mb-3">
                                <label for="input-admin-weight-class" class="form-label"><?php echo lang('Entry.admin_weight_class'); ?></label>
                                <select name="setting_admin_weight_class_id" id="input-admin-weight-class" class="form-select">
                                    <?php foreach ($weight_classes as $weight_class) { ?>
                                        <?php if ($weight_class['weight_class_id'] == $setting_admin_weight_class_id) { ?>
                                        <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="input-marketplace-weight-class" class="form-label"><?php echo lang('Entry.marketplace_weight_class'); ?></label>
                                <select name="setting_marketplace_weight_class_id" id="input-marketplace-weight-class" class="form-select">
                                    <?php foreach ($weight_classes as $weight_class) { ?>
                                        <?php if ($weight_class['weight_class_id'] == $setting_marketplace_weight_class_id) { ?>
                                        <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                    <div class="tab-pane fade" id="appearance" role="tabpanel" aria-labelledby="appearance-tab">
                        <fieldset>
                            <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.themes'); ?></legend>
                            <div class="mb-3">
                                <label for="input-admin-theme" class="form-label"><?php echo lang('Entry.admin_theme'); ?></label>
                                <select name="setting_admin_theme" id="input-admin-theme" class="form-select">
                                    <?php foreach ($admin_themes as $admin_theme) { ?>
                                        <?php if ($admin_theme['theme_author'] . ':' . $admin_theme['theme_name'] == $setting_admin_theme) { ?>
                                        <option value="<?php echo $admin_theme['theme_author'] . ':' . $admin_theme['theme_name']; ?>" selected="selected"><?php echo lang('Text.theme') . ' ' . $admin_theme['theme_name'] . ' ( ' . lang('Text.author') . ': ' . $admin_theme['theme_author'] . ' )'; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $admin_theme['theme_author'] . ':' . $admin_theme['theme_name']; ?>"><?php echo lang('Text.theme') . ' ' . $admin_theme['theme_name'] . ' ( ' . lang('Text.author') . ': ' . $admin_theme['theme_author'] . ' )'; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="input-marketplace-theme" class="form-label"><?php echo lang('Entry.marketplace_theme'); ?></label>
                                <select name="setting_marketplace_theme" id="input-marketplace-theme" class="form-select">
                                    <?php foreach ($marketplace_themes as $marketplace_theme) { ?>
                                        <?php if ($marketplace_theme['theme_author'] . ':' . $marketplace_theme['theme_name'] == $setting_marketplace_theme) { ?>
                                        <option value="<?php echo $marketplace_theme['theme_author'] . ':' . $marketplace_theme['theme_name']; ?>" selected="selected"><?php echo lang('Text.theme') . ' ' . $marketplace_theme['theme_name'] . ' ( ' . lang('Text.author') . ': ' . $marketplace_theme['theme_author'] . ' )'; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $marketplace_theme['theme_author'] . ':' . $marketplace_theme['theme_name']; ?>"><?php echo lang('Text.theme') . ' ' . $marketplace_theme['theme_name'] . ' ( ' . lang('Text.author') . ': ' . $marketplace_theme['theme_author'] . ' )'; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                    <div class="tab-pane fade" id="order-status" role="tabpanel" aria-labelledby="order-status-tab">
                        <fieldset>
                            <legend class="lead border-bottom border-warning pb-2 mb-3"><?php echo lang('Text.general'); ?></legend>
                            <div class="mb-3">
                                <div class="form-label"><?php echo lang('Entry.processing_order_statuses'); ?></div>
                                <div class="card overflow-auto" style="height: 120px;">
                                    <div class="card-body">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="setting_processing_order_statuses[]" value="<?php echo $order_status['order_status_id']; ?>" id="processing-order-statuses-<?php echo $order_status['order_status_id']; ?>"<?php if ($setting_processing_order_statuses !== null && in_array($order_status['order_status_id'], $setting_processing_order_statuses)) { ?> checked<?php } ?>>
                                            <label class="form-check-label" for="processing-order-statuses-<?php echo $order_status['order_status_id']; ?>">
                                                <?php echo $order_status['name']; ?>
                                            </label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-label"><?php echo lang('Entry.completed_order_statuses'); ?></div>
                                <div class="card overflow-auto" style="height: 120px;">
                                    <div class="card-body">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="setting_completed_order_statuses[]" value="<?php echo $order_status['order_status_id']; ?>" id="completed-order-statuses-<?php echo $order_status['order_status_id']; ?>"<?php if ($setting_completed_order_statuses !== null && in_array($order_status['order_status_id'], $setting_completed_order_statuses)) { ?> checked<?php } ?>>
                                            <label class="form-check-label" for="completed-order-statuses-<?php echo $order_status['order_status_id']; ?>">
                                                <?php echo $order_status['name']; ?>
                                            </label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-label"><?php echo lang('Entry.stock_subtraction_order_statuses'); ?></div>
                                <div class="card overflow-auto" style="height: 120px;">
                                    <div class="card-body">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="setting_stock_subtraction_order_statuses[]" value="<?php echo $order_status['order_status_id']; ?>" id="stock-subtraction-order-statuses-<?php echo $order_status['order_status_id']; ?>"<?php if ($setting_stock_subtraction_order_statuses !== null && in_array($order_status['order_status_id'], $setting_stock_subtraction_order_statuses)) { ?> checked<?php } ?>>
                                            <label class="form-check-label" for="stock-subtraction-order-statuses-<?php echo $order_status['order_status_id']; ?>">
                                                <?php echo $order_status['name']; ?>
                                            </label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <legend class="lead border-bottom border-warning pb-2 mb-3"><?php echo lang('Text.seller'); ?></legend>
                            <div class="mb-3">
                                <div class="form-label"><?php echo lang('Entry.non_rejectable_order_statuses'); ?></div>
                                <div class="card overflow-auto" style="height: 120px;">
                                    <div class="card-body">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="setting_non_rejectable_order_statuses[]" value="<?php echo $order_status['order_status_id']; ?>" id="non-rejectable-order-statuses-<?php echo $order_status['order_status_id']; ?>"<?php if ($setting_non_rejectable_order_statuses !== null && in_array($order_status['order_status_id'], $setting_non_rejectable_order_statuses)) { ?> checked<?php } ?>>
                                            <label class="form-check-label" for="non-rejectable-order-statuses-<?php echo $order_status['order_status_id']; ?>">
                                                <?php echo $order_status['name']; ?>
                                            </label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="input-rejected-order-status" class="form-label"><?php echo lang('Entry.rejected_order_status'); ?></label>
                                <input type="text" name="setting_rejected_order_status" value="<?php echo isset($setting_rejected_order_status['name']) ? $setting_rejected_order_status['name'] : ''; ?>" id="input-rejected-order-status" class="form-control order-status-autocomplete" placeholder="<?php echo lang('Entry.rejected_order_status'); ?>">
                                <input type="hidden" name="setting_rejected_order_status_id" value="<?php echo isset($setting_rejected_order_status_id) ? $setting_rejected_order_status_id : ''; ?>" id="input-rejected-order-status-id" class="form-control" placeholder="<?php echo lang('Entry.rejected_order_status'); ?>">
                            </div>
                            <div class="mb-3">
                                <div class="form-label"><?php echo lang('Entry.non_acceptable_order_statuses'); ?></div>
                                <div class="card overflow-auto" style="height: 120px;">
                                    <div class="card-body">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="setting_non_acceptable_order_statuses[]" value="<?php echo $order_status['order_status_id']; ?>" id="non-acceptable-order-statuses-<?php echo $order_status['order_status_id']; ?>"<?php if ($setting_non_acceptable_order_statuses !== null && in_array($order_status['order_status_id'], $setting_non_acceptable_order_statuses)) { ?> checked<?php } ?>>
                                            <label class="form-check-label" for="non-acceptable-order-statuses-<?php echo $order_status['order_status_id']; ?>">
                                                <?php echo $order_status['name']; ?>
                                            </label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="input-accepted-order-status" class="form-label"><?php echo lang('Entry.accepted_order_status'); ?></label>
                                <input type="text" name="setting_accepted_order_status" value="<?php echo isset($setting_accepted_order_status['name']) ? $setting_accepted_order_status['name'] : ''; ?>" id="input-accepted-order-status" class="form-control order-status-autocomplete" placeholder="<?php echo lang('Entry.accepted_order_status'); ?>">
                                <input type="hidden" name="setting_accepted_order_status_id" value="<?php echo isset($setting_accepted_order_status_id) ? $setting_accepted_order_status_id : ''; ?>" id="input-accepted-order-status-id" class="form-control" placeholder="<?php echo lang('Entry.accepted_order_status'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-shipped-order-status" class="form-label"><?php echo lang('Entry.shipped_order_status'); ?></label>
                                <input type="text" name="setting_shipped_order_status" value="<?php echo isset($setting_shipped_order_status['name']) ? $setting_shipped_order_status['name'] : ''; ?>" id="input-shipped-order-status" class="form-control order-status-autocomplete" placeholder="<?php echo lang('Entry.shipped_order_status'); ?>">
                                <input type="hidden" name="setting_shipped_order_status_id" value="<?php echo isset($setting_shipped_order_status_id) ? $setting_shipped_order_status_id : ''; ?>" id="input-shipped-order-status-id" class="form-control" placeholder="<?php echo lang('Entry.shipped_order_status'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-delivered-order-status" class="form-label"><?php echo lang('Entry.delivered_order_status'); ?></label>
                                <input type="text" name="setting_delivered_order_status" value="<?php echo isset($setting_delivered_order_status['name']) ? $setting_delivered_order_status['name'] : ''; ?>" id="input-delivered-order-status" class="form-control order-status-autocomplete" placeholder="<?php echo lang('Entry.delivered_order_status'); ?>">
                                <input type="hidden" name="setting_delivered_order_status_id" value="<?php echo isset($setting_delivered_order_status_id) ? $setting_delivered_order_status_id : ''; ?>" id="input-delivered-order-status-id" class="form-control" placeholder="<?php echo lang('Entry.delivered_order_status'); ?>">
                            </div>
                            <legend class="lead border-bottom border-warning pb-2 mb-3"><?php echo lang('Text.customer'); ?></legend>
                            <div class="mb-3">
                                <div class="form-label"><?php echo lang('Entry.non_cancelable_order_statuses'); ?></div>
                                <div class="card overflow-auto" style="height: 120px;">
                                    <div class="card-body">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="setting_non_cancelable_order_statuses[]" value="<?php echo $order_status['order_status_id']; ?>" id="non-cancelable-order-statuses-<?php echo $order_status['order_status_id']; ?>"<?php if ($setting_non_cancelable_order_statuses !== null && in_array($order_status['order_status_id'], $setting_non_cancelable_order_statuses)) { ?> checked<?php } ?>>
                                            <label class="form-check-label" for="non-cancelable-order-statuses-<?php echo $order_status['order_status_id']; ?>">
                                                <?php echo $order_status['name']; ?>
                                            </label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="input-canceled-order-status" class="form-label"><?php echo lang('Entry.canceled_order_status'); ?></label>
                                <input type="text" name="setting_canceled_order_status" value="<?php echo isset($setting_canceled_order_status['name']) ? $setting_canceled_order_status['name'] : ''; ?>" id="input-canceled-order-status" class="form-control order-status-autocomplete" placeholder="<?php echo lang('Entry.canceled_order_status'); ?>">
                                <input type="hidden" name="setting_canceled_order_status_id" value="<?php echo isset($setting_canceled_order_status_id) ? $setting_canceled_order_status_id : ''; ?>" id="input-canceled-order-status-id" class="form-control" placeholder="<?php echo lang('Entry.canceled_order_status'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-paid-order-status" class="form-label"><?php echo lang('Entry.paid_order_status'); ?></label>
                                <input type="text" name="setting_paid_order_status" value="<?php echo isset($setting_paid_order_status['name']) ? $setting_paid_order_status['name'] : ''; ?>" id="input-paid-order-status" class="form-control order-status-autocomplete" placeholder="<?php echo lang('Entry.paid_order_status'); ?>">
                                <input type="hidden" name="setting_paid_order_status_id" value="<?php echo isset($setting_paid_order_status_id) ? $setting_paid_order_status_id : ''; ?>" id="input-paid-order-status-id" class="form-control" placeholder="<?php echo lang('Entry.paid_order_status'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-completed-order-status" class="form-label"><?php echo lang('Entry.completed_order_status'); ?></label>
                                <input type="text" name="setting_completed_order_status" value="<?php echo isset($setting_completed_order_status['name']) ? $setting_completed_order_status['name'] : ''; ?>" id="input-completed-order-status" class="form-control order-status-autocomplete" placeholder="<?php echo lang('Entry.completed_order_status'); ?>">
                                <input type="hidden" name="setting_completed_order_status_id" value="<?php echo isset($setting_completed_order_status_id) ? $setting_completed_order_status_id : ''; ?>" id="input-completed-order-status-id" class="form-control" placeholder="<?php echo lang('Entry.completed_order_status'); ?>">
                            </div>
                        </fieldset>
                    </div>
                    <div class="tab-pane fade" id="mail" role="tabpanel" aria-labelledby="mail-tab">
                        <fieldset>
                            <div class="mb-3">
                                <label for="input-mail-protocol" class="form-label"><?php echo lang('Entry.mail_protocol'); ?></label>
                                <select name="setting_mail_protocol" id="input-mail-protocol" class="form-select">
                                    <?php foreach ($mail_protocols as $mail_protocol) { ?>
                                        <?php if ($mail_protocol == $setting_mail_protocol) { ?>
                                        <option value="<?php echo $mail_protocol; ?>" selected="selected"><?php echo $mail_protocol; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $mail_protocol; ?>"><?php echo $mail_protocol; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="input-smtp-encryption" class="form-label"><?php echo lang('Entry.smtp_encryption'); ?></label>
                                <select name="setting_smtp_encryption" id="input-smtp-encryption" class="form-select">
                                    <?php foreach ($smtp_encryptions as $smtp_encryption) { ?>
                                        <?php if ($smtp_encryption == $setting_smtp_encryption) { ?>
                                        <option value="<?php echo $smtp_encryption; ?>" selected="selected"><?php echo $smtp_encryption; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $smtp_encryption; ?>"><?php echo $smtp_encryption; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="input-smtp-host" class="form-label"><?php echo lang('Entry.smtp_host'); ?></label>
                                <input type="text" name="setting_smtp_host" value="<?php echo $setting_smtp_host; ?>" id="input-smtp-host" class="form-control" placeholder="<?php echo lang('Entry.smtp_host'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-smtp-username" class="form-label"><?php echo lang('Entry.smtp_username'); ?></label>
                                <input type="text" name="setting_smtp_username" value="<?php echo $setting_smtp_username; ?>" id="input-smtp-username" class="form-control" placeholder="<?php echo lang('Entry.smtp_username'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-smtp-password" class="form-label"><?php echo lang('Entry.smtp_password'); ?></label>
                                <input type="text" name="setting_smtp_password" value="<?php echo $setting_smtp_password; ?>" id="input-smtp-password" class="form-control" placeholder="<?php echo lang('Entry.smtp_password'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-smtp-port" class="form-label"><?php echo lang('Entry.smtp_port'); ?></label>
                                <input type="number" name="setting_smtp_port" value="<?php echo $setting_smtp_port; ?>" id="input-smtp-port" class="form-control" placeholder="<?php echo lang('Entry.smtp_port'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="input-smtp-timeout" class="form-label"><?php echo lang('Entry.smtp_timeout'); ?></label>
                                <input type="number" name="setting_smtp_timeout" value="<?php echo $setting_smtp_timeout; ?>" id="input-smtp-timeout" class="form-control" placeholder="<?php echo lang('Entry.smtp_timeout'); ?>">
                            </div>
                         </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
$('select[name=\'setting_country_id\']').on('change', function() {
	$.ajax({
		url: '<?php echo base_url(); ?>' + '/<?php echo env('app.adminUrlSegment'); ?>/localisation/country/get_country?administrator_token=<?php echo $administrator_token; ?>&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'setting_country_id\']').prop('disabled', true);
		},
		complete: function() {
			$('select[name=\'setting_country_id\']').prop('disabled', false);
		},
		success: function(json) {
			html = '<option value=""><?php echo lang('Text.please_select'); ?></option>';
			
			if (json['zones'] && json['zones'] != '') {
				for (i = 0; i < json['zones'].length; i++) {
                    zone = json['zones'][i];

					html += '<option value="' + zone['zone_id'] + '"';
					
					if (zone['zone_id'] == '<?php echo $setting_zone_id; ?>') {
						html += ' selected="selected"';
					}
					
					html += '>' + zone['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo lang('Text.none'); ?></option>';
			}
			
			$('select[name=\'setting_zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'setting_country_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
    tinymce.init({
    selector: '.editor',
    height: 300,
    });
});
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
    var triggerFirstTabEl = document.querySelector('#description-tab li:first-child button')
    new bootstrap.Tab(triggerFirstTabEl).show()
});
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
    $('body').on('focus', '.order-status-autocomplete', function(){
        var node = this;
        $(node).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: '<?php echo $order_status_autocomplete; ?>',
                    dataType: 'json',
                    data: {
                        filter_name: request.term
                    },
                    beforeSend: function() {
                        //$('select[name=\'setting_country_id\']').prop('disabled', true);
                    },
                    complete: function() {
                        //$('select[name=\'setting_country_id\']').prop('disabled', false);
                    },
                    success: function(json) {
                        if (json['error']) {
                            alert(json['error']);
                        } else {
                            if (json.length) {
                                var none = {
                                        name: '<?php echo lang('Text.none'); ?>', 
                                        order_status_id: 0,
                                    };

                                json.push(none);       
                                response( json );
                            } else {
                                var json = [
                                    {
                                        name: '<?php echo lang('Text.none'); ?>', 
                                        order_status_id: 0,
                                    }
                                ];

                                response(json);
                            }
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
                $(node).val(ui.item.name);
                $(node).next('input[type=hidden]').val(ui.item.order_status_id);
                $(node).autocomplete('close');
                console.log( 'Selected: ' + ui.item.name + ' aka ' + ui.item.order_status_id );
                return false;
            }
        }).focus(function () {
            $(this).autocomplete('search');
        }).data('ui-autocomplete')._renderItem = function (ul, item) {
            return $('<li>')
                .data('item.autocomplete', item)
                .append('<a>' + item.name + '</a>')
                .appendTo(ul);
        };
    });
});
//--></script>
<?php echo $footer; ?>
