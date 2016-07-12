<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="container-fluid">


        <?php echo form_open('', array('class'=>"form form-horizontal"))?>
       
        <?php if(validation_errors()):?>
        <div class="aler alert-danger">
            <?php echo validation_errors('<p>','</p>');?>
        </div>
            <?php endif;?>

        
    <!-- start LEFT COLUMN-->
    <div class="col-md-6">
         <h3>Personal    Details</h3>

        <p class="form-group"><span class="red-notice">The fields marked * are required</span></p>

            <div class="form-group required_field">
                <label for="client_reference" class="col-sm-3 control-label">Client's Reference</label>
                <?php //echo form_label("Client's Reference", 'client_reference','class="hh"') ?>
                <div class="col-sm-9">
                <?php
                  $data = array(
                    'name'        => 'client_reference',
                    'id'          => 'client_reference',
                    'value'       => set_value('client_reference', (!empty($client)) ? $client->client_reference : ''),
                    'class'       => 'field  form-control',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>  
                </div>                 
            </div>

            <div class="form-group required_field">
             <label for="client_title" class="col-sm-3 control-label">Title</label>
             <div class="col-sm-9">
                <?php $titleName = (isset($client) ? $client->title : '')?>
                 <?php echo Modules::run('titles/display_title_widget_select',$titleName);?>
             </div>
            </div>




            <div class="form-group">
                <label for="client_fname" class="col-sm-3 control-label">First Name</label>
                <div class="col-sm-9">
                <?php
                  $data = array(
                    'name'        => 'client_fname',
                    'id'          => 'client_fname',
                    'value'       => set_value('client_fname', (!empty($client)) ? $client->client_fname : ''),
                    'class'       => 'field  form-control',
                    'required'  =>'required'
                   );

                echo form_input($data);
               
                ?>
                </div>
            </div>
        
        
            <div class="form-group">
                <label for="client_lname" class="col-sm-3 control-label">Last Name</label>
                <div class="col-sm-9">
                <?php
                  $data = array(
                    'name'        => 'client_lname',
                    'id'          => 'client_lname',
                    'value'       => set_value('client_lname', (!empty($client)) ? $client->client_lname : ''),
                    'class'       => 'field  form-control',
                      'required'  =>'required'
                   );

                echo form_input($data);
                ?>
                </div>
            </div>

            <div class="form-group">
                <label for="client_email" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                <?php
                  $data = array(
                    'name'        => 'client_email',
                    'id'          => 'client_email',
                    'value'       => set_value('client_email', (!empty($client)) ? $client->client_email : ''),
                    'class'       => 'field  form-control',
                      'required'  =>'required'
                   );

                echo form_input($data);
                ?>
                </div>
            </div>

             <div class="form-group">
                 <label for="client_address_1" class="col-sm-3 control-label">Address Line 1</label>
               <div class="col-sm-9">
                <?php
                  $data = array(
                    'name'        => 'client_address_1',
                    'id'          => 'client_address_1',
                    'value'       => set_value('client_address_1', (!empty($client)) ? $client->client_address_1 : ''),
                    'class'       => 'field  form-control',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
               </div>
            </div>


             <div class="form-group">
                 <label for="client_address_2" class="col-sm-3 control-label">Address Line 2</label>
               <div class="col-sm-9">
                <?php
                  $data = array(
                    'name'        => 'client_address_2',
                    'id'          => 'client_address_2',
                    'value'       => set_value('client_address_2', (!empty($client)) ? $client->client_address_2 : ''),
                    'class'       => 'field form-control'
                   );

                echo form_input($data);
                ?>
               </div>
            </div>



            <div class="form-group">
                <label for="client_address_3" class="col-sm-3 control-label">Address Line 3</label>
              <div class="col-sm-9">
                <?php
                  $data = array(
                    'name'        => 'client_address_3',
                    'id'          => 'client_address_3',
                    'value'       => set_value('client_address_3', (!empty($client)) ? $client->client_address_3 : ''),
                    'class'       => 'field form-control'
                   );

                echo form_input($data);
                ?>
              </div>
            </div>

             <div class="form-group">
                 <label for="client_town" class="col-sm-3 control-label">Town</label>
               <div class="col-sm-9">
                <?php
                  $data = array(
                    'name'        => 'client_town',
                    'id'          => 'client_town',
                    'value'       => set_value('client_town', (!empty($client)) ? $client->client_town : ''),
                    'class'       => 'field  form-control',
                    'required'  =>'required'
                   );

                echo form_input($data);
                ?>
               </div>
            </div>

             <div class="form-group">
                 <label for="client_county" class="col-sm-3 control-label">County</label>
               <div class="col-sm-9">
                <?php
                  $data = array(
                    'name'        => 'client_county',
                    'id'          => 'client_county',
                    'value'       => set_value('client_county', (!empty($client)) ? $client->client_county : ''),
                    'class'       => 'field form-control'
                   );

                echo form_input($data);
                ?>
               </div>
            </div>


             <div class="form-group"> 
                 <label for="client_postcode" class="col-sm-3 control-label">Postcode</label>
                 <div class="col-sm-9">
                <?php
                  $data = array(
                    'name'        => 'client_postcode',
                    'id'          => 'client_postcode',
                    'value'       => set_value('client_postcode', (!empty($client)) ? $client->client_postcode : ''),
                    'class'       => 'field  form-control',
                   'required'  =>'required'
                   );

                echo form_input($data);
                ?>
                </div>
            </div>

        
            <div class="form-group ">
                <label for="countryAlpha2" class="col-sm-3 control-label">Country of Residence</label>
                <div class="col-sm-9">
                 <?php $countryAlpha2 = (isset($client) ? $client->countryAlpha2 : 'gb')?>

                <?php echo Modules::run('countries/display_country_widget_select', $countryAlpha2) ?>
                </div>
            </div>


            <div class="form-group">
                <p>
                <?php 
                    if($mode == "New"):
                        echo form_submit('add_client', "Add Client", 'class="btn btn-primary-2"');
                    elseif($mode == "Edit"):
                        echo form_submit('edit_client', "Update Client", 'class="btn btn-primary-2"');
                       echo anchor(base_url('client/view/'.$client->clientUrl), "Cancel", 'class="btn btn-primary-2"');
                    endif;


                 ?>
                </p>
                <br/>
            </div>

    </div>
    <!-- END LEFT COUMN-->
    
    
    
    <!-- START RIGHT COUMN-->
    <div class="col-md-6">
        
        <h3>Other Details</h3>
        
        <div class="form-group  required">	    
	     <label for="retirementAge" class="col-sm-3 control-label">Expected Retirement Age</label>
	     <div class="col-sm-9">
		  <?php
		    $data = array(
		      'name'        => 'retirementAge',
		      'id'          => 'retirementAge',
		      'value'       => set_value('retirementAge', (!empty($client)) ? $client->clientRetirementAge : ''),
		      'class'       => 'field form-control date_width',
		      'required'  =>'required'
		     );

		  echo form_input($data);
		  ?>
	     </div>                   
        </div>
        
        <div class="form-group  required">	    
	     <label for="marital_status" class="col-sm-3 control-label">Marital Status</label>
	     <?php $maritalStatus = (isset($client) ? $client->maritalStatus : '')?>
	     
	     <div class="col-sm-9">
		 <select name="marital_status">
		     <option>Please select</option>
		     <?php if(!empty($marital_status)):?>
			<?php foreach($marital_status as $key=>$ms):?>
		     
		     <option value="<?php echo $ms->maritalStatusID?>" <?php echo (($maritalStatusID==$ms->maritalStatusID)? "selected=''selected": '') ?>>
			 <?php echo $ms->maritalStatusName?>
		     </option>
			<?php endforeach; ?>
		     <?php endif;?>
		 </select>
		 
	     </div>                   
        </div>
        
        <div class="form-group  required">	    
	     <label for="gender" class="col-sm-3 control-label">Gender</label>
	     <?php $clientGender = (isset($client) ? $client->clientGender : '')?>
	     
	     <div class="col-sm-9">
		 <select name="gender">		    
		     <option value="F" <?php echo (($clientGender== "F")? "selected=''selected": '') ?>>Female</option>
		     <option value="M" <?php echo (($clientGender=="M")? "selected=''selected": '') ?>>Male</option>
		    
		 </select>
		 
	     </div>                   
        </div>
        
       <div class="form-group  required">	    
	    <label for="employmentType" class="col-sm-3 control-label">Employment Type </label>
	     <?php $employmentTypeCode = (isset($client) ? $client->employmentTypeCode : '')?>
	     
	     <div class="col-sm-9">
		 <select name="employmentType">
		    
		     <?php if(!empty($employmentTypes)):?>
			<?php foreach($employmentTypes as $key=>$employmentType):?>
		     
		     <option value="<?php echo $employmentType->employmentTypeCode?>" <?php echo (($employmentTypeCode==$employmentType->employmentTypeCode)? "selected=''selected": '') ?>>
			 <?php echo $employmentType->employmentTypeName?>
		     </option>
			<?php endforeach; ?>
		     <?php endif;?>
		 </select>
		 
	     </div>                   
        </div> 
        
        
        
        
        
        
        <h3>Personal Bank Details</h3>
          <div class="form-group">
              <label for="client_bank_number" class="col-sm-3 control-label">Bank Account Number</label>
              <div class="col-sm-9">
             <?php
               $data = array(
                 'name'        => 'client_bank_number',
                 'id'          => 'client_bank_number',
                 'value'       => set_value('client_bank_number', (!empty($client)) ? $client->client_bank_number : ''),
                 'class'       => 'field  form-control',
                 'maxlength'     =>8,
                 'size'        =>8,
                 'required'  =>'required'
                );

             echo form_input($data);
             ?>    
              </div>
         </div>

           <div class="form-group">
               <label for="client_bank_sortcode" class="col-sm-3 control-label">Bank Sortcode</label>
               <div class="col-sm-9">
             <?php
               $data = array(
                 'name'        => 'client_bank_sortcode',
                 'id'          => 'client_bank_sortcode',
                 'value'       => set_value('client_bank_sortcode', (!empty($client)) ? $client->client_bank_sortcode : ''),
                 'class'       => 'field  form-control',
                 'maxlength'        =>6,
                   'size'        =>8
                 //'required'  =>'required'
                );

             echo form_input($data);
             ?>    
               </div>
         </div>
           <div class="form-group">
              <label for="client_bank_balance" class="col-sm-3 control-label">Account Balance</label>
                <div class="col-sm-9">
             <?php
               $data = array(
                 'name'        => 'client_bank_balance',
                 'id'          => 'client_bank_balance',
                 'value'       => set_value('client_bank_balance', (!empty($client)) ? $client->client_bank_balance : '0.00'),
                 'class'       => 'field price_field',
                 'required'  =>'required',
                 'size'        =>8
                );

             echo form_input($data);
             ?>    
                </div>
         </div>

    </div>
    
    <!-- end RIGHT COLUMN-->
    
    
    <?php echo form_close()?>



</div>