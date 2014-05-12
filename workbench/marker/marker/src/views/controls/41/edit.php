<!-- 41 >> edit -->
<?php
if ($field->attr('type') === 'static'):

    $options = array();
    foreach (explode("\n", $field->attr('type_static')) as $row) {
        if (strpos($row, '::')) {
            $row = explode('::', $row);
            $options[$row[0]] = $row[1];
        } else {
            $options[$row] = $row;
        }
    }
    //echo //form_dropdown($field->internaltitle, $options, false, "ng-model=\"item.$field->internaltitle\" $attrs class=\"form-control\"");
    ?>

<?php elseif ($field->attr('type') === 'internal'): ?>
    <select 
        class="form-control"
        id="<?php echo $field->internaltitle ?>" 
        name="<?php echo $field->internaltitle ?>"
        ng-model="item.<?php echo $field->internaltitle ?>" 
        field-internal="<?php echo $field->attr('type_internal') ?>" 
        field-display="<?php echo $field->attr('type_internal_display') ?>">
    </select>
<?php endif ?>