<div id="search" class="input-group w-100 me-auto mt-3 mt-lg-0">
    <button id="search-type-toggle" class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?php if ($type == 'seller') { ?><?php echo lang('Text.sellers', [], $language_lib->getCurrentCode()); ?><?php } else { ?><?php echo lang('Text.products', [], $language_lib->getCurrentCode()); ?><?php } ?></button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="javascript:void(0);" onclick="selectType('product')"><?php echo lang('Text.products', [], $language_lib->getCurrentCode()); ?></a></li>
        <li><a class="dropdown-item" href="javascript:void(0);" onclick="selectType('seller')"><?php echo lang('Text.sellers', [], $language_lib->getCurrentCode()); ?></a></li>
    </ul>
    <input class="form-control" type="text" name="search" value="<?php echo $keyword; ?>" placeholder="Search" aria-label="Search">
    <input type="hidden" name="type" value="<?php echo $type; ?>" />
    <button class="btn btn-danger" type="button" id="button-search"><i class="fas fa-search fa-fw"></i> <?php echo lang('Button.search', [], $language_lib->getCurrentCode()); ?></button>
</div>
<script type="text/javascript"><!--
function selectType(type) {
    $('#search input[name="type"]').val(type);

    if (type == 'seller') {
        $('#search-type-toggle').text('<?php echo lang('Text.sellers', [], $language_lib->getCurrentCode()); ?>');
    } else {
        $('#search-type-toggle').text('<?php echo lang('Text.products', [], $language_lib->getCurrentCode()); ?>');
    }
}
//--></script> 
