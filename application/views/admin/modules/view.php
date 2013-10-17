<ng-include src="'../partials/tmpl/sidebar.html'"></ng-include>
<div class="page-content">

    <ul class="page-breadcrumb breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="#/index">Dashboard</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <a href="#/modules/<?php echo $module->id ?>/index"><?php echo $module->title ?></a> 
            <i class="icon-angle-right"></i>
        </li>
        <li>{{item.title}}</li>
    </ul>

    <form ng-submit="save()">
        <div class="row-fluid">
            <div class="span12">
                <dl class="dl-horizontal">
                    <dt>Id</dt>
                    <dd>{{item.id}}</dd>
                    <?php foreach ($fields as $field): ?>
                        <dt><?php echo $field->title ?></dt>
                        <dd><?php echo Content::renderViewField($field) ?></dd>
                    <?php endforeach ?>
                </dl>
            </div>
        </div>
        <hr/>
        <p class="pull-right">
            <a href="#/modules/<?php echo $module->id ?>/delete/{{item.id}}" class="btn btn-danger">Delete</a>
            <a href="#/modules/<?php echo $module->id ?>/edit/{{item.id}}" class="btn btn-primary">Edit</a>
            <a class="btn" href="#/modules/<?php echo $module->id ?>/index">Back</a>
        </p>
    </form>
</div>