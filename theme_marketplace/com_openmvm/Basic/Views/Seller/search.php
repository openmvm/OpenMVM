<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
    </div>
    <?php if (!empty($sellers)) { ?>
        <?php foreach ($sellers as $seller) { ?>
        <div class="card mb-3">
            <div class="card-body d-flex">
                <div class="d-inline-block me-3"><a href="<?php echo $seller['href']; ?>"><img src="<?php echo $seller['thumb']; ?>" class="border p-2" alt="<?php echo $seller['store_name']; ?>" title="<?php echo $seller['store_name']; ?>" /></a></div>
                <div class="d-inline-block">
                    <div class="fs-6"><a href="<?php echo $seller['href']; ?>" class="link-dark text-decoration-none"><strong><?php echo $seller['store_name']; ?></strong></a></div>
                </div>
            </div>
        </div>
        <?php } ?>
    <?php } else { ?>
    <div class="text-secondary text-center my-5"><?php echo lang('Error.no_data_found', [], $language_lib->getCurrentCode()); ?></div>
    <?php } ?>
</div>
<?php echo $footer; ?>
