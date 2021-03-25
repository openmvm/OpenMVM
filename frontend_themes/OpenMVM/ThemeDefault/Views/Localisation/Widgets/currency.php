<?php echo form_open_multipart($action, 'id="form-currency"'); ?>
<div class="dropdown">
  <a class="link-light text-decoration-none dropdown-toggle" type="button" id="dropdownMenuWidgetLanguage" data-bs-toggle="dropdown" aria-expanded="false">
  	<?php foreach ($currencies as $currency) { ?>
  		<?php if (!empty($currency['symbol_left']) && $currency['code'] == $frontend_currency) { ?>
			<strong><?php echo $currency['symbol_left']; ?></strong>
			<?php } elseif (!empty($currency['symbol_right']) && $currency['code'] == $frontend_currency) { ?>
			<strong><?php echo $currency['symbol_right']; ?></strong>
  		<?php } ?>
  	<?php } ?>
  	<?php echo lang('Text.text_currency', array(), $lang->getFrontEndLocale()); ?>
	</a>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuWidgetLanguage">
  	<?php foreach ($currencies as $currency) { ?>
    <li><button class="dropdown-item small" type="button" name="<?php echo $currency['code']; ?>"><?php if (!empty($currency['symbol_left'])) { ?><?php echo $currency['symbol_left']; ?><?php } else { ?><?php echo $currency['symbol_right']; ?><?php } ?> <?php echo $currency['title']; ?></button></li>
  	<?php } ?>
  </ul>
</div>
<input type="hidden" name="frontend_currency" value="" />
<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
<?php echo form_close(); ?>