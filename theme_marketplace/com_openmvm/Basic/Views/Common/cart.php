<?php if (!empty($sellers)) { ?>
    <?php foreach ($sellers as $seller) { ?>
    <h5 class="border-bottom pb-3"><?php echo $seller['store_name']; ?></h5>
    <div class="text-end small"><strong><?php echo lang('Text.weight'); ?>:</strong> <?php echo $seller['weight']; ?></div>
        <?php if ($seller['product']) { ?>
            <div class="table-responsive mb-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap" scope="col"><?php echo lang('Column.image'); ?></th>
                            <th class="text-nowrap" scope="col"><?php echo lang('Column.product'); ?></th>
                            <th class="text-nowrap text-end" scope="col"><?php echo lang('Column.qty'); ?></th>
                            <th class="text-nowrap text-end" scope="col"><?php echo lang('Column.sub_total'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($seller['product'] as $product) { ?>
                        <tr>
                            <td><img src="<?php echo $product['thumb']; ?>" class="border p-1" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"></td>
                            <td class="small">
                                <div><?php echo $product['name']; ?></div>
                                <div class="text-muted my-3"><?php echo $product['quantity']; ?> X <?php echo $product['price']; ?></div>
                                <div><a href="#" class="link-danger text-decoration-none"><i class="fas fa-trash-alt fa-fw"></i> <?php echo lang('Button.remove'); ?></a></div>
                            </td>
                            <td class="text-end small"><?php echo $product['quantity']; ?></td>
                            <td class="text-end small"><?php echo $product['total']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    <div class="d-grid gap-2 mb-5"><a href="<?php echo $seller['checkout']; ?>" class="btn btn-primary"><?php echo lang('button.checkout'); ?></a></div>
    <?php } ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="d-grid gap-2"><a href="<?php echo $shopping_cart; ?>" class="btn btn-danger"><?php echo lang('Button.shopping_cart'); ?></a></div>
        </div>
        <div class="col-sm-6">
            <div class="d-grid gap-2"><a href="<?php echo $checkout; ?>" class="btn btn-success"><?php echo lang('Button.checkout_all'); ?></a></div>
        </div>
    </div>
<script type="text/javascript"><!--
$(document).ready(function() {
    $('#offcanvas-right-icon-total-products').remove();

    var total_products = '<?php echo $total_products; ?>';

    html = '<span id="offcanvas-right-icon-total-products" class="position-absolute top-25 start-75 translate-middle badge rounded-pill bg-danger small">';
    html += '    <small>' + total_products + '</small>';
    html += '</span>';
    
    $('#icon-offcanvas-right').append(html);
});
//--></script> 
<?php } else { ?>
<div><?php echo lang('Text.cart_empty'); ?></div>
<?php } ?>
