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
                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="button-favorite"><i class="fas fa-heart<?php if ($is_wishlist) { ?> text-danger<?php } ?> me-2"></i><?php echo lang('Button.favorite', [], $language_lib->getCurrentCode()); ?></button>
                                    </div>
                                </div>
                                <div id="price" class="text-danger bg-light fs-1 px-3 mb-3">
                                    <?php if ($is_product_option) { ?>
                                        <?php if ($is_product_variant_special) { ?>
                                        <div id="product-variant-price">
                                            <div class="text-secondary fs-3"><s><?php echo $min_price; ?></s> - <s><?php echo $max_price; ?></s></div>
                                            <div><?php echo $special_min_price; ?> - <?php echo $special_max_price; ?></div>
                                        </div>
                                        <?php } else { ?>
                                        <div id="product-variant-price"><?php echo $min_price; ?> - <?php echo $max_price; ?></div>
                                        <?php } ?>
                                    <?php } else { ?>
                                    <div id="product-price"><?php if ($special) { ?><s class="text-secondary me-2"><?php echo $price; ?></s><?php echo $special; ?><?php } else { ?><?php echo $price; ?><?php } ?></div>
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
                                <?php if ($is_product_option) { ?>
                                    <?php if ($is_product_variant_discount) { ?>
                                    <div id="product-variant-discounts"></div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php if (!empty($product_discounts)) { ?>
                                    <div id="product-discounts">
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-sm" style="max-width: 12rem;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2" class="bg-danger text-white"><?php echo lang('Text.buy_more_and_save', [], $language_lib->getCurrentCode()); ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="bg-light"><?php echo lang('Column.quantity', [], $language_lib->getCurrentCode()); ?></th>
                                                        <th class="text-end bg-light"><?php echo lang('Column.price', [], $language_lib->getCurrentCode()); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($product_discounts as $product_discount) { ?>
                                                    <tr>
                                                        <td class="bg-light"><?php echo $product_discount['min_quantity']; ?><?php if (empty($product_discount['max_quantity'])) { ?>+<?php } else { ?>-<?php echo $product_discount['max_quantity']; ?><?php } ?></td>
                                                        <td class="text-end bg-light"><?php echo $product_discount['price']; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <?php } ?>
                                <div id="input-quantity-container" class="input-group<?php if ($is_product_option) { ?> d-none<?php } ?>" style="max-width: 200px;">
                                    <button class="btn btn-outline-secondary" type="button" id="button-quantity-minus"><i class="fas fa-minus fa-fw"></i></button>
                                    <input type="number" min="1" name="quantity" value="1" class="form-control" id="input-quantity" placeholder="Quantity" aria-label="Quantity" aria-describedby="input-quantity">
                                    <button class="btn btn-outline-secondary" type="button" id="button-quantity-plus"><i class="fas fa-plus fa-fw"></i></button>
                                </div>
                                <div class="mb-3"><?php echo lang('Text.stock', [], $language_lib->getCurrentCode()); ?>: <strong id="product-quantity"><?php if ($is_product_option) { ?>-<?php } else { ?><?php echo $quantity; ?><?php } ?></strong></div>
                                <div class="buttons">
                                    <div id="product-variant-error-message" class="text-danger<?php if (!$is_product_option) { ?> d-none<?php } ?>"><?php echo lang('Error.select_product_options', [], $language_lib->getCurrentCode()); ?></div>
                                    <button type="button" class="btn btn-primary<?php if ($is_product_option) { ?> d-none<?php } ?>" id="button-cart"><i class="fas fa-cart-plus fa-fw"></i> <?php echo lang('Button.add_to_cart', [], $language_lib->getCurrentCode()); ?></button>
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
                        <h5 class="mb-4"><?php echo lang('Text.product_description', [], $language_lib->getCurrentCode()); ?></h5>
                        <div><?php echo $description; ?></div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div id="customer-question">
                        <div class="clearfix">
                            <h5 class="float-start"><?php echo lang('Text.customer_questions_and_answers', [], $language_lib->getCurrentCode()); ?></h5>
                            <?php if ($logged_in) { ?>
                            <a data-bs-toggle="collapse" href="#form-question" role="button" aria-expanded="false" aria-controls="form-question" id="button-question-open" class="link-secondary text-decoration-none float-end"><?php echo lang('Button.ask_a_question', [], $language_lib->getCurrentCode()); ?><i class="fas fa-caret-down ms-2"></i></a>
                            <a data-bs-toggle="collapse" href="#form-question" role="button" aria-expanded="false" aria-controls="form-question" id="button-question-close" class="link-secondary text-decoration-none float-end d-none"><?php echo lang('Button.close', [], $language_lib->getCurrentCode()); ?><i class="fas fa-xmark ms-2"></i></a>
                            <?php } ?>
                        </div>
                        <?php if ($logged_in) { ?>
                        <div mt-2>
                            <?php echo form_open($add_product_question, ['id' => 'form-question', 'class' => 'collapse']); ?>
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" id="input-product-id" />
                                <div class="mb-2"><input type="text" name="question" value="" id="input-question" class="form-control" placeholder="<?php echo lang('Entry.type_your_question_here', [], $language_lib->getCurrentCode()); ?>" /></div>
                                <div class="clearfix">
                                    <div class="float-start">
                                        <button type="button" class="btn btn-sm btn-outline-success button-action" data-form="form-question" data-form-action="<?php echo $add_product_question; ?>" data-icon="fa-paper-plane" data-toast-heading-title-success="<?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-title-error="<?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?>" data-toast-heading-icon-success="fa-check-circle" data-toast-heading-icon-error="fa-triangle-exclamation" data-redirection="false" data-form-reset="true" data-form-reset-ignore="#input-product-id"><i class="fas fa-paper-plane fa-fw"></i><span class="d-none d-md-inline-block ms-1"><?php echo lang('Button.submit', [], $language_lib->getCurrentCode()); ?></span></button>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <?php } ?>
                        <div id="customer-question-list" class="mt-4">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div id="customer-review">
                        <h5 class="mb-4"><?php echo lang('Text.customer_reviews', [], $language_lib->getCurrentCode()); ?></h5>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-2">
                                    <div class="d-inline-block fs-4 me-3">
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                            <?php if ($i <= $average_product_review_rating) { ?>
                                            <i class="fas fa-star text-danger"></i>
                                            <?php } else { ?>
                                            <i class="far fa-star text-danger"></i>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <div class="d-inline-block fs-4"><?php echo lang('Text.rating_out_of', ['rating' => $average_product_review_rating, 'max_rating' => 5], $language_lib->getCurrentCode()); ?></div>
                                </div>
                                <div class="mb-2"><a href="javascript:void(0);" class="link-warning text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 0);"><?php echo $total_product_reviews; ?> <?php echo strtolower(lang('Text.product_reviews', [], $language_lib->getCurrentCode())); ?></a></div>
                                <div>
                                    <table class="table table-borderless p-0">
                                        <tbody>
                                            <tr>
                                                <td class="ps-0" style="width: 15%;"><a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 5);">5 <?php echo lang('Text.star', [], $language_lib->getCurrentCode()); ?></a></td>
                                                <td>
                                                    <a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 5);">
                                                        <div class="progress" style="height: 24px;">
                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentage_product_reviews_rating_5; ?>%; height: 24px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $percentage_product_reviews_rating_5; ?>%</div>
                                                        </div> 
                                                    </a>                           
                                                </td>
                                                <td class="text-start pe-0" style="width: 15%;"><a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 5);"><?php echo $total_product_reviews_rating_5; ?></a></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-0" style="width: 15%;"><a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 4);">4 <?php echo lang('Text.star', [], $language_lib->getCurrentCode()); ?></a></td>
                                                <td>
                                                    <a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 4);">
                                                        <div class="progress" style="height: 24px;">
                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentage_product_reviews_rating_4; ?>%; height: 24px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $percentage_product_reviews_rating_4; ?>%</div>
                                                        </div>     
                                                    </a>                       
                                                </td>
                                                <td class="text-start pe-0" style="width: 15%;"><a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 4);"><?php echo $total_product_reviews_rating_4; ?></a></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-0" style="width: 15%;"><a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 3);">3 <?php echo lang('Text.star', [], $language_lib->getCurrentCode()); ?></a></td>
                                                <td>
                                                    <a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 3);">
                                                        <div class="progress" style="height: 24px;">
                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentage_product_reviews_rating_3; ?>%; height: 24px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $percentage_product_reviews_rating_3; ?>%</div>
                                                        </div>
                                                    </a>                            
                                                </td>
                                                <td class="text-start pe-0" style="width: 15%;"><a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 3);"><?php echo $total_product_reviews_rating_3; ?></a></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-0" style="width: 15%;"><a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 2);">2 <?php echo lang('Text.star', [], $language_lib->getCurrentCode()); ?></a></td>
                                                <td>
                                                    <a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 2);">
                                                        <div class="progress" style="height: 24px;">
                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentage_product_reviews_rating_2; ?>%; height: 24px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $percentage_product_reviews_rating_2; ?>%</div>
                                                        </div>  
                                                    </a>                          
                                                </td>
                                                <td class="text-start pe-0" style="width: 15%;"><a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 2);"><?php echo $total_product_reviews_rating_2; ?></a></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-0" style="width: 15%;"><a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 1);">1 <?php echo lang('Text.star', [], $language_lib->getCurrentCode()); ?></a></td>
                                                <td>
                                                    <a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 1);">
                                                        <div class="progress" style="height: 24px;">
                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentage_product_reviews_rating_1; ?>%; height: 24px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $percentage_product_reviews_rating_1; ?>%</div>
                                                        </div> 
                                                    </a>                           
                                                </td>
                                                <td class="text-start pe-0" style="width: 15%;"><a href="javascript:void(0);" class="link-dark text-decoration-none" onclick="getProductReviews('<?php echo $product_id; ?>', 1);"><?php echo $total_product_reviews_rating_1; ?></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div id="customer-review-list">
                                </div>
                            </div>
                        </div>
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
                if (json['product_variant']['special']) {
                    html = '<div class="text-secondary fs-3"><s>' + json['product_variant']['price'] + '</s></div>';
                    html += '<div>' + json['product_variant']['special'] + '</div>';
                } else {
                    html = json['product_variant']['price'];
                }

                $('#product-variant-price').html(html);

                if (json['product_variant']['discount'].length !== 0) {
                    discount = '    <div class="table-responsive">';
                    discount += '        <table class="table table-borderless table-sm" style="max-width: 12rem;">';
                    discount += '            <thead>';
                    discount += '                <tr>';
                    discount += '                    <th colspan="2" class="bg-danger text-white"><?php echo lang('Text.buy_more_and_save', [], $language_lib->getCurrentCode()); ?></th>';
                    discount += '                </tr>';
                    discount += '                <tr>';
                    discount += '                    <th class="bg-light"><?php echo lang('Column.quantity', [], $language_lib->getCurrentCode()); ?></th>';
                    discount += '                    <th class="text-end bg-light"><?php echo lang('Column.price', [], $language_lib->getCurrentCode()); ?></th>';
                    discount += '                </tr>';
                    discount += '            </thead>';
                    discount += '            <tbody>';
                    for (i = 0; i < json['product_variant']['discount'].length; i++) {
                        product_discount = json['product_variant']['discount'][i];
                        discount += '                <tr>';
                        discount += '                    <td class="bg-light">' + product_discount['min_quantity'];
                        if (product_discount['max_quantity'] == 0) {
                            discount += '+';
                        } else {
                            discount += '-' + product_discount['max_quantity'];
                        }
                        discount += '                    </td>';
                        discount += '                    <td class="text-end bg-light">'+ product_discount['price'] + '</td>';
                        discount += '                </tr>';
                    }
                    discount += '            </tbody>';
                    discount += '        </table>';
                    discount += '    </div>';

                    $('#product-variant-discounts').html('');
                    $('#product-variant-discounts').html(discount);
                } else {
                    $('#product-variant-discounts').html('');
                }

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
            $('.toast-container').remove();
            
            if (json['error']) {
                html = '<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11;">';
                html += '    <div id="liveToast" class="toast bg-danger" role="alert" aria-live="assertive" aria-atomic="true">';
                html += '        <div class="toast-header">';
                html += '            <i class="fas fa-times-circle text-danger me-1"></i>';
                html += '            <strong class="text-danger me-auto"><?php echo lang('Text.error', [], $language_lib->getCurrentCode()); ?></strong>';
                html += '            <small><?php echo lang('Text.add_to_cart', [], $language_lib->getCurrentCode()); ?></small>';
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

                html = '<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">';
                html += '    <div id="liveToast" class="toast bg-success" role="alert" aria-live="assertive" aria-atomic="true">';
                html += '        <div class="toast-header">';
                html += '            <i class="fas fa-check-circle text-success me-1"></i>';
                html += '            <strong class="text-success me-auto"><?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?></strong>';
                html += '            <small><?php echo lang('Text.add_to_cart', [], $language_lib->getCurrentCode()); ?></small>';
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

            $('.toast-container').remove();
            
            html = '<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11;">';
            html += '    <div id="liveToast" class="toast bg-success" role="alert" aria-live="assertive" aria-atomic="true">';
            html += '        <div class="toast-header">';
            html += '            <i class="fas fa-times-circle text-success me-1"></i>';
            html += '            <strong class="text-success me-auto"><?php echo lang('Text.success', [], $language_lib->getCurrentCode()); ?></strong>';
            html += '            <small><?php echo lang('Text.add_to_wishlist', [], $language_lib->getCurrentCode()); ?></small>';
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
<script type="text/javascript"><!--
getProductQuestions('<?php echo $product_id; ?>');

function getProductQuestions(product_id) {
    $('#customer-question-list').html('<i class="fas fa-spinner fa-spin"></i>');
    $('#customer-question-list').load('<?php echo $get_product_questions; ?>?product_id=' + product_id);
}
//--></script> 
<script type="text/javascript"><!--
getProductReviews('<?php echo $product_id; ?>', 0);

function getProductReviews(product_id, rating) {
    $('#customer-review-list').html('<i class="fas fa-spinner fa-spin"></i>');
    $('#customer-review-list').load('<?php echo $get_product_reviews; ?>?product_id=' + product_id + '&rating=' + rating);
}
//--></script> 
<script type="text/javascript"><!--
$('#button-question-open').on('click', function() {
    $('#button-question-open').addClass('d-none');
    $('#button-question-close').removeClass('d-none');
});

$('#button-question-close').on('click', function() {
    $('#button-question-close').addClass('d-none');
    $('#button-question-open').removeClass('d-none');
});
//--></script> 
<?php echo $footer; ?>
