<ng-include src="'api/partials/static/sidebar'"></ng-include>
<div class="page-content <?php echo $entity->attr('cssClass') ?>">

    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title"><?php echo $entity->title ?></h3>
        </div>
    </div>


    <ul class="page-breadcrumb breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="#">Dashboard</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <a href="#/m/<?php echo $entity->id ?>"><?php echo $entity->title ?></a>  
            <i class="icon-angle-right"></i>
        </li>
        <li>Item <small class="muted">(New)</small></li>
    </ul>

    <div class="ng-cloak">
        <div class="alert alert-warning" ng-show="working">
            Working ... 
        </div>

        <div class="alert alert-success" ng-show="saved">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Item saved</strong>
        </div>

        <div class="alert alert-danger alert-dismissable" ng-show="errors.length">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Oops!</strong>
            <ul>
                <li ng-repeat="error in errors">{{error}}</li>
            </ul>
        </div>
    </div>


    <form name="form" ng-submit="save()">
        <div class="form-body">

            <?php foreach ($entity->fields as $field): /* @var $field EntityField */ ?>
                <?php echo $field->RenderEdit(TRUE) ?>
            <?php endforeach ?>
           
        </div>
        <p class="pull-right">
            <button ng-disabled="working || !form.$valid" type="submit" class="btn btn-primary">Save</button>
            <a ng-disabled="working" class="btn" href="#/m/<?php echo $entity->id ?>">Back</a>
        </p>
    </form>
    <?php if (Config::get('marker.debug')): ?>
        <pre>{{item}}</pre>
    <?php endif ?>
</div>