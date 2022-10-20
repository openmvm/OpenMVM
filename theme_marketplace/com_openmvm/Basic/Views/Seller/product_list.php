<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <?php echo form_open($action, ['id' => 'form-product']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-list fa-fw"></i> <?php echo lang('Heading.list', [], $language_lib->getCurrentCode()); ?></h5>
                <div class="float-end">
                    <a href="<?php echo $add; ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus fa-fw"></i></a>
                    <button type="button" class="btn btn-sm btn-danger button-action" data-form="form-product" data-form-action="<?php echo $action; ?>" data-form-confirm-text="<?php echo lang('Text.are_you_sure', [], $language_lib->getCurrentCode()); ?>" data-icon="fa-trash-can" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-trash-can fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.delete', [], $language_lib->getCurrentCode()); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <caption><?php echo lang('Caption.list_of_products', [], $language_lib->getCurrentCode()); ?></caption>
                    <thead>
                        <tr>
                            <th scope="col"><input class="form-check-input" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                            <th scope="col"><?php echo lang('Column.image', [], $language_lib->getCurrentCode()); ?></th>
                            <th scope="col"><?php echo lang('Column.name', [], $language_lib->getCurrentCode()); ?></th>
                            <th scope="col"><?php echo lang('Column.price', [], $language_lib->getCurrentCode()); ?></th>
                            <th scope="col"><?php echo lang('Column.quantity', [], $language_lib->getCurrentCode()); ?></th>
                            <th scope="col"><?php echo lang('Column.status', [], $language_lib->getCurrentCode()); ?></th>
                            <th scope="col" class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($products) { ?>
                            <?php foreach ($products as $product) { ?>
                            <tr>
                                <th scope="row">
                                    <div class="form-check">
                                        <?php if (in_array($product['product_id'], $selected)) { ?>
                                        <input class="form-check-input" type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" id="input-selected-<?php echo $product['product_id']; ?>" checked="checked">
                                        <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" id="input-selected-<?php echo $product['product_id']; ?>">
                                        <?php } ?>
                                    </div>                                        
                                </th>
                                <td><img src="<?php echo $product['thumb']; ?>" class="border p-1" /></td>
                                <td><?php echo $product['name']; ?></td>
                                <td>
                                    <?php if ($product['product_option']) { ?>
                                        <?php if ($product['min_price'] !== $product['max_price']) { ?>
                                        <span><?php echo $product['min_price']; ?></span> - <span><?php echo $product['max_price']; ?></span>
                                        <?php } else { ?>
                                        <span><?php echo $product['min_price']; ?></span>
                                        <?php } ?>
                                    <?php } else { ?>
                                    <span><?php echo $product['price']; ?></span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($product['product_option']) { ?>
                                        <?php if ($product['min_quantity'] !== $product['max_quantity']) { ?>
                                        <span><?php echo $product['min_quantity']; ?></span> - <span><?php echo $product['max_quantity']; ?></span>
                                        <?php } else { ?>
                                        <span><?php echo $product['min_quantity']; ?></span>
                                        <?php } ?>
                                    <?php } else { ?>
                                    <span><?php echo $product['quantity']; ?></span>
                                    <?php } ?>
                                </td>
                                <td><?php echo $product['status']; ?></td>
                                <td class="text-end"><a href="<?php echo $product['href']; ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit fa-fw"></i></a></td>
                            </tr>
                            <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td colspan="7" class="text-muted text-center"><?php echo lang('Error.no_data_found', [], $language_lib->getCurrentCode()); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>
