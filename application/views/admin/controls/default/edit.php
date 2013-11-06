<!-- default >> edit -->
<input
    <?php echo $attrs ?>
    id="<?php echo $field->internaltitle ?>" 
    name="<?php echo $field->internaltitle ?>" 
    type="text"  
    class="form-control" 
    ng-model="item.<?php echo $field->internaltitle ?>" 
/>