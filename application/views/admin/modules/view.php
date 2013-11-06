<?php
/*
 * @var $list Entity 
 * @var $fields EntityField[]
 */
?>
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
        <li>Item <small class="muted">(View)</small></li>
    </ul>

    <form ng-submit="save()">
        <div class="row-fluid">
            <div class="span12">
                <dl class="dl-horizontal">
                    <dt>Id</dt>
                    <dd>{{item.<?php echo $list->getIdentity() ?>}}</dd>
                    <?php foreach ($fields as $field): /* @var $field EntityField */?>
                        <dt><?php echo $field->title ?></dt>
                        <dd><?php echo $field->RenderView() ?></dd>
                    <?php endforeach ?>
                </dl>
            </div>
        </div>
        <hr/>
        <p class="pull-right">

            <?php if ($list->attr('view_edit')): ?>
                <a class="btn btn-primary" href="#/modules/<?php echo $list->id ?>/edit/{{item.<?php echo $list->getIdentity() ?>}}" >Edit</a>
            <?php endif ?>
            <?php if ($list->attr('view_delete')): ?>
                <a class="btn btn-danger" href="#/modules/<?php echo $list->id ?>/delete/{{item.<?php echo $list->getIdentity() ?>}}" >Delete</a>
            <?php endif ?>
            <a class="btn" href="#/modules/<?php echo $list->id ?>/index">Back</a>
        </p>
    </form>
</div>