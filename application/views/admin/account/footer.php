    </div>
    <!-- END LOGIN -->
    <!-- BEGIN COPYRIGHT -->
    <div class="copyright">
        <?php echo config_item('project_copyright') ?>
    </div>
    <!-- END COPYRIGHT -->

    <!-- Marker -->
        <?php echo Content::script('admin/js/angular/angular.js') ?>
        <?php echo Content::script('app/account.js' ,'/') ?>
        <?php echo Content::script('app/services.js' ,'/') ?>
    <!-- Marker -->
</body>
<!-- END BODY -->
</html>