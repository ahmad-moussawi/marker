<ul class="breadcrumb">
    <li><a href="#/">Home</a> <span class="divider">/</span></li>
    <li><a href="#/modules/<?php echo $module->id ?>/index"><?php echo $module->title ?></a> <span class="divider">/</span></li>
    <li class="active">{{item.title}}</li>
</ul>

<form ng-submit="save()">
    <div class="row-fluid">
        <div class="span12">
            <dl class="dl-horizontal">
                <dt>Id</dt>
                <dd>{{item.id}}</dd>
                <?php foreach ($fields as $field):?>
                <dt><?php echo $field->title ?></dt>
                <dd><?php echo Content::renderViewField($field) ?></dd>
                <?php endforeach ?>
            </dl>
        </div>
    </div>
    <hr/>

    <p class="pull-right">
        <a href="#/modules/<?php echo $module->id ?>/edit/{{item.id}}" class="btn btn-primary">Edit</a>
        <a class="btn" href="#/modules/<?php echo $module->id ?>/index">Back</a>
    </p>
</form>