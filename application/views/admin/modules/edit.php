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
            <a href="#/modules/<?php echo $list->id ?>/index"><?php echo $list->title ?></a> 
            <i class="icon-angle-right"></i>
        </li>
        <li>Item <small class="muted">(Edit)</small></li>
    </ul>


    <div class="alert alert-success" ng-show="saved">
        <strong>Item saved</strong>
    </div>

    <form role="form" ng-submit="save()">
        <div class="form-body">

            <?php foreach ($list->published_fields as $field): ?>
                <?php if ($field->typeref < 5 && $field->typeref != '1.3') : ?>
                    <div class="form-group">
                        <label for="field_<?php echo $field->id ?>"><?php echo $field->title ?></label>
                        <?php echo Content::renderEditField($field) ?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>

            <?php foreach ($list->published_fields as $field): ?>
                <?php if ($field->typeref > 5 || $field->typeref == '1.3') : ?>
                     <div class="form-group">
                        <label for="field_<?php echo $field->id ?>"><?php echo $field->title ?></label>
                        <?php echo Content::renderEditField($field) ?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
        <p class="pull-right">
            <button ng-disabled="working" type="submit" class="btn btn-primary">Save</button>
            <a ng-disabled="working" class="btn" href="#/modules/<?php echo $list->id ?>/view/{{item.<?php echo $list->identity ?>}}">Back</a>
        </p>
    </form>

</div>