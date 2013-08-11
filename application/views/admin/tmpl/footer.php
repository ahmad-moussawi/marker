        </div> <!-- /container -->

        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>-->
        <script>window.jQuery || document.write('<script src="<?php echo site_url('assets/admin/js/vendor/jquery-1.8.1.min.js') ?>"><\/script>')</script>
        <?php //echo Content::script('admin/js/jquery.validation.min.js') ?>
        <?php echo Content::script('admin/js/vendor/ckeditor/ckeditor.js') ?>
        <?php echo Content::script('admin/js/vendor/ace/ace.js') ?>
        <?php echo Content::script('admin/js/vendor/bootstrap.min.js') ?>
        <?php //echo Content::script('admin/js/plugins.js') ?>
        <?php //echo Content::script('admin/js/main.js') ?>
        <?php echo Content::script('admin/js/angular.js') ?>
        <?php echo Content::script('admin/js/angular-sanitize.js') ?>
        
        
        <!-- Upload -->
        <?php echo Content::script('admin/js/fileupload/vendor/jquery.ui.widget.js') ?>
        <?php echo Content::script('admin/js/fileupload/load-image.min.js') ?>
        <?php echo Content::script('admin/js/fileupload/canvas-to-blob.min.js') ?>
        <?php echo Content::script('admin/js/fileupload/jquery.iframe-transport.js') ?>
        <?php echo Content::script('admin/js/fileupload/jquery.fileupload.js') ?>
        <?php echo Content::script('admin/js/fileupload/jquery.fileupload-process.js') ?>
        <?php echo Content::script('admin/js/fileupload/jquery.fileupload-image.js') ?>
        <?php echo Content::script('admin/js/fileupload/jquery.fileupload-audio.js') ?>
        <?php echo Content::script('admin/js/fileupload/jquery.fileupload-video.js') ?>
        <?php echo Content::script('admin/js/fileupload/jquery.fileupload-validate.js') ?>
        <?php //echo Content::script('admin/js/fileupload/jquery.fileupload-angular.js') ?>
        <!-- -->
        
        
        <?php echo Content::script('app/app.js' ,'/') ?>
        <?php echo Content::script('app/controllers.js' ,'/') ?>
        <?php echo Content::script('app/directives.js', '/') ?>
        <?php echo Content::script('app/filters.js', '/') ?>
        <?php echo Content::script('app/services.js', '/') ?>
    </body>
</html>
