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
					<h4 class="text-danger float-end p-0 m-0"><?php echo lang('Heading.heading_welcome', array(), $front_locale); ?></h4>
				</div>
				<div class="mb-3" style="min-height: 390px;"><?php echo lang('Text.text_welcome_to'); ?></div>
				<div class="border-top border-danger pt-3 clearfix text-end"><a href="<?php echo base_url('install/public/license_agreement'); ?>" class="btn btn-sm btn-danger float-end"><?php echo lang('Button.button_continue', array(), $front_locale); ?></a></div>
			</div>
		</div>
	</div>
</section>
<?php echo $footer; ?>
