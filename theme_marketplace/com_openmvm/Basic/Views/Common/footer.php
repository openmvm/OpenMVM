    <div role="button" id="button-back-to-top" class="text-light bg-danger text-center py-3 mt-5" onclick="$('html, body').animate({scrollTop: 0}, 250);"><?php echo lang('Button.back_to_top', [], $language_lib->getCurrentCode()); ?> <i class="fas fa-long-arrow-alt-up fa-fw"></i></div>
    <div id="footer" class="footer bg-dark text-white p-3">
        <?php $widgets = $marketplace_common_widget->index(['position' => 'footer']); ?>
        <?php if ($widgets) { ?>
        <div class="row">
            <?php foreach ($widgets as $widget) { ?>
                <div class="col-sm-<?php echo $widget['column_width']; ?>">
                    <?php if (!empty($widget['widget'])) { ?>
                        <?php foreach ($widget['widget'] as $key => $value) { ?>
                            <div><?php echo $marketplace_common_widget->get($value); ?></div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    <div id="copyrights" class="text-center my-3"><?php echo $copyrights; ?></div>
    <div class="rendered text-muted text-center small mb-3"><?php echo $rendered; ?></div>
</body>
</html>