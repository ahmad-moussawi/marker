<!-- 41 >> view -->
<?php if ($field->attr('type') === 'internal') : ?>
    {{item.__<?php echo $field->internaltitle ?>| field_view_41:'<?php echo $field->attr('type_internal_display') ?>'}}
<?php elseif($field->attr('type') === 'static'): ?>
    {{item.<?php echo $field->internaltitle ?>}}
<?php endif ?>