  <?php $include_investment = ($this->input->post('include_investment') ? (int)$this->input->post('include_investment') : 1 )?>

<div class="container-fluid" style="">



        <div class="col-md-7 col-md-offset-0">

         <?php echo form_open_multipart('', array('class'=>"reg-form"))?>
         <h3>Upload Portfolio Valuation</h3>

         <?php if(isset($errorMessage) && !empty($errorMessage)):?>
         <div class="alert alert-danger " style="max-height: 120px; overflow-y: auto">
                 <?php foreach($errorMessage as $k=>$error):?>
                     <p class=""><?php echo $error ?></p>
                 <?php endforeach;?>   
             </div>
         <?php endif; ?>


         <?php if(validation_errors()):?>
         
             <div class="alert alert-danger ">
                <?php echo validation_errors('<p>','</p>')?> 
             </div>
         <?php endif; ?>


         <p class="form-group"><span class="red-notice">The fields marked * are required</span></p>
         <p>Your csv columns MUST in this form:</p>
         <div class="form-group">
             <table class="table col-80">
                 <tr>
                     <th>Client Code </th>
                     <th>Valuation Date</th>
                     <th>Portfolio Value</th>
                     <th>Price Ccy</th>
                 </tr>
                 <tr>
                     <td>xyz</td>
                     <td>date of valuation</td>
                     <td>value excluding currency sign</td>
                     <td>GBP</td>
                 </tr>

             </table>
         </div>

         <div class="form-group">
             <input type="hidden" name="file_ref2" value="1"/>
         </div>

          <div class="form-group">
             <?php echo form_label('Upload', 'upload_Val') ?>
              <input type="file" name="upload_pVal" style="display: inline-block"/>
              <span class="alert-danger"> <?php echo form_error('upload_pVal');?></span>
         </div>




         <!-- client investment-->
         <div class="form-group">
             <?php echo form_label("Please un-check if you don't want to upload memebers' investment " , 'upload_pVal') ?>
             <input type="checkbox" name="include_investment" value="1" <?php echo ($include_investment == 1? "checked": '') ?>/>               
         </div>


         <div class="">          

             <h3>upload client investment</h3>


             <p>Your csv columns MUST in this form:</p>
             <div class="form-group">
                 <table class="table col-80">
                     <tr>

                         <th>Reference</th>
                         <th>Member</th>
                         <th>Amount</th>
                         <th>Valuation Date</th>
                     </tr>
                     <tr>
                         <td>xyz</td>
                         <td>first name and last name</td>
                         <td>amount excluding currency sign</td>
                         <td>this date MUST match the last portfolio valuation date</td>
                     </tr>

                 </table>

             </div>


              <div class="form-group">
                 <?php echo form_label('Upload', 'upload_cInvst') ?>
                  <input type="file" name="upload_cInvst" style="display: inline-block"/>
                  <span class="alert-danger"> <?php echo form_error('upload_cInvst');?></span>
             </div>       
         </div>








         <div class="form-group">
             <p class="pull-right">
             <?php echo form_submit('upload_valuation', 'Upload','class="btn btn-primary-2"')?>
             </p>
         </div>

        <?php echo form_close()?>


     </div>


</div>