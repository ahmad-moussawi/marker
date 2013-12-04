<div title="<?php echo $field->description ?>" class="form-group" ng-class="{'has-error': form.<?php echo $field->internaltitle ?>.$invalid}">
    <label  class="control-label" for="<?php echo $field->internaltitle ?>">
        <?php echo $field->title ?>
        <?php if ($field->attr('required')): ?>
            *
        <?php endif ?>
    </label>

    <?php if ($new && $field->attr('default') !== NULL) : ?>
        <?php if (is_numeric($field->attr('default'))): ?>
            <span ng-init="item.<?php echo $field->internaltitle ?> = <?php echo $field->attr('default') ?>"></span>
        <?php elseif (is_bool($field->attr('default'))): ?>
            <span ng-init="item.<?php echo $field->internaltitle ?> = <?php echo $field->attr('default') ? 'true' : 'false' ?>"></span>
        <?php else: ?>
            <span ng-init="item.<?php echo $field->internaltitle ?> = '<?php echo $field->attr('default') ?>'"></span>
        <?php endif; ?>
    <?php endif ?>
    
    