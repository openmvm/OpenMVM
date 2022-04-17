<?php echo $header; ?>
<?php $layout_id = $marketplace_common_widget->layout_id(); ?>
<?php $widget = $marketplace_common_widget->index(['position' => 'content']); ?>
<?php if (!empty($widget[$layout_id]['page_top'])) { ?>
<div class="container-fluid">
    <?php foreach ($widget[$layout_id]['page_top'] as $key => $value) { ?>
    <?php echo $marketplace_common_widget->get($value); ?>
    <?php } ?>
</div>
<?php } ?>
<div class="container-fluid">
    <div id="content" class="content">
        <div class="row">
            <?php if (!empty($widget[$layout_id]['column_left']) && !empty($widget[$layout_id]['column_right'])) { ?>
                <?php $class = 'col-sm-8'; ?>
            <?php } elseif (!empty($widget[$layout_id]['column_left']) || !empty($widget[$layout_id]['column_right'])) { ?>
                <?php $class = 'col-sm-10'; ?>
            <?php } else { ?>
                <?php $class = 'col-sm-12'; ?>
            <?php } ?>
            <?php if (!empty($widget[$layout_id]['column_left'])) { ?>
            <div class="col-sm-2">
                <?php foreach ($widget[$layout_id]['column_left'] as $key => $value) { ?>
                <?php echo $marketplace_common_widget->get($value); ?>
                <?php } ?>
            </div>
            <?php } ?>
            <div class="<?php echo $class; ?>">
                <?php if (!empty($widget[$layout_id]['content_top'])) { ?>
                <div>
                    <?php foreach ($widget[$layout_id]['content_top'] as $key => $value) { ?>
                    <?php echo $marketplace_common_widget->get($value); ?>
                    <?php } ?>
                </div>
                <?php } ?>
                <?php if (!empty($widget[$layout_id]['content_bottom'])) { ?>
                <div>
                    <?php foreach ($widget[$layout_id]['content_bottom'] as $key => $value) { ?>
                    <?php echo $marketplace_common_widget->get($value); ?>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
            <?php if (!empty($widget[$layout_id]['column_right'])) { ?>
            <div class="col-sm-2">
                <?php foreach ($widget[$layout_id]['column_right'] as $key => $value) { ?>
                <?php echo $marketplace_common_widget->get($value); ?>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php if (!empty($widget[$layout_id]['page_bottom'])) { ?>
<div class="container-fluid">
    <?php foreach ($widget[$layout_id]['page_bottom'] as $key => $value) { ?>
    <?php echo $marketplace_common_widget->get($value); ?>
    <?php } ?>
</div>
<?php } ?>
<?php echo $footer; ?>
