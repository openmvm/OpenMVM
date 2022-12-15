<?php echo $header; ?>
<div class="container-fluid">
    <div id="content" class="content">
        <div class="card shadow rounded-0 mb-3">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <h2 class="p-0 m-0"><?php echo $heading_title; ?></h2>
                        <div class="lead text-uppercase"><?php echo $lead; ?></div>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-5">
                        <div id="form-seller-product-search" class="input-group">
                            <input type="text" name="keyword" value="<?php echo $keyword; ?>" class="form-control" id="input-seller-product-search-keyword" placeholder="<?php echo lang('Text.search_in_this_shop', [], $language_lib->getCurrentCode()); ?>" aria-label="<?php echo lang('Entry.keyword', [], $language_lib->getCurrentCode()); ?>">
                            <input type="hidden" name="type" value="<?php echo $type; ?>" />
                            <button class="btn btn-outline-secondary dropdown-toggle" id="input-seller-product-search-type" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php if ($type == 'marketplace') { ?>
                                    <?php echo lang('Text.in_the_marketplace', [], $language_lib->getCurrentCode()); ?>
                                <?php } else { ?>
                                    <?php echo lang('Text.in_this_shop', [], $language_lib->getCurrentCode()); ?>
                                <?php } ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" id="button-seller-product-search-shop" role="button" onclick="changeSearchType('shop');"><?php echo lang('Text.in_this_shop', [], $language_lib->getCurrentCode()); ?><?php if ($type == 'shop') { ?><i class="fas fa-check fa-fw text-danger ms-2 mt-1 float-end"></i><?php } else { ?><i class="fas fa-times fa-fw ms-2 mt-1 float-end" style="color: transparent;">&nbsp;</i></a><?php } ?></a></li>
                                <li><a class="dropdown-item" id="button-seller-product-search-marketplace" role="button" onclick="changeSearchType('marketplace');"><?php echo lang('Text.in_the_marketplace', [], $language_lib->getCurrentCode()); ?><?php if ($type == 'marketplace') { ?><i class="fas fa-check fa-fw text-danger ms-2 mt-1 float-end"></i><?php } else { ?><i class="fas fa-times fa-fw ms-2 mt-1 float-end" style="color: transparent;">&nbsp;</i></a><?php } ?></a></li>
                            </ul>
                            <button id="button-seller-product-search" class="btn btn-danger" type="button"><i class="fas fa-search fa-fw"></i></button>
                        </div>                        
                    </div>
                </div>
                <div>
                    <a href="<?php echo $store_url; ?>" class="btn btn-<?php if ($link_id == 'home') { ?>primary<?php } else { ?>light<?php } ?> rounded-0"><?php echo lang('Button.home', [], $language_lib->getCurrentCode()); ?></a>
                    <div id="seller-categories" class="d-inline-block"></div>
                    <div id="seller-categories-other" class="d-inline-block"></div>
                </div>
            </div>
        </div>
        <?php if ($products) { ?>
        <div class="card shadow rounded-0 mb-3">
            <div class="card-body">
                <div class="lead mb-3"><?php echo lang('Text.products', [], $language_lib->getCurrentCode()); ?></div>
                <div class="row g-3">
                    <?php foreach ($products as $product) { ?>
                    <div class="col-sm-3 d-flex">
                        <div class="card w-100">
                            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                            <div class="card-body">
                                <a href="<?php echo $product['href']; ?>" class="card-title" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
                                <div class="my-3">
                                    <?php if (!empty($product['product_option'])) { ?>
                                        <?php if (!empty($product['product_variant_special'])) { ?>
                                        <div><span class="text-secondary me-2"><s><?php echo $product['min_price']; ?></s> - <s><?php echo $product['max_price']; ?></s></span><span><?php echo $product['special_min_price']; ?> - <?php echo $product['special_max_price']; ?></span></div>
                                        <?php } else { ?>
                                        <div><?php echo $product['min_price']; ?> - <?php echo $product['max_price']; ?></div>
                                        <?php } ?>
                                    <?php } else { ?>
                                    <div><?php if ($product['special']) { ?><s class="text-secondary me-2"><?php echo $product['price']; ?></s><?php echo $product['special']; ?><?php } else { ?><?php echo $product['price']; ?><?php } ?></div>
                                    <?php } ?>
                                </div>
                                <a href="<?php echo $product['href']; ?>" class="btn btn-primary"><?php echo lang('Button.details', [], $language_lib->getCurrentCode()); ?></a>
                            </div>
                        </div>                
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript"><!--
$('#seller-categories').html('<i class="fas fa-spinner fa-spin"></i>');

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
            //$('#seller-categories').html('<i class="fas fa-spinner fa-spin"></i>');
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
        parent_id = '<?php echo $parent_id; ?>';

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
                    html += '    <a id="seller-category-' + seller_category['seller_category_id'] + '" class="btn btn-light';
                    html += ' rounded-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
                    html += seller_category['name'];
                    html += '    </a>';
                    html += '    <ul class="dropdown-menu rounded-0">';
                    html += '        <li><a id="seller-category-child-' + seller_category['seller_category_id'] + '" class="dropdown-item" href="';
                    html += seller_category['href'];
                    html += '"><strong>';
                    html += seller_category['name'];
                    html += '        </strong></a></li>';
                    for (var j = 0, jlen = seller_category['children'].length; j < jlen; j++) {
                        seller_category_child = seller_category['children'][j];

                        html += '        <li><a id="seller-category-child-' + seller_category_child['seller_category_id'] + '" class="dropdown-item" href="';
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

            if (parent_id != 0) {
                $('#seller-category-' + parent_id).removeClass('btn-light').addClass('btn-primary');
                $('#seller-category-child-' + link_id).addClass('active');
            } else {
                $('#seller-category-' + link_id).removeClass('btn-light').addClass('btn-primary');
                $('#seller-category-child-' + link_id).addClass('active');
            }
        }

        if (sellerCategories.length > 0 && total_main < sellerCategories.length) {
            html = '';

            html += '<div class="dropdown d-inline">';
            html += '    <a id="seller-category-more" class="btn btn-light rounded-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo lang('Text.more', [], $language_lib->getCurrentCode()); ?></a>';
            html += '    <ul class="dropdown-menu rounded-0">';
            var other_seller_categories = [];

            for (var k = total_main, klen = sellerCategories.length; k < klen; k++) {
                other_seller_category = sellerCategories[k];

                html += '        <li><a id="seller-category-child-' + other_seller_category['seller_category_id'] + '" class="dropdown-item" href="';
                html += other_seller_category['href'];
                html += '">';
                html += other_seller_category['name'];
                html += '        </a></li>';

                other_seller_categories.push(other_seller_category['seller_category_id']);
            }
            html += '    </ul>';
            html += '</div>';

            $('#seller-categories-other').html(html);

            if (other_seller_categories.includes(link_id)) {
                $('#seller-category-more').removeClass('btn-light').addClass('btn-primary');
                $('#seller-category-child-' + link_id).addClass('active');
            }
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
<script type="text/javascript"><!--
function changeSearchType(type) {
    $('#button-seller-product-search-shop i').remove();
    $('#button-seller-product-search-marketplace i').remove();

    if (type == 'shop') {
        $('#input-seller-product-search-keyword').attr('placeholder', '<?php echo lang('Text.search_in_this_shop', [], $language_lib->getCurrentCode()); ?>');
        $('#input-seller-product-search-type').html('<?php echo lang('Text.in_this_shop', [], $language_lib->getCurrentCode()); ?>');
        $('#button-seller-product-search-shop').append('<i class="fas fa-check fa-fw text-danger ms-2 mt-1 float-end"></i>');
        $('#button-seller-product-search-marketplace i').remove();
        $('#button-seller-product-search-marketplace').append('<i class="fas fa-times fa-fw ms-2 mt-1 float-end" style="color: transparent;">&nbsp;</i>');

        $('#form-seller-product-search input[name="type"]').val('shop');
    } else {
        $('#input-seller-product-search-keyword').attr('placeholder', '<?php echo lang('Text.search_in_the_marketplace', [], $language_lib->getCurrentCode()); ?>');
        $('#input-seller-product-search-type').html('<?php echo lang('Text.in_the_marketplace', [], $language_lib->getCurrentCode()); ?>');
        $('#button-seller-product-search-marketplace').append('<i class="fas fa-check fa-fw text-danger ms-2 mt-1 float-end"></i>');
        $('#button-seller-product-search-shop i').remove();
        $('#button-seller-product-search-shop').append('<i class="fas fa-times fa-fw ms-2 mt-1 float-end" style="color: transparent;">&nbsp;</i>');

        $('#form-seller-product-search input[name="type"]').val('marketplace');
    }
}
//--></script>
<script type="text/javascript"><!--
$('body').on('click', '#button-seller-product-search', function() {
    seller = '<?php echo $seller_slug; ?>';

    if ($('#form-seller-product-search input[name="keyword"]').val() !== '') {
        keyword = $('#form-seller-product-search input[name="keyword"]').val();
    } else {
        alert('<?php echo lang('Error.search_keywords', [], $language_lib->getCurrentCode()); ?>');
    }

    type = $('#form-seller-product-search input[name="type"]').val();

    if (type == 'shop') {
        url = '<?php echo $seller_product_search_url; ?>' + '/' + seller + '/' + keyword + '?type=' + type;
    } else {
        url = '<?php echo $product_search_url; ?>' + '?keyword=' + keyword;
    }

    window.location.href = url;
});
//--></script>
<?php echo $footer; ?>
