<?php echo $header; ?>
<section id="main" class="main container">
	<div class="row" style="min-height: 550px;">
		<div class="col-sm-3 bg-danger">
			<?php echo $menu; ?>
		</div>
		<div class="col-sm-9 bg-light">
			<div class="p-3">
				<div class="border-bottom border-danger clearfix pb-3 mb-3">
					<h4 class="float-start p-0 m-0"><?php echo lang('Text.text_openmvm', array(), $front_locale); ?></h4>
					<h4 class="text-danger float-end p-0 m-0"><?php echo lang('Heading.heading_finish', array(), $front_locale); ?></h4>
				</div>
				<div class="mb-3" style="height: 390px;">
					<div class="d-flex h-100" style="width: 100%;">
						<div class="justify-content-center align-self-center mx-auto">
							<h4 class="text-center text-success mb-3"><?php echo lang('Text.text_finish_message', array(), $front_locale); ?></h4>
							<h5 class="text-center text-danger mb-5"><?php echo lang('Text.text_delete_install_folder', array(), $front_locale); ?></h5>
							<div class="row">
								<div class="col-sm-6">
									<div class="d-grid">
										<a href="<?php echo base_url($admin_dir); ?>" target="_blank" class="btn btn-success btn-block text-white mb-3"><?php echo lang('Button.button_open_admin', array(), $front_locale); ?></a>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="d-grid">
										<a href="<?php echo base_url(); ?>" target="_blank" class="btn btn-success btn-block text-white mb-3"><?php echo lang('Button.button_open_site', array(), $front_locale); ?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php echo $footer; ?>
