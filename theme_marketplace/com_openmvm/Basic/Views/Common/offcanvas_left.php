<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasLeft" aria-labelledby="offcanvasLeftLabel">
    <div class="offcanvas-header bg-dark">
        <h5 class="offcanvas-title text-light" id="offcanvasLeftLabel"><i class="fas fa-user-circle fa-fw"></i> <?php echo $hello; ?></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div id="offcanvas-category">
            <h5 class="strong mb-3"><?php echo lang('Text.shop_by_department'); ?></h5>
            <div class="accordion" id="accordion-category">
                <?php foreach ($categories as $category) { ?>
                    <?php if (!empty($category['children'])) { ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-<?php echo $category['category_id']; ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $category['category_id']; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $category['category_id']; ?>">
                                <?php echo $category['name']; ?>
                            </button>
                        </h2>
                        <div id="collapse-<?php echo $category['category_id']; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $category['category_id']; ?>" data-bs-parent="#accordion-category">
                            <div class="accordion-body p-0">

                                <div class="accordion accordion-flush" id="accordion-children">
                                <?php foreach ($category['children'] as $child) { ?>
                                    <?php if (!empty($child['children'])) { ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-<?php echo $category['category_id']; ?>-<?php echo $child['category_id']; ?>">
                                        <button class="accordion-button collapsed ps-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $category['category_id']; ?>-<?php echo $child['category_id']; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $category['category_id']; ?>-<?php echo $child['category_id']; ?>">
                                            <div class="ps-3"><?php echo $child['name']; ?></div>
                                        </button>
                                        </h2>
                                        <div id="collapse-<?php echo $category['category_id']; ?>-<?php echo $child['category_id']; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $category['category_id']; ?>-<?php echo $child['category_id']; ?>" data-bs-parent="#accordion-children">
                                            <div class="accordion-body p-0">
                                                
                                                <div class="accordion accordion-flush" id="accordion-sub-children">

                                                <?php foreach ($child['children'] as $sub_child) { ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header ps-3" id="heading-<?php echo $category['category_id']; ?>-<?php echo $child['category_id']; ?>-<?php echo $sub_child['category_id']; ?>">
                                                        <a href="<?php echo $sub_child['href']; ?>" class="accordion-button-disabled collapsed link-dark text-decoration-none ps-3" type="button">
                                                            <div class="ps-3"><?php echo $sub_child['name']; ?></div>
                                                        </a>
                                                    </h2>
                                                </div>
                                                <?php } ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header ps-3" id="show-all-<?php echo $category['category_id']; ?>-<?php echo $child['category_id']; ?>">
                                                        <a href="<?php echo $child['href']; ?>" class="accordion-button-disabled collapsed link-dark text-decoration-none show-all ps-3" type="button">
                                                            <div class="ps-3"><?php echo lang('Text.show_all'); ?> <?php echo $child['name']; ?></div>
                                                        </a>
                                                    </h2>
                                                </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-<?php echo $category['category_id']; ?>-<?php echo $child['category_id']; ?>">
                                            <a href="<?php echo $child['href']; ?>" class="accordion-button-disabled collapsed link-dark text-decoration-none ps-3" type="button">
                                                <div class="ps-3"><?php echo $child['name']; ?></div>
                                            </a>
                                        </h2>
                                    </div>
                                    <?php } ?>
                                <?php } ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="show-all-<?php echo $category['category_id']; ?>">
                                        <a href="<?php echo $category['href']; ?>" class="accordion-button-disabled collapsed link-primary text-decoration-none show-all ps-3" type="button">
                                            <div class="ps-3"><?php echo lang('Text.show_all'); ?> <?php echo $category['name']; ?></div>
                                        </a>
                                    </h2>
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-<?php echo $category['category_id']; ?>">
                            <a href="<?php echo $category['href']; ?>" class="accordion-button-disabled collapsed link-dark text-decoration-none" type="button">
                                <?php echo $category['name']; ?>
                            </a>
                        </h2>
                    </div>
                    <?php } ?>
                <?php } ?>
            </div>            
        </div>
    </div>
</div>    