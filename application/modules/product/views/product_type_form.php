
    
    <?php if(validation_errors()):?>
        <div class="alert alert-danger" id="">
                <?php  echo validation_errors('<p>','</p>') ;?>             
        </div>
     <?php endif;?>
<?php //  print_r(@$product_type);?>

    <?php echo form_open('', array('class'=>"form-horizontal"))?>
    <div class="form-group">
        <label for="type_name" class="col-sm-3 control-label">Product type Name</label>
        <div class="col-sm-9">
            <?php
                  $data = array(
                    'name'        => 'type_name',
                    'id'          => 'type_name',
                    'value'       => set_value('type_name', (!empty($product_type)) ? $product_type->type_name : ''),
                    'class'       => 'field form-control',
                    'placeholder' => 'Type name',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
        </div>
    </div>
     <div class="form-group">
        <label for="default_growth_rate_low" class="col-sm-3 control-label">Default growth rate low</label>
        <div class="col-sm-9">
            <?php
                  $data = array(
                    'name'        => 'default_growth_rate_low',
                    'id'          => 'default_growth_rate_low',
                    'value'       => set_value('default_growth_rate_low', (!empty($product_type)) ? $product_type->default_growth_rate_low : ''),
                    'class'       => 'field form-control',
                    'placeholder' => 'Default growth rate low',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
        </div>
    </div>
    <div class="form-group">
        <label for="default_growth_rate_mid" class="col-sm-3 control-label">Default growth rate mid</label>
        <div class="col-sm-9">
            <?php
                  $data = array(
                    'name'        => 'default_growth_rate_mid',
                    'id'          => 'default_growth_rate_mid',
                    'value'       => set_value('default_growth_rate_mid', (!empty($product_type)) ? $product_type->default_growth_rate_mid : ''),
                    'class'       => 'field form-control',
                    'placeholder' => 'Default growth rate mid',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
        </div>
    </div>
    <div class="form-group">
        <label for="default_growth_rate_high" class="col-sm-3 control-label">Default growth rate high</label>
        <div class="col-sm-9">
            <?php
                  $data = array(
                    'name'        => 'default_growth_rate_high',
                    'id'          => 'default_growth_rate_high',
                    'value'       => set_value('default_growth_rate_high', (!empty($product_type)) ? $product_type->default_growth_rate_high : ''),
                    'class'       => 'field form-control',
                    'placeholder' => 'Default growth rate high',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
        </div>
    </div>
    <div class="form-group">
        <label for="max_mid_growth_rate" class="col-sm-3 control-label">Max mid growth rate</label>
        <div class="col-sm-9">
            <?php
                  $data = array(
                    'name'        => 'max_mid_growth_rate',
                    'id'          => 'max_mid_growth_rate',
                    'value'       => set_value('max_mid_growth_rate', (!empty($product_type)) ? $product_type->max_mid_growth_rate : ''),
                    'class'       => 'field form-control',
                    'placeholder' => 'Max mid growth rate',
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
                        echo form_submit('add_product_type', "Add Product Type", 'class="btn btn-primary-2"');
                    elseif($mode == "Edit"):
                        echo form_submit('edit_product_type', "Update Product Type", 'class="btn btn-primary-2"');
                      //  echo anchor(base_url('product_options/'.$product_id.'/options'), "Cancel", 'class="btn btn-primary-2"');
                    endif;
                 ?>
        </div>
    </div>
<?php echo form_close()?>