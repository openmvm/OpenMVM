	  		<!-- Footer -->
				<section class="footer mt-5">
					<div class="copyright text-center small mb-3"><?php echo sprintf(lang('Text.text_copyright', array(), $lang->getBackEndLocale()), date("Y",now()), $website_name); ?></div>
					<div class="powered text-center small"><?php echo lang('Text.text_powered', array(), $lang->getBackEndLocale()); ?></div>
					<div class="version text-center small"><?php echo $version_name . ' - <span class="text-lowercase">' . sprintf(lang('Text.text_version', array(), $lang->getBackEndLocale()), $version_number) . '</span>'; ?></div>
					<div class="text-muted text-center small mt-3"><?php echo sprintf(lang('Text.text_page_rendered_in_seconds', array(), $lang->getBackEndLocale()), '{elapsed_time}'); ?></div>
				</section>
	  		<!-- /.footer -->
			</div>
			<!-- /.content-wrapper -->
		</div>
  	<!-- /.container-fluid -->
	</body>
</html>
