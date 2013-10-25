<ng-include src="'../admin/modules/getView/sidebar'"></ng-include>
<div class="page-content <?php echo $list->attrs->cssClass ?>">

    <div class="row">
        <div class="col-md-12">

            <h3 class="page-title"><?php echo $list->title ?>
                <div class="input-icon pull-right">
                    <i class="icon-search"></i>
                    <input type="text" class="form-control" ng-model="searchText" placeholder="Search ..."> 
                </div>
            </h3>
        </div>
    </div>


    <ul class="page-breadcrumb breadcrumb">
        <?php if (Auth::IsUserInRole('super')): ?>
            <li class="btn-group">
                <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                    <span>Actions</span> <i class="icon-angle-down"></i>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li><a target="_blank" href="../api/get/<?php echo $list->internaltitle ?>">JSON Api</a></li>
                    <li><a href="#/lists/edit/<?php echo $list->id ?>">Edit list</a></li>
                </ul>
            </li>
        <?php endif ?>
        <li>
            <i class="icon-home"></i>
            <a href="#/index">Dashboard</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li><?php echo $list->title ?></li>
    </ul>


    <?php if ($list->attrs->view_create): ?>
        <a href="#/modules/<?php echo $list->id ?>/create" class="btn green">
            Add New <i class="icon-plus"></i>
        </a>
    <?php endif ?>
    <p></p>

    <table ng-table="tableParams" show-filter="false" class="table table-hover">
        <tr ng-repeat="item in $data | filter:searchText" >
            <td sortable="<?php echo $list->identity ?>" data-title="'id'">{{item.<?php echo $list->identity ?>}}</td>
            <?php foreach ($list->published_fields as $field) : ?>
                <td 
                <?php if (strpos($field->typeref, '5.') === FALSE): ?>
                        filter="{ '<?php echo $field->internaltitle ?>': 'text' }" 
                        sortable="<?php echo $field->internaltitle ?>"
                    <?php endif ?>
                    data-title="'<?php echo $field->title ?>'"><?php echo Content::renderIndexField($field) ?></td>
                <?php endforeach ?>
            <td data-title="''">

                <div class="btn-group">
                    <a class="btn btn-default" href="#/modules/<?php echo $list->id ?>/view/{{item.<?php echo $list->identity ?>}}">View</a>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="icon-angle-down"></i></button>
                    <ul class="dropdown-menu" role="menu">
                        <?php if ($list->attrs->view_edit): ?>
                            <li>
                                <a href="#/modules/<?php echo $list->id ?>/edit/{{item.<?php echo $list->identity ?>}}" >Edit</a>
                            </li>
                        <?php endif ?>
                        <?php if ($list->attrs->view_delete): ?>
                            <li>
                                <a href="#/modules/<?php echo $list->id ?>/delete/{{item.<?php echo $list->identity ?>}}" >Delete</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </td>
        </tr>

    </table>

</div>
