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
                <h3 class="card-title"><i class="fas fa-handshake fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-payment-method']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo lang('Heading.edit'); ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-payment-method" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-payment-method" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.cancel'); ?>"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-instruction" class="form-label"><?php echo lang('Entry.instructions'); ?></label>
                        <?php foreach ($languages as $language) { ?>
                            <div class="form-floating mb-3">
                                <textarea name="component_payment_method_free_checkout_instruction_<?php echo $language['language_id']; ?>" class="form-control" placeholder="Leave a comment here" id="input-instruction-<?php echo $language['language_id']; ?>" style="height: 200px;"><?php echo ${'component_payment_method_free_checkout_instruction_' . $language['language_id']}; ?></textarea>
                                <label for="input-instruction-<?php echo $language['language_id']; ?>" class="small"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /></label>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-order-status" class="form-label"><?php echo lang('Entry.order_status'); ?></label>
                        <select name="component_payment_method_free_checkout_order_status_id" class="form-select" id="input-order-status">
                            <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $component_payment_method_free_checkout_order_status_id) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="input-sort-order" class="form-label"><?php echo lang('Entry.sort_order'); ?></label>
                        <input type="number" step="any" min="0" name="component_payment_method_free_checkout_sort_order" value="<?php echo $component_payment_method_free_checkout_sort_order; ?>" id="input-sort-order" class="form-control" placeholder="<?php echo lang('Entry.sort_order'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="input-status" class="form-label"><?php echo lang('Entry.status'); ?></label>
                        <select name="component_payment_method_free_checkout_status" id="input-status" class="form-select">
                            <?php if ($component_payment_method_free_checkout_status) { ?>
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
