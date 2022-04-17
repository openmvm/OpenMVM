    <div class="footer"></div>
    <div class="copyright text-center mb-1"><?php echo $copyright; ?></div>
    <div class="version text-muted text-center small mb-3"><?php echo sprintf(lang('Common.app_version'), $_SERVER['app.VERSION']); ?> ( <?php echo sprintf(lang('Common.framework_version'), CodeIgniter\CodeIgniter::CI_VERSION); ?> )</div>
    <div class="rendered text-muted text-center small mb-3"><?php echo $rendered; ?></div>
</body>
</html>