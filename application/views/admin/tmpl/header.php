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
        <title><?php echo isset($title) ? $title : config_item('project_title') ?></title>
        <base href="<?php echo site_url('admin') ?>/" />

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="MobileOptimized" content="320">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <?php echo Content::link('admin/assets/plugins/font-awesome/css/font-awesome.min.css') ?>
        <?php echo Content::link('admin/assets/plugins/bootstrap/css/bootstrap.min.css') ?>
        <?php echo Content::link('admin/assets/plugins/uniform/css/uniform.default.css') ?>
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME STYLES --> 
        <?php echo Content::link('admin/assets/css/style-metronic.css') ?>
        <?php echo Content::link('admin/assets/css/style.css') ?>
        <?php echo Content::link('admin/assets/css/style-responsive.css') ?>
        <?php echo Content::link('admin/assets/css/plugins.css') ?>
        <?php echo Content::link('admin/assets/css/pages/about-us.css') ?>
        <?php echo Content::link('admin/assets/css/themes/default.css') ?>
        <?php echo Content::link('admin/assets/css/custom.css') ?>
        <!-- END THEME STYLES -->
        <?php echo Content::link('admin/css/main.css') ?>
        <link rel="shortcut icon" href="favicon.ico" />

        <script>
            var site = {name: '<?php echo config_item('project_title') ?>'};
            var path = {
                base: '<?php echo site_url() ?>',
                admin: '<?php echo site_url('admin') ?>/',
                ajax: '<?php echo site_url('admin') ?>/',
                partials: '<?php echo site_url('partials') ?>/'
            };
        </script>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="page-header-fixed">

        <div id="loading-indicator" class="progress progress-striped active">
            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span class="sr-only">100% Complete (warning)</span>
            </div>
        </div>

        <!-- BEGIN HEADER -->   
        <div class="header navbar navbar-inverse navbar-fixed-top">
            <!-- BEGIN TOP NAVIGATION BAR -->
            <div class="header-inner">
                <!-- BEGIN LOGO -->  
                <a class="navbar-brand" href="#/index">
                    Marker
                    <!--<img src="assets/img/logo.png" alt="logo" class="img-responsive" />-->
                </a>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER --> 
                <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <img src="assets/img/menu-toggler.png" alt="" />
                </a> 
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown user" auth-menu></li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END TOP NAVIGATION BAR -->
        </div>
        <!-- END HEADER -->
        <div class="clearfix"></div>
        <!-- BEGIN CONTAINER -->   
        <div auth-check></div>
        <div class="page-container" id="view" ng-view>