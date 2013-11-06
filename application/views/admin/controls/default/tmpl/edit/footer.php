<?php if ($field->attr('maxlength')): ?>
    <span class="help-block" ng-show="form.<?php echo $field->internaltitle ?>.$error.maxlength">The maximum length is <?php echo $field->attr('maxlength') ?></span>
<?php endif ?>

<?php if ($field->attr('minlength')): ?>
    <span class="help-block" ng-show="form.<?php echo $field->internaltitle ?>.$error.minlength">The minimum length is <?php echo $field->attr('minlength') ?></span>
<?php endif ?>

<?php if ($field->attr('required')): ?>
    <span class="help-block" ng-show="form.<?php echo $field->internaltitle ?>.$error.required">This field cannot be empty</span>
<?php endif ?>

<?php if ($field->attr('unique')): ?>
    <span class="help-block" ng-show="form.<?php echo $field->internaltitle ?>.$error.unique">Value already exists</span>
    <span class="help-block" ng-show="form.<?php echo $field->internaltitle ?>.$error.validatingunique">Checking the new value ...</span>
<?php endif ?>

<?php if ($field->attr('unique_group')): ?>
    <span class="help-block" ng-show="form.<?php echo $field->internaltitle ?>.$error.uniquegroup">
        The combination already exists</span>
    <span class="help-block" ng-show="form.<?php echo $field->internaltitle ?>.$error.validatinguniquegroup">Checking the new values ...</span>
<?php endif ?>
    
</div>
