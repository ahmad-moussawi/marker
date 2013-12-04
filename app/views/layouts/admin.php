<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.0
Version: 1.5
Author: KeenThemes
Website: http://www.keenthemes.com/
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
-->
<!--[if IE 8]> <html ng-app="myApp" lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html ng-app="myApp" lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html ng-app="myApp" lang="en" class="no-js"> <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title><?php echo isset($title) ? $title : Config::get('marker.project_title') ?></title>
        <base href="<?php echo URL::to('admin') ?>" />

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="MobileOptimized" content="320">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <?php echo HTML::style('assets/admin/js/spectrum/spectrum.css') ?>

        <?php echo HTML::style('assets/admin/assets/plugins/font-awesome/css/font-awesome.min.css') ?>
        <?php echo HTML::style('assets/admin/assets/plugins/bootstrap/css/bootstrap.min.css') ?>
        <?php echo HTML::style('assets/admin/assets/plugins/uniform/css/uniform.default.css') ?>

        <?php echo HTML::style('assets/admin/assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.css') ?>
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME STYLES --> 
        <?php echo HTML::style('assets/admin/assets/css/style-metronic.css') ?>
        <?php echo HTML::style('assets/admin/assets/css/style.css') ?>
        <?php echo HTML::style('assets/admin/assets/css/style-responsive.css') ?>
        <?php echo HTML::style('assets/admin/assets/css/plugins.css') ?>
        <?php echo HTML::style('assets/admin/assets/css/pages/about-us.css') ?>
        <?php echo HTML::style('assets/admin/assets/css/themes/default.css') ?>
        <?php echo HTML::style('assets/admin/assets/css/pages/login.css') ?>
        <?php echo HTML::style('assets/admin/assets/css/custom.css') ?>
        <!-- END THEME STYLES -->

        <?php echo HTML::style('assets/admin/css/colorbox.css') ?> 
        <?php echo HTML::style('assets/admin/css/main.css') ?>
        <link rel="shortcut icon" href="favicon.ico" />

        <script>
            var site = {name: '<?php echo Config::get('marker.project_title') ?>'};
            var path = {
                base: '<?php echo URL::to('/') ?>/',
                admin: '<?php echo URL::to('admin') ?>/',
                api: '<?php echo URL::to('/api') ?>/',
                partials: '<?php echo URL::to('partials') ?>/'
            };
        </script>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="page-header-fixed <?php // echo Auth::IsUserInRole('super') ? '' : 'page-sidebar-closed'     ?>">

        <div id="loading-indicator" class="progress progress-striped active">
            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span class="sr-only">100% Complete (warning)</span>
            </div>
        </div>

        <?php if (Auth::check()): ?>
            <!-- BEGIN HEADER -->   
            <div class="header navbar navbar-inverse navbar-fixed-top">
                <!-- BEGIN TOP NAVIGATION BAR -->
                <div class="header-inner">
                    <!-- BEGIN LOGO -->  
                    <a class="navbar-brand" href="#/">
                        <?php echo Config::get('marker.project_title') ?>
                        <!--<img src="assets/img/logo.png" alt="logo" class="img-responsive" />-->
                    </a>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER --> 
                    <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <img src="<?php echo URL::asset('assets/admin/assets/img/menu-toggler.png') ?>" alt="" />
                    </a> 
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <li class="dropdown user" >
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <span class="username" marker-auth-username></span>
                                <i class="icon-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#account/changepwd"><i class="icon-lock"></i> Change Password</a>
                                <li>
                                    <a href="#account/logout"><i class="icon-key"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END TOP NAVIGATION BAR -->
            </div>
            <!-- END HEADER -->
        <?php endif ?>
        <div class="clearfix"></div>
        <!-- BEGIN CONTAINER -->  
        <?php if (Auth::check()): ?>
            <div auth-check></div>
        <?php endif ?>
        <div class="page-container" id="view" ng-view>

            <?php echo $content ?>

        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="footer">
            <div class="footer-inner">
                <div class="copyright">
                    <?php echo Config::get('marker.project_copyright') ?>
                </div>
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
             <!--<script>window.jQuery || document.write('<script src="<?php echo URL::asset('assets/admin/js/vendor/jquery-1.8.1.min.js') ?>"><\/script>')</script>-->
        <?php //echo HTML::script('assets/admin/js/jquery.validation.min.js') ?>

        <?php echo HTML::script('assets/admin/assets/plugins/jquery-1.10.2.min.js') ?>
        <?php echo HTML::script('assets/admin/assets/plugins/jquery-migrate-1.2.1.min.js') ?>
        <?php echo HTML::script('assets/admin/assets/plugins/bootstrap/js/bootstrap.min.js') ?>

        <?php echo HTML::script('assets/admin/js/vendor/ckeditor/ckeditor.js') ?>
        <?php echo HTML::script('assets/admin/js/vendor/ace/ace.js') ?>
        <?php echo HTML::script('assets/admin/js/vendor/bootstrap.min.js') ?>

        <?php echo HTML::script('assets/admin/js/angular-file-upload/angular-file-upload-shim.min.js') ?>
        <?php echo HTML::script('assets/admin/js/angular/angular.min.js') ?>
        <?php echo HTML::script('assets/admin/js/angular/angular-sanitize.min.js') ?>
        <?php echo HTML::script('assets/admin/js/angular/angular-route.min.js') ?>
        <?php echo HTML::script('assets/admin/js/angular/angular-resource.min.js') ?>
        <?php echo HTML::script('assets/admin/assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') ?>



        <?php if (false): ?>
            <!-- Upload -->
            <?php //echo HTML::script('assets/admin/js/fileupload/vendor/jquery.ui.widget.js') ?>
            <?php echo HTML::script('assets/admin/js/fileupload/load-image.min.js') ?>
            <?php echo HTML::script('assets/admin/js/fileupload/canvas-to-blob.min.js') ?>
            <?php echo HTML::script('assets/admin/js/fileupload/jquery.iframe-transport.js') ?>
            <?php echo HTML::script('assets/admin/js/fileupload/jquery.fileupload.js') ?>
            <?php echo HTML::script('assets/admin/js/fileupload/jquery.fileupload-process.js') ?>
            <?php echo HTML::script('assets/admin/js/fileupload/jquery.fileupload-image.js') ?>
            <?php echo HTML::script('assets/admin/js/fileupload/jquery.fileupload-audio.js') ?>
            <?php echo HTML::script('assets/admin/js/fileupload/jquery.fileupload-video.js') ?>
            <?php echo HTML::script('assets/admin/js/fileupload/jquery.fileupload-validate.js') ?>
            <?php //echo HTML::script('assets/admin/js/fileupload/jquery.fileupload-angular.js') ?>
            <!-- -->
        <?php endif ?>


        <?php echo HTML::script('assets/admin/js/angular-file-upload/angular-file-upload.min.js') ?>

        <!-- spectrum -->
        <?php echo HTML::script('assets/admin/js/spectrum/spectrum.js') ?>
        <!-- Barcode -->
        <?php echo HTML::script('assets/admin/js/barcode/jquery-barcode.min.js') ?>
        <?php echo HTML::script('assets/admin/js/jquery.elevateZoom-3.0.3.min.js') ?>
        <?php echo HTML::script('assets/admin/js/jquery.colorbox-min.js') ?>

        <?php echo HTML::script('assets/admin/js/angular/angular-webstorage.js') ?>
        <?php echo HTML::script('assets/admin/js/angular/ng-loadingindicator.js') ?>
        <?php echo HTML::script('assets/admin/js/angular/ng-table.js') ?>

        <?php echo HTML::script('app/app.js') ?>
        <?php echo HTML::script('app/controllers.js') ?>
        <?php echo HTML::script('app/account.js') ?>
        <?php echo HTML::script('app/directives.js') ?>
        <?php echo HTML::script('app/filters.js') ?>
        <?php echo HTML::script('app/services.js') ?>
        <?php echo HTML::script('app/modules/marker.modules.js') ?>
        <?php echo HTML::script('app/modules/marker.entities.js') ?>
        <?php echo HTML::script('app/modules/marker.validation.js') ?>


        <!-- //MARKER -->

        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>