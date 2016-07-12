<script>

    //var aFirms = <?php echo($firmsList); ?> ;
    //var aNetworks = <?php echo($networksList); ?>;

    var sMod = 'EditAdviser';

</script>


<div class="container-fluid">



    <?php echo form_open('', array('class' => "form form-horizontal")) ?>

    <input type="hidden" id="hIfaID" name="hIfaID" value="<?php echo($hIfaID); ?>" />


    <?php if (validation_errors()) { ?>
        <div class="alert-danger alert text-center">
            <?php echo validation_errors() ?>
        </div>
    <?php } ?>

    <?php if (isset($db_error)) { ?>
        <div class="alert-danger alert"><?php echo $db_error ?></div>
    <?php } ?>


    <p class="text-right" style="margin:0;">
        <span class="red-notice" style="color:red;">The fields marked * are required</span>
    </p>



    <?php // FCA Specific Data  ===========================================================================	?>

    <div class="form-group has-feedback has-feedback-left required">	    
        <label for="individualFcaNumber" class="col-sm-3 control-label">FCA Ref. No.</label>
        <div class="col-sm-9">
            <?php
            $data = array(
                'name' => 'individualFcaNumber',
                'id' => 'individualFcaNumber',
                'value' => $adviser->individualFcaNumber,
                'class' => 'field col-sm-3',
                'placeholder' => 'Your personal FCA reference number.',
                'required' => 'required'
            );
            echo form_input($data);
            ?>
        </div>                   
    </div>


    <div class="form-group has-feedback has-feedback-left required">	    
        <label for="" class="col-sm-3 control-label">Adviser Roles</label>
        <div class="col-sm-9">

            <?php
            $data = array(
                'name' => 'chkNormal',
                'id' => 'chkNormal',
                'value' => '1',
                'checked' => (( isset($has_normal) && $has_normal == TRUE ) ? TRUE : FALSE),
                'style' => 'margin:10px',
                ($can_edit_roles != TRUE ? 'disabled' : null ) => ($can_edit_roles != TRUE ? '' : '' )
            );
            echo form_checkbox($data);
            ?> <small>Normal Adviser</small>
            <br>


            <?php
            $data = array(
                'name' => 'chkParaPlanner',
                'id' => 'chkParaPlanner',
                'value' => '1',
                'checked' => (( isset($has_para) && $has_para == TRUE ) ? TRUE : FALSE),
                'style' => 'margin:10px',
                ($can_edit_roles != TRUE ? 'disabled' : null ) => ($can_edit_roles != TRUE ? '' : '' )
            );
            echo form_checkbox($data);
            ?> <small>Para-Planner Adviser</small>
            <br>


            <?php
            $data = array(
                'name' => 'chkSuper',
                'id' => 'chkSuper',
                'value' => '1',
                'checked' => (( isset($has_super) && $has_super == TRUE ) ? TRUE : FALSE),
                'style' => 'margin:10px',
                ($can_edit_roles != TRUE ? 'disabled' : null ) => ($can_edit_roles != TRUE ? '' : '' )
            );
            echo form_checkbox($data);
            ?> <small>Super Adviser</small>
            <br>



        </div>                   
    </div>

    <?php //  Buttons  =============================================================================	 ?>

    <br>

    <div class="form-group ">	    
        <label for="" class="col-sm-3 control-label"></label>
        <div class="col-sm-9">
            <button id="faUpdate" name="faUpdate" class="btn btn-primary-2" style="width:30%;" value="Update">Update Adviser</button>
        </div>                   
    </div>

    <?php echo form_close() ?>

</div><!-- content -->


<?php
/*
  NOTES & TODO:



 */
?>

