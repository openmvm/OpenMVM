		<!-- Footer -->
		<section class="container-fluid footer bg-light mt-5">
			<div class="bg-dark mb-5 px-5">
				<div class="py-3">
					<div class="row">
						<div class="col-sm-3">
							<h5 class="text-light"><?php echo lang('Text.text_help_desk', array(), $lang->getFrontEndLocale()); ?></h5>
							<ul class="list-unstyled">
								<li><a href="<?php echo base_url('/contact_us'); ?>" class="link-light text-decoration-none"><?php echo lang('Text.text_contact_us', array(), $lang->getFrontEndLocale()); ?></a></li>
							</ul>
						</div>
						<div class="col-sm-3"></div>
						<div class="col-sm-3"></div>
						<div class="col-sm-3"></div>
					</div>
				</div>
				<div class="py-3">
					<div class="row">
						<div class="col-sm-6">
							<div class="copyright text-light text-start small"><?php echo sprintf(lang('Text.text_copyright', array(), $lang->getFrontEndLocale()), date("Y",now()), $website_name); ?></div>
						</div>
						<div class="col-sm-6">
							<div class="powered text-light text-end small"><?php echo lang('Text.text_powered', array(), $lang->getFrontEndLocale()); ?></div>
						</div>
					</div>
				</div>
			</div>
			<div class="text-muted text-center small my-3"><?php echo sprintf(lang('Text.text_page_rendered_in_seconds', array(), $lang->getFrontEndLocale()), '{elapsed_time}'); ?></div>
		</section>
		<!-- /.footer -->
	</body>
</html>
