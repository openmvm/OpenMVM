<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-danger">
        <h5 class="offcanvas-title text-light" id="offcanvasRightLabel"><i class="fas fa-shopping-cart me-2"></i><?php echo lang('Heading.shopping_cart', [], $language_lib->getCurrentCode()); ?></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div id="offcanvas-cart" class="offcanvas-body">
    </div>
</div>
<script type="text/javascript"><!--
$( '#offcanvas-cart' ).load( '<?php echo base_url('marketplace/common/cart'); ?>' );
//--></script> 
<script type="text/javascript"><!--
function cartRemove(event, product_id, product_variant) {
    const userData = {};
    userData['product_variant'] = product_variant;
    userData['uri_string'] = '<?php echo $uri_string; ?>';

    $.ajax({
        url: '<?php echo $cart_remove_url; ?>' + '?product_id=' + product_id,
        type: 'post',
        data: JSON.stringify(userData),
        dataType: 'json',
        beforeSend: function() {
            $(event).find('i').removeClass('fa-trash-alt').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            
        },
        success: function(json) {
            $( '#offcanvas-cart' ).load( '<?php echo base_url('marketplace/common/cart'); ?>' );

            if (json['refresh']) {
                window.location.href=window.location.href;
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
//--></script> 
