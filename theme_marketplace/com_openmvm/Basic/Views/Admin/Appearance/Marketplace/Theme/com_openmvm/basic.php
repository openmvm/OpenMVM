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
        <div class="card border-0 shadow heading mb-3">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-paint-roller fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php echo form_open($action, ['id' => 'form-theme']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5> <div class="float-end"><button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-save fa-fw"></i></button> <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="true"><?php echo lang('Tab.data', [], $language_lib->getCurrentCode()); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="widget-layouts-tab" data-bs-toggle="tab" data-bs-target="#widget-layouts" type="button" role="tab" aria-controls="widget-layouts" aria-selected="false"><?php echo lang('Tab.widget_layouts', [], $language_lib->getCurrentCode()); ?></button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">...</div>
                    <div class="tab-pane fade" id="widget-layouts" role="tabpanel" aria-labelledby="widget-layouts-tab">
                        <!-- Header widgets -->
                        <fieldset class="mb-5">
                            <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.header', [], $language_lib->getCurrentCode()); ?></legend>
                            <div id="header-widgets" class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang('Column.widget', [], $language_lib->getCurrentCode()); ?></th>
                                            <th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $header_widget_row = 0; ?>
                                        <?php if ($header_widgets) { ?>
                                            <?php foreach ($header_widgets as $header_widget) { ?>
                                            <tr id="header-widget-<?php echo $header_widget_row; ?>">
                                                <td>
                                                    <select name="theme_marketplace_com_openmvm_basic_header_widget[<?php echo $header_widget_row; ?>]" id="input-header-widget-<?php echo $header_widget_row; ?>" class="form-select">
                                                        <?php if ($widgets) { ?>
                                                            <?php foreach ($widgets as $widget) { ?>
                                                                <?php if ($widget['is_installed']) { ?>
                                                                <optgroup label="<?php echo $widget['name']; ?>">
                                                                    <?php if ($widget['widget']) { ?>
                                                                        <?php foreach ($widget['widget'] as $header_added_widget) { ?>
                                                                            <?php if ($header_added_widget['widget_id'] == $header_widget) { ?>
                                                                            <option value="<?php echo $header_added_widget['widget_id']; ?>" selected="selected"><?php echo $header_added_widget['name']; ?></option>
                                                                            <?php } else { ?>
                                                                            <option value="<?php echo $header_added_widget['widget_id']; ?>"><?php echo $header_added_widget['name']; ?></option>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </optgroup>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td class="text-end"><button type="button" id="button-header-widget-remove" class="btn btn-danger btn-sm" onclick="$('#header-widget-<?php echo $header_widget_row; ?>').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>
                                            </tr>
                                            <?php $header_widget_row++; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-end"><button type="button" id="button-header-widget-add" class="btn btn-primary btn-sm" onclick="addHeaderWidget();"><i class="fas fa-plus fa-fw"></i></button></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div> 
                        </fieldset>
                        <!-- Header widgets //-->
                        <!-- Content widgets -->
                        <fieldset class="mb-5">
                            <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.content', [], $language_lib->getCurrentCode()); ?></legend> 
                            <div id="layouts" class="d-flex align-items-start">
                                <div class="nav flex-column nav-pills me-3 w-25" id="layout-tab" role="tablist" aria-orientation="vertical">
                                    <?php if ($layouts) { ?>
                                        <?php foreach ($layouts as $layout) { ?>
                                        <button class="nav-link" id="layout-<?php echo $layout['layout_id']; ?>-tab" data-bs-toggle="pill" data-bs-target="#layout-<?php echo $layout['layout_id']; ?>" type="button" role="tab" aria-controls="layout-<?php echo $layout['layout_id']; ?>" aria-selected="false"><?php echo $layout['name']; ?></button>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="tab-content w-100" id="layout-content">
                                    <?php if ($layouts) { ?>
                                        <?php foreach ($layouts as $layout) { ?>
                                        <div class="tab-pane fade" id="layout-<?php echo $layout['layout_id']; ?>" role="tabpanel" aria-labelledby="layout-<?php echo $layout['layout_id']; ?>-tab">
                                            <h6 class="border-bottom pb-3 mb-3"><?php echo $layout['name']; ?></h6>
                                            <!-- Page top -->
                                            <h5 class="mb-3"><?php echo lang('Text.page_top', [], $language_lib->getCurrentCode()); ?></h5>
                                            <div id="page-top-<?php echo $layout['layout_id']; ?>" class="row mb-3">
                                                <div class="col-sm-12">
                                                    <div class="border">
                                                        <div id="layout-<?php echo $layout['layout_id']; ?>-page-top-widgets" class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo lang('Column.widget', [], $language_lib->getCurrentCode()); ?></th>
                                                                        <th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $page_top_widget_row = 0; ?>
                                                                    <?php if (!empty($layout_widget[$layout['layout_id']]['page_top'])) { ?>
                                                                        <?php foreach ($layout_widget[$layout['layout_id']]['page_top'] as $page_top_widget) { ?>
                                                                        <tr id="layout-<?php echo $layout['layout_id']; ?>-page-top-<?php echo $page_top_widget_row; ?>-widget">
                                                                            <td>
                                                                                <select name="theme_marketplace_com_openmvm_basic_content_layout_widget[<?php echo $layout['layout_id']; ?>][page_top][<?php echo $page_top_widget_row; ?>]" id="input-layout-<?php echo $layout['layout_id']; ?>-page-top-<?php echo $page_top_widget_row; ?>-widget" class="form-select">
                                                                                <?php if ($widgets) { ?>
                                                                                    <?php foreach ($widgets as $widget) { ?>
                                                                                        <?php if ($widget['is_installed']) { ?>
                                                                                        <optgroup label="<?php echo $widget['name']; ?>">
                                                                                            <?php if ($widget['widget']) { ?>
                                                                                                <?php foreach ($widget['widget'] as $page_top_added_widget) { ?>
                                                                                                    <?php if ($page_top_added_widget['widget_id'] == $page_top_widget) { ?>
                                                                                                    <option value="<?php echo $page_top_added_widget['widget_id']; ?>" selected="selected"><?php echo $page_top_added_widget['name']; ?></option>
                                                                                                    <?php } else { ?>
                                                                                                    <option value="<?php echo $page_top_added_widget['widget_id']; ?>"><?php echo $page_top_added_widget['name']; ?></option>
                                                                                                    <?php } ?>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        </optgroup>
                                                                                        <?php } ?>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                                </select>
                                                                            </td>
                                                                            <td class="text-end"><button type="button" id="button-layout-<?php echo $layout['layout_id']; ?>-page-top-<?php echo $page_top_widget_row; ?>-widget-remove" class="btn btn-danger btn-sm" onclick="$('#layout-<?php echo $layout['layout_id']; ?>-page-top-<?php echo $page_top_widget_row; ?>-widget').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>
                                                                        </tr>
                                                                        <?php $page_top_widget_row++; ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="2" class="text-end"><button type="button" id="button-layout-<?php echo $layout['layout_id']; ?>-page-top-add" class="btn btn-primary btn-sm" onclick="addContentWidget('page-top', '<?php echo $layout['layout_id']; ?>');"><i class="fas fa-plus fa-fw"></i></button></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Page top //-->
                                            <div id="page-content-<?php echo $layout['layout_id']; ?>" class="row mb-3">
                                                <div class="col-sm-4">
                                                    <!-- Column left -->
                                                    <h5 class="mb-3"><?php echo lang('Text.column_left', [], $language_lib->getCurrentCode()); ?></h5>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-12">
                                                            <div class="border">
                                                                <div id="layout-<?php echo $layout['layout_id']; ?>-column-left-widgets" class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><?php echo lang('Column.widget', [], $language_lib->getCurrentCode()); ?></th>
                                                                                <th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $column_left_widget_row = 0; ?>
                                                                            <?php if (!empty($layout_widget[$layout['layout_id']]['column_left'])) { ?>
                                                                                <?php foreach ($layout_widget[$layout['layout_id']]['column_left'] as $column_left_widget) { ?>
                                                                                <tr id="layout-<?php echo $layout['layout_id']; ?>-column-left-<?php echo $column_left_widget_row; ?>-widget">
                                                                                    <td>
                                                                                        <select name="theme_marketplace_com_openmvm_basic_content_layout_widget[<?php echo $layout['layout_id']; ?>][column_left][<?php echo $column_left_widget_row; ?>]" id="input-layout-<?php echo $layout['layout_id']; ?>-column-left-<?php echo $column_left_widget_row; ?>-widget" class="form-select">
                                                                                        <?php if ($widgets) { ?>
                                                                                            <?php foreach ($widgets as $widget) { ?>
                                                                                                <?php if ($widget['is_installed']) { ?>
                                                                                                <optgroup label="<?php echo $widget['name']; ?>">
                                                                                                    <?php if ($widget['widget']) { ?>
                                                                                                        <?php foreach ($widget['widget'] as $column_left_added_widget) { ?>
                                                                                                            <?php if ($column_left_added_widget['widget_id'] == $column_left_widget) { ?>
                                                                                                            <option value="<?php echo $column_left_added_widget['widget_id']; ?>" selected="selected"><?php echo $column_left_added_widget['name']; ?></option>
                                                                                                            <?php } else { ?>
                                                                                                            <option value="<?php echo $column_left_added_widget['widget_id']; ?>"><?php echo $column_left_added_widget['name']; ?></option>
                                                                                                            <?php } ?>
                                                                                                        <?php } ?>
                                                                                                    <?php } ?>
                                                                                                </optgroup>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        <?php } ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td class="text-end"><button type="button" id="button-layout-<?php echo $layout['layout_id']; ?>-column-left-<?php echo $column_left_widget_row; ?>-widget-remove" class="btn btn-danger btn-sm" onclick="$('#layout-<?php echo $layout['layout_id']; ?>-column-left-<?php echo $column_left_widget_row; ?>-widget').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>
                                                                                </tr>
                                                                                <?php $column_left_widget_row++; ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <td colspan="2" class="text-end"><button type="button" id="button-layout-<?php echo $layout['layout_id']; ?>-column-left-add" class="btn btn-primary btn-sm" onclick="addContentWidget('column-left', '<?php echo $layout['layout_id']; ?>');"><i class="fas fa-plus fa-fw"></i></button></td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Column left //-->
                                                </div>
                                                <div class="col-sm-4">
                                                    <!-- Content top -->
                                                    <h5 class="mb-3"><?php echo lang('Text.content_top', [], $language_lib->getCurrentCode()); ?></h5>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-12">
                                                            <div class="border">
                                                                <div id="layout-<?php echo $layout['layout_id']; ?>-content-top-widgets" class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><?php echo lang('Column.widget', [], $language_lib->getCurrentCode()); ?></th>
                                                                                <th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $content_top_widget_row = 0; ?>
                                                                            <?php if (!empty($layout_widget[$layout['layout_id']]['content_top'])) { ?>
                                                                                <?php foreach ($layout_widget[$layout['layout_id']]['content_top'] as $content_top_widget) { ?>
                                                                                <tr id="layout-<?php echo $layout['layout_id']; ?>-content-top-<?php echo $content_top_widget_row; ?>-widget">
                                                                                    <td>
                                                                                        <select name="theme_marketplace_com_openmvm_basic_content_layout_widget[<?php echo $layout['layout_id']; ?>][content_top][<?php echo $content_top_widget_row; ?>]" id="input-layout-<?php echo $layout['layout_id']; ?>-content-top-<?php echo $content_top_widget_row; ?>-widget" class="form-select">
                                                                                        <?php if ($widgets) { ?>
                                                                                            <?php foreach ($widgets as $widget) { ?>
                                                                                                <?php if ($widget['is_installed']) { ?>
                                                                                                <optgroup label="<?php echo $widget['name']; ?>">
                                                                                                    <?php if ($widget['widget']) { ?>
                                                                                                        <?php foreach ($widget['widget'] as $content_top_added_widget) { ?>
                                                                                                            <?php if ($content_top_added_widget['widget_id'] == $content_top_widget) { ?>
                                                                                                            <option value="<?php echo $content_top_added_widget['widget_id']; ?>" selected="selected"><?php echo $content_top_added_widget['name']; ?></option>
                                                                                                            <?php } else { ?>
                                                                                                            <option value="<?php echo $content_top_added_widget['widget_id']; ?>"><?php echo $content_top_added_widget['name']; ?></option>
                                                                                                            <?php } ?>
                                                                                                        <?php } ?>
                                                                                                    <?php } ?>
                                                                                                </optgroup>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        <?php } ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td class="text-end"><button type="button" id="button-layout-<?php echo $layout['layout_id']; ?>-content-top-<?php echo $content_top_widget_row; ?>-widget-remove" class="btn btn-danger btn-sm" onclick="$('#layout-<?php echo $layout['layout_id']; ?>-content-top-<?php echo $content_top_widget_row; ?>-widget').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>
                                                                                </tr>
                                                                                <?php $content_top_widget_row++; ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <td colspan="2" class="text-end"><button type="button" id="button-layout-<?php echo $layout['layout_id']; ?>-content-top-add" class="btn btn-primary btn-sm" onclick="addContentWidget('content-top', '<?php echo $layout['layout_id']; ?>');"><i class="fas fa-plus fa-fw"></i></button></td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Content top //-->
                                                    <!-- Content bottom -->
                                                    <h5 class="mb-3"><?php echo lang('Text.content_bottom', [], $language_lib->getCurrentCode()); ?></h5>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-12">
                                                            <div class="border">
                                                                <div id="layout-<?php echo $layout['layout_id']; ?>-content-bottom-widgets" class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><?php echo lang('Column.widget', [], $language_lib->getCurrentCode()); ?></th>
                                                                                <th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $content_bottom_widget_row = 0; ?>
                                                                            <?php if (!empty($layout_widget[$layout['layout_id']]['content_bottom'])) { ?>
                                                                                <?php foreach ($layout_widget[$layout['layout_id']]['content_bottom'] as $content_bottom_widget) { ?>
                                                                                <tr id="layout-<?php echo $layout['layout_id']; ?>-content-bottom-<?php echo $content_bottom_widget_row; ?>-widget">
                                                                                    <td>
                                                                                        <select name="theme_marketplace_com_openmvm_basic_content_layout_widget[<?php echo $layout['layout_id']; ?>][content_bottom][<?php echo $content_bottom_widget_row; ?>]" id="input-layout-<?php echo $layout['layout_id']; ?>-content-bottom-<?php echo $content_bottom_widget_row; ?>-widget" class="form-select">
                                                                                        <?php if ($widgets) { ?>
                                                                                            <?php foreach ($widgets as $widget) { ?>
                                                                                                <?php if ($widget['is_installed']) { ?>
                                                                                                <optgroup label="<?php echo $widget['name']; ?>">
                                                                                                    <?php if ($widget['widget']) { ?>
                                                                                                        <?php foreach ($widget['widget'] as $content_bottom_added_widget) { ?>
                                                                                                            <?php if ($content_bottom_added_widget['widget_id'] == $content_bottom_widget) { ?>
                                                                                                            <option value="<?php echo $content_bottom_added_widget['widget_id']; ?>" selected="selected"><?php echo $content_bottom_added_widget['name']; ?></option>
                                                                                                            <?php } else { ?>
                                                                                                            <option value="<?php echo $content_bottom_added_widget['widget_id']; ?>"><?php echo $content_bottom_added_widget['name']; ?></option>
                                                                                                            <?php } ?>
                                                                                                        <?php } ?>
                                                                                                    <?php } ?>
                                                                                                </optgroup>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        <?php } ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td class="text-end"><button type="button" id="button-layout-<?php echo $layout['layout_id']; ?>-content-bottom-<?php echo $content_bottom_widget_row; ?>-widget-remove" class="btn btn-danger btn-sm" onclick="$('#layout-<?php echo $layout['layout_id']; ?>-content-bottom-<?php echo $content_bottom_widget_row; ?>-widget').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>
                                                                                </tr>
                                                                                <?php $content_bottom_widget_row++; ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <td colspan="2" class="text-end"><button type="button" id="button-layout-<?php echo $layout['layout_id']; ?>-content-bottom-add" class="btn btn-primary btn-sm" onclick="addContentWidget('content-bottom', '<?php echo $layout['layout_id']; ?>');"><i class="fas fa-plus fa-fw"></i></button></td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Content bottom //-->
                                                </div>
                                                <div class="col-sm-4">
                                                    <!-- Column right -->
                                                    <h5 class="mb-3"><?php echo lang('Text.column_right', [], $language_lib->getCurrentCode()); ?></h5>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-12">
                                                            <div class="border">
                                                                <div id="layout-<?php echo $layout['layout_id']; ?>-column-right-widgets" class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><?php echo lang('Column.widget', [], $language_lib->getCurrentCode()); ?></th>
                                                                                <th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $column_right_widget_row = 0; ?>
                                                                            <?php if (!empty($layout_widget[$layout['layout_id']]['column_right'])) { ?>
                                                                                <?php foreach ($layout_widget[$layout['layout_id']]['column_right'] as $column_right_widget) { ?>
                                                                                <tr id="layout-<?php echo $layout['layout_id']; ?>-column-right-<?php echo $column_right_widget_row; ?>-widget">
                                                                                    <td>
                                                                                        <select name="theme_marketplace_com_openmvm_basic_content_layout_widget[<?php echo $layout['layout_id']; ?>][column_right][<?php echo $column_right_widget_row; ?>]" id="input-layout-<?php echo $layout['layout_id']; ?>-column-right-<?php echo $column_right_widget_row; ?>-widget" class="form-select">
                                                                                        <?php if ($widgets) { ?>
                                                                                            <?php foreach ($widgets as $widget) { ?>
                                                                                                <?php if ($widget['is_installed']) { ?>
                                                                                                <optgroup label="<?php echo $widget['name']; ?>">
                                                                                                    <?php if ($widget['widget']) { ?>
                                                                                                        <?php foreach ($widget['widget'] as $column_right_added_widget) { ?>
                                                                                                            <?php if ($column_right_added_widget['widget_id'] == $column_right_widget) { ?>
                                                                                                            <option value="<?php echo $column_right_added_widget['widget_id']; ?>" selected="selected"><?php echo $column_right_added_widget['name']; ?></option>
                                                                                                            <?php } else { ?>
                                                                                                            <option value="<?php echo $column_right_added_widget['widget_id']; ?>"><?php echo $column_right_added_widget['name']; ?></option>
                                                                                                            <?php } ?>
                                                                                                        <?php } ?>
                                                                                                    <?php } ?>
                                                                                                </optgroup>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        <?php } ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td class="text-end"><button type="button" id="button-layout-<?php echo $layout['layout_id']; ?>-column-right-<?php echo $column_right_widget_row; ?>-widget-remove" class="btn btn-danger btn-sm" onclick="$('#layout-<?php echo $layout['layout_id']; ?>-column-right-<?php echo $column_right_widget_row; ?>-widget').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>
                                                                                </tr>
                                                                                <?php $column_right_widget_row++; ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <td colspan="2" class="text-end"><button type="button" id="button-layout-<?php echo $layout['layout_id']; ?>-column-right-add" class="btn btn-primary btn-sm" onclick="addContentWidget('column-right', '<?php echo $layout['layout_id']; ?>');"><i class="fas fa-plus fa-fw"></i></button></td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Column right //-->
                                                </div>
                                            </div>
                                            <!-- Page bottom -->
                                            <h5 class="mb-3"><?php echo lang('Text.page_bottom', [], $language_lib->getCurrentCode()); ?></h5>
                                            <div id="page-bottom-<?php echo $layout['layout_id']; ?>" class="row mb-3">
                                                <div class="col-sm-12">
                                                    <div class="border">
                                                        <div id="layout-<?php echo $layout['layout_id']; ?>-page-bottom-widgets" class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo lang('Column.widget', [], $language_lib->getCurrentCode()); ?></th>
                                                                        <th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $page_bottom_widget_row = 0; ?>
                                                                    <?php if (!empty($layout_widget[$layout['layout_id']]['page_bottom'])) { ?>
                                                                        <?php foreach ($layout_widget[$layout['layout_id']]['page_bottom'] as $page_bottom_widget) { ?>
                                                                        <tr id="layout-<?php echo $layout['layout_id']; ?>-page-bottom-<?php echo $page_bottom_widget_row; ?>-widget">
                                                                            <td>
                                                                                <select name="theme_marketplace_com_openmvm_basic_content_layout_widget[<?php echo $layout['layout_id']; ?>][page_bottom][<?php echo $page_bottom_widget_row; ?>]" id="input-layout-<?php echo $layout['layout_id']; ?>-page-bottom-<?php echo $page_bottom_widget_row; ?>-widget" class="form-select">
                                                                                <?php if ($widgets) { ?>
                                                                                    <?php foreach ($widgets as $widget) { ?>
                                                                                        <?php if ($widget['is_installed']) { ?>
                                                                                        <optgroup label="<?php echo $widget['name']; ?>">
                                                                                            <?php if ($widget['widget']) { ?>
                                                                                                <?php foreach ($widget['widget'] as $page_bottom_added_widget) { ?>
                                                                                                    <?php if ($page_bottom_added_widget['widget_id'] == $page_bottom_widget) { ?>
                                                                                                    <option value="<?php echo $page_bottom_added_widget['widget_id']; ?>" selected="selected"><?php echo $page_bottom_added_widget['name']; ?></option>
                                                                                                    <?php } else { ?>
                                                                                                    <option value="<?php echo $page_bottom_added_widget['widget_id']; ?>"><?php echo $page_bottom_added_widget['name']; ?></option>
                                                                                                    <?php } ?>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        </optgroup>
                                                                                        <?php } ?>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                                </select>
                                                                            </td>
                                                                            <td class="text-end"><button type="button" id="button-layout-<?php echo $layout['layout_id']; ?>-page-bottom-<?php echo $page_bottom_widget_row; ?>-widget-remove" class="btn btn-danger btn-sm" onclick="$('#layout-<?php echo $layout['layout_id']; ?>-page-bottom-<?php echo $page_bottom_widget_row; ?>-widget').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>
                                                                        </tr>
                                                                        <?php $page_bottom_widget_row++; ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="2" class="text-end"><button type="button" id="button-layout-<?php echo $layout['layout_id']; ?>-page-bottom-add" class="btn btn-primary btn-sm" onclick="addContentWidget('page-bottom', '<?php echo $layout['layout_id']; ?>');"><i class="fas fa-plus fa-fw"></i></button></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Page bottom //-->
                                        </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </fieldset>
                        <!-- Content widgets //-->
                        <!-- Footer widgets -->
                        <fieldset class="mb-5">
                            <legend class="lead border-bottom border-warning pb-2"><?php echo lang('Text.footer', [], $language_lib->getCurrentCode()); ?></legend> 
                            <div id="footer-columns" class="d-flex align-items-start">
                                <div class="nav flex-column nav-pills me-3 w-25" id="footer-column-tab" role="tablist" aria-orientation="vertical">
                                    <?php $footer_column_row = 0; ?>
                                    <?php if ($footer_columns) { ?>
                                        <?php foreach ($footer_columns as $footer_column) { ?>
                                        <button class="nav-link mb-2" id="footer-column-tab-<?php echo $footer_column_row; ?>" data-bs-toggle="pill" data-bs-target="#footer-column-<?php echo $footer_column_row; ?>" type="button" role="tab" aria-controls="footer-column-<?php echo $footer_column_row; ?>" aria-selected="false"><i class="fas fa-minus-circle fa-fw" onclick="$('#footer-column-tab-<?php echo $footer_column_row; ?>').remove(); $('#footer-column-<?php echo $footer_column_row; ?>').remove(); var triggerFirstTabEl = document.querySelector('#footer-columns #footer-column-tab button.nav-link:first-child'); new bootstrap.Tab(triggerFirstTabEl).show();"></i> <?php echo lang('Tab.column', [], $language_lib->getCurrentCode()); ?> <?php echo $footer_column_row; ?></button>
                                        <?php $footer_column_row++; ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <button type="button" id="button-footer-column-add" class="btn btn-secondary"><i class="fas fa-plus fa-fw"></i> <?php echo lang('button.add', [], $language_lib->getCurrentCode()); ?></button>
                                </div>
                                <div class="tab-content w-100" id="footer-column-tab-content">
                                    <?php $footer_column_row = 0; ?>
                                    <?php $footer_column_widget_row = 0; ?>
                                    <?php if ($footer_columns) { ?>
                                        <?php foreach ($footer_columns as $footer_column) { ?>
                                        <div class="tab-pane fade" id="footer-column-<?php echo $footer_column_row; ?>" role="tabpanel" aria-labelledby="footer-column-tab-<?php echo $footer_column_row; ?>">
                                            <h6 class="border-bottom pb-3 mb-3"><?php echo lang('Tab.column', [], $language_lib->getCurrentCode()); ?> <?php echo $footer_column_row; ?></h6>
                                            <div class="mb-3">
                                                <label for="input-footer-column-width-<?php echo $footer_column_row; ?>" class="form-label"><?php echo lang('Entry.column_width', [], $language_lib->getCurrentCode()); ?></label>
                                                <select name="theme_marketplace_com_openmvm_basic_footer_column[<?php echo $footer_column_row; ?>][column_width]" id="input-footer-column-width-<?php echo $footer_column_row; ?>" class="form-select">
                                                    <?php foreach ($column_widths as $column_width) { ?>
                                                        <?php if ($column_width == $footer_column['column_width']) { ?>
                                                        <option value="<?php echo $column_width; ?>" selected="selected"><?php echo $column_width; ?></option>
                                                        <?php } else { ?>
                                                        <option value="<?php echo $column_width; ?>"><?php echo $column_width; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input-footer-column-widget-<?php echo $footer_column_row; ?>" class="form-label"><?php echo lang('Entry.widgets', [], $language_lib->getCurrentCode()); ?></label>
                                                <div id="footer-column-<?php echo $footer_column_row; ?>-widgets" class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th><?php echo lang('Column.widget', [], $language_lib->getCurrentCode()); ?></th>
                                                                <th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($footer_column['widget'])) { ?>
                                                                <?php foreach ($footer_column['widget'] as $footer_column_widget) { ?>
                                                                <tr id="footer-column-<?php echo $footer_column_row; ?>-widget-<?php echo $footer_column_widget_row; ?>">
                                                                    <td>
                                                                        <select name="theme_marketplace_com_openmvm_basic_footer_column[<?php echo $footer_column_row; ?>][widget][<?php echo $footer_column_widget_row; ?>]" id="footer-column-<?php echo $footer_column_row; ?>-width-<?php echo $footer_column_widget_row; ?>" class="form-select">
                                                                        <?php if ($widgets) { ?>
                                                                            <?php foreach ($widgets as $widget) { ?>
                                                                                <?php if ($widget['is_installed']) { ?>
                                                                                <optgroup label="<?php echo $widget['name']; ?>">
                                                                                    <?php if ($widget['widget']) { ?>
                                                                                        <?php foreach ($widget['widget'] as ${'footer_column_' . $footer_column_widget_row . '_widget'}) { ?>
                                                                                            <?php if (${'footer_column_' . $footer_column_widget_row . '_widget'}['widget_id'] == $footer_column_widget) { ?>
                                                                                            <option value="<?php echo ${'footer_column_' . $footer_column_widget_row . '_widget'}['widget_id']; ?>" selected="selected"><?php echo ${'footer_column_' . $footer_column_widget_row . '_widget'}['name']; ?></option>
                                                                                            <?php } else { ?>
                                                                                            <option value="<?php echo ${'footer_column_' . $footer_column_widget_row . '_widget'}['widget_id']; ?>"><?php echo ${'footer_column_' . $footer_column_widget_row . '_widget'}['name']; ?></option>
                                                                                            <?php } ?>
                                                                                        <?php } ?>
                                                                                    <?php } ?>
                                                                                </optgroup>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </td>
                                                                    <td class="text-end"><button type="button" id="button-footer-column-<?php echo $footer_column_row; ?>-widget-<?php echo $footer_column_widget_row; ?>-remove" class="btn btn-danger btn-sm" onclick="$('#footer-column-<?php echo $footer_column_row; ?>-widget-<?php echo $footer_column_widget_row; ?>').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>
                                                                </tr>
                                                                <?php $footer_column_widget_row++; ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2" class="text-end"><button type="button" id="button-footer-column-<?php echo $footer_column_row; ?>-widget-add" class="btn btn-primary btn-sm" onclick="addFooterWidget('<?php echo $footer_column_row; ?>');"><i class="fas fa-plus fa-fw"></i></button></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $footer_column_row++; ?>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </fieldset>
                        <!-- Footer widgets //-->
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
var header_widget_row = '<?php echo $header_widget_row; ?>';

function addHeaderWidget() {
    html = '<tr id="header-widget-' + header_widget_row + '">';
    html += '    <td>';
    html += '        <select name="theme_marketplace_com_openmvm_basic_header_widget[' + header_widget_row + ']" id="input-header-widget-' + header_widget_row + '" class="form-select">';
    <?php if ($widgets) { ?>
        <?php foreach ($widgets as $widget) { ?>
            <?php if ($widget['is_installed']) { ?>
            html += '                    <optgroup label="<?php echo $widget['name']; ?>">';
                <?php if ($widget['widget']) { ?>
                    <?php foreach ($widget['widget'] as $header_added_widget) { ?>
                    html += '                            <option value="<?php echo $header_added_widget['widget_id']; ?>"><?php echo $header_added_widget['name']; ?></option>';
                    <?php } ?>
                <?php } ?>
            html += '                    </optgroup>';
            <?php } ?>
        <?php } ?>
    <?php } ?>
    html += '        </select>';
    html += '    </td>';
    html += '    <td class="text-end"><button type="button" id="button-header-widget-remove" class="btn btn-danger btn-sm" onclick="$(\'#header-widget-' + header_widget_row + '\').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>';
    html += '</tr>';

    $('#header-widgets table tbody').append(html);

    header_widget_row++;
}
//--></script> 
<script type="text/javascript"><!--
var page_top_widget_row = '<?php echo $page_top_widget_row; ?>';
var column_left_widget_row = '<?php echo $column_left_widget_row; ?>';
var content_top_widget_row = '<?php echo $content_top_widget_row; ?>';
var content_bottom_widget_row = '<?php echo $content_bottom_widget_row; ?>';
var column_right_widget_row = '<?php echo $column_right_widget_row; ?>';
var page_bottom_widget_row = '<?php echo $page_bottom_widget_row; ?>';

function addContentWidget(position, layout_id) {
    if (position == 'page-top') {
        content_widget_row = page_top_widget_row;
    } else if (position == 'column-left') {
        content_widget_row = column_left_widget_row;
    } else if (position == 'content-top') {
        content_widget_row = content_top_widget_row;
    } else if (position == 'content-bottom') {
        content_widget_row = content_bottom_widget_row;
    } else if (position == 'column-right') {
        content_widget_row = column_right_widget_row;
    } else if (position == 'page-bottom') {
        content_widget_row = page_bottom_widget_row;
    }

    html = '<tr id="layout-' + layout_id + '-' + position + '-' + content_widget_row + '-widget">';
    html += '    <td>';
    html += '        <select name="theme_marketplace_com_openmvm_basic_content_layout_widget[' + layout_id + '][' + position.replace('-', '_') + '][' + content_widget_row + ']" id="input-layout-' + layout_id + '-' + position + '-' + content_widget_row + '-widget" class="form-select">';
    <?php if ($widgets) { ?>
        <?php foreach ($widgets as $widget) { ?>
            <?php if ($widget['is_installed']) { ?>
            html += '                    <optgroup label="<?php echo $widget['name']; ?>">';
                <?php if ($widget['widget']) { ?>
                    <?php foreach ($widget['widget'] as $layout_added_widget) { ?>
                    html += '                            <option value="<?php echo $layout_added_widget['widget_id']; ?>"><?php echo $layout_added_widget['name']; ?></option>';
                    <?php } ?>
                <?php } ?>
            html += '                    </optgroup>';
            <?php } ?>
        <?php } ?>
    <?php } ?>
    html += '        </select>';
    html += '    </td>';
    html += '    <td class="text-end"><button type="button" id="button-layout-' + layout_id + '-' + position + '-' + content_widget_row + '-widget-remove" class="btn btn-danger btn-sm" onclick="$(\'#layout-' + layout_id + '-' + position + '-' + content_widget_row + '-widget\').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>';
    html += '</tr>';

    $('#layout-' + layout_id + '-' + position + '-widgets table tbody').append(html);

    if (position == 'page-top') {
        page_top_widget_row++;
    } else if (position == 'column-left') {
        column_left_widget_row++;
    } else if (position == 'content-top') {
        content_top_widget_row++;
    } else if (position == 'content-bottom') {
        content_bottom_widget_row++;
    } else if (position == 'column-right') {
        column_right_widget_row++;
    } else if (position == 'page-bottom') {
        page_bottom_widget_row++;
    }
};
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
    var triggerFirstTabEl = document.querySelector('#layouts #layout-tab button.nav-link:first-child')
    new bootstrap.Tab(triggerFirstTabEl).show()
});
//--></script>
<script type="text/javascript"><!--
var footer_column_row = '<?php echo $footer_column_row; ?>';

$( "#button-footer-column-add" ).on( "click", function() {
    html = '<div class="tab-pane fade" id="footer-column-' + footer_column_row + '" role="tabpanel" aria-labelledby="footer-column-tab-' + footer_column_row + '">';
    html += '<h6 class="border-bottom pb-3 mb-3"><?php echo lang('Tab.column', [], $language_lib->getCurrentCode()); ?> ' + footer_column_row + '</h6>';
    html += '    <div class="mb-3">';
    html += '        <label for="input-footer-column-width-' + footer_column_row + '" class="form-label"><?php echo lang('Entry.column_width', [], $language_lib->getCurrentCode()); ?></label>';
    html += '        <select name="theme_marketplace_com_openmvm_basic_footer_column[' + footer_column_row + '][column_width]" id="footer-column-width-' + footer_column_row + '" class="form-select">';
    <?php foreach ($column_widths as $column_width) { ?>
        html += '        <option value="<?php echo $column_width; ?>"><?php echo $column_width; ?></option>';
    <?php } ?>
    html += '        </select>';
    html += '    </div>';
    html += '    <div class="mb-3">';
    html += '        <label for="input-footer-column-widget-' + footer_column_row + '" class="form-label"><?php echo lang('Entry.widgets', [], $language_lib->getCurrentCode()); ?></label>';
    html += '        <div id="footer-column-' + footer_column_row + '-widgets" class="table-responsive">';
    html += '            <table class="table">';
    html += '                <thead>';
    html += '                    <tr>';
    html += '                        <th><?php echo lang('Column.widget', [], $language_lib->getCurrentCode()); ?></th>';
    html += '                        <th class="text-end"><?php echo lang('Column.action', [], $language_lib->getCurrentCode()); ?></th>';
    html += '                    </tr>';
    html += '                </thead>';
    html += '                <tbody>';
    html += '                </tbody>';
    html += '                <tfoot>';
    html += '                    <tr>';
    html += '                        <td colspan="2" class="text-end"><button type="button" id="button-footer-column-' + footer_column_row + '-widget-add" class="btn btn-primary btn-sm" onclick="addFooterWidget(' + footer_column_row + ');"><i class="fas fa-plus fa-fw"></i></button></td>';
    html += '                    </tr>';
    html += '                </tfoot>';
    html += '            </table>';
    html += '        </div>';
    html += '    </div>';
    html += '</div>';

    $('#footer-columns #footer-column-tab-content').append(html);

    $('#footer-columns #footer-column-tab').find('#button-footer-column-add').before('<button class="nav-link mb-2" id="footer-column-tab-' + footer_column_row + '" data-bs-toggle="pill" data-bs-target="#footer-column-' + footer_column_row + '" type="button" role="tab" aria-controls="footer-column-' + footer_column_row + '" aria-selected="false"><i class="fas fa-minus-circle fa-fw" onclick="$(\'#footer-column-tab-' + footer_column_row + '\').remove(); $(\'#footer-column-' + footer_column_row + '\').remove(); var triggerFirstTabEl = document.querySelector(\'#footer-columns #footer-column-tab button.nav-link:first-child\'); new bootstrap.Tab(triggerFirstTabEl).show();"></i> <?php echo lang('Tab.column', [], $language_lib->getCurrentCode()); ?> ' + footer_column_row + '</button>');

    var triggerFirstTabEl = document.querySelector('#footer-columns #footer-column-tab-' + footer_column_row + '');
    new bootstrap.Tab(triggerFirstTabEl).show();

    footer_column_row++;
});
//--></script> 
<script type="text/javascript"><!--
var footer_column_widget_row = '<?php echo $footer_column_widget_row; ?>';

function addFooterWidget(footer_column_row) {
    html = '<tr id="footer-column-' + footer_column_row + '-widget-' + footer_column_widget_row + '">';
    html += '    <td>';
    html += '        <select name="theme_marketplace_com_openmvm_basic_footer_column[' + footer_column_row + '][widget][' + footer_column_widget_row + ']" id="input-footer-column-' + footer_column_row + '-width-' + footer_column_widget_row + '" class="form-select">'
    <?php if ($widgets) { ?>
        <?php foreach ($widgets as $widget) { ?>
            <?php if ($widget['is_installed']) { ?>
            html += '                    <optgroup label="<?php echo $widget['name']; ?>">';
                <?php if ($widget['widget']) { ?>
                    <?php foreach ($widget['widget'] as $footer_column_widget) { ?>
                    html += '                            <option value="<?php echo $footer_column_widget['widget_id']; ?>"><?php echo $footer_column_widget['name']; ?></option>';
                    <?php } ?>
                <?php } ?>
            html += '                    </optgroup>';
            <?php } ?>
        <?php } ?>
    <?php } ?>
    html += '        </select>';
    html += '    </td>';
    html += '    <td class="text-end"><button type="button" class="btn btn-danger btn-sm" onclick="$(\'#footer-column-' + footer_column_row + '-widget-' + footer_column_widget_row + '\').remove();"><i class="fas fa-minus-circle fa-fw"></i></button></td>';
    html += '</tr>';

    $('#footer-column-' + footer_column_row + '-widgets table tbody').append(html);

    footer_column_widget_row++;
};
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
    var triggerFirstTabEl = document.querySelector('#footer-columns #footer-column-tab button.nav-link:first-child')
    new bootstrap.Tab(triggerFirstTabEl).show()
});
//--></script>
<?php echo $footer; ?>
