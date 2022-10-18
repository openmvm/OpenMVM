<?php echo $header; ?>
<div class="container-fluid">
    <div id="content" class="content">
        <div id="product-container">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="mb-3">
                                <?php if ($additional_images) { ?>
                                    <!-- Slider main container -->
                                    <div class="swiper product-images p-0 m-0">
                                        <!-- Additional required wrapper -->
                                        <div class="swiper-wrapper p-0 m-0">
                                            <div class="swiper-slide d-flex justify-content-center align-items-center border p-1"><img src="<?php echo $image; ?>" class="img-fluid" alt="<?php echo $name; ?>" title="<?php echo $name; ?>"></div>
                                            <?php foreach ($additional_images as $additional_image) { ?>
                                            <!-- Slides -->
                                            <div class="swiper-slide d-flex justify-content-center align-items-center border p-1"><img src="<?php echo $additional_image['image']; ?>" class="img-fluid" alt="<?php echo $name; ?>" title="<?php echo $name; ?>" /></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                <img src="<?php echo $image; ?>" class="border img-fluid" alt="<?php echo $name; ?>" title="<?php echo $name; ?>">
                                <?php } ?>
                            </div>
                            <div>
                                <?php if ($additional_images) { ?>
                                    <!-- Slider main container -->
                                    <div class="swiper product-thumbs p-0 m-0">
                                        <!-- Additional required wrapper -->
                                        <div class="swiper-wrapper p-0 m-0">
                                            <div class="swiper-slide d-flex justify-content-center align-items-center"><img src="<?php echo $thumb; ?>" class="border img-fluid border p-1" alt="<?php echo $name; ?>" title="<?php echo $name; ?>"></div>
                                            <?php foreach ($additional_images as $additional_image) { ?>
                                            <!-- Slides -->
                                            <div class="swiper-slide d-flex justify-content-center align-items-center"><img src="<?php echo $additional_image['thumb']; ?>" class="img-fluid border p-1" alt="<?php echo $name; ?>" title="<?php echo $name; ?>" /></div>
                                            <?php } ?>
                                        </div>
                                        <!-- If we need pagination -->
                                        <div class="swiper-pagination"></div>

                                        <!-- If we need navigation buttons -->
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div id="form-product">
                                <div class="mb-3">
                                    <h3><?php echo $heading_title; ?></h3>
                                    <div>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="button-favorite"><i class="fas fa-heart<?php if ($is_wishlist) { ?> text-danger<?php } ?> me-2"></i><?php echo lang('Button.favorite', [], 'en'); ?></button>
                                    </div>
                                </div>
                                <div id="price" class="text-danger bg-light fs-1 px-3 mb-3">
                                    <?php if ($is_product_option) { ?>
                                    <div id="product-variant-price"><?php echo $min_price; ?> - <?php echo $max_price; ?></div>
                                    <?php } else { ?>
                                    <div id="product-price"><?php echo $price; ?></div>
                                    <?php } ?>
                                </div>
                                <?php if ($is_product_option) { ?>
                                    <?php if (!empty($product_options)) { ?>
                                    <div id="product-options" class="mb-5">
                                        <?php foreach ($product_options as $product_option) { ?>
                                        <div class="mb-3">
                                            <div class="text-uppercase text-secondary mb-2"><small><strong><?php echo $product_option['description']['name']; ?></strong>: <span id="product-option-<?php echo $product_option['option_id']; ?>" class="text-primary"></span></small></div>
                                            <?php if (!empty($product_option['product_option_value'])) { ?>
                                            <div>
                                                <?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
                                                <input type="radio" name="product_variant[<?php echo $product_option['option_id']; ?>]" value="<?php echo $product_option_value['option_value_id']; ?>" class="btn-check" id="input-product-option-value-<?php echo $product_option['option_id']; ?>-<?php echo $product_option_value['option_value_id']; ?>" autocomplete="off" onclick="getProductVariant();">
                                                <label class="btn btn-outline-primary shadow-none" for="input-product-option-value-<?php echo $product_option['option_id']; ?>-<?php echo $product_option_value['option_value_id']; ?>"><?php echo $product_option_value['description']['name']; ?></label>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                <?php } ?>
                                <div id="input-quantity-container" class="input-group<?php if ($is_product_option) { ?> d-none<?php } ?>" style="max-width: 200px;">
                                    <button class="btn btn-outline-secondary" type="button" id="button-quantity-minus"><i class="fas fa-minus fa-fw"></i></button>
                                    <input type="number" min="1" name="quantity" value="1" class="form-control" id="input-quantity" placeholder="Quantity" aria-label="Quantity" aria-describedby="input-quantity">
                                    <button class="btn btn-outline-secondary" type="button" id="button-quantity-plus"><i class="fas fa-plus fa-fw"></i></button>
                                </div>
                                <div class="mb-3"><?php echo lang('Text.stock', [], 'en'); ?>: <strong id="product-quantity"><?php if ($is_product_option) { ?>-<?php } else { ?><?php echo $quantity; ?><?php } ?></strong></div>
                                <div class="buttons">
                                    <div id="product-variant-error-message" class="text-danger<?php if (!$is_product_option) { ?> d-none<?php } ?>"><?php echo lang('Error.select_product_options', [], 'en'); ?></div>
                                    <button type="button" class="btn btn-primary<?php if ($is_product_option) { ?> d-none<?php } ?>" id="button-cart"><i class="fas fa-cart-plus fa-fw"></i> <?php echo lang('Button.add_to_cart'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body d-flex">
                    <div class="d-inline-block me-3"><a href="<?php echo $store_url; ?>"><img src="<?php echo $store_logo; ?>" class="border p-2" alt="<?php echo $store_name; ?>" title="<?php echo $store_name; ?>" /></a></div>
                    <div class="d-inline-block">
                        <div class="fs-6"><a href="<?php echo $store_url; ?>" class="link-dark text-decoration-none"><strong><?php echo $store_name; ?></strong></a></div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div>
                        <h5 class="mb-4"><?php echo lang('Text.product_description'); ?></h5>
                        <div><?php echo $description; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($is_product_option) { ?>
<script type="text/javascript"><!--
function getProductVariant() {
    $.ajax({
        url: '<?php echo $get_product_variant; ?>?product_id=<?php echo $product_id; ?>',
        type: 'post',
        dataType: 'json',
        data: $('#product-options').find('input').serialize(),
        beforeSend: function() {
            //$('select[name=\'setting_country_id\']').prop('disabled', true);
        },
        complete: function() {
            //$('select[name=\'setting_country_id\']').prop('disabled', false);
        },
        success: function(json) {
            if (json['product_variant'].length !== 0) {
                $('#product-variant-price').html(json['product_variant']['price']);
                $('#product-quantity').html();
                $('#product-quantity').html(json['product_variant']['quantity']);

                $('#product-variant-error-message').addClass('d-none');
                $('#button-cart').removeClass('d-none');
                $('#input-quantity-container').removeClass('d-none');
            } else {
                $('#product-variant-error-message').removeClass('d-none');
                $('button-cart').addClass('d-none');
                $('#input-quantity-container').addClass('d-none');
            }

            if (json['options'].length !== 0) {
                for (i = 0; i < json['options'].length; i++) {
                    option = json['options'][i];

                    $('#product-option-' + option['option_id']).html(option['option_value']);
                }
            }

            //alert(json['result']);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
//--></script>
<?php } ?>
<script type="text/javascript"><!--
$( "#button-cart" ).on( "click", function() {
	$.ajax({
		url: '<?php echo base_url('marketplace/checkout/cart/add?product_id=' . $product_id); ?>',
		type: 'post',
		data: $('#form-product input[type=\'text\'], #form-product input[type=\'number\'], #form-product input[type=\'hidden\'], #form-product input[type=\'radio\']:checked, #form-product input[type=\'checkbox\']:checked, #form-product select, #form-product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart i').removeClass('fa-cart-plus').addClass('fa-spinner fa-spin');
		},
		complete: function() {
			$('#button-cart i').removeClass('fa-spinner fa-spin').addClass('fa-cart-plus');
		},
		success: function(json) {
            if (json['error']) {
                html = '<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11;">';
                html += '    <div id="liveToast" class="toast bg-danger" role="alert" aria-live="assertive" aria-atomic="true">';
                html += '        <div class="toast-header">';
                html += '            <i class="fas fa-times-circle text-danger me-1"></i>';
                html += '            <strong class="text-danger me-auto"><?php echo lang('Text.error'); ?></strong>';
                html += '            <small><?php echo lang('Text.add_to_cart'); ?></small>';
                html += '            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>';
                html += '        </div>';
                html += '        <div class="toast-body text-light">';
                html +=              json['error'];
                html += '        </div>';
                html += '    </div>';
                html += '</div>';

                $('body').append(html);

                var toastLiveExample = document.getElementById('liveToast');
                var toast = new bootstrap.Toast(toastLiveExample);
                toast.show();
            }

            if (json['success']) {
                $( '#offcanvas-cart' ).load( '<?php echo base_url('marketplace/common/cart'); ?>' );

                html = '<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">';
                html += '    <div id="liveToast" class="toast bg-success" role="alert" aria-live="assertive" aria-atomic="true">';
                html += '        <div class="toast-header">';
                html += '            <i class="fas fa-check-circle text-success me-1"></i>';
                html += '            <strong class="text-success me-auto"><?php echo lang('Text.success'); ?></strong>';
                html += '            <small><?php echo lang('Text.add_to_cart'); ?></small>';
                html += '            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>';
                html += '        </div>';
                html += '        <div class="toast-body text-light">';
                html +=              json['success'];
                html += '        </div>';
                html += '    </div>';
                html += '</div>';

                $('body').append(html);

                var toastLiveExample = document.getElementById('liveToast');
                var toast = new bootstrap.Toast(toastLiveExample);
                toast.show();

                var myOffcanvas = document.getElementById('offcanvasRight');
                var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);

                bsOffcanvas.show();
            }

            //alert(JSON.stringify(json));
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
    var $buttonPlus = $('#button-quantity-plus');
    var $buttonMin = $('#button-quantity-minus');
    var $quantity = $('#input-quantity');

    /*For plus and minus buttons*/
    $buttonPlus.click(function() {
        $quantity.val(parseInt($quantity.val()) + 1);
    });

    $buttonMin.click(function() {
        $quantity.val(Math.max(parseInt($quantity.val()) - 1, 1));
    });
});
//--></script> 
<script type="text/javascript"><!--
var swiper = new Swiper('.product-thumbs', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
    slidesPerView: 4,

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

var swiper2 = new Swiper('.product-images', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // Thumbs
    thumbs: {
      swiper: swiper,
    },
});
//--></script> 
<script type="text/javascript"><!--
$( "#button-favorite" ).on( "click", function() {
    var product_id = '<?php echo $product_id; ?>';

    $.ajax({
        url: '<?php echo base_url('marketplace/product/product/add_to_wishlist'); ?>',
        type: 'post',
        data: {
            product_id: product_id
        },
        dataType: 'json',
        beforeSend: function() {
            $('#button-favorite i').removeClass('fa-heart').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            $('#button-favorite i').removeClass('fa-spinner fa-spin').addClass('fa-heart');
        },
        success: function(json) {
            if (json['is_wishlist']) {
                $('#button-favorite i').addClass('text-danger');
            } else {
                $('#button-favorite i').removeClass('text-danger');
            }

            $('#toast-container').remove();

            html = '<div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11;">';
            html += '    <div id="liveToast" class="toast bg-success" role="alert" aria-live="assertive" aria-atomic="true">';
            html += '        <div class="toast-header">';
            html += '            <i class="fas fa-times-circle text-success me-1"></i>';
            html += '            <strong class="text-success me-auto"><?php echo lang('Text.success'); ?></strong>';
            html += '            <small><?php echo lang('Text.add_to_wishlist'); ?></small>';
            html += '            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>';
            html += '        </div>';
            html += '        <div class="toast-body text-light">';
            html +=              json['success'];
            if (json['additional_message']) {
                html +=              ' ' + json['additional_message'];
            }
            html += '        </div>';
            html += '    </div>';
            html += '</div>';

            $('body').append(html);

            var toastLiveExample = document.getElementById('liveToast');
            var toast = new bootstrap.Toast(toastLiveExample);
            toast.show();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
//--></script>
<?php echo $footer; ?>
