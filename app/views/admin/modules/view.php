<?php
/*
 * @var $list Entity 
 * @var $fields EntityField[]
 */
?>
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
        <li>Item <small class="muted">(View)</small></li>
    </ul>

    <form ng-submit="save()">
        <div class="row-fluid">
            <div class="span12">
                <dl class="dl-horizontal">
                    <dt>Id</dt>
                    <dd>{{item.<?php echo $entity->identity ?>}}</dd>
                    <?php foreach ($entity->fields as $field): /* @var $field EntityField */ ?>
                        <dt><?php echo $field->title ?></dt>
                        <dd><?php echo $field->RenderView() ?></dd>
                    <?php endforeach ?>
                </dl>
            </div>
        </div>
        <hr/>
        <p class="pull-right">

            <?php if ($entity->attr('view_edit')): ?>
                <a class="btn btn-primary" href="#/m/<?php echo $entity->id ?>/edit/{{item.<?php echo $entity->identity ?>}}" >Edit</a>
            <?php endif ?>
            <?php if ($entity->attr('view_delete')): ?>
                <a class="btn btn-danger" href="#/m/<?php echo $entity->id ?>/delete/{{item.<?php echo $entity->identity ?>}}" >Delete</a>
            <?php endif ?>
            <a class="btn" href="#/m/<?php echo $entity->id ?>">Back</a>
        </p>
    </form>
    <?php if (Config::get('marker.debug')): ?>
        <pre>{{item}}</pre>
    <?php endif ?>
</div>