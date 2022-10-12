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
                <h3 class="card-title"><i class="fas fa-ruler-combined fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-length-class']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-list fa-fw"></i> <?php echo lang('Heading.list'); ?></h5>
                <div class="float-end">
                    <a href="<?php echo $add; ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus fa-fw"></i></a>
                    <button type="button" class="btn btn-sm btn-danger button-action" data-form="form-length-class" data-form-action="<?php echo $action; ?>" data-form-confirm-text="<?php echo lang('Text.are_you_sure', [], 'en'); ?>" data-icon="fa-trash-can" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-trash-can fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.delete', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <caption><?php echo lang('Caption.list_of_length_classes'); ?></caption>
                    <thead>
                        <tr>
                            <th scope="col"><input class="form-check-input" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                            <th scope="col"><?php echo lang('Column.title'); ?></th>
                            <th scope="col"><?php echo lang('Column.unit'); ?></th>
                            <th scope="col"><?php echo lang('Column.value'); ?></th>
                            <th scope="col" class="text-end"><?php echo lang('Column.action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($length_classes) { ?>
                            <?php foreach ($length_classes as $length_class) { ?>
                            <tr>
                                <th scope="row">
                                    <div class="form-check">
                                        <?php if (in_array($length_class['length_class_id'], $selected)) { ?>
                                        <input class="form-check-input" type="checkbox" name="selected[]" value="<?php echo $length_class['length_class_id']; ?>" id="input-selected-<?php echo $length_class['length_class_id']; ?>" checked="checked">
                                        <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" name="selected[]" value="<?php echo $length_class['length_class_id']; ?>" id="input-selected-<?php echo $length_class['length_class_id']; ?>">
                                        <?php } ?>
                                    </div>                                        
                                </th>
                                <td><?php echo $length_class['title']; ?> <?php if ($length_class['length_class_id'] == $default) { ?><strong>( <?php echo lang('Text.default'); ?> )</strong><?php } ?></td>
                                <td><?php echo $length_class['unit']; ?></td>
                                <td><?php echo $length_class['value']; ?></td>
                                <td class="text-end"><a href="<?php echo $length_class['href']; ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit fa-fw"></i></a></td>
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
        <?php echo form_close(); ?>
    </div>
</div>
<?php echo $footer; ?>
