		<!-- Footer -->
		<section class="container-fluid footer bg-light mt-5">
			<div class="copyright text-center small"><?php echo sprintf(lang('Text.text_copyright', array(), $lang->getFrontEndLocale()), date("Y",now()), $website_name); ?></div>
			<div class="powered text-center small"><?php echo lang('Text.text_powered', array(), $lang->getFrontEndLocale()); ?></div>
			<div class="text-muted text-center small mt-3"><?php echo sprintf(lang('Text.text_page_rendered_in_seconds', array(), $lang->getFrontEndLocale()), '{elapsed_time}'); ?></div>
		</section>
		<!-- /.footer -->
	</body>
</html>
