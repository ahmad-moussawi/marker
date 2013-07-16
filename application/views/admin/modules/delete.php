<ul class="breadcrumb">
    <li><a href="#/">Home</a> <span class="divider">/</span></li>
    <li><a href="#/modules/<?php echo $module->id ?>/index"><?php echo $module->title ?></a> <span class="divider">/</span></li>
    <li class="active">{{item.title}}</li>
</ul>

<div class="alert alert-danger">
    <strong>Delete <?php echo $term ?></strong> Are you sure you want to delete this <?php echo $term ?> ?
</div>

<form ng-submit="save()">
    <div class="row-fluid">
        <div class="span5">
            <dl class="dl-horizontal">
                <?php foreach ($fields as $field):?>
                <dt><?php echo $field->title ?></dt>
                <dd>{{item.<?php echo $field->internaltitle ?>}}</dd>
                <?php endforeach ?>
            </dl>
        </div>
    </div>
    <hr/>

    <p class="pull-right">
        <a ng-click="delete()" class="btn btn-danger">Delete</a>
        <a class="btn" href="#/modules/<?php echo $module->id ?>/index">Back</a>
    </p>
</form>