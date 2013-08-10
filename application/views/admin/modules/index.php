<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="#/index"><?php echo $module->title ?></a>
        <ul class="nav">
            <li><a href="#/modules/<?php echo $module->id ?>/create">New <?php echo $term ?></a></li>
        </ul>
    </div>
</div>

<p>
    <input type="text" ng-model="searchText" placeholder="Search <?php echo $module->title ?>" class="pull-right" />
</p>

<table class="table table-hover">
    <tr>
        <th>Id</th>
        <?php foreach ($fields as $field): ?>
            <th><?php echo $field->title ?></th>
        <?php endforeach ?>
        <th></th>
    </tr>

    <tr ng-repeat="item in items | filter:searchText">
        <td>{{item.id}}</td>
        <?php foreach ($fields as $field) : ?>
        <td><?php echo Content::renderIndexField($field) ?></td>
        <?php endforeach ?>
        <td>
            <a class="btn btn-danger" href="#/modules/<?php echo $module->id ?>/delete/{{item.id}}" >Delete</a>
            <a class="btn" href="#/modules/<?php echo $module->id ?>/view/{{item.id}}" >View</a>
            <a class="btn btn-primary" href="#/modules/<?php echo $module->id ?>/edit/{{item.id}}" >Edit</a>
        </td>
    </tr>

</table>