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
                <h3 class="card-title"><i class="fas fa-puzzle-piece fa-fw"></i> <?php echo $heading_title; ?></h3>
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
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-list fa-fw"></i> <?php echo lang('Heading.list'); ?></h5> <div class="float-end"><a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <table class="table table-hover">
                    <caption><?php echo lang('Caption.list_of_widgets'); ?></caption>
                    <thead>
                        <tr>
                            <th scope="col"><?php echo lang('Column.widget'); ?></th>
                            <th scope="col" class="text-end"><?php echo lang('Column.status'); ?></th>
                            <th scope="col" class="text-end"><?php echo lang('Column.action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($widgets) { ?>
                            <tr>
                                <td colspan="3" class="text-dark bg-warning bg-opacity-25"><strong><?php echo lang('Text.core_widgets'); ?></strong></td>
                            </tr>
                            <?php foreach ($widgets as $widget) { ?>
                            <tr>
                                <td><strong><?php echo $widget['name']; ?></strong></td>
                                <td class="text-end">&nbsp;</td>
                                <td class="text-end">
                                    <?php if ($widget['is_installed']) { ?>
                                    <a href="<?php echo $widget['uninstall']; ?>" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.uninstall'); ?>"><i class="fas fa-minus-circle fa-fw"></i></a>
                                    <a href="<?php echo $widget['add']; ?>" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.add'); ?>"><i class="fas fa-plus fa-fw"></i></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $widget['install']; ?>" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.install'); ?>"><i class="fas fa-magic fa-fw"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                                <?php if ($widget['widget']) { ?>
                                    <?php foreach ($widget['widget'] as $added_widget) { ?>
                                    <tr>
                                        <td class="ps-4">&middot; <?php echo $added_widget['name']; ?></td>
                                        <td class="text-end"><?php if ($added_widget['status']) { ?><span class="text-success"><?php echo lang('Text.enabled'); ?></span><?php } else { ?><span class="text-danger"><?php echo lang('Text.disabled'); ?></span><?php } ?></td>
                                        <td class="text-end"><a href="<?php echo $added_widget['delete']; ?>" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.delete'); ?>"><i class="fas fa-times-circle fa-fw"></i></a> <a href="<?php echo $added_widget['edit']; ?>" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.edit'); ?>"><i class="fas fa-edit fa-fw"></i></a></td>
                                    </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($plugin_widgets) { ?>
                            <tr>
                                <td colspan="3" class="text-dark bg-warning bg-opacity-25"><strong><?php echo lang('Text.plugin_widgets'); ?></strong></td>
                            </tr>
                            <?php foreach ($plugin_widgets as $plugin_widget) { ?>
                            <tr>
                                <td><strong><?php echo $plugin_widget['name']; ?></strong></td>
                                <td></td>
                                <td class="text-end">
                                    <?php if ($plugin_widget['is_installed']) { ?>
                                    <a href="<?php echo $plugin_widget['uninstall']; ?>" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.uninstall'); ?>"><i class="fas fa-minus-circle fa-fw"></i></a>
                                    <a href="<?php echo $plugin_widget['add']; ?>" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.add'); ?>"><i class="fas fa-plus fa-fw"></i></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $plugin_widget['install']; ?>" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.install'); ?>"><i class="fas fa-magic fa-fw"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                                <?php if ($plugin_widget['widget']) { ?>
                                    <?php foreach ($plugin_widget['widget'] as $added_widget) { ?>
                                    <tr>
                                        <td class="ps-4">&middot; <?php echo $added_widget['name']; ?></td>
                                        <td class="text-end"><?php if ($added_widget['status']) { ?><span class="text-success"><?php echo lang('Text.enabled'); ?></span><?php } else { ?><span class="text-danger"><?php echo lang('Text.disabled'); ?></span><?php } ?></td>
                                        <td class="text-end"><a href="<?php echo $added_widget['delete']; ?>" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.delete'); ?>"><i class="fas fa-times-circle fa-fw"></i></a> <a href="<?php echo $added_widget['edit']; ?>" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.edit'); ?>"><i class="fas fa-edit fa-fw"></i></a></td>
                                    </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        <?php if (empty($widgets) && empty($plugin_widgets)) { ?>
                        <tr>
                            <td colspan="3" class="text-muted text-center"><?php echo lang('Error.no_data_found'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>
