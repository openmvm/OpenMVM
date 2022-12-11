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
        <div class="card shadow rounded-0 mb-3">
            <div class="card-body">
                <h1 class="mb-5"><?php echo $heading_title; ?></h1>
                <div>
                    <a href="<?php echo $store_url; ?>" class="btn btn-<?php if ($link_id == 'home') { ?>primary<?php } else { ?>light<?php } ?> rounded-0"><?php echo lang('Button.home', [], $language_lib->getCurrentCode()); ?></a>
                    <div id="seller-categories" class="d-inline-block"></div>
                    <div id="seller-categories-other" class="d-inline-block"></div>
                </div>
            </div>
        </div>
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
                <div></div>
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
<script type="text/javascript"><!--
$('#seller-categories').html('<i class="fas fa-spinner fa-spin ms-3 mt-2"></i>');

$(document).ready(function() {
    var sellerCategories = [];

    $.ajax({
        url: '<?php echo $get_seller_categories_url; ?>',
        type: 'post',
        dataType: 'json',
        async: false,
        data: {
            parent_id: 0,
        },
        beforeSend: function() {
            //$('#seller-categories').html('<i class="fas fa-spinner fa-spin"></i>');
        },
        complete: function() {
            //$('#seller-categories').append('<i class="fas fa-spinner fa-spin"></i>');
        },
        success: function(json) {
            sellerCategories = json['seller_categories'];
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

    // Optimalisation: Store the references outside the event handler:
    var $window = $(window);

    function displayResults() {
        link_id = '<?php echo $link_id; ?>';

        var windowsize = $window.width();

        if (sellerCategories.length > 0) {
            if (windowsize < 576) {
                if (sellerCategories.length > 1) {
                    total_main = 1;
                } else {
                    total_main = sellerCategories.length;
                }
            } else if (windowsize >= 576 && windowsize < 768) {
                if (sellerCategories.length > 2) {
                    total_main = 2;
                } else {
                    total_main = sellerCategories.length;
                }
            } else if (windowsize >= 768 && windowsize < 992) {
                if (sellerCategories.length > 3) {
                    total_main = 3;
                } else {
                    total_main = sellerCategories.length;
                }
            } else if (windowsize >= 992 && windowsize < 1200) {
                if (sellerCategories.length > 5) {
                    total_main = 5;
                } else {
                    total_main = sellerCategories.length;
                }
            } else if (windowsize >= 1200 && windowsize < 1440) {
                if (sellerCategories.length > 7) {
                    total_main = 7;
                } else {
                    total_main = sellerCategories.length;
                }
            } else {
                if (sellerCategories.length > 8) {
                    total_main = 8;
                } else {
                    total_main = sellerCategories.length;
                }
            }

            html = '';

            for (var i = 0, ilen = sellerCategories.length; i < total_main; i++) {
                seller_category = sellerCategories[i];

                if (seller_category['children'].length > 0) {
                    html += '<div class="dropdown d-inline">';
                    html += '    <a class="btn btn-';
                    if (link_id == seller_category['seller_category_id']) {
                        html += 'primary';
                    } else {
                        html += 'light';
                    }
                    html += ' rounded-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
                    html += seller_category['name'];
                    html += '    </a>';
                    html += '    <ul class="dropdown-menu rounded-0">';
                    html += '        <li><a class="dropdown-item" href="';
                    html += seller_category['href'];
                    html += '"><strong>';
                    html += seller_category['name'];
                    html += '        </strong></a></li>';
                    for (var j = 0, jlen = seller_category['children'].length; j < jlen; j++) {
                        seller_category_child = seller_category['children'][j];

                        html += '        <li><a class="dropdown-item" href="';
                        html += seller_category_child['href'];
                        html += '">';
                        html += seller_category_child['name'];
                        html += '        </a></li>';
                    }
                    html += '    </ul>';
                    html += '</div>';
                } else {
                    html += '<a href="';
                    html += seller_category['href'];
                    html += '" class="btn btn-';
                    if (link_id == seller_category['seller_category_id']) {
                        html += 'primary';
                    } else {
                        html += 'light';
                    }
                    html += ' rounded-0">';
                    html += seller_category['name'];
                    html += '</a> ';
                }
            }

            $('#seller-categories').html(html);
        }

        if (sellerCategories.length > 0 && total_main < sellerCategories.length) {
            html = '';

            html += '<div class="dropdown d-inline">';
            html += '    <a class="btn btn-light rounded-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo lang('Text.more', [], $language_lib->getCurrentCode()); ?></a>';
            html += '    <ul class="dropdown-menu rounded-0">';
            for (var k = total_main, klen = sellerCategories.length; k < klen; k++) {
                other_seller_category = sellerCategories[k];

                html += '        <li><a class="dropdown-item" href="';
                html += other_seller_category['href'];
                html += '">';
                html += other_seller_category['name'];
                html += '        </a></li>';
            }
            html += '    </ul>';
            html += '</div>';

            $('#seller-categories-other').html(html);
        } else {
            $('#seller-categories-other').html('');
        }

        //alert(seller_categories.length + '-' + sellerCategories.length);
        //alert(windowsize);
    }

    // Execute on load
    displayResults();
    // Bind event listener
    $(window).resize(displayResults);
});
//--></script>
<?php echo $footer; ?>
