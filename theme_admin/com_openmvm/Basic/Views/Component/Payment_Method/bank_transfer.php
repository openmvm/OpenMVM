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
                <h3 class="card-title"><i class="fas fa-wallet fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php if ($error_warning) { ?>
        <div class="alert alert-warning alert-dismissible border-0 shadow fade show" role="alert">
            <?php echo $error_warning; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert alert-success alert-dismissible border-0 shadow fade show" role="alert">
            <?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>
        <?php echo form_open($action, ['id' => 'form-payment-method']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo lang('Heading.edit'); ?></h5> <div class="float-end"><button type="submit" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.save'); ?>"><i class="fas fa-save fa-fw"></i></button> <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.cancel'); ?>"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-instruction" class="form-label"><?php echo lang('Entry.instructions'); ?></label>
                        <?php foreach ($languages as $language) { ?>
                            <div class="form-floating mb-3">
                                <textarea name="component_payment_method_bank_transfer_instruction_<?php echo $language['language_id']; ?>" class="form-control" placeholder="Leave a comment here" id="instruction-<?php echo $language['language_id']; ?>" style="height: 200px;"><?php echo ${'component_payment_method_bank_transfer_instruction_' . $language['language_id']}; ?></textarea>
                                <label for="instruction-<?php echo $language['language_id']; ?>" class="small"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></label>
                                <?php if (!empty(${'error_component_payment_method_bank_transfer_instruction_' . $language['language_id']})) { ?><div class="text-danger small"><?php echo ${'error_component_payment_method_bank_transfer_instruction_' . $language['language_id']}; ?></div><?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-amount" class="form-label"><?php echo lang('Entry.amount'); ?></label>
                        <input type="number" step="any" min="0" name="component_payment_method_bank_transfer_amount" value="<?php echo $component_payment_method_bank_transfer_amount; ?>" id="input-amount" class="form-control" placeholder="<?php echo lang('Entry.amount'); ?>">
                        <div class="text-muted small"><?php echo lang('Help.checkout_total_amount'); ?></div>
                        <?php if (!empty($error_component_payment_method_bank_transfer_amount)) { ?><div class="text-danger small"><?php echo $error_component_payment_method_bank_transfer_amount; ?></div><?php } ?>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-geo-zone" class="form-label"><?php echo lang('Entry.geo_zone'); ?></label>
                        <select name="component_payment_method_bank_transfer_geo_zone_id" class="form-control" id="input-geo-zone">
                            <?php foreach ($geo_zones as $geo_zone) { ?>
                                <?php if ($geo_zone['geo_zone_id'] == $component_payment_method_bank_transfer_geo_zone_id) { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-order-status" class="form-label"><?php echo lang('Entry.order_status'); ?></label>
                        <select name="component_payment_method_bank_transfer_order_status_id" class="form-control" id="input-order-status">
                            <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $component_payment_method_bank_transfer_order_status_id) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="input-sort-order" class="form-label"><?php echo lang('Entry.sort_order'); ?></label>
                        <input type="number" step="any" min="0" name="component_payment_method_bank_transfer_sort_order" value="<?php echo $component_payment_method_bank_transfer_sort_order; ?>" id="input-sort-order" class="form-control" placeholder="<?php echo lang('Entry.sort_order'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="input-status" class="form-label"><?php echo lang('Entry.status'); ?></label>
                        <select name="component_payment_method_bank_transfer_status" id="input-status" class="form-control">
                            <?php if ($component_payment_method_bank_transfer_status) { ?>
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
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>
