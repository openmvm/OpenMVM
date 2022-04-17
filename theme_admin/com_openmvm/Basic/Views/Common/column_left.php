<div id="swipeNav" class="column-left">
    <div class="administrator-profile mb-3">
        <div class="administrator-avatar text-center">
            <span class="fa-stack fa-2x">
                <i class="fas fa-circle fa-stack-2x text-dark"></i>
                <i class="fas fa-user-tie fa-stack-1x fa-inverse text-light"></i>
            </span>
        </div>
        <div class="administrator-name text-center"><strong><?php echo $administrator; ?></strong></div>
    </div>
    <div class="menu">
        <ul class="list-unstyled">
            <?php if ($menus) { ?>
                <?php foreach ($menus as $menu) { ?>
                    <?php if ($menu['children']) { ?>
                    <li>
                        <a href="#collapse-<?php echo $menu['id']; ?>" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-<?php echo $menu['id']; ?>" class="d-block"><?php if ($menu['icon']) { ?><i class="<?php echo $menu['icon']; ?> me-2"></i> <?php } ?><?php echo $menu['text']; ?> <i class="fas fa-angle-down float-end"></i></a>
                        <ul id="collapse-<?php echo $menu['id']; ?>" class="collapse list-unstyled">
                            <?php foreach ($menu['children'] as $child) { ?>
                                <?php if ($child['children']) { ?>
                                <li>
                                    <a href="#collapse-<?php echo $child['id']; ?>" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-<?php echo $child['id']; ?>" class="d-block"><?php if ($child['icon']) { ?><i class="<?php echo $child['icon']; ?> me-2"></i> <?php } ?><?php echo $child['text']; ?> <i class="fas fa-angle-down float-end"></i></a>
                                    <ul id="collapse-<?php echo $child['id']; ?>" class="collapse list-unstyled">
                                        <?php foreach ($child['children'] as $sub_child) { ?>
                                        <li><a href="<?php echo $sub_child['href']; ?>" class="d-block"><?php if ($sub_child['icon']) { ?><i class="<?php echo $sub_child['icon']; ?> me-2"></i> <?php } ?><?php echo $sub_child['text']; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php } else { ?>
                                <li><a href="<?php echo $child['href']; ?>" class="d-block"><?php if ($child['icon']) { ?><i class="<?php echo $child['icon']; ?> me-2"></i> <?php } ?><?php echo $child['text']; ?></a></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } else { ?>
                    <li><a href="<?php echo $menu['href']; ?>" id="<?php echo $menu['id']; ?>" class="d-block"><?php if ($menu['icon']) { ?><i class="<?php echo $menu['icon']; ?> me-2"></i> <?php } ?><?php echo $menu['text']; ?></a></li>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
    $('#swipeNav').swipeNav();
});
//--></script>
