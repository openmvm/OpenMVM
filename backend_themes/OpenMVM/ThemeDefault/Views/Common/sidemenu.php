<aside id="sidemenu" class="sidemenu bg-light">
	<div class="min-vh-100">
		<h5 class="sidemenu-title text-dark px-3 py-2"><i class="fas fa-list"></i> <?php echo lang('Text.text_navigation', array(), $lang->getBackEndLocale()); ?></h5>
		<div class="">
			<?php if ($menus) { ?>
			<ul id="menu" class="list-unstyled small">
				<?php foreach ($menus as $menu) { ?>
					<?php if ($menu['children']) { ?>
					<li class="">
						<a href="<?php echo $menu['href'] . '/' . $administrator_token; ?>#<?php echo $menu['id']; ?>" class="parent text-dark collapsed ps-3 py-2" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="<?php echo $menu['id']; ?>"><i class="<?php echo $menu['icon']; ?>"></i>&nbsp;&nbsp;<?php echo $menu['text']; ?></a>
						<div id="<?php echo $menu['id']; ?>" class="collapse" aria-labelledby="<?php echo $menu['id']; ?>" data-parent="#<?php echo $menu['id']; ?>">
							<ul class="list-unstyled">
								<?php foreach ($menu['children'] as $child) { ?>
									<?php if ($child['children']) { ?>
									<li class="">
										<a href="#<?php echo $child['id']; ?>" class="parent text-dark ps-4 py-2" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="<?php echo $child['id']; ?>"><i class="<?php echo $child['icon']; ?>"></i>&nbsp;&nbsp;<?php echo $child['text'][$lang->getBackEndLocale()]; ?></a>
										<div id="<?php echo $child['id']; ?>" class="collapse" aria-labelledby="<?php echo $child['id']; ?>" data-parent="#<?php echo $child['id']; ?>">
											<ul class="list-unstyled">
												<?php foreach ($child['children'] as $sub_child) { ?>
												<li><a href="<?php echo base_url($_SERVER['app.adminDir'] . $sub_child['href'] . '/' . $administrator_token); ?>" class="text-dark ps-5 py-2"><i class="<?php echo $sub_child['icon']; ?>"></i>&nbsp;&nbsp;<?php echo $sub_child['text'][$lang->getBackEndLocale()]; ?></a></li>
												<?php } ?>
											</ul>
										</div>
									</li>
									<?php } else { ?>
									<li><a href="<?php echo base_url($_SERVER['app.adminDir'] . $child['href'] . '/' . $administrator_token); ?>" class="text-dark ps-4 py-2"><i class="<?php echo $child['icon']; ?>"></i>&nbsp;&nbsp;<?php echo $child['text'][$lang->getBackEndLocale()]; ?></a></li>
									<?php } ?>
								<?php } ?>
							</ul>
						</div>
					</li>
					<?php } else { ?>
					<li class=""><a href="<?php echo $menu['href'] . '/' . $administrator_token; ?>" class="text-dark ps-3 py-2"><i class="<?php echo $menu['icon']; ?>"></i>&nbsp;&nbsp;<?php echo $menu['text']; ?></a></li>
					<?php } ?>
				<?php } ?>
			</ul>
			<?php } ?>
		</div>
	</div>
</aside>
