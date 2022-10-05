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
                <h3 class="card-title"><i class="fas fa-shipping-fast fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-shipping-method']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo lang('Heading.edit'); ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-shipping-method" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-shipping-method" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.cancel'); ?>"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-amount" class="form-label"><?php echo lang('Entry.amount'); ?></label>
                        <input type="number" step="any" min="0" name="component_shipping_method_flat_rate_amount" value="<?php echo $component_shipping_method_flat_rate_amount; ?>" id="input-amount" class="form-control" placeholder="<?php echo lang('Entry.amount'); ?>">
                        <div class="text-muted small"><?php echo lang('Help.checkout_total_amount'); ?></div>
                        <?php if (!empty($error_component_shipping_method_flat_rate_amount)) { ?><div class="text-danger small"><?php echo $error_component_shipping_method_flat_rate_amount; ?></div><?php } ?>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-geo-zone" class="form-label"><?php echo lang('Entry.geo_zone'); ?></label>
                        <select name="component_shipping_method_flat_rate_geo_zone_id" class="form-control" id="input-geo-zone">
                            <?php foreach ($geo_zones as $geo_zone) { ?>
                                <?php if ($geo_zone['geo_zone_id'] == $component_shipping_method_flat_rate_geo_zone_id) { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3 required">
                        <label for="input-sort-order" class="form-label"><?php echo lang('Entry.sort_order'); ?></label>
                        <input type="number" step="any" min="0" name="component_shipping_method_flat_rate_sort_order" value="<?php echo $component_shipping_method_flat_rate_sort_order; ?>" id="input-sort-order" class="form-control" placeholder="<?php echo lang('Entry.sort_order'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="input-status" class="form-label"><?php echo lang('Entry.status'); ?></label>
                        <select name="component_shipping_method_flat_rate_status" id="input-status" class="form-control">
                            <?php if ($component_shipping_method_flat_rate_status) { ?>
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
