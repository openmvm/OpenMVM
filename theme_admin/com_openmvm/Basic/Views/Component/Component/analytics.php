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
                <h3 class="card-title"><i class="fas fa-chart-bar fa-fw"></i> <?php echo $heading_title; ?></h3>
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
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-list fa-fw"></i> <?php echo lang('Heading.list'); ?></h5> <div class="float-end"><a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.cancel'); ?>"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <table class="table table-hover">
                    <caption><?php echo lang('Caption.list_of_analytics'); ?></caption>
                    <thead>
                        <tr>
                            <th scope="col"><?php echo lang('Column.name'); ?></th>
                            <th scope="col"><?php echo lang('Column.author'); ?></th>
                            <th scope="col" class="text-end"><?php echo lang('Column.action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($analytics) { ?>
                            <?php foreach ($analytics as $analytic) { ?>
                            <tr>
                                <td><?php echo $analytic['name']; ?></td>
                                <td><?php echo $analytic['author']; ?></td>
                                <td class="text-end"><?php if ($analytic['installed']) { ?><a href="<?php echo $analytic['uninstall']; ?>" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.uninstall'); ?>" onclick="return confirm('<?php echo lang('Text.are_you_sure'); ?>');"><i class="fas fa-minus-circle fa-fw"></i></a> <a href="<?php echo $analytic['edit']; ?>" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.edit'); ?>"><i class="fas fa-edit fa-fw"></i></a><?php } else { ?><a href="<?php echo $analytic['install']; ?>" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('Button.install'); ?>"><i class="fas fa-magic fa-fw"></i></a><?php } ?></td>
                            </tr>
                            <?php } ?>
                        <?php } else { ?>
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
