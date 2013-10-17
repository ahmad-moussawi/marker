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
        <li>{{item.title}} <small class="muted">(Edit)</small></li>
    </ul>


    <div class="alert alert-success" ng-show="saved">
        <strong>Item saved</strong>
    </div>

    <form role="form" ng-submit="save()">
        <div class="form-body">

            <?php foreach ($fields as $field): ?>
                <?php if ($field->type < 5 && $field->type != '1.3') : ?>
                    <div class="form-group">
                        <label for="field_<?php echo $field->id ?>"><?php echo $field->title ?></label>
                        <?php echo Content::renderEditField($field) ?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>

            <?php foreach ($fields as $field): ?>
                <?php if ($field->type > 5 || $field->type == '1.3') : ?>
                    <dt><?php echo $field->title ?></dt>
                    <dd>
                        <?php echo Content::renderEditField($field) ?>
                    </dd>
                <?php endif ?>
            <?php endforeach ?>
        </div>

        <!--<pre>{{item}}</pre>-->
        <hr/>
        <p class="pull-right">
            <button ng-disabled="working" type="submit" class="btn btn-primary">Save</button>
            <a ng-disabled="working" class="btn" href="#/modules/<?php echo $module->id ?>/index">Back</a>
        </p>
    </form>

</div>