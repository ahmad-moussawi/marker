<!-- Footer -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo site_url('site/js/vendor/jquery-1.8.1.min.js') ?>"><\/script>')</script>

<!-- Upload -->
<?php echo Content::script('site/js/fileupload/vendor/jquery.ui.widget.js') ?>
<?php echo Content::script('site/js/fileupload/vendor/jquery.iframe-transport.js') ?>
<?php echo Content::script('site/js/fileupload/vendor/jquery.fileupload.js') ?>
<?php echo Content::script('site/js/fileupload/jquery.fileupload-process.js') ?>
<?php echo Content::script('site/js/fileupload/jquery.fileupload-image.js') ?>
<?php echo Content::script('site/js/fileupload/jquery.fileupload-audio.js') ?>
<?php echo Content::script('site/js/fileupload/jquery.fileupload-video.js') ?>
<?php echo Content::script('site/js/fileupload/jquery.fileupload-validate.js') ?>
<?php echo Content::script('site/js/fileupload/jquery.fileupload-angular.js') ?>

<!-- -->
<?php // echo Content::script('site/js/plugins.js') ?>
<?php // echo Content::script('site/js/main.js') ?>
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