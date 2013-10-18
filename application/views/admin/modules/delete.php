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
        <li>{{item.title}} <small class="muted">(Delete)</small></li>
    </ul>

    <div class="alert alert-danger">
        <strong>Delete Item</strong> Are you sure you want to delete this item ?
    </div>

    <form ng-submit="save()">
        <div class="row-fluid">
            <div class="span5">
                <dl class="dl-horizontal">
                    <?php foreach ($list->fields as $field): ?>
                        <dt><?php echo $field->title ?></dt>
                        <dd><?php echo Content::renderViewField($field) ?></dd>
                    <?php endforeach ?>
                </dl>
            </div>
        </div>
        <hr/>

        <p class="pull-right">
            <a ng-click="remove()" class="btn btn-danger">Delete</a>
            <a class="btn" href="#/modules/<?php echo $list->id ?>/index">Back</a>
        </p>
    </form>
</div>