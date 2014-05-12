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

            <h3 class="page-title"><?php echo $entity->title ?>
                <div class="input-icon pull-right">
                    <i class="icon-search"></i>
                    <input type="text" class="form-control" ng-model="searchText" placeholder="Search ..."> 
                </div>
            </h3>
        </div>
    </div>


    <ul class="page-breadcrumb breadcrumb">
        <?php //if (Auth::IsUserInRole('super')): ?>
            <li class="btn-group">
                <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                    <span>Actions</span> <i class="icon-angle-down"></i>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li><a target="_blank" href="api/modules/<?php echo $entity->internaltitle ?>">JSON Api</a></li>
                    <li><a href="#/entities/edit/<?php echo $entity->id ?>">Edit entity</a></li>
                </ul>
            </li>
        <?php //endif ?>
        <li>
            <i class="icon-home"></i>
            <a href="#">Dashboard</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li><?php echo $entity->title ?></li>
    </ul>


    <?php if ($entity->attr('view_create')): ?>
        <a href="#/m/<?php echo $entity->id ?>/new" class="btn green">
            Add New <i class="icon-plus"></i>
        </a>
    <?php endif ?>
    <p></p>

    <table ng-table="tableParams" show-filter="false" class="table table-hover">
        <tr ng-repeat="item in $data| filter:searchText" >
            <td sortable="<?php echo $entity->identity ?>" data-title="'id'">{{item.<?php echo $entity->identity ?>}}</td>
            <?php foreach ($entity->fields as $field) : /* @var $field Field */ ?>
                <td 
                    
                    <?php if ($field->attr('sortable')): ?>
                        sortable="<?php echo $field->internaltitle ?>"
                    <?php endif ?>

                    <?php if ($field->attr('searchable')): ?>
                        filter="{ '<?php echo $field->internaltitle ?>': 'text' }" 
                    <?php endif ?>
                    
                    data-title="'<?php echo $field->title ?>'"
                >
                    <?php echo $field->renderIndex() ?>
                </td>
            <?php endforeach ?>
            <td data-title="''">

                <div class="btn-group">
                    <a class="btn btn-default" href="#/m/<?php echo $entity->id ?>/view/{{item.<?php echo $entity->identity ?>}}">View</a>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="icon-angle-down"></i></button>
                    <ul class="dropdown-menu" role="menu">
                        <?php if ($entity->attr('view_edit')): ?>
                            <li>
                                <a href="#/m/<?php echo $entity->id ?>/edit/{{item.<?php echo $entity->identity ?>}}" >Edit</a>
                            </li>
                        <?php endif ?>
                        <?php if ($entity->attr('view_delete')): ?>
                            <li>
                                <a href="#/m/<?php echo $entity->id ?>/delete/{{item.<?php echo $entity->identity ?>}}" >Delete</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </td>
        </tr>

    </table>

</div>
