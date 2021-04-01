<?php echo $header; ?>
<section id="main" class="main container">
	<?php echo form_open(base_url('install/public/configuration')); ?>
	<div class="row" style="min-height: 590px;">
		<div class="col-sm-3 bg-danger">
			<?php echo $menu; ?>
		</div>
		<div class="col-sm-9 bg-light">
			<div class="p-3">
				<div class="border-bottom border-danger clearfix pb-3 mb-3">
					<h4 class="float-start p-0 m-0"><?php echo lang('Text.text_openmvm', array(), $front_locale); ?></h4>
					<h4 class="text-danger float-end p-0 m-0"><?php echo lang('Heading.heading_configuration', array(), $front_locale); ?></h4>
				</div>
				<div class="mb-3" style="height: 430px;">
					<h6 class="border-bottom border-dark text-uppercase pb-2"><?php echo lang('Text.text_server_configuration', array(), $this->front_locale); ?></h6>
					<fieldset class="small">
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group row required mb-3">
									<label for="input-db-driver" class="col-sm-4 control-label small"><?php echo lang('Entry.entry_db_driver', array(), $front_locale); ?></label>
									<div class="col-sm-8">
										<select name="db_driver" id="input-db-driver" class="form-control form-control-sm">
											<?php if ($mysqli) { ?>
												<?php if ($db_driver == 'mysqli') { ?>
													<option value="mysqli" selected="selected">MySQLi</option>
												<?php } else { ?>
													<option value="mysqli">MySQLi</option>
												<?php } ?>
											<?php } ?>
											<?php if ($pdo) { ?>
												<?php if ($db_driver == 'pdo') { ?>
													<option value="pdo" selected="selected">mPDO</option>
												<?php } else { ?>
													<option value="pdo">mPDO</option>
												<?php } ?>
											<?php } ?>
											<?php if ($pgsql) { ?>
												<?php if ($db_driver == 'pgsql') { ?>
													<option value="pgsql" selected="selected">PostgreSQL</option>
												<?php } else { ?>
													<option value="pgsql">PostgreSQL</option>
												<?php } ?>
											<?php } ?>
										</select>
										<div class="text-danger small"><?php echo $validation->showError('db_driver'); ?></div>
									</div>
								</div>
								<div class="form-group row required mb-3">
									<label for="input-hostname" class="col-sm-4 control-label small"><?php echo lang('Entry.entry_hostname', array(), $front_locale); ?></label>
									<div class="col-sm-8">
										<input type="text" name="hostname" value="<?php echo $hostname; ?>" id="input-hostname" class="form-control form-control-sm" />
										<div class="text-danger small"><?php echo $validation->showError('hostname'); ?></div>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group row required mb-3">
									<label for="input-db-username" class="col-sm-4 control-label small"><?php echo lang('Entry.entry_db_username', array(), $front_locale); ?></label>
									<div class="col-sm-8">
										<input type="text" name="db_username" value="<?php echo $db_username; ?>" id="input-db-username" class="form-control form-control-sm" />
										<div class="text-danger small"><?php echo $validation->showError('db_username'); ?></div>
									</div>
								</div>
								<div class="form-group row mb-3">
									<label for="input-db-password" class="col-sm-4 control-label small"><?php echo lang('Entry.entry_db_password', array(), $front_locale); ?></label>
									<div class="col-sm-8">
										<input type="password" name="db_password" value="<?php echo $db_password; ?>" id="input-db-password" class="form-control form-control-sm" />
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group row required mb-3">
									<label for="input-database" class="col-sm-4 control-label small"><?php echo lang('Entry.entry_database', array(), $front_locale); ?></label>
									<div class="col-sm-8">
										<input type="text" name="database" value="<?php echo $database; ?>" id="input-database" class="form-control form-control-sm" />
										<div class="text-danger small"><?php echo $validation->showError('database'); ?></div>
									</div>
								</div>
								<div class="form-group row mb-3">
									<label for="input-db-prefix" class="col-sm-4 control-label small"><?php echo lang('Entry.entry_db_prefix', array(), $front_locale); ?></label>
									<div class="col-sm-8">
										<input type="text" name="db_prefix" value="<?php echo $db_prefix; ?>" id="input-db-prefix" class="form-control form-control-sm" />
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					<h6 class="border-bottom border-dark text-uppercase mt-3 pb-2"><?php echo lang('Text.text_administrator', array(), $this->front_locale); ?></h6>
					<fieldset class="small">
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group row required mb-3">
									<label for="input-firstname" class="col-sm-4 control-label small"><?php echo lang('Entry.entry_firstname', array(), $front_locale); ?></label>
									<div class="col-sm-8">
										<input type="text" name="firstname" value="<?php echo $firstname; ?>" id="input-firstname" class="form-control form-control-sm" />
										<div class="text-danger small"><?php echo $validation->showError('firstname'); ?></div>
									</div>
								</div>
								<div class="form-group row required mb-3">
									<label for="input-lastname" class="col-sm-4 control-label small"><?php echo lang('Entry.entry_lastname', array(), $front_locale); ?></label>
									<div class="col-sm-8">
										<input type="text" name="lastname" value="<?php echo $lastname; ?>" id="input-lastname" class="form-control form-control-sm" />
										<div class="text-danger small"><?php echo $validation->showError('lastname'); ?></div>
									</div>
								</div>
								<div class="form-group row required mb-3">
									<label for="input-email" class="col-sm-4 control-label small"><?php echo lang('Entry.entry_email', array(), $front_locale); ?></label>
									<div class="col-sm-8">
										<input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control form-control-sm" />
										<div class="text-danger small"><?php echo $validation->showError('email'); ?></div>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group row required mb-3">
									<label for="input-username" class="col-sm-4 control-label small"><?php echo lang('Entry.entry_username', array(), $front_locale); ?></label>
									<div class="col-sm-8">
										<input type="text" name="username" value="<?php echo $username; ?>" id="input-username" class="form-control form-control-sm" />
										<div class="text-danger small"><?php echo $validation->showError('username'); ?></div>
									</div>
								</div>
								<div class="form-group row required mb-3">
									<label for="input-password" class="col-sm-4 control-label small"><?php echo lang('Entry.entry_password', array(), $front_locale); ?></label>
									<div class="col-sm-8">
										<input type="password" name="password" value="<?php echo $password; ?>" id="input-password" class="form-control form-control-sm" />
										<div class="text-danger small"><?php echo $validation->showError('password'); ?></div>
									</div>
								</div>
								<div class="form-group row required mb-3">
									<label for="input-passconf" class="col-sm-4 control-label small"><?php echo lang('Entry.entry_passconf', array(), $front_locale); ?></label>
									<div class="col-sm-8">
										<input type="password" name="passconf" value="<?php echo $passconf; ?>" id="input-passconf" class="form-control form-control-sm" />
										<div class="text-danger small"><?php echo $validation->showError('passconf'); ?></div>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group row required mb-3">
									<label for="input-uri-segment" class="col-sm-4 control-label small"><?php echo lang('Entry.entry_uri_segment', array(), $front_locale); ?></label>
									<div class="col-sm-8">
										<input type="text" name="uri_segment" value="<?php echo $uri_segment; ?>" id="input-uri-segment" class="form-control form-control-sm" />
										<div class="text-danger small"><?php echo $validation->showError('uri_segment'); ?></div>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
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
