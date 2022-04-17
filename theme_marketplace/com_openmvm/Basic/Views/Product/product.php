<?php echo $header; ?>
<div class="container-fluid">
    <div id="content" class="content">
        <div id="product-container">
            <div class="row">
                <div class="col-sm-5">
                    <img src="<?php echo $thumb; ?>" class="border img-fluid" alt="<?php echo $name; ?>" title="<?php echo $name; ?>">
                </div>
                <div class="col-sm-7">
                    <div id="form-product">
                        <h3><?php echo $heading_title; ?></h3>
                        <div><a href="<?php echo $store_url; ?>"><?php echo $store_name; ?></a></div>
                        <div class="mb-3"><?php echo $description; ?></div>
                        <div id="price" class="mb-3"><?php echo $price; ?></div>
                        <div class="input-group mb-3" style="max-width: 200px;">
                            <button class="btn btn-outline-secondary" type="button" id="button-quantity-minus"><i class="fas fa-minus fa-fw"></i></button>
                            <input type="text" name="quantity" value="1" class="form-control" id="input-quantity" placeholder="Quantity" aria-label="Quantity" aria-describedby="input-quantity">
                            <button class="btn btn-outline-secondary" type="button" id="button-quantity-plus"><i class="fas fa-plus fa-fw"></i></button>
                        </div>
                        <div class="buttons">
                            <button type="button" class="btn btn-primary" id="button-cart"><i class="fas fa-cart-plus fa-fw"></i> <?php echo lang('Button.add_to_cart'); ?></button> <button type="button" class="btn btn-secondary" id="button-buy"><?php echo lang('Button.buy_now'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
$( "#button-cart" ).on( "click", function() {
	$.ajax({
		url: '<?php echo base_url('marketplace/checkout/cart/add?product_id=' . $product_id); ?>',
		type: 'post',
		data: $('#form-product input[type=\'text\'], #form-product input[type=\'hidden\'], #form-product input[type=\'radio\']:checked, #form-product input[type=\'checkbox\']:checked, #form-product select, #form-product textarea'),
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
        $quantity.val(Math.max(parseInt($quantity.val()) - 1, 0));
    });
});
//--></script> 
<?php echo $footer; ?>
