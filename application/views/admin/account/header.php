<!DOCTYPE html>
<!--[if lt IE 7]>      <html ng-app="myApp" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html ng-app="myApp" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html ng-app="myApp" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html ng-app="myApp" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo isset($title) ? $title : config_item('project_title') ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <base href="<?php echo site_url('admin') ?>/" />
        <?php echo Content::link('admin/css/bootstrap.css') ?>
        <?php echo Content::link('admin/css/bootstrap-responsive.css') ?>
        <?php echo Content::link('admin/css/main.css') ?>
        <script>
            var site = {name: '<?php echo config_item('project_title') ?>'};
            var path = {
                base: '<?php echo site_url() ?>',
                admin: '<?php echo site_url('admin') ?>/',
                ajax: '<?php echo site_url('admin') ?>/',
                partials : '<?php echo site_url('partials') ?>/'
            };
        </script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->
        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->
            <div class = "container">