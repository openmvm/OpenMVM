<?php echo $header; ?>
<section id="main" class="main container">
	<?php echo form_open(base_url('install/public/license_agreement')); ?>
	<div class="row" style="min-height: 400px;">
		<div class="col-sm-3 bg-danger">
			<?php echo $menu; ?>
		</div>
		<div class="col-sm-9 bg-light">
			<div class="p-3">
				<div class="border-bottom border-danger clearfix pb-3 mb-3">
					<h4 class="float-start p-0 m-0"><?php echo lang('Text.text_openmvm', array(), $front_locale); ?></h4>
					<h4 class="text-danger float-end p-0 m-0"><?php echo lang('Heading.heading_license_agreement', array(), $front_locale); ?></h4>
				</div>
				<div class="mb-3" style="height: 270px; overflow-y: scroll;"><?php echo $license; ?></div>
				<div class="border-top border-danger pt-3 clearfix">
					<div class="float-start">
						<div class="form-check">
						  <input name="license_agreement" class="form-check-input" type="checkbox" value="1" id="licenseAgreementCheck">
						  <label class="form-check-label" for="licenseAgreementCheck">
						    <?php echo lang('Text.text_agree_to'); ?>
						  </label>
						</div>
            <div class="text-danger"><?php echo $validation->showError('license_agreement'); ?></div>
					</div>
					<div class="float-end"><button type="submit" class="btn btn-sm btn-danger" onclick="submit();"><?php echo lang('Button.button_continue', array(), $front_locale); ?></button></div>
				</div>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>
</section>
<?php echo $footer; ?>
