<!-- default >> edit -->
<input
    id="<?php echo $field->internaltitle ?>" 
    name="<?php echo $field->internaltitle ?>" 
    type="text"  
    class="form-control"
    <?php foreach($htmlattr as $key => $val): ?>
    <?php echo "$key=\"$val\"" ?>
    <?php endforeach ?>
    ng-model="item.<?php echo $field->internaltitle ?>" 
/>