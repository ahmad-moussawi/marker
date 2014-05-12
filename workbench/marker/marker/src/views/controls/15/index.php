<!-- 15 >> index -->
<span class="color-box" 
<?php if ($field->attr('mode') === 'minirgb') : ?>
    style="border-color:rgb({{item.<?php echo $field->internaltitle ?>}})" >
<?php else: ?>
    style="border-color:{{item.<?php echo $field->internaltitle ?>}}" >
<?php endif ?>

{{item.<?php echo $field->internaltitle ?>}}
</span>