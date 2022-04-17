<?php if ($languages) { ?>
<li id="language" class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?php foreach ($languages as $language) { ?>
            <?php if ($language['code'] == $current_language_code) { ?>
            <span class="small"><img src="<?php echo base_url() . '/assets/flags/' . $language['code'] . '.png'; ?>" /></span>
            <?php } ?>
        <?php } ?>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <?php foreach ($languages as $language) { ?>
        <li><a class="dropdown-item small" href="javascript:void(0);" onclick="setLanguage('<?php echo $language['code']; ?>');"><img src="<?php echo base_url() . '/assets/flags/' . $language['code'] . '.png'; ?>" class="me-2" /><?php echo $language['name']; ?></a></li>
        <?php } ?>
    </ul>
</li>
<script type="text/javascript"><!--
function setLanguage(code) {
    $.ajax({
        url: '<?php echo $set_language; ?>' + '?code=' + code,
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
