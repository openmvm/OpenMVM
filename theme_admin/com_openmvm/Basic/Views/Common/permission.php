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
                <h3 class="card-title"><i class="fas fa-exclamation-triangle fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <div class="card border-0 shadow heading mb-3">
            <div class="card-body py-5">
                <h1 class="text-center text-danger"><?php echo $code_number; ?> <?php echo $code_text; ?></h1>
                <h5 class="text-center text-danger"><?php echo $message; ?></h5>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>
