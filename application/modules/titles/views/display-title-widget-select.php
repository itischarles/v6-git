
<?php $titleName = (isset($mark_selected) ? $mark_selected : '')?>
   <select name="title">

    <?php if(!empty($titles)):?>
       <?php foreach($titles as $key=>$title):?>

    <option value="<?php echo $title->titleName?>" <?php echo (($titleName==$title->titleName)? "selected=''selected": '') ?>>
        <?php echo $title->titleName?>
    </option>
       <?php endforeach; ?>
    <?php endif;?>
</select>
