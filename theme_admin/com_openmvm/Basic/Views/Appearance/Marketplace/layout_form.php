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
                <h3 class="card-title"><i class="fas fa-th-large fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-layout']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix">
                <h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5>
                <div class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-layout" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save_and_continue', [], 'en'); ?></span></button>
                    <button type="button" class="btn btn-sm btn-success button-action" data-form="form-layout" data-form-action="<?php echo $action; ?>" data-icon="fa-save" data-toast-heading-title-success="<?php echo lang('Text.success', [], 'en'); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], 'en'); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="true"><i class="fas fa-save fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.save', [], 'en'); ?></span></button>
                    <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a>
                </div>
            </div>
            <div class="card-body">
                <fieldset>
                    <div class="mb-3 required">
                        <label for="input-name" class="form-label"><?php echo lang('Entry.name'); ?></label>
                        <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" placeholder="<?php echo lang('Entry.name'); ?>">
                        <?php if (!empty($error_name)) { ?><div class="text-danger small"><?php echo $error_name; ?></div><?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="input-route" class="form-label"><?php echo lang('Entry.route'); ?></label>
                        <div id="routes" class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('Entry.route'); ?></th>
                                        <th class="text-end"><?php echo lang('Column.action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $route_row = 1; ?>
                                    <?php if ($routes) { ?>
                                        <?php foreach ($routes as $route) { ?>
                                        <tr id="route-<?php echo $route_row; ?>">
                                            <td><input type="test" name="route[<?php echo $route_row; ?>][route]" value="<?php echo $route['route']; ?>" id="input-route-<?php echo $route_row; ?>" class="form-control" /></td>
                                            <td class="text-end"><button type="button" id="button-route-remove-<?php echo $route_row; ?>" class="btn btn-danger btn-sm" onclick="$('#route-<?php echo $route_row; ?>').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>
                                        </tr>
                                        <?php $route_row++; ?>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end"><button type="button" id="button-add" class="btn btn-primary btn-sm" onclick="addRoute();"><i class="fas fa-plus fa-fw"></i></button></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
var route_row = '<?php echo $route_row; ?>';

function addRoute() {
    html = '<tr id="route-' + route_row + '">';
    html += '    <td><input type="text" name="route[' + route_row + '][route]" value="" id="input-row-' + route_row + '" class="form-control" /></td>';
    html += '    <td class="text-end"><button type="button" id="button-route-remove-' + route_row + '" class="btn btn-danger btn-sm" onclick="$(\'#route-' + route_row + '\').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>';
    html += '</tr>';

    $('#routes table tbody').append(html);

    route_row++;
}
//--></script> 
<?php echo $footer; ?>
