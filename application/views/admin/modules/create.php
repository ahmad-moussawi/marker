<ng-include src="'../partials/tmpl/sidebar.html'"></ng-include>
<div class="page-content <?php echo $list->attrs->cssClass ?>">

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
            <a href="#/index"><?php echo $list->title ?></a> 
            <i class="icon-angle-right"></i>
        </li>
        <li>New</li>
    </ul>

    <div class="alert alert-warning" ng-show="working">
        Working ... 
    </div>

    <div class="alert alert-success" ng-show="saved">
        <strong>Item saved</strong>
    </div>

    <form name="form" ng-submit="save()">
       <div class="form-body">

            <?php foreach ($list->published_fields as $field): ?>
                <?php if ($field->typeref < 5 && $field->typeref != '1.3') : ?>
                    <div class="form-group">
                        <label for="field_<?php echo $field->id ?>"><?php echo $field->title ?></label>
                        <?php echo Content::renderEditField($field, TRUE) ?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>

            <?php foreach ($list->published_fields as $field): ?>
                <?php if ($field->typeref > 5 || $field->typeref == '1.3') : ?>
                     <div class="form-group">
                        <label for="field_<?php echo $field->id ?>"><?php echo $field->title ?></label>
                        <?php echo Content::renderEditField($field, TRUE) ?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
        <p class="pull-right">
            <button ng-disabled="working || !form.$valid" type="submit" class="btn btn-primary">Save</button>
            <a ng-disabled="working" class="btn" href="#/modules/<?php echo $list->id ?>/index">Back</a>
        </p>
    </form>
</div>