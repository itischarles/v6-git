
<div class="container-fluid">
   
     <div class="col-md-6">    
 

         <?php echo form_open(base_url('unitisation/portfolio/new'), array('class'=>"form form-horizontal"))?>
        
         <?php if(validation_errors()):?>
        <div class="aler alert-danger">
            <?php echo validation_errors('<p>','</p>');?>
        </div>
            <?php endif;?>
        
        <h3>Portfolio Details</h3>
    
        <p class="form-group"><span class="red-notice">The fields marked * are required</span></p>
     
        <div class="form-group">
            
            <label for="reference" class="col-sm-2 control-label">Reference</label>
              <div class="col-sm-10">
            <?php
              $data = array(
                'name'        => 'reference',
                'id'          => 'reference',
                'value'       => set_value('reference', (!empty($portfolio)) ? $portfolio->portfolioReference : ''),
                'class'       => 'field',
                'required'  =>'required'
               );

            echo form_input($data);
            ?>  
              </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10">
            <?php
              $data = array(
                'name'        => 'name',
                'id'          => 'name',
                'value'       => set_value('name', (!empty($portfolio)) ? $portfolio->portfolioName : ''),
                'class'       => 'field',
                'required'  =>'required'
               );

            echo form_input($data);
            ?>  
              </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 control-label"></label>
              <div class="col-sm-10">
            <p>
            <?php 
                if($mode == "New"):
                    echo form_submit('add_portfolio', "Add", 'class="btn btn-primary-2"');
                elseif($mode == "Edit"):
                    echo form_submit('edit_portfolio', "Update", 'class="btn btn-primary-2"');
                   //echo anchor(base_url('client/view/'.$client->clientUrl), "Cancel", 'class="btn btn-primary"');
                endif;


             ?>
            </p>
              </div>
        </div>

<?php echo form_close()?>


   </div>
    
    <!-- end add need portfolio-->
    

    
    
    <!--- UPLOAD PORTFOLIOS--->
    <div class="col-md-6">    

           <div class="">
           
             <?php echo form_open(base_url('unitisation/portfolio/upload'), array('class'=>"form form-horizontal"))?>
            <h3>upload csv to create new portfolios</h3>
            
            <?php if(isset($errorMessage) && !empty($errorMessage)):?>
            <div class="alert-danger alert">
                <?php foreach ($errorMessage as $key=>$msg): ?>
                     <p class=""><?php echo $db_error ?></p>
                <?php  endforeach;?>
            </div>               
            <?php endif; ?>
   
             

            <p class="form-group"><span class="red-notice">The fields marked * are required</span></p>
	    <p>Your csv columns MUST in this form:</p>
	    <div class="form-group">
		<table class="table col-50">
		    <tr>
			<th>reference</th>
			<th>name</th>
		    </tr>
		    <tr>
			<td>xyz(required)</td>
			<td>portfolio name (optional)</td>
		    </tr>
		</table>
		
                <p>
                    The system will ignore any record without entry for Account Number and duplicate account numbers will not be processed
                </p>
            </div>

            <div class="form-group">
                <input type="hidden" name="file_ref2" value="1"/>
                 <span class="alert-danger"> <?php echo form_error('file_ref2');?></span>
            </div>
	    
             <div class="form-group">
                <?php echo form_label('Upload', 'upload_p') ?>
                 <input type="file" name="upload_p" style="display: inline-block"/>
                 <span class="alert-danger"> <?php echo form_error('upload_p');?></span>
            </div>
            
            
            <div class="form-group">
                <?php echo form_submit('upload_portfolios', 'Upload','class="btn btn-primary-2"')?>
            </div>
            
           <?php echo form_close()?>
         
        
        </div>

   </div>    
    <!--- END UPLOAD--->
    
    
    
    
</div>
