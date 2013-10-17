    </div>
    <!-- END LOGIN -->
    <!-- BEGIN COPYRIGHT -->
    <div class="copyright">
        <?php echo date('Y') ?> &copy; Marker CMS.
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