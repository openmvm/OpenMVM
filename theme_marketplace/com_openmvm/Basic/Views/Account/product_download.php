<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th><?php echo lang('Column.order_id', [], $language_lib->getCurrentCode()); ?></th>
                    <th><?php echo lang('Column.date', [], $language_lib->getCurrentCode()); ?></th>
                    <th><?php echo lang('Column.product', [], $language_lib->getCurrentCode()); ?></th>
                    <th><?php echo lang('Column.download_name', [], $language_lib->getCurrentCode()); ?></th>
                    <th><?php echo lang('Column.filename', [], $language_lib->getCurrentCode()); ?></th>
                    <th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($product_downloads)) { ?>
                    <?php foreach ($product_downloads as $product_download) { ?>
                    <tr>
                        <td><?php echo $product_download['order_id']; ?></td>
                        <td><?php echo $product_download['date_added']; ?></td>
                        <td><?php echo $product_download['product_name']; ?></td>
                        <td><?php echo $product_download['name']; ?></td>
                        <td><?php echo $product_download['filename']; ?></td>
                        <td class="text-end"><a href="<?php echo $product_download['download']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-download"></i></a></td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                <tr>
                    <td colspan="6"><?php echo lang('Text.not_found', [], $language_lib->getCurrentCode()); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php echo $footer; ?>
