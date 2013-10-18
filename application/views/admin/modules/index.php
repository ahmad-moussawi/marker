<ng-include src="'../partials/tmpl/sidebar.html'"></ng-include>
<div class="page-content">

    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title"><?php echo $list->title ?></h3>
        </div>
    </div>


    <ul class="page-breadcrumb breadcrumb">
        <li class="pull-right"><input type="text" ng-model="searchText" placeholder="Search ..." /></li>
        <li>
            <i class="icon-home"></i>
            <a href="#/index">Dashboard</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li><?php echo $list->title ?></li>
    </ul>

    <a href="#/modules/<?php echo $list->id ?>/create" class="btn green">
        Add New <i class="icon-plus"></i>
    </a>

    <p></p>

    <table ng-table="tableParams" show-filter="false" class="table table-hover">
        <tr ng-repeat="item in $data | filter:searchText" >
            <td sortable="<?php echo $list->identity ?>" data-title="'id'">{{item.<?php echo $list->identity ?>}}</td>
            <?php foreach ($list->fields as $field) : ?>
                <td 
                <?php if ( strpos($field->type, '5.') === FALSE ): ?>
                        filter="{ '<?php echo $field->internaltitle ?>': 'text' }" 
                        sortable="<?php echo $field->internaltitle ?>"
                    <?php endif ?>
                    data-title="'<?php echo $field->title ?>'"><?php echo Content::renderIndexField($field) ?></td>
                <?php endforeach ?>
            <td data-title="''">
                <a class="btn btn-danger" href="#/modules/<?php echo $list->id ?>/delete/{{item.<?php echo $list->identity ?>}}" >Delete</a>
                <a class="btn" href="#/modules/<?php echo $list->id ?>/view/{{item.<?php echo $list->identity ?>}}" >View</a>
                <a class="btn btn-primary" href="#/modules/<?php echo $list->id ?>/edit/{{item.<?php echo $list->identity ?>}}" >Edit</a>
            </td>
        </tr>

    </table>

</div>
