<!-- Footer -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo site_url('site/js/vendor/jquery-1.8.1.min.js') ?>"><\/script>')</script>

<?php echo Content::script('site/js/plugins.js') ?>
<?php echo Content::script('site/js/main.js') ?>
<?php if ( strlen(config_item('ga_code')) > 0 ) : ?>
<script>
    var _gaq=[['_setAccount','<?php echo config_item('ga_code') ?>'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<?php endif ?>
</body>
</html>