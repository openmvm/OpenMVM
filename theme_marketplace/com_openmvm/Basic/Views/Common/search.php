<div id="search" class="input-group w-100 me-auto mt-3 mt-lg-0">
    <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo lang('Text.all'); ?></button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Separated link</a></li>
    </ul>
    <input class="form-control" type="text" name="search" value="<?php echo $keyword; ?>" placeholder="Search" aria-label="Search">
    <button class="btn btn-danger" type="button" id="button-search"><i class="fas fa-search fa-fw"></i> <?php echo lang('Button.search'); ?></button>
</div>
