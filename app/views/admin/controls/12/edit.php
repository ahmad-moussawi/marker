<!-- 12 >> edit -->
<textarea
    <?php foreach ($htmlattr as $key => $val): ?>
        <?php echo "$key=\"$val\"" ?>
    <?php endforeach ?>
    id="<?php echo $field->internaltitle ?>" 
    name="<?php echo $field->internaltitle ?>" 
    type="text"  
    class="form-control" 
    ng-model="item.<?php echo $field->internaltitle ?>" 
    >
</textarea>