<!-- 15 >> edit -->
<div>
    <input 
    <?php // echo $attrs ?>
        color-picker 
        type="color" 
        id="<?php echo $field->internaltitle ?>" 
        name="<?php echo $field->internaltitle ?>"
        ng-model="item.<?php echo $field->internaltitle ?>" 
        /> 
    <span class="label label-default">{{item.<?php echo $field->internaltitle ?>}}</span>
</div>