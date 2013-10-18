<ng-include src="'../partials/tmpl/sidebar.html'"></ng-include>
<div class="page-content">
    
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title"><?php echo $list->title ?></h3>
        </div>
    </div>
    
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="#/index">Dashboard</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <a href="#/modules/<?php echo $list->id ?>/index"><?php echo $list->title ?></a> 
            <i class="icon-angle-right"></i>
        </li>
        <li>{{item.title}}</li>
    </ul>

    <form ng-submit="save()">
        <div class="row-fluid">
            <div class="span12">
                <dl class="dl-horizontal">
                    <dt>Id</dt>
                    <dd>{{item.<?php echo $list->identity ?>}}</dd>
                    <?php foreach ($list->fields as $field): ?>
                        <dt><?php echo $field->title ?></dt>
                        <dd><?php echo Content::renderViewField($field) ?></dd>
                    <?php endforeach ?>
                </dl>
            </div>
        </div>
        <hr/>
        <p class="pull-right">
            <a href="#/modules/<?php echo $list->id ?>/delete/{{item.<?php echo $list->identity ?>}}" class="btn btn-danger">Delete</a>
            <a href="#/modules/<?php echo $list->id ?>/edit/{{item.<?php echo $list->identity ?>}}" class="btn btn-primary">Edit</a>
            <a class="btn" href="#/modules/<?php echo $list->id ?>/index">Back</a>
        </p>
    </form>
</div>