
    
    <?php if(validation_errors()):?>
        <div class="alert alert-danger" id="">
                <?php  echo validation_errors('<p>','</p>') ;?>             
        </div>
     <?php endif;?>


    <?php echo form_open('', array('class'=>"form-horizontal"))?>
    <div class="form-group">
        <label for="productProviderName" class="col-sm-3 control-label">Product Provider Name</label>
        <div class="col-sm-9">
            <?php
                  $data = array(
                    'name'        => 'productProviderName',
                    'id'          => 'productProviderName',
                    'value'       => set_value('productProviderName', (!empty($product_provider)) ? $product_provider->productProviderName : ''),
                    'class'       => 'field form-control',
                    'placeholder' => 'Name',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
        </div>
    </div>
    <div class="form-group">
        <label for="productProviderAddressLine1" class="col-sm-3 control-label">product Provider AddressLine1</label>
        <div class="col-sm-9">
            <?php
                  $data = array(
                    'name'        => 'productProviderAddressLine1',
                    'id'          => 'productProviderAddressLine1',
                    'value'       => set_value('productProviderAddressLine1', (!empty($product_provider)) ? $product_provider->productProviderAddressLine1 : ''),
                    'class'       => 'field form-control',
                    'placeholder' => 'AddressLine1',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
        </div>
    </div>
    <div class="form-group">
        <label for="productProviderAddressLine2" class="col-sm-3 control-label">product Provider AddressLine2</label>
        <div class="col-sm-9">
            <?php
                  $data = array(
                    'name'        => 'productProviderAddressLine2',
                    'id'          => 'productProviderAddressLine2',
                    'value'       => set_value('productProviderAddressLine2', (!empty($product_provider)) ? $product_provider->productProviderAddressLine2 : ''),
                    'class'       => 'field form-control',
                    'placeholder' => 'AddressLine2',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
        </div>
    </div>
    <div class="form-group">
        <label for="productProviderAddressLine3" class="col-sm-3 control-label">product Provider AddressLine3</label>
        <div class="col-sm-9">
            <?php
                  $data = array(
                    'name'        => 'productProviderAddressLine3',
                    'id'          => 'productProviderAddressLine3',
                    'value'       => set_value('productProviderAddressLine3', (!empty($product_provider)) ? $product_provider->productProviderAddressLine3 : ''),
                    'class'       => 'field form-control',
                    'placeholder' => 'AddressLine3',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
        </div>
    </div>
    <div class="form-group">
        <label for="productProviderCity" class="col-sm-3 control-label">product Provider City</label>
        <div class="col-sm-9">
            <?php
                  $data = array(
                    'name'        => 'productProviderCity',
                    'id'          => 'productProviderCity',
                    'value'       => set_value('productProviderCity', (!empty($product_provider)) ? $product_provider->productProviderCity : ''),
                    'class'       => 'field form-control',
                    'placeholder' => 'City',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
        </div>
    </div>
    <div class="form-group">
        <label for="productProviderPostcode" class="col-sm-3 control-label">product Provider Postcode</label>
        <div class="col-sm-9">
            <?php
                  $data = array(
                    'name'        => 'productProviderPostcode',
                    'id'          => 'productProviderPostcode',
                    'value'       => set_value('productProviderPostcode', (!empty($product_provider)) ? $product_provider->productProviderPostcode : ''),
                    'class'       => 'field form-control',
                    'placeholder' => 'Postcode',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
        </div>
    </div>
    <div class="form-group">
        <label for="productProviderEmail" class="col-sm-3 control-label">product Provider Email</label>
        <div class="col-sm-9">
            <?php
                  $data = array(
                    'name'        => 'productProviderEmail',
                    'id'          => 'productProviderEmail',
                    'value'       => set_value('productProviderEmail', (!empty($product_provider)) ? $product_provider->productProviderEmail : ''),
                    'class'       => 'field form-control',
                    'placeholder' => 'Email',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
        </div>
    </div>
    <div class="form-group">
        <label for="productProviderTel" class="col-sm-3 control-label">product Provider Tel</label>
        <div class="col-sm-9">
            <?php
                  $data = array(
                    'name'        => 'productProviderTel',
                    'id'          => 'productProviderTel',
                    'value'       => set_value('productProviderTel', (!empty($product_provider)) ? $product_provider->productProviderTel : ''),
                    'class'       => 'field form-control',
                    'placeholder' => 'Telephone',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
        </div>
    </div>
     
    
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?php 
                    if($mode == "New"):
                        echo form_submit('add_product_provider', "Add Product Provider", 'class="btn btn-primary-2"');
                    elseif($mode == "Edit"):
                        echo form_submit('edit_product_provider', "Update Product Provider", 'class="btn btn-primary-2"');
                      //  echo anchor(base_url('product_options/'.$product_id.'/options'), "Cancel", 'class="btn btn-primary-2"');
                    endif;
                 ?>
        </div>
    </div>
<?php echo form_close()?>