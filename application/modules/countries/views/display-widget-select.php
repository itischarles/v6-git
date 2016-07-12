<?php $countryAlpha2 = (isset($mark_selected) ? $mark_selected : '')?>
   <select name="country">

    <?php if(!empty($countries)):?>
       <?php foreach($countries as $key=>$country):?>

    <option value="<?php echo $country->countryAlpha2?>" <?php echo (($countryAlpha2==$country->countryAlpha2)? "selected=''selected": '') ?>>
        <?php echo $country->countryName?>
    </option>
       <?php endforeach; ?>
    <?php endif;?>
</select>
