<?php echo form_open_multipart($action, 'id="form-language"'); ?>
<div class="dropdown">
  <a class="link-light text-decoration-none dropdown-toggle" type="button" id="dropdownMenuWidgetLanguage" data-bs-toggle="dropdown" aria-expanded="false">
  	<?php foreach ($languages as $language) { ?>
  		<?php if ($language['code'] == $frontend_language) { ?>
			<img src="<?php echo base_url('/assets/flags/' . $language['image']); ?>" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>" />
  		<?php } ?>
  	<?php } ?>
  	<?php echo lang('Text.text_language', array(), $lang->getFrontEndLocale()); ?>
	</a>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuWidgetLanguage">
  	<?php foreach ($languages as $language) { ?>
    <li><button class="dropdown-item small" type="button" name="<?php echo $language['code']; ?>"><img src="<?php echo base_url('/assets/flags/' . $language['image']); ?>" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></button></li>
  	<?php } ?>
  </ul>
</div>
<input type="hidden" name="frontend_language" value="" />
<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
<?php echo form_close(); ?>