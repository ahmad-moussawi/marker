<ng-include src="'../admin/modules/getView/sidebar'"></ng-include>
<div class="page-content <?php echo $list->attr('cssClass') ?>">


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
        <li>Item <small class="muted">(Edit)</small></li>
    </ul>

    <div class="ng-cloak">
        <div class="alert alert-warning" ng-show="working">
            Working ... 
        </div>

        <div class="alert alert-success" ng-show="saved">
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

    <form name="form" role="form" ng-submit="save()">
        <div class="form-body">

            <?php foreach ($fields as $field): /* @var $field EntityField */?>
                <?php echo $field->RenderEdit() ?>
            <?php endforeach ?>

        </div>
        <p class="pull-right">
            <button ng-disabled="working" type="submit" class="btn btn-primary">Save</button>
            <a ng-disabled="working" class="btn" href="#/modules/<?php echo $list->id ?>/view/{{item.<?php echo $list->getIdentity() ?>}}">Back</a>
        </p>
    </form>

</div>