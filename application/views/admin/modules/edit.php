<ul class="breadcrumb">
    <li><a href="#/">Home</a> <span class="divider">/</span></li>
    <li><a href="#/modules/<?php echo $module->id ?>/index"><?php echo $module->title ?></a> <span class="divider">/</span></li>
    <li class="active">{{item.title}}</li>
</ul>

<div class="alert alert-warning" ng-show="working">
    Working ... 
</div>

<div class="alert alert-success" ng-show="saved">
    <strong>List saved</strong>
</div>

<form ng-submit="save()">
    <div class="row-fluid">
        <div class="span5">
            <dl class="dl-horizontal">
                <?php foreach ($fields as $field): ?>
                    <?php if ($field->type < 5) : ?>
                        <dt><?php echo $field->title ?></dt>
                        <dd>
                            <?php echo Content::renderEditField($field) ?>
                        </dd>
                    <?php endif ?>
                <?php endforeach ?>
            </dl>
        </div>
        <div class="span7">
            <dl class="dl-horizontal">
                <?php foreach ($fields as $field): ?>
                    <?php if ($field->type > 5) : ?>
                        <dt><?php echo $field->title ?></dt>
                        <dd>
                            <?php echo Content::renderEditField($field) ?>
                        </dd>
                    <?php endif ?>
                <?php endforeach ?>
            </dl>
        </div>
    </div>
    <hr/>

    <p class="pull-right">
        <button ng-disabled="working" type="submit" class="btn btn-primary">Save</button>
        <a ng-disabled="working" class="btn" href="#/modules/<?php echo $module->id ?>/index">Back</a>
    </p>
</form>