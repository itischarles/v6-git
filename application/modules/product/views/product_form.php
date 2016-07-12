

<?php if (validation_errors()): ?>
    <div class="alert alert-danger" id="">
        <?php echo validation_errors('<p>', '</p>'); ?>             
    </div>
<?php endif; ?>



<?php echo form_open('', array('class' => "form-horizontal")) ?>
<div class="form-group">
    <label for="Name" class="col-sm-3 control-label">Product Name</label>
    <div class="col-sm-9">
        <?php
        $data = array(
            'name' => 'name',
            'id' => 'name',
            'value' => set_value('name', (!empty($product)) ? $product->name : ''),
            'class' => 'field form-control',
            'placeholder' => 'Product Name',
            'required' => 'required'
        );

        echo form_input($data);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="active" class="col-sm-3 control-label">Product Active</label>
    <div class="col-sm-9">
        <?php
        $data = array(
            'name' => 'active',
            'id' => 'active',
            'value' => set_value('active', (!empty($product)) ? $product->active : ''),
            'class' => 'field form-control',
            'placeholder' => 'Product Active',
            'required' => 'required'
        );

        echo form_input($data);
        ?>
    </div>
</div>

<div class="form-group">
    <label for="productTypeID" class="col-sm-3 control-label">Product Type</label>
    <div class="col-sm-9">
        <select name="productTypeID" class="field form-control">
            <option value="none" selected="selected" name="productTypeID">select product type</option>
           
           <?php $productTypeID = (isset($product)? $product->productTypeID : 0); ?>
            
            <?php foreach ($product_types as $row=>$product_type): ?>
           
                <option <?php echo (($product_type->productTypeID == $productTypeID)? "selected" :'')?> value="<?php echo $product_type->productTypeID  ?>">
                    <?php echo $product_type->type_name ?>
                </option>
            <?php endforeach; ?>
                
                
        </select>
    </div>
</div>

<?php       // print_r($product_providers)?>
<div class="form-group">
    <label for="productProviderID" class="col-sm-3 control-label">Product Provider</label>
    <div class="col-sm-9">
        <select name="productProviderID" class="field form-control">
            
            <option value="none" selected="selected">Product Provider</option>
            
            <?php $productProviderID = (isset($product)? $product->productProviderID : 0); ?>
            
            <!-----Displaying fetched cities in options using foreach loop ---->
            <?php foreach ($product_providers as $row=>$product_provider): ?>
            <option <?php echo ( ($product_provider->productProviderID == $productProviderID)? "selected": '') ?> value="<?php echo $product_provider->productProviderID  ?>">
                    <?php echo $product_provider->productProviderName ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label for="reference" class="col-sm-3 control-label">Product Reference</label>
    <div class="col-sm-9">
        <?php
        $data = array(
            'name' => 'reference',
            'id' => 'reference',
            'value' => set_value('reference', (!empty($product)) ? $product->reference : ''),
            'class' => 'field form-control',
            'placeholder' => 'Product Reference',
            'required' => 'required'
        );

        echo form_input($data);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="initialChargePercentage" class="col-sm-3 control-label">Product initial Charge Percentage</label>
    <div class="col-sm-9">
        <?php
        $data = array(
            'name' => 'initialChargePercentage',
            'id' => 'initialChargePercentage',
            'value' => set_value('initialChargePercentage', (!empty($product)) ? $product->initialChargePercentage : ''),
            'class' => 'field form-control',
            'placeholder' => 'Product initial Charge Percentage',
            'required' => 'required'
        );

        echo form_input($data);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="initialChargeFixed" class="col-sm-3 control-label">Product initial Charge Fixed</label>
    <div class="col-sm-9">
        <?php
        $data = array(
            'name' => 'initialChargeFixed',
            'id' => 'initialChargeFixed',
            'value' => set_value('initialChargeFixed', (!empty($product)) ? $product->initialChargeFixed : ''),
            'class' => 'field form-control',
            'placeholder' => 'Product initial Charge Fixed',
            'required' => 'required'
        );

        echo form_input($data);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="annualChargePercentage" class="col-sm-3 control-label">Product annual Charge Percentage</label>
    <div class="col-sm-9">
        <?php
        $data = array(
            'name' => 'annualChargePercentage',
            'id' => 'annualChargePercentage',
            'value' => set_value('annualChargePercentage', (!empty($product)) ? $product->annualChargePercentage : ''),
            'class' => 'field form-control',
            'placeholder' => 'Product annual Charge Percentage',
            'required' => 'required'
        );

        echo form_input($data);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="annualChargePercentageCap" class="col-sm-3 control-label">Product annual Charge Percentage Cap</label>
    <div class="col-sm-9">
        <?php
        $data = array(
            'name' => 'annualChargePercentageCap',
            'id' => 'annualChargePercentageCap',
            'value' => set_value('annualChargePercentageCap', (!empty($product)) ? $product->annualChargePercentageCap : ''),
            'class' => 'field form-control',
            'placeholder' => 'Product annual Charge Percentage Cap',
            'required' => 'required'
        );

        echo form_input($data);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="annualChargeFixed" class="col-sm-3 control-label">Product annual Charge Fixed</label>
    <div class="col-sm-9">
        <?php
        $data = array(
            'name' => 'annualChargeFixed',
            'id' => 'annualChargeFixed',
            'value' => set_value('annualChargeFixed', (!empty($product)) ? $product->annualChargeFixed : ''),
            'class' => 'field form-control',
            'placeholder' => 'Product annual Charge Fixed',
            'required' => 'required'
        );

        echo form_input($data);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="keyFeaturesPath" class="col-sm-3 control-label">Product Name</label>
    <div class="col-sm-9">
        <?php
        $data = array(
            'name' => 'keyFeaturesPath',
            'id' => 'keyFeaturesPath',
            'value' => set_value('keyFeaturesPath', (!empty($product)) ? $product->keyFeaturesPath : ''),
            'class' => 'field form-control',
            'placeholder' => 'Product key Features Path',
            'required' => 'required'
        );

        echo form_input($data);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="illustrationTitle" class="col-sm-3 control-label">Product Name</label>
    <div class="col-sm-9">
        <?php
        $data = array(
            'name' => 'illustrationTitle',
            'id' => 'illustrationTitle',
            'value' => set_value('illustrationTitle', (!empty($product)) ? $product->illustrationTitle : ''),
            'class' => 'field form-control',
            'placeholder' => 'Product illustration Title',
            'required' => 'required'
        );

        echo form_input($data);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="applicationForm" class="col-sm-3 control-label">Product application Form</label>
    <div class="col-sm-9">
        <?php
        $data = array(
            'name' => 'applicationForm',
            'id' => 'applicationForm',
            'value' => set_value('applicationForm', (!empty($product)) ? $product->applicationForm : ''),
            'class' => 'field form-control',
            'placeholder' => 'Product application Form',
            'required' => 'required'
        );

        echo form_input($data);
        ?>
    </div>
</div>



<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
        <?php
        if ($mode == "New"):
            echo form_submit('add_product', "Add Product", 'class="btn btn-primary-2"');
        elseif ($mode == "Edit"):
            echo form_submit('edit_product', "Update Product", 'class="btn btn-primary-2"');
        //  echo anchor(base_url('product_options/'.$product_id.'/options'), "Cancel", 'class="btn btn-primary-2"');
        endif;
        ?>
    </div>
</div>
<?php
echo form_close()?>