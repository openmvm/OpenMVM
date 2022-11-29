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
                <h3 class="card-title"><i class="fas fa-user fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-customer']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-customer" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-customer" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="customer-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true"><?php echo lang('Tab.general'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="wallet-tab" data-bs-toggle="tab" data-bs-target="#wallet" type="button" role="tab" aria-controls="wallet" aria-selected="false"><?php echo lang('Tab.wallet'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                    </li>
                </ul>
                <div class="tab-content" id="customer-tab-content">
                    <div class="tab-pane show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="nav flex-column nav-pills me-3" id="v-pills-customer-tab" role="tablist" aria-orientation="vertical">
                                    <button class="nav-link active text-start" id="v-pills-general-tab" data-bs-toggle="pill" data-bs-target="#v-pills-general" type="button" role="tab" aria-controls="v-pills-general" aria-selected="true"><?php echo lang('Tab.general'); ?></button>
                                    <?php $customer_address_row = 1; ?>
                                    <?php foreach ($customer_addresses as $customer_address) { ?>
                                    <button class="nav-link text-start" id="v-pills-customer-address-tab-<?php echo $customer_address_row; ?>" data-bs-toggle="pill" data-bs-target="#v-pills-customer-address-<?php echo $customer_address_row; ?>" type="button" role="tab" aria-controls="v-pills-customer-address-<?php echo $customer_address_row; ?>" aria-selected="false"><i class="fas fa-minus-circle" onclick="removeAddress('<?php echo $customer_address_row; ?>');"></i> <?php echo lang('Tab.address'); ?> <?php echo $customer_address_row; ?></button>
                                    <?php $customer_address_row++; ?>
                                    <?php } ?>
                                    <button class="btn btn-warning mt-3" id="button-address" type="button" onclick="addAddress();"><i class="fas fa-plus fa-fw"></i> <?php echo lang('Button.address_add'); ?></button>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="tab-content" id="v-pills-customer-tab-content">
                                    <div class="tab-pane show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
                                        <legend class="lead border-bottom border-warning pb-2 mb-3"><?php echo lang('Tab.general'); ?></legend>
                                        <fieldset>
                                            <div class="mb-3 required">
                                                <label for="input-customer-group" class="form-label"><?php echo lang('Entry.customer_group'); ?></label>
                                                <select name="customer_group_id" id="input-customer-group" class="form-select">
                                                    <?php foreach ($customer_groups as $customer_group) { ?>
                                                        <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
                                                        <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                                                        <?php } else { ?>
                                                        <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="mb-3 required">
                                                <label for="input-username" class="form-label"><?php echo lang('Entry.username'); ?></label>
                                                <input type="text" name="username" value="<?php echo $username; ?>" id="input-username" class="form-control" placeholder="<?php echo lang('Entry.username'); ?>">
                                                <?php if (!empty($error_username)) { ?><div class="text-danger small"><?php echo $error_username; ?></div><?php } ?>
                                            </div>
                                            <div class="mb-3 required">
                                                <label for="input-firstname" class="form-label"><?php echo lang('Entry.firstname'); ?></label>
                                                <input type="text" name="firstname" value="<?php echo $firstname; ?>" id="input-firstname" class="form-control" placeholder="<?php echo lang('Entry.firstname'); ?>">
                                                <?php if (!empty($error_firstname)) { ?><div class="text-danger small"><?php echo $error_firstname; ?></div><?php } ?>
                                            </div>
                                            <div class="mb-3 required">
                                                <label for="input-lastname" class="form-label"><?php echo lang('Entry.lastname'); ?></label>
                                                <input type="text" name="lastname" value="<?php echo $lastname; ?>" id="input-lastname" class="form-control" placeholder="<?php echo lang('Entry.lastname'); ?>">
                                                <?php if (!empty($error_lastname)) { ?><div class="text-danger small"><?php echo $error_lastname; ?></div><?php } ?>
                                            </div>
                                            <div class="mb-3 required">
                                                <label for="input-telephone" class="form-label"><?php echo lang('Entry.telephone'); ?></label>
                                                <input type="text" name="telephone" value="<?php echo $telephone; ?>" id="input-telephone" class="form-control" placeholder="<?php echo lang('Entry.telephone'); ?>">
                                                <?php if (!empty($error_telephone)) { ?><div class="text-danger small"><?php echo $error_telephone; ?></div><?php } ?>
                                            </div>
                                            <div class="mb-3 required">
                                                <label for="input-email" class="form-label"><?php echo lang('Entry.email'); ?></label>
                                                <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" placeholder="<?php echo lang('Entry.email'); ?>">
                                                <?php if (!empty($error_email)) { ?><div class="text-danger small"><?php echo $error_email; ?></div><?php } ?>
                                            </div>
                                            <div class="mb-3 required">
                                                <label for="input-password" class="form-label"><?php echo lang('Entry.password'); ?></label>
                                                <input type="password" name="password" value="" id="input-password" class="form-control" placeholder="<?php echo lang('Entry.password'); ?>">
                                                <?php if (!empty($error_password)) { ?><div class="text-danger small"><?php echo $error_password; ?></div><?php } ?>
                                            </div>
                                            <div class="mb-3 required">
                                                <label for="input-passconf" class="form-label"><?php echo lang('Entry.passconf'); ?></label>
                                                <input type="password" name="passconf" value="" id="input-passconf" class="form-control" placeholder="<?php echo lang('Entry.passconf'); ?>">
                                                <?php if (!empty($error_passconf)) { ?><div class="text-danger small"><?php echo $error_passconf; ?></div><?php } ?>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input-status" class="form-label"><?php echo lang('Entry.status'); ?></label>
                                                <select name="status" id="input-status" class="form-select">
                                                    <?php if ($status) { ?>
                                                    <option value="0"><?php echo lang('Text.disabled'); ?></option>
                                                    <option value="1" selected="selected"><?php echo lang('Text.enabled'); ?></option>
                                                    <?php } else { ?>
                                                    <option value="0" selected="selected"><?php echo lang('Text.disabled'); ?></option>
                                                    <option value="1"><?php echo lang('Text.enabled'); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <?php $customer_address_row = 1; ?>
                                    <?php foreach ($customer_addresses as $customer_address) { ?>
                                    <div class="tab-pane" id="v-pills-customer-address-<?php echo $customer_address_row; ?>" role="tabpanel" aria-labelledby="v-pills-customer-address-tab-<?php echo $customer_address_row; ?>">
                                        <legend class="lead border-bottom border-warning pb-2 mb-3"><?php echo lang('Tab.address'); ?> <?php echo $customer_address_row; ?></legend>
                                        <fieldset>
                                            <div class="mb-3 required">
                                                <label for="input-firstname-<?php echo $customer_address_row; ?>" class="form-label"><?php echo lang('Entry.firstname'); ?></label>
                                                <input type="text" name="customer_address[<?php echo $customer_address_row; ?>][firstname]" value="<?php echo $customer_address['firstname']; ?>" id="input-firstname-<?php echo $customer_address_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.firstname'); ?>">
                                                <?php if (!empty(${'error_customer_address_' . $customer_address_row . '_firstname'})) { ?><div class="text-danger small"><?php echo ${'error_customer_address_' . $customer_address_row . '_firstname'}; ?></div><?php } ?>
                                            </div>
                                            <div class="mb-3 required">
                                                <label for="input-lastname-<?php echo $customer_address_row; ?>" class="form-label"><?php echo lang('Entry.lastname'); ?></label>
                                                <input type="text" name="customer_address[<?php echo $customer_address_row; ?>][lastname]" value="<?php echo $customer_address['lastname']; ?>" id="input-lastname-<?php echo $customer_address_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.lastname'); ?>">
                                                <?php if (!empty(${'error_customer_address_' . $customer_address_row . '_lastname'})) { ?><div class="text-danger small"><?php echo ${'error_customer_address_' . $customer_address_row . '_lastname'}; ?></div><?php } ?>
                                            </div>
                                            <div class="mb-3 required">
                                                <label for="input-address-1-<?php echo $customer_address_row; ?>" class="form-label"><?php echo lang('Entry.address_1'); ?></label>
                                                <textarea rows="5" name="customer_address[<?php echo $customer_address_row; ?>][address_1]" id="input-address-1-<?php echo $customer_address_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.address_1'); ?>"><?php echo $customer_address['address_1']; ?></textarea>
                                                <?php if (!empty(${'error_customer_address_' . $customer_address_row . '_address_1'})) { ?><div class="text-danger small"><?php echo ${'error_customer_address_' . $customer_address_row . '_address_1'}; ?></div><?php } ?>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input-address-2-<?php echo $customer_address_row; ?>" class="form-label"><?php echo lang('Entry.address_2'); ?></label>
                                                <textarea rows="5" name="customer_address[<?php echo $customer_address_row; ?>][address_2]" id="input-address-2-<?php echo $customer_address_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.address_2'); ?>"><?php echo $customer_address['address_2']; ?></textarea>
                                            </div>
                                            <div class="mb-3 required">
                                                <label for="input-city-<?php echo $customer_address_row; ?>" class="form-label"><?php echo lang('Entry.city'); ?></label>
                                                <input type="text" name="customer_address[<?php echo $customer_address_row; ?>][city]" value="<?php echo $customer_address['city']; ?>" id="input-city-<?php echo $customer_address_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.city'); ?>">
                                                <?php if (!empty(${'error_customer_address_' . $customer_address_row . '_city'})) { ?><div class="text-danger small"><?php echo ${'error_customer_address_' . $customer_address_row . '_city'}; ?></div><?php } ?>
                                            </div>
                                            <div class="mb-3 required">
                                                <label for="input-country-<?php echo $customer_address_row; ?>" class="form-label"><?php echo lang('Entry.country'); ?></label>
                                                <select name="customer_address[<?php echo $customer_address_row; ?>][country_id]" id="input-country-<?php echo $customer_address_row; ?>" class="form-select" onchange="country(this, '<?php echo $customer_address_row; ?>', '<?php echo $customer_address['zone_id']; ?>');">
                                                <?php foreach ($countries as $country) { ?>
                                                    <?php if ($country['country_id'] == $customer_address['country_id']) { ?>
                                                    <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                                </select>
                                                <?php if (!empty(${'error_customer_address_' . $customer_address_row . '_country_id'})) { ?><div class="text-danger small"><?php echo ${'error_customer_address_' . $customer_address_row . '_country_id'}; ?></div><?php } ?>
                                            </div>
                                            <div class="mb-3 required">
                                                <label for="input-zone-<?php echo $customer_address_row; ?>" class="form-label"><?php echo lang('Entry.zone'); ?></label>
                                                <select name="customer_address[<?php echo $customer_address_row; ?>][zone_id]" id="input-zone-<?php echo $customer_address_row; ?>" class="form-select"></select>
                                                <?php if (!empty(${'error_customer_address_' . $customer_address_row . '_zone_id'})) { ?><div class="text-danger small"><?php echo ${'error_customer_address_' . $customer_address_row . '_zone_id'}; ?></div><?php } ?>
                                            </div>
                                            <div class="mb-3 required">
                                                <label for="input-telephone-<?php echo $customer_address_row; ?>" class="form-label"><?php echo lang('Entry.telephone'); ?></label>
                                                <input type="text" name="customer_address[<?php echo $customer_address_row; ?>][telephone]" value="<?php echo $customer_address['telephone']; ?>" id="input-telephone-<?php echo $customer_address_row; ?>" class="form-control" placeholder="<?php echo lang('Entry.telephone'); ?>">
                                                <?php if (!empty(${'error_customer_address_' . $customer_address_row . '_telephone'})) { ?><div class="text-danger small"><?php echo ${'error_customer_address_' . $customer_address_row . '_telephone'}; ?></div><?php } ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <?php $customer_address_row++; ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">
                        <div class="clearfix mb-3">
                            <span class="lead float-start"><?php echo lang('Text.balance'); ?>: <strong id="wallet-balance"><?php echo $wallet_balance; ?></strong></span>
                            <button type="button" id="button-add-transaction" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#add-transaction-modal"><i class="fas fa-plus-circle fa-fw"></i> <?php echo lang('Button.add_new'); ?></button>
                        </div>
                        <legend class="lead border-bottom border-warning pb-2 mb-3"><?php echo lang('Text.transactions'); ?></legend>
                        <div id="customer-wallet"></div>
                    </div>
                    <div class="tab-pane" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="add-transaction-modal" tabindex="-1" aria-labelledby="add-transaction-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add-transaction-modal-label"><?php echo lang('Text.transaction_add'); ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo form_open('', ['id' => 'form-transaction-add']); ?>
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-transaction-amount" class="form-label"><?php echo lang('Entry.amount'); ?></label>
                        <div class="input-group mb-3">
                            <?php if (!empty($default_currency['symbol_left'])) { ?><span class="input-group-text" id="addon-symbol-left"><?php echo $default_currency['code']; ?> <?php echo $default_currency['symbol_left']; ?></span><?php } ?>
                            <input type="number" name="amount" value="" id="input-transaction-amount" class="form-control" placeholder="<?php echo lang('Entry.amount'); ?>" aria-label="<?php echo lang('Entry.amount'); ?>">
                            <?php if (!empty($default_currency['symbol_right'])) { ?><span class="input-group-text" id="addon-symbol-right"><?php echo $default_currency['symbol_right']; ?> <?php echo $default_currency['code']; ?></span><?php } ?>
                        </div>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-transaction-description" class="form-label"><?php echo lang('Entry.description'); ?></label>
                        <?php foreach ($languages as $language) { ?>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><img src="<?php echo base_url('/assets/flags/' . $language['code'] . '.png'); ?>" /></span>
                            <textarea rows="3" name="description[<?php echo $language['language_id']; ?>" id="input-transaction-description-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.description'); ?>" aria-label="<?php echo lang('Entry.description'); ?>"></textarea>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="input-transaction-comment" class="form-label"><?php echo lang('Entry.comment'); ?></label>
                        <?php foreach ($languages as $language) { ?>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><img src="<?php echo base_url('/assets/flags/' . $language['code'] . '.png'); ?>" /></span>
                            <textarea rows="3" name="comment[<?php echo $language['language_id']; ?>" id="input-transaction-comment-<?php echo $language['language_id']; ?>" class="form-control" placeholder="<?php echo lang('Entry.comment'); ?>" aria-label="<?php echo lang('Entry.comment'); ?>"></textarea>
                        </div>
                        <?php } ?>
                    </div>
                </fieldset>
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo lang('Button.close'); ?></button>
                <button type="button" class="btn btn-primary" id="button-transaction-add" onclick="addTransaction();"><i class="fas fa-save fa-fw"></i> <?php echo lang('Button.submit'); ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
var customer_address_row = '<?php echo $customer_address_row; ?>';

function addAddress() {
    html = '<div class="tab-pane" id="v-pills-customer-address-' + customer_address_row + '" role="tabpanel" aria-labelledby="v-pills-customer-address-tab=' + customer_address_row + '">';
    html += '<legend class="lead border-bottom border-warning pb-2 mb-3"><?php echo lang('Tab.address'); ?> ' + customer_address_row + '</legend>';
    html += '<fieldset>';
    html += '    <div class="mb-3 required">';
    html += '        <label for="input-firstname-' + customer_address_row + '" class="form-label"><?php echo lang('Entry.firstname'); ?></label>';
    html += '        <input type="text" name="customer_address[' + customer_address_row + '][firstname]" value="" id="input-firstname-' + customer_address_row + '" class="form-control" placeholder="<?php echo lang('Entry.firstname'); ?>">';
    html += '    </div>';
    html += '    <div class="mb-3 required">';
    html += '        <label for="input-lastname-' + customer_address_row + '" class="form-label"><?php echo lang('Entry.lastname'); ?></label>';
    html += '        <input type="text" name="customer_address[' + customer_address_row + '][lastname]" value="" id="input-lastname-' + customer_address_row + '" class="form-control" placeholder="<?php echo lang('Entry.lastname'); ?>">';
    html += '    </div>';
    html += '    <div class="mb-3 required">';
    html += '        <label for="input-address-1-' + customer_address_row + '" class="form-label"><?php echo lang('Entry.address_1'); ?></label>';
    html += '        <textarea rows="5" name="customer_address[' + customer_address_row + '][address_1]" id="input-address-1-' + customer_address_row + '" class="form-control" placeholder="<?php echo lang('Entry.address_1'); ?>"></textarea>';
    html += '    </div>';
    html += '    <div class="mb-3 required">';
    html += '        <label for="input-address-2-' + customer_address_row + '" class="form-label"><?php echo lang('Entry.address_2'); ?></label>';
    html += '        <textarea rows="5" name="customer_address[' + customer_address_row + '][address_2]" id="input-address-2-' + customer_address_row + '" class="form-control" placeholder="<?php echo lang('Entry.address_1'); ?>"></textarea>';
    html += '    </div>';
    html += '    <div class="mb-3 required">';
    html += '        <label for="input-city-' + customer_address_row + '" class="form-label"><?php echo lang('Entry.city'); ?></label>';
    html += '        <input type="text" name="customer_address[' + customer_address_row + '][city]" value="" id="input-city-' + customer_address_row + '" class="form-control" placeholder="<?php echo lang('Entry.city'); ?>">';
    html += '    </div>';
    html += '    <div class="mb-3 required">';
    html += '        <label for="input-country-' + customer_address_row + '" class="form-label"><?php echo lang('Entry.country'); ?></label>';
    html += '        <select name="customer_address[' + customer_address_row + '][country_id]" id="input-country-' + customer_address_row + '" class="form-select" onchange="country(this, \'' + customer_address_row + '\', \'0\');">';
    <?php foreach ($countries as $country) { ?>
    html += '            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>';
    <?php } ?>
    html += '        </select>';
    html += '    </div>';
    html += '    <div class="mb-3 required">';
    html += '        <label for="input-zone-' + customer_address_row + '" class="form-label"><?php echo lang('Entry.zone'); ?></label>';
    html += '        <select name="customer_address[' + customer_address_row + '][zone_id]" id="input-zone-' + customer_address_row + '" class="form-select">';
    html += '        </select>';
    html += '    </div>';
    html += '    <div class="mb-3 required">';
    html += '        <label for="input-telephone-' + customer_address_row + '" class="form-label"><?php echo lang('Entry.telephone'); ?></label>';
    html += '        <input type="text" name="customer_address[' + customer_address_row + '][telephone]" value="" id="input-telephone-' + customer_address_row + '" class="form-control" placeholder="<?php echo lang('Entry.telephone'); ?>">';
    html += '    </div>';
    html += '</fieldset>';
    html += '</div>';

    $('#v-pills-customer-tab-content').append(html);

    $('#button-address').before('<button class="nav-link text-start" id="v-pills-customer-address-tab-' + customer_address_row + '" data-bs-toggle="pill" data-bs-target="#v-pills-customer-address-' + customer_address_row + '" type="button" role="tab" aria-controls="v-pills-customer-address-' + customer_address_row + '" aria-selected="false"><i class="fas fa-minus-circle" onclick="removeAddress(' + customer_address_row + ');"></i> <?php echo lang('Tab.address'); ?> ' + customer_address_row + '</button>');

    var customerAddressLastTabEl = document.querySelector('#v-pills-customer-tab button:nth-last-child(2)')
    var customerAddressLastTab = new bootstrap.Tab(customerAddressLastTabEl)

    customerAddressLastTab.show()

    $('select[name=\'customer_address[' + customer_address_row + '][country_id]\']').trigger('change');

    customer_address_row++;
}
//--></script> 
<script type="text/javascript"><!--
function removeAddress(customer_address_row) {
    $('#v-pills-customer-address-tab-' + customer_address_row).remove();
    $('#v-pills-customer-address-' + customer_address_row).remove();

    var customerAddressFirstTabEl = document.querySelector('#v-pills-customer-tab button:first-child')
    var customerAddressFirstTab = new bootstrap.Tab(customerAddressFirstTabEl)

    customerAddressFirstTab.show()
}
//--></script> 
<script type="text/javascript"><!--
$('#customer-wallet').load('<?php echo $wallet_url; ?>');
//--></script> 
<script type="text/javascript"><!--
function addTransaction() {
    var transaction_inputs = $('#form-transaction-add').find('textarea, input').serializeJSON();

    $.ajax({
        url: '<?php echo $add_transaction_url; ?>',
        type: 'post',
        dataType: 'json',
        data: JSON.stringify(transaction_inputs),
        beforeSend: function() {
            $('#button-transaction-add i').removeClass('fa-save').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            $('#button-transaction-add i').removeClass('fa-spinner fa-spin').addClass('fa-save');
        },
        success: function(json) {
            $('.text-danger').remove();

            if (json['error']) {
                for (var key in json['error']) {
                    $('#input-' + key).parent().after('<div class="text-danger small">' + json['error'][key] + '</div>');
                }
            }

            if (json['success']) {
                $('#customer-wallet').load('<?php echo $wallet_url; ?>');

                getWalletBalance();

                $('#form-transaction-add')[0].reset();

                $('#add-transaction-modal').modal('hide');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function getWalletBalance() {
    $.ajax({
        url: '<?php echo $wallet_balance_url; ?>',
        type: 'post',
        dataType: 'json',
        data: {},
        beforeSend: function() {
        },
        complete: function() {
        },
        success: function(json) {
            $('#wallet-balance').html(json['wallet_balance']);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
//--></script>
<script type="text/javascript"><!--
const addTransactionModal = document.getElementById('add-transaction-modal');

addTransactionModal.addEventListener('hidden.bs.modal', event => {
    $('#form-transaction-add')[0].reset();
});
//--></script>
<script type="text/javascript"><!--
function country(element, index, zone_id) {
    $.ajax({
        url: '<?php echo base_url(); ?>' + '/<?php echo env('app.adminUrlSegment'); ?>/localisation/country/get_country?administrator_token=<?php echo $administrator_token; ?>&country_id=' + element.value,
        dataType: 'json',
        beforeSend: function() {
            $('select[name=\'customer_address[' + index + '][country_id]\']').prop('disabled', true);
        },
        complete: function() {
            $('select[name=\'customer_address[' + index + '][country_id]\']').prop('disabled', false);
        },
        success: function(json) {
            html = '<option value=""><?php echo lang('Text.please_select'); ?></option>';
            
            if (json['zones'] && json['zones'] != '') {
                for (i = 0; i < json['zones'].length; i++) {
                    zone = json['zones'][i];

                    html += '<option value="' + zone['zone_id'] + '"';
                    
                    if (zone['zone_id'] == zone_id) {
                        html += ' selected="selected"';
                    }
                    
                    html += '>' + zone['name'] + '</option>';
                }
            } else {
                html += '<option value="0" selected="selected"><?php echo lang('Text.none'); ?></option>';
            }
            
            $('select[name=\'customer_address[' + index + '][zone_id]\']').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

$('select[name$=\'[country_id]\']').trigger('change');
//--></script> 
<?php echo $footer; ?>
