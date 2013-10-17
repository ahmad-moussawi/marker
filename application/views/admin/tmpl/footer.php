   </div>
   <!-- END CONTAINER -->
   <!-- BEGIN FOOTER -->
   <div class="footer">
      <div class="footer-inner">
         2013 &copy; Metronic by keenthemes.
      </div>
      <div class="footer-tools">
         <span class="go-top">
         <i class="icon-angle-up"></i>
         </span>
      </div>
   </div>
   <!-- END FOOTER -->
   <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
   <!-- BEGIN CORE PLUGINS -->   
   <!--[if lt IE 9]>
   <script src="assets/plugins/respond.min.js"></script>
   <script src="assets/plugins/excanvas.min.js"></script> 
   <![endif]-->
   
   
   <!-- MARKER -->
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>-->
        <script>window.jQuery || document.write('<script src="<?php echo site_url('assets/admin/js/vendor/jquery-1.8.1.min.js') ?>"><\/script>')</script>
        <?php //echo Content::script('admin/js/jquery.validation.min.js') ?>
        <?php echo Content::script('admin/js/vendor/ckeditor/ckeditor.js') ?>
        <?php echo Content::script('admin/js/vendor/ace/ace.js') ?>
        <?php echo Content::script('admin/js/vendor/bootstrap.min.js') ?>
        <?php //echo Content::script('admin/js/plugins.js') ?>
        <?php //echo Content::script('admin/js/main.js') ?>
        <?php echo Content::script('admin/js/angular/angular.js') ?>
        <?php echo Content::script('admin/js/angular/angular-sanitize.js') ?>
        <?php echo Content::script('admin/js/angular/angular-route.js') ?>
        
        
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
        
        <!-- spectrum -->
         <?php echo Content::script('admin/js/spectrum/spectrum.js') ?>

        <!-- Barcode -->
        <?php echo Content::script('admin/js/barcode/jquery-barcode.min.js') ?>
        
        <?php echo Content::script('admin/js/angular/ng-loadingindicator.js') ?>
        <?php echo Content::script('admin/js/angular/ng-table.js') ?>
        
        <?php echo Content::script('app/app.js' ,'/') ?>
        <?php echo Content::script('app/controllers.js' ,'/') ?>
        <?php echo Content::script('app/directives.js', '/') ?>
        <?php echo Content::script('app/filters.js', '/') ?>
        <?php echo Content::script('app/services.js', '/') ?>
        
        
   <!-- //MARKER -->
   
   <?php echo Content::script('admin/assets/plugins/jquery-1.10.2.min.js') ?>
   <?php echo Content::script('admin/assets/plugins/jquery-migrate-1.2.1.min.js') ?>
   <?php echo Content::script('admin/assets/plugins/bootstrap/js/bootstrap.min.js') ?>
   <?php echo Content::script('admin/assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') ?>
   <?php echo Content::script('admin/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') ?>
   <?php echo Content::script('admin/assets/plugins/jquery.blockui.min.js') ?>
   <?php echo Content::script('admin/assets/plugins/jquery.cookie.min.js') ?>
   <?php echo Content::script('admin/assets/plugins/uniform/jquery.uniform.min.js') ?>
   
   
   <!--<script src="assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>-->
   <!--<script src="assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>-->     
   <!--<script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>-->
   <!--<script src="assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>-->
   <!--<script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>-->
   <!--<script src="assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>-->  
   <!--<script src="assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>-->
   <!--<script src="assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>-->
   <!-- END CORE PLUGINS -->
   <!--<script src="assets/scripts/app.js"></script>-->  
      <?php echo Content::script('admin/assets/scripts/app.js') ?>
   <script>
      jQuery(document).ready(function() {    
         App.init();
      });
   </script>
   <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>