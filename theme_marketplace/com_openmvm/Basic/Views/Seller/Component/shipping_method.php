<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-list fa-fw"></i> <?php echo lang('Heading.list', [], $language_lib->getCurrentCode()); ?></h5> <div class="float-end"><a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.cancel', [], $language_lib->getCurrentCode()); ?>"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <table class="table table-hover">
                    <caption><?php echo lang('Caption.list_of_shipping_methods', [], $language_lib->getCurrentCode()); ?></caption>
                    <thead>
                        <tr>
                            <th scope="col"><?php echo lang('Column.name', [], $language_lib->getCurrentCode()); ?></th>
                            <th scope="col"><?php echo lang('Column.author', [], $language_lib->getCurrentCode()); ?></th>
                            <th scope="col" class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($shipping_methods) { ?>
                            <?php foreach ($shipping_methods as $shipping_method) { ?>
                            <tr>
                                <td><?php echo $shipping_method['name']; ?></td>
                                <td><?php echo $shipping_method['author']; ?></td>
                                <td class="text-end"><a href="<?php echo $shipping_method['edit']; ?>" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.edit', [], $language_lib->getCurrentCode()); ?>"><i class="fas fa-edit fa-fw"></i></a></td>
                            </tr>
                            <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td colspan="3" class="text-muted text-center"><?php echo lang('Error.no_data_found', [], $language_lib->getCurrentCode()); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>
