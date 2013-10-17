<ng-include src="'../partials/tmpl/sidebar.html'"></ng-include>
<div class="page-content">
    
     <div class="row">
        <div class="col-md-12">
            <h3 class="page-title"><?php echo $module->title ?></h3>
        </div>
    </div>

    
    <ul class="page-breadcrumb breadcrumb">
        <li class="pull-right"><input type="text" ng-model="searchText.title" placeholder="Search ..." /></li>
        <li>
            <i class="icon-home"></i>
            <a href="#/index">Dashboard</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li><?php echo $module->title ?></li>
    </ul>

    <a href="#/modules/<?php echo $module->id ?>/create" class="btn green">
        Add New <i class="icon-plus"></i>
    </a>
    
    <p></p>


    <table ng-table="tableParams" class="table table-hover">
        <tr ng-repeat="item in $data">
            <td sortable="id" data-title="'id'">{{item.id}}</td>
            <?php foreach ($fields as $field) : ?>
                <td  sortable="<?php echo $field->internaltitle ?>" data-title="'<?php echo $field->title ?>'"><?php echo Content::renderIndexField($field) ?></td>
            <?php endforeach ?>
            <td data-title="''">
                <a class="btn btn-danger" href="#/modules/<?php echo $module->id ?>/delete/{{item.id}}" >Delete</a>
                <a class="btn" href="#/modules/<?php echo $module->id ?>/view/{{item.id}}" >View</a>
                <a class="btn btn-primary" href="#/modules/<?php echo $module->id ?>/edit/{{item.id}}" >Edit</a>
            </td>
        </tr>

    </table>

</div>
