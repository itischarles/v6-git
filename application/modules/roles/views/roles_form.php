  <?php if(isset($func_responses['roles_func'])):?>
        <div class="alert <?php echo $func_responses['roles_func']['type'] ?>" id="">
                <?php  echo $func_responses['roles_func']['message'] ;?>             
        </div>
     <?php endif;?>
    
     
    <form class="form-horizontal" method="post" action="">
        
      
        <div class="form-group">
          <label for="roleName" class="col-sm-3 control-label-">Role Name</label>

          <div class="col-sm-9">
              <input type="text" class="form-control" id="roleName" placeholder="Enter Role Name" name="roleName" value="<?php  ?>">
          </div>
        </div>
         

        <div class="form-group">
           <input type="hidden" name="tkn" value="<?php echo $this->session->userdata('Ajax_token'); ?>"/>
          <input type="submit" name="addRole" value="Submit" class="btn btn-danger pull-right"/>
 
        </div>
      </form>