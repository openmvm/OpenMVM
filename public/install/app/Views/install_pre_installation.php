<?php echo $header; ?>
<section id="main" class="main container">
	<?php echo form_open(base_url('install/public/pre_installation')); ?>
	<div class="row" style="min-height: 400px;">
		<div class="col-sm-3 bg-danger">
			<?php echo $menu; ?>
		</div>
		<div class="col-sm-9 bg-light">
			<div class="p-3">
				<div class="border-bottom border-danger clearfix pb-3 mb-3">
					<h4 class="float-start p-0 m-0"><?php echo lang('Text.text_openmvm', array(), $front_locale); ?></h4>
					<h4 class="text-danger float-end p-0 m-0"><?php echo lang('Heading.heading_pre_installation', array(), $front_locale); ?></h4>
				</div>
				<div class="mb-3" style="height: 270px; overflow-y: scroll;">
					<h6 class="border-bottom border-dark text-uppercase pe-2 pb-2"><?php echo lang('Text.text_required_settings', array(), $front_locale); ?></h6>
					<div class="mb-3">
						<div class="table-responsive">
							<table class="table table-borderless table-hover">
							  <thead>
							    <tr>
							      <th scope="col"><?php echo lang('Column.column_setting', array(), $front_locale); ?></th>
							      <th scope="col"><?php echo lang('Column.column_current', array(), $front_locale); ?></th>
							      <th scope="col"><?php echo lang('Column.column_required', array(), $front_locale); ?></th>
							      <th scope="col"><?php echo lang('Column.column_status', array(), $front_locale); ?></th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <th scope="row"><?php echo lang('Text.text_php_version', array(), $front_locale); ?></th>
							      <td><?php echo $php_version; ?></td>
							      <td>7.3+</td>
							      <td><?php if ($php_version >= '7.3') { ?><span class="text-success"><i class="fas fa-check-circle fa-fw"></i></span><?php } else { ?><span class="text-danger"><i class="fas fa-minus-circle fa-fw"></i><?php } ?></td>
							    </tr>
							  </span>
							</table>
						</div>
					</div>
					<h6 class="border-bottom border-dark text-uppercase pe-2 pb-2"><?php echo lang('Text.text_required_php_extensions', array(), $front_locale); ?></h6>
					<div class="mb-3">
						<div class="table-responsive">
							<table class="table table-borderless table-hover">
							  <thead>
							    <tr>
							      <th scope="col"><?php echo lang('Column.column_extension', array(), $front_locale); ?></th>
							      <th scope="col"><?php echo lang('Column.column_current', array(), $front_locale); ?></th>
							      <th scope="col"><?php echo lang('Column.column_required', array(), $front_locale); ?></th>
							      <th scope="col"><?php echo lang('Column.column_status', array(), $front_locale); ?></th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <th scope="row">intl</th>
							      <td><?php if ($intl) { ?><?php echo lang('Text.text_on', array(), $front_locale); ?><?php } else { ?><?php echo lang('Text.text_off', array(), $front_locale); ?><?php } ?></td>
							      <td><?php echo lang('Text.text_on', array(), $front_locale); ?></td>
							      <td><?php if ($intl) { ?><span class="text-success"><i class="fas fa-check-circle fa-fw"></i></span><?php } else { ?><span class="text-danger"><i class="fas fa-minus-circle fa-fw"></i><?php } ?></td>
							    </tr>
							    <tr>
							      <th scope="row">cURL</th>
							      <td><?php if ($curl) { ?><?php echo lang('Text.text_on', array(), $front_locale); ?><?php } else { ?><?php echo lang('Text.text_off', array(), $front_locale); ?><?php } ?></td>
							      <td><?php echo lang('Text.text_on', array(), $front_locale); ?></td>
							      <td><?php if ($curl) { ?><span class="text-success"><i class="fas fa-check-circle fa-fw"></i></span><?php } else { ?><span class="text-danger"><i class="fas fa-minus-circle fa-fw"></i><?php } ?></td>
							    </tr>
							    <tr>
							      <th scope="row">json</th>
							      <td><?php if ($json) { ?><?php echo lang('Text.text_on', array(), $front_locale); ?><?php } else { ?><?php echo lang('Text.text_off', array(), $front_locale); ?><?php } ?></td>
							      <td><?php echo lang('Text.text_on', array(), $front_locale); ?></td>
							      <td><?php if ($json) { ?><span class="text-success"><i class="fas fa-check-circle fa-fw"></i></span><?php } else { ?><span class="text-danger"><i class="fas fa-minus-circle fa-fw"></i><?php } ?></td>
							    </tr>
							    <tr>
							      <th scope="row">mbstring</th>
							      <td><?php if ($mbstring) { ?><?php echo lang('Text.text_on', array(), $front_locale); ?><?php } else { ?><?php echo lang('Text.text_off', array(), $front_locale); ?><?php } ?></td>
							      <td><?php echo lang('Text.text_on', array(), $front_locale); ?></td>
							      <td><?php if ($mbstring) { ?><span class="text-success"><i class="fas fa-check-circle fa-fw"></i></span><?php } else { ?><span class="text-danger"><i class="fas fa-minus-circle fa-fw"></i><?php } ?></td>
							    </tr>
							    <tr>
							      <th scope="row">mysqlnd</th>
							      <td><?php if ($mysqlnd) { ?><?php echo lang('Text.text_on', array(), $front_locale); ?><?php } else { ?><?php echo lang('Text.text_off', array(), $front_locale); ?><?php } ?></td>
							      <td><?php echo lang('Text.text_on', array(), $front_locale); ?></td>
							      <td><?php if ($mysqlnd) { ?><span class="text-success"><i class="fas fa-check-circle fa-fw"></i></span><?php } else { ?><span class="text-danger"><i class="fas fa-minus-circle fa-fw"></i><?php } ?></td>
							    </tr>
							    <tr>
							      <th scope="row">xml</th>
							      <td><?php if ($xml) { ?><?php echo lang('Text.text_on', array(), $front_locale); ?><?php } else { ?><?php echo lang('Text.text_off', array(), $front_locale); ?><?php } ?></td>
							      <td><?php echo lang('Text.text_on', array(), $front_locale); ?></td>
							      <td><?php if ($xml) { ?><span class="text-success"><i class="fas fa-check-circle fa-fw"></i></span><?php } else { ?><span class="text-danger"><i class="fas fa-minus-circle fa-fw"></i><?php } ?></td>
							    </tr>
							  </tbody>
							</table>
						</div>
					</div>
					<h6 class="border-bottom border-dark text-uppercase pe-2 pb-2"><?php echo lang('Text.text_required_writable_file_dir', array(), $front_locale); ?></h6>
					<div class="mb-3">
						<div class="table-responsive">
							<table class="table table-borderless table-hover">
							  <thead>
							    <tr>
							      <th scope="col"><?php echo lang('Column.column_path', array(), $front_locale); ?></th>
							      <th scope="col"><?php echo lang('Column.column_status', array(), $front_locale); ?></th>
							    </tr>
							  </thead>
							  <tbody>
							  	<?php foreach ($directories as $directory) { ?>
								    <tr>
								      <td scope="row"><?php echo $directory['path']; ?></td>
								      <td><?php if ($directory['writable']) { ?><span class="text-success"><?php echo lang('Text.text_writable', array(), $front_locale); ?></span><?php } else { ?><span class="text-danger"><?php echo lang('Text.text_not_writable', array(), $front_locale); ?></span><?php } ?></td>
								    </tr>
							  	<?php } ?>
							  </span>
							</table>
						</div>
					</div>
				</div>
				<div class="border-top border-danger pt-3 clearfix">
					<div class="float-start"></div>
					<div class="float-end"><button type="submit" class="btn btn-sm btn-danger" onclick="submit();"><?php echo lang('Button.button_continue', array(), $front_locale); ?></button></div>
				</div>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>
</section>
<?php echo $footer; ?>
