<!-- default >> index -->
<?php if ($field->attr('pointer')): $tmpl = array(); ?>
    <?php
    $pointedEntity = $field->getPointedEntity()->internaltitle;
    $pointedFields = $field->getPointedFields();
    foreach ($pointedFields as $pointedField):
        $tmpl[] = "{{item.{$pointedEntity}.{$pointedField->internaltitle}}}";
    endforeach
    ?>
    <?php echo implode($field->attr('pointer_separator', ' '), $tmpl) ?>
<?php else: ?>
    <span>{{item.<?php echo $field->internaltitle ?>}}</span>
<?php endif ?>