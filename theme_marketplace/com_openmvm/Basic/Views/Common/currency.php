<?php if ($currencies) { ?>
<li id="currency" class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?php foreach ($currencies as $currency) { ?>
            <?php if ($currency['code'] == $current_currency_code) { ?>
            <span class="small"><?php if (!empty($currency['symbol_left'])) { ?><?php echo $currency['symbol_left']; ?><?php } else { ?><?php echo $currency['symbol_right']; ?><?php } ?></span>
            <?php } ?>
        <?php } ?>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <?php foreach ($currencies as $currency) { ?>
        <li><a class="dropdown-item small" href="javascript:void(0);" onclick="setCurrency('<?php echo $currency['code']; ?>');"><?php echo $currency['symbol_left']; ?> <?php echo $currency['name']; ?> <?php echo $currency['symbol_right']; ?></a></li>
        <?php } ?>
    </ul>
</li>
<script type="text/javascript"><!--
function setCurrency(code) {
    $.ajax({
        url: '<?php echo $set_currency; ?>' + '?code=' + code,
        dataType: 'json',
        beforeSend: function() {
            // ...
        },
        complete: function() {
            // ...
        },
        success: function(json) {
            // alert(code);
            // Redirect to current url
            var url = $(location).attr('href');

            location = url;
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
//--></script> 
<?php } ?>
