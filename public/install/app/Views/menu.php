<div class="p-3">
	<h4 class="border-bottom border-light text-light pb-3 mb-3"><?php echo lang('Heading.heading_installation', array(), $front_locale); ?></h4>
	<ul class="list-unstyled text-light">
		<li class="text-uppercase<?php if ($current_page == 'install' || $current_page == 'public') { ?> fw-bold<?php } ?>"><?php echo lang('Heading.heading_welcome', array(), $front_locale); ?></li>
		<li class="text-uppercase<?php if ($current_page == 'license_agreement') { ?> fw-bold<?php } ?>"><?php echo lang('Heading.heading_license_agreement', array(), $front_locale); ?></li>
		<li class="text-uppercase<?php if ($current_page == 'pre_installation') { ?> fw-bold<?php } ?>"><?php echo lang('Heading.heading_pre_installation', array(), $front_locale); ?></li>
		<li class="text-uppercase<?php if ($current_page == 'configuration') { ?> fw-bold<?php } ?>"><?php echo lang('Heading.heading_configuration', array(), $front_locale); ?></li>
		<li class="text-uppercase<?php if ($current_page == 'finish') { ?> fw-bold<?php } ?>"><?php echo lang('Heading.heading_finish', array(), $front_locale); ?></li>
	</ul>
</div>