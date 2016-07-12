<script>
        var sMod ='ListAdvisers';
        
</script>

<?php if(validation_errors()):?>
    <div class="aler alert-danger">
        <?php echo validation_errors('<p>','</p>');?>
    </div>
<?php endif;?>
   
    <table id="example2" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th></th>
        <th>Reference</th>
        <th>Adviser Name</th>
        <th>Normal</th>
        <th>Para</th>
        <th>Super</th>
        <th>Email</th>
        <th>Actions</th>
       
      </tr>
      </thead>
    
      <tfoot>
      <tr>
         <th></th> 
         <th>Reference</th>
        <th>Adviser Name</th>
        <th>Normal</th>
        <th>Para</th>
        <th>Super</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
      </tfoot>
      
      
      <tbody>
          
          <?php if(empty($advisers)){ ?>
          <tr>
              <td>There are no Advisers to display</td>
          </tr>
          <?php } ?>
          
          <?php if(!empty($advisers)){ ?>
          <?php foreach($advisers as $key=>$adviser) { ?>
          <tr>
                <td><i class='fa fa-star'></i></td>
                <td><?php echo $adviser->individualFcaNumber ?></td>
                <td><?php echo $adviser->user_fname . '. ' . ucwords($adviser->user_lname) ?></td>
                
                <td><?php //echo $adviser-> ?></td>
                <td><?php //echo $adviser-> ?></td>
                <td><?php //echo $adviser-> ?></td>
                
                
                <td><?php echo $adviser->user_username ?></td>
                <td>
                   
                   <div style="display:block;margin:auto;">
                        
                        <a href="<?php  echo  base_url('adviser/edit/' . $adviser->ifaCode ) ?>" title="Edit Adviser">
                                &nbsp;<i class='fa fa-pencil' style="color: #292;"></i>
                        </a>

                        <?php if(false){ ?>
                            <a href="<?php  echo base_url('adviser/deactivate/' . $adviser->ifaCode ) ?>" title="Re-Activate Adviser">
                                &nbsp;<i class='fa fa-battery-empty'></i>
                            </a>

                        <?php } else{ ?>
                            <a href="<?php  echo base_url('adviser/reactivate/' .  $adviser->ifaCode  ) ?>" title="Deactivate Adviser">
                                &nbsp;<i class="fa fa-battery-full"></i>
                           </a>
                        <?php } ?>
                   </div>
                  
                </td>
                
                
          </tr>
          <?php } ?>
          <?php } ?>
          
        
      </tbody>
    </table>
