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
