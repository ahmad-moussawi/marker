<!-- 51 >> edit -->
<marker-upload 
    <?php // echo $attrs ?>
    id="<?php echo $field->internaltitle ?>" 
    name="<?php echo $field->internaltitle ?>"
    type="image" 
    ng-model="item.<?php echo $field->internaltitle ?>" 
    path="uploads/upload/<?php echo $field->id ?>/image">
</marker-upload>