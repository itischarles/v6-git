<script>

	var aFirms = <?php echo($firmsList);?> ;
	var aNetworks = <?php echo($networksList);?> 
	
</script>


<style>
.fa.form-control-feedback {
    line-height: 34px; 
}
.input-sm ~ .fa.form-control-feedback {
    line-height: 30px; 
}
.input-lg ~ .fa.form-control-feedback {
    line-height: 46px; 
}
.has-feedback-left input.form-control {
    padding-left: 34px; 
    padding-right: 12px; 
}
.has-feedback-left .form-control-feedback {
    left: 0; 
}
.form-horizontal .has-feedback-left .form-control-feedback {
    left: 12px; 
}
.has-feedback-left input.input-sm {
  padding-left: 30px;  @input-height-small;
}
.has-feedback-left input.input-lg {
  padding-left: 46px;  @input-height-large;
}
.iconSpan
{
	color:rgba(105, 102, 102, 0.8);
}
</style>
	
<div class="container-fluid register-box">
			
    <div class="register-box-body">

        <div class="">
            <div class="content">

                <?php echo form_open('', array('class'=>"form form-horizontal col-100") )?>

                    <input type="hidden" id="hNetworkID" name="hNetworkID" value="<?php echo(set_value('hNetworkID'));?>" />
                    <input type="hidden" id="hFirmID" name="hFirmID" value="<?php echo(set_value('hFirmID'));?>" />

                     <?php if(validation_errors()){ ?>
                              <div class="alert-danger alert text-center">
                              <?php echo validation_errors()?>
                              </div>
                     <?php } ?>

                    <?php $this->load->view('template/flash_message')?>


                    <?php if(isset($db_error)){?>
                            <div class="alert-danger alert"><?php echo $db_error ?></div>
                    <?php } ?>


                    <p class="text-right" style="margin:0;">
                      <span class="red-notice" style="color:red;">The fields marked * are required</span>
                    </p>








                    <?php // Personal Data  ========================================================================================= 
                    // ===========================================================================================================	?>


                    <div class="text-center" style="margin-bottom:5px; background-color:#696666;color:white;padding:3px;">
                            <h4 style="display:inline; margin-left:20px;">Personal Details</h4>
                    </div>


                    <div class="form-group has-feedback has-feedback-left required">	    
                       <label for="individualFcaNumber" class="col-sm-3 control-label">FCA Ref. No.</label>
                       <div class="col-sm-9">
                            <?php
                              $data = array(
                            'name'        => 'individualFcaNumber',
                            'id'          => 'individualFcaNumber',
                            'value'       => set_value('individualFcaNumber'),
                            'class'       => 'form-control field',
                            'placeholder' => 'Your personal FCA reference number.',
                            'required'  =>'required'
                              );
                            echo form_input($data);
                            ?>
                            <span class="iconSpan glyphicon glyphicon-sound-dolby form-control-feedback"></span>
                       </div>                   
                    </div>

                    <div class="form-group  has-feedback has-feedback-left required">	    
                       <label for="firstName" class="col-sm-3 control-label">First Name</label>
                       <div class="col-sm-9">
                            <?php
                              $data = array(
                            'name'        => 'firstName',
                            'id'          => 'firstName',
                            'value'       => set_value('firstName'),
                            'class'       => 'field form-control',
                            'placeholder' => 'Enter first name.',
                            'required'  =>'required'
                               );
                            echo form_input($data);
                            ?>
                            <span class="iconSpan glyphicon glyphicon-pencil form-control-feedback"></span>
                       </div>                   
                    </div>

                    <div class="form-group  has-feedback has-feedback-left required">	    
                       <label for="lastName" class="col-sm-3 control-label">Last Name</label>
                       <div class="col-sm-9">
                            <?php
                              $data = array(
                            'name'        => 'lastName',
                            'id'          => 'lastName',
                            'value'       => set_value('lastName'),
                            'class'       => 'field form-control',
                            'placeholder' => 'Enter last name.',
                            'required'  =>'required'
                               );
                            echo form_input($data);
                            ?>
                            <span class="iconSpan glyphicon glyphicon-pencil form-control-feedback"></span>
                       </div>                   
                    </div>

                    <div class="form-group  has-feedback has-feedback-left required">	    
                       <label for="userPass" class="col-sm-3 control-label">Password</label>
                       <div class="col-sm-9">
                            <?php
                              $data = array(
                            'name'        => 'userPass',
                            'id'          => 'userPass',
                            'value'       => '' ,
                            'class'       => 'field form-control',
                            'placeholder' => '',
                            'required'  =>'required'
                               );
                            echo form_password($data);
                            ?>
                            <span class="iconSpan glyphicon glyphicon-lock form-control-feedback"></span>
                       </div>                   
                    </div>

                    <div class="form-group  has-feedback has-feedback-left required">	    
                       <label for="userRePass" class="col-sm-3 control-label">Re-Enter Password</label>
                       <div class="col-sm-9">
                            <?php
                              $data = array(
                            'name'        => 'userRePass',
                            'id'          => 'userRePass',
                            'value'       => '' ,
                            'class'       => 'field form-control',
                            'placeholder' => '',
                            'required'  =>'required'
                               );
                            echo form_password($data);
                            ?>
                            <span class="iconSpan glyphicon glyphicon-lock form-control-feedback"></span>
                       </div>                   
                    </div>

                    <hr>

                    <div class="form-group  has-feedback has-feedback-left  required ">	    
                       <label for="address1" class="col-sm-3 control-label">Address Line 1</label>
                       <div class="col-sm-9">
                            <?php
                              $data = array(
                            'name'        => 'address1',
                            'id'          => 'address1',
                            'value'       => set_value('address1'),
                            'class'       => 'field form-control',
                            'placeholder' => 'Enter address line(s).',
                            'required'  =>'required'
                               );
                            echo form_input($data);
                            ?>
                            <span class="iconSpan glyphicon glyphicon-tag form-control-feedback"></span> 
                       </div>                   
                    </div>

                    <div class="form-group  has-feedback has-feedback-left ">	    
                       <label for="address2" class="col-sm-3 control-label">Address Line 2</label>
                       <div class="col-sm-9">
                            <?php
                              $data = array(
                            'name'        => 'address2',
                            'id'          => 'address2',
                            'value'       => set_value('address2'),
                            'class'       => 'field form-control',
                               );
                            echo form_input($data);
                            ?>
                            <span class="iconSpan glyphicon glyphicon-option-horizontal form-control-feedback"></span> 
                       </div>                   
                    </div>



                    <div class="form-group  has-feedback has-feedback-left ">	    
                       <label for="address3" class="col-sm-3 control-label">Address Line 3</label>
                       <div class="col-sm-9">
                            <?php
                              $data = array(
                            'name'        => 'address3',
                            'id'          => 'address3',
                            'value'       => set_value('address3'),
                            'class'       => 'field form-control',
                               );
                            echo form_input($data);
                            ?>
                            <span class="iconSpan glyphicon glyphicon-option-horizontal form-control-feedback"></span> 
                       </div>                   
                    </div>

                    <div class="form-group  has-feedback has-feedback-left  required">	    
                       <label for="postalCode" class="col-sm-3 control-label">Postal Code</label>
                       <div class="col-sm-9">
                            <?php
                              $data = array(
                            'name'        => 'postalCode',
                            'id'          => 'postalCode',
                            'value'       => set_value('postalCode'),
                            'class'       => 'field form-control',
                            'placeholder' => 'Enter postal code.',
                            'required'  =>'required'
                               );
                            echo form_input($data);
                            ?>
                            <span class="iconSpan glyphicon glyphicon-option-horizontal form-control-feedback"></span> 
                       </div>                   
                    </div>


                    <div class="form-group  has-feedback has-feedback-left  required">	    
                       <label for="city" class="col-sm-3 control-label">City</label>
                       <div class="col-sm-9">
                            <?php
                              $data = array(
                            'name'        => 'city',
                            'id'          => 'city',
                            'value'       => set_value('city'),
                            'class'       => 'field form-control',
                            'placeholder' => 'Enter city.',
                            'required'  =>'required'
                               );
                            echo form_input($data);
                            ?>
                            <span class="form-control-feedback"><i class="icon icon-building icon-large"></i></span>
                       </div>                   
                    </div>

                    <hr>

                    <div class="form-group  has-feedback has-feedback-left required">	    
                       <label for="email" class="col-sm-3 control-label">Email</label>
                       <div class="col-sm-9">
                            <?php
                              $data = array(
                            'name'        => 'email',
                            'id'          => 'email',
                            'value'       => set_value('email'),
                            'class'       => 'field form-control',
                            'placeholder' => 'Enter your email address.',
                            'required'  =>'required'
                               );
                            echo form_input($data);
                            ?>
                            <span class="iconSpan glyphicon glyphicon-envelope form-control-feedback"></span>
                       </div>                   
                    </div>

                    <div class="form-group  has-feedback has-feedback-left  required">	    
                       <label for="telephone" class="col-sm-3 control-label">Telephone</label>
                       <div class="col-sm-9">
                            <?php
                              $data = array(
                            'name'        => 'telephone',
                            'id'          => 'telephone',
                            'value'       => set_value('telephone'),
                            'class'       => 'field form-control',
                            'placeholder' => 'Enter fixed line number.',
                            'required'  =>'required'
                               );
                            echo form_input($data);
                            ?>
                            <span class="iconSpan glyphicon glyphicon-phone-alt form-control-feedback"></span>
                       </div>                   
                    </div>

                    <div class="form-group  has-feedback has-feedback-left  required">	    
                       <label for="mobile" class="col-sm-3 control-label">Mobile</label>
                       <div class="col-sm-9">
                            <?php
                              $data = array(
                            'name'        => 'mobile',
                            'id'          => 'mobile',
                            'value'       => set_value('mobile'),
                            'class'       => 'field form-control',
                            'placeholder' => 'Enter personal mobile.',
                            'required'  =>'required'
                               );
                            echo form_input($data);
                            ?>
                            <span style="width:30px; height:30px;" class="form-control-feedback"    >
                                    <img id="home" src="<?php echo base_url('images/icons/empty.png')?>" style="width:20px;height:20px;background: url(<?php echo base_url('images/icons/mobile.png')?>) 0 0;">
                            </span>
                       </div>                   
                    </div>




                                <?php // Firm  =============================================================================================== 
                                // ===========================================================================================================	?>


                                <div class="text-center" style="margin-bottom:5px; background-color:#696666;color:white;padding:3px;">
                                        <h4 style="display:inline; margin-left:20px;">Select / Add Firm </h4>
                                </div>

                                <div class="form-group has-feedback has-feedback-left">	    
                                   <label for="chkAddFirm" class="col-sm-3 control-label">Add Firm?</label>
                                        <div class="col-sm-9">
                                        <?php
                                        $data = array(
                                                'name'          => 'chkAddFirm',
                                                'id'            => 'chkAddFirm',
                                                'value'         => 'accept',
                                                'checked'       => set_value('chkAddFirm'),
                                                'style'         => 'margin:10px'
                                        );
                                        echo form_checkbox($data);
                                        ?> <small>(Tick if you want to specify existing or new firm)</small>
                                   </div>                   
                                </div>


                                <div id="divFirmSearchBox" style="display:none;">

                                        <div class="form-group has-feedback has-feedback-left required">	    
                                           <label for="firmSeacher" class="col-sm-3 control-label">Firm Name</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'firmSeacher',
                                                'id'          => 'firmSeacher',
                                                'value'       => set_value('firmSeacher'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'Type here to Select or Add a Firm.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-search form-control-feedback"></span> 
                                           </div>                   
                                        </div>

                                </div>

                                <div id="divFirmContainer" style="display:none;">

                                        <div class="form-group has-feedback has-feedback-left required">	    
                                           <label for="firmFCANo" class="col-sm-3 control-label">Firm FCA Reg. No</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'firmFCANo',
                                                'id'          => 'firmFCANo',
                                                'value'       => set_value('firmFCANo'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'FCA Ref. No. of the Firm.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-sound-dolby form-control-feedback"></span> 
                                           </div>                   
                                        </div>


                                <div class="form-group  has-feedback has-feedback-left  required ">	    
                                   <label for="firmAddress1" class="col-sm-3 control-label">Address Line 1</label>
                                   <div class="col-sm-9">
                                        <?php
                                          $data = array(
                                        'name'        => 'firmAddress1',
                                        'id'          => 'firmAddress1',
                                        'value'       => set_value('firmAddress1'),
                                        'class'       => 'field form-control',
                                        'placeholder' => 'Enter address line(s).',
                                        'required'  =>'required'
                                           );
                                        echo form_input($data);
                                        ?>
                                        <span class="iconSpan glyphicon glyphicon-tag form-control-feedback"></span> 
                                   </div>                   
                                </div>

                                <div class="form-group  has-feedback has-feedback-left ">	    
                                   <label for="firmAddress2" class="col-sm-3 control-label">Address Line 2</label>
                                   <div class="col-sm-9">
                                        <?php
                                          $data = array(
                                        'name'        => 'firmAddress1',
                                        'id'          => 'firmAddress1',
                                        'value'       => set_value('firmAddress1'),
                                        'class'       => 'field form-control',
                                           );
                                        echo form_input($data);
                                        ?>
                                        <span class="iconSpan glyphicon glyphicon-option-horizontal form-control-feedback"></span> 
                                   </div>                   
                                </div>



                                <div class="form-group  has-feedback has-feedback-left ">	    
                                   <label for="firmAddress3" class="col-sm-3 control-label">Address Line 3</label>
                                   <div class="col-sm-9">
                                        <?php
                                          $data = array(
                                        'name'        => 'firmAddress3',
                                        'id'          => 'firmAddress3',
                                        'value'       => set_value('firmAddress3'),
                                        'class'       => 'field form-control',
                                           );
                                        echo form_input($data);
                                        ?>
                                        <span class="iconSpan glyphicon glyphicon-option-horizontal form-control-feedback"></span> 
                                   </div>                   
                                </div>

                                <div class="form-group  has-feedback has-feedback-left  required">	    
                                   <label for="firmPostalCode" class="col-sm-3 control-label">Postal Code</label>
                                   <div class="col-sm-9">
                                        <?php
                                          $data = array(
                                        'name'        => 'firmPostalCode',
                                        'id'          => 'firmPostalCode',
                                        'value'       => set_value('firmPostalCode'),
                                        'class'       => 'field form-control',
                                        'placeholder' => 'Enter postal code.',
                                        'required'  =>'required'
                                           );
                                        echo form_input($data);
                                        ?>
                                        <span class="iconSpan glyphicon glyphicon-option-horizontal form-control-feedback"></span> 
                                   </div>                   
                                </div>


                                <div class="form-group  has-feedback has-feedback-left  required">	    
                                   <label for="firmCity" class="col-sm-3 control-label">City</label>
                                   <div class="col-sm-9">
                                        <?php
                                          $data = array(
                                        'name'        => 'firmCity',
                                        'id'          => 'firmCity',
                                        'value'       => set_value('firmCity'),
                                        'class'       => 'field form-control',
                                        'placeholder' => 'Enter city.',
                                        'required'  =>'required'
                                           );
                                        echo form_input($data);
                                        ?>
                                        <span class="form-control-feedback"><i class="icon icon-building icon-large"></i></span>
                                   </div>                   
                                </div>

                                        <div class="form-group has-feedback has-feedback-left required">	    
                                           <label for="firmEmail" class="col-sm-3 control-label">Email</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'firmEmail',
                                                'id'          => 'firmEmail',
                                                'value'       => set_value('firmEmail'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'Enter email of the firm to add.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-envelope form-control-feedback"></span> 
                                           </div>                   
                                        </div>


                                        <div class="form-group has-feedback has-feedback-left">	    
                                           <label for="firmMobile" class="col-sm-3 control-label">Mobile</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'firmMobile',
                                                'id'          => 'firmMobile',
                                                'value'       => set_value('firmMobile'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'Enter mobile of the firm to add.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-envelope form-control-feedback"></span> 
                                           </div>                   
                                        </div>

                                        <div class="form-group has-feedback has-feedback-left required">	    
                                           <label for="firmTelephone" class="col-sm-3 control-label">Telephone</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'firmTelephone',
                                                'id'          => 'firmTelephone',
                                                'value'       => set_value('firmTelephone'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'Enter telephone of the firm to add.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-phone-alt form-control-feedback"></span> 
                                           </div>                   
                                        </div>

                                        <div class="form-group has-feedback has-feedback-left required">	    
                                           <label for="firmContact" class="col-sm-3 control-label">Contact Person</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'firmContact',
                                                'id'          => 'firmContact',
                                                'value'       => set_value('firmContact'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'Enter contact person of the firm to add.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-user form-control-feedback"></span> 
                                           </div>                   
                                        </div>

                                        <div class="form-group has-feedback has-feedback-left">	    
                                           <label for="firmWebAddress" class="col-sm-3 control-label">Website Address</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'firmWebAddress',
                                                'id'          => 'firmWebAddress',
                                                'value'       => set_value('firmWebAddress'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'Enter webiste address of the  firm.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-user form-control-feedback"></span> 
                                           </div>                   
                                        </div>




                                </div> <?php // Firm  Container ?>














                                <?php // Network  =============================================================================================== 
                                // ===========================================================================================================	?>

                                <div class="text-center" style="margin-bottom:5px; background-color:#696666;color:white;padding:3px;">
                                        <h4 style="display:inline; margin-left:20px;">Select / Add Firm Network Details</h4>
                                </div>


                                <div class="form-group has-feedback has-feedback-left">	    
                                   <label for="chkAddNetwork" class="col-sm-3 control-label">Add Firm Netowrk?</label>
                                        <div class="col-sm-9">
                                        <?php
                                        $data = array(
                                                'name'          => 'chkAddNetwork',
                                                'id'            => 'chkAddNetwork',
                                                'value'         => 'accept',
                                                'checked'       => set_value('chkAddNetwork'),
                                                'style'         => 'margin:10px'
                                        );
                                        echo form_checkbox($data);
                                        ?> <small>(Tick if you want to specify existing or new firm network)</small>
                                   </div>                   
                                </div>

                                <div id="divNetworkSearchBox" style="display:none;">

                                        <div class="form-group has-feedback has-feedback-left required">	    
                                           <label for="networkSearcher" class="col-sm-3 control-label">Network Name</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'networkSearcher',
                                                'id'          => 'networkSearcher',
                                                'value'       => set_value('networkSearcher'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'Type here to Select or Add a Firm Network.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-search form-control-feedback"></span> 
                                           </div>                   
                                        </div>

                                </div>

                                <div id="divNetworkContainer" style="display:none;">

                                        <div class="form-group has-feedback has-feedback-left required">	    
                                           <label for="networkFCANo" class="col-sm-3 control-label">Network FCA Reg. No</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'networkFCANo',
                                                'id'          => 'networkFCANo',
                                                'value'       => set_value('networkFCANo'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'FCA Ref. No. of the Network.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-sound-dolby form-control-feedback"></span> 
                                           </div>                   
                                        </div>


                                                <div class="form-group  has-feedback has-feedback-left  required ">	    
                                   <label for="networkAddress1" class="col-sm-3 control-label">Address Line 1</label>
                                   <div class="col-sm-9">
                                        <?php
                                          $data = array(
                                        'name'        => 'networkAddress1',
                                        'id'          => 'networkAddress1',
                                        'value'       => set_value('networkAddress1'),
                                        'class'       => 'field form-control',
                                        'placeholder' => 'Enter address line(s).',
                                        'required'  =>'required'
                                           );
                                        echo form_input($data);
                                        ?>
                                        <span class="iconSpan glyphicon glyphicon-tag form-control-feedback"></span> 
                                   </div>                   
                                </div>

                                <div class="form-group  has-feedback has-feedback-left ">	    
                                   <label for="networkAddress2" class="col-sm-3 control-label">Address Line 2</label>
                                   <div class="col-sm-9">
                                        <?php
                                          $data = array(
                                        'name'        => 'networkAddress1',
                                        'id'          => 'networkAddress1',
                                        'value'       => set_value('networkAddress1'),
                                        'class'       => 'field form-control',
                                           );
                                        echo form_input($data);
                                        ?>
                                        <span class="iconSpan glyphicon glyphicon-option-horizontal form-control-feedback"></span> 
                                   </div>                   
                                </div>



                                <div class="form-group  has-feedback has-feedback-left ">	    
                                   <label for="networkAddress3" class="col-sm-3 control-label">Address Line 3</label>
                                   <div class="col-sm-9">
                                        <?php
                                          $data = array(
                                        'name'        => 'networkAddress3',
                                        'id'          => 'networkAddress3',
                                        'value'       => set_value('networkAddress3'),
                                        'class'       => 'field form-control',
                                           );
                                        echo form_input($data);
                                        ?>
                                        <span class="iconSpan glyphicon glyphicon-option-horizontal form-control-feedback"></span> 
                                   </div>                   
                                </div>

                                <div class="form-group  has-feedback has-feedback-left  required">	    
                                   <label for="networkPostalCode" class="col-sm-3 control-label">Postal Code</label>
                                   <div class="col-sm-9">
                                        <?php
                                          $data = array(
                                        'name'        => 'networkPostalCode',
                                        'id'          => 'networkPostalCode',
                                        'value'       => set_value('networkPostalCode'),
                                        'class'       => 'field form-control',
                                        'placeholder' => 'Enter postal code.',
                                        'required'  =>'required'
                                           );
                                        echo form_input($data);
                                        ?>
                                        <span class="iconSpan glyphicon glyphicon-option-horizontal form-control-feedback"></span> 
                                   </div>                   
                                </div>


                                <div class="form-group  has-feedback has-feedback-left  required">	    
                                   <label for="networkCity" class="col-sm-3 control-label">City</label>
                                   <div class="col-sm-9">
                                        <?php
                                          $data = array(
                                        'name'        => 'networkCity',
                                        'id'          => 'networkCity',
                                        'value'       => set_value('networkCity'),
                                        'class'       => 'field form-control',
                                        'placeholder' => 'Enter city.',
                                        'required'  =>'required'
                                           );
                                        echo form_input($data);
                                        ?>
                                        <span class="form-control-feedback"><i class="icon icon-building icon-large"></i></span>
                                   </div>                   
                                </div>




                                        <div class="form-group has-feedback has-feedback-left required">	    
                                           <label for="networkEmail" class="col-sm-3 control-label">Email</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'networkEmail',
                                                'id'          => 'networkEmail',
                                                'value'       => set_value('networkEmail'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'Enter email of the network to add.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-envelope form-control-feedback"></span> 
                                           </div>                   
                                        </div>


                                        <div class="form-group has-feedback has-feedback-left">	    
                                           <label for="networkMobile" class="col-sm-3 control-label">Mobile</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'networkMobile',
                                                'id'          => 'networkMobile',
                                                'value'       => set_value('networkMobile'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'Enter email of the network to add.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-envelope form-control-feedback"></span> 
                                           </div>                   
                                        </div>



                                        <div class="form-group has-feedback has-feedback-left required">	    
                                           <label for="networkTelephone" class="col-sm-3 control-label">Telephone</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'networkTelephone',
                                                'id'          => 'networkTelephone',
                                                'value'       => set_value('networkTelephone'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'Enter telephone (fixed line) of the network.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-phone-alt form-control-feedback"></span> 
                                           </div>                   
                                        </div>

                                        <div class="form-group has-feedback has-feedback-left required">	    
                                           <label for="networkContact" class="col-sm-3 control-label">Contact Person</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'networkContact',
                                                'id'          => 'networkContact',
                                                'value'       => set_value('networkContact'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'Enter name of the contact person of the network.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-user form-control-feedback"></span> 
                                           </div>                   
                                        </div>

                                        <div class="form-group has-feedback has-feedback-left">	    
                                           <label for="networkWebAddress" class="col-sm-3 control-label">Website Address</label>
                                           <div class="col-sm-9">
                                                <?php
                                                  $data = array(
                                                'name'        => 'networkWebAddress',
                                                'id'          => 'networkWebAddress',
                                                'value'       => set_value('networkWebAddress'),
                                                'class'       => 'form-control field',
                                                'placeholder' => 'Enter webiste address of the  network.',
                                                'list'  	=>'json-datalist'
                                                  );
                                                echo form_input($data);
                                                ?>
                                                <span class="iconSpan glyphicon glyphicon-user form-control-feedback"></span> 
                                           </div>                   
                                        </div>

                                </div><?php // END  Network  Container ?>



                                <div class="text-center" style="margin-bottom:1px; background-color:#696666;color:white;padding:1px;">
                                </div>


                                <?php // Register / Submit Buttons  =========================================================================== 
                                // ===========================================================================================================	?>

                                <br>

                                <div class="form-group text-center">	    
                                   <label for="mobile" class="col-sm-3 control-label"></label>
                                   <div class="col-sm-9">
                                         <button id="faSelfRegister" name="faSelfRegister" class="btn btn-primary-2"  value="Add">Register Now...</button>
                                   </div>                   
                                </div>

                        <?php echo form_close()?>

                </div><!-- content -->
        </div><!-- col md 12-->
		
		
		
		
		
		
	
		
		
		
    </div> <!-- end row-->
    
</div><!-- end content-->





<?php 
/*
TODO:

1. Set display:none; to network and firm divs
2. empty network and then new firm name will not popup the div showing new fields to add fix this.
3. 


<span style="width:30px; height:30px;" class="form-control-feedback"    >
	<img id="home" src="<?php echo base_url('images/icons/empty.png')?>" style="width:20px;height:20px;background: url(<?php echo base_url('images/icons/icons.png')?>) 0 0;">
</span>


*/



?>

