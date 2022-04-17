<?php echo $header; ?><?php echo $column_left; ?>
<div class="container-fluid">
    <div id="content" class="content">
        <?php if ($breadcrumbs) { ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <?php if ($breadcrumb['active']) { ?>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
                    <?php } else { ?>
                    <li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                    <?php } ?>
                <?php } ?>
            </ol>
        </nav>
        <?php } ?>
        <div class="card border-0 shadow heading mb-3">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-images fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <div class="card shadow">
            <div class="card-header"><i class="fas fa-images fa-fw"></i> <?php echo $heading_title; ?></div>
            <div class="card-body">
                <div id="image-manager-workspace"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
    $( '#image-manager-workspace' ).load( '<?php echo $image_manager_workspace; ?>' );
});
//--></script> 
<?php echo $footer; ?>
