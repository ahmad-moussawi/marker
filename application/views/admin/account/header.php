<!DOCTYPE html>
<!--[if IE 8]> <html ng-app="myApp" lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html ng-app="myApp" lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html ng-app="myApp" lang="en" class="no-js"> <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <base href="<?php echo site_url() ?>/" />
        <title><?php echo isset($title) ? $title : config_item('project_title') ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="MobileOptimized" content="320">
        <!-- BEGIN GLOBAL MANDATORY STYLES --> 
        <?php echo Content::link('admin/assets/plugins/font-awesome/css/font-awesome.min.css') ?>
        <?php echo Content::link('admin/assets/plugins/bootstrap/css/bootstrap.min.css') ?>
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME STYLES --> 
        <?php echo Content::link('admin/assets/css/style-metronic.css') ?>
        <?php echo Content::link('admin/assets/css/style.css') ?>
        <?php echo Content::link('admin/assets/css/style-responsive.css') ?>
        <?php echo Content::link('admin/assets/css/pages/login.css') ?>
        <!-- END THEME STYLES -->
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
        <style>
            [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak, .ng-hide {
                display: none !important;
            }
        </style>
    </head>
    <!-- BEGIN BODY -->
    <body class="login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <h1><?php echo config_item('project_title') ?></h1><!--<img src="assets/img/logo-big.png" alt="" />--> 
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">