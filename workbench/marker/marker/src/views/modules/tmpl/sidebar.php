<?php if (Auth::IsUserInRole('super')): ?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->        
    <ul class="page-sidebar-menu">
        <li>
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <!--<div class="sidebar-toggler hidden-phone"></div>-->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        </li>
        <li class="start ">
            <a href="#">
                <i class="icon-home"></i> 
                <span class="title">Dashboard</span>
            </a>
        </li>
        <li class="">
            <a href="#/lists">
                <i class="icon-table"></i> 
                <span class="title">Lists</span>
            </a>
        </li>
        <li class="">
            <a href="#/users">
                <i class="icon-user"></i> 
                <span class="title">Users</span>
            </a>
        </li>
        <li class="last ">
            <a href="#/settings">
                <i class="icon-cogs"></i> 
                <span class="title">Settings</span>
            </a>
        </li>
    </ul>
    <!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->
<?php endif ?>