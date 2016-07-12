
<?php 
//echo "<pre>";

if(($mode == "edit")&&(!empty($user))){
   $user_fname = $user->user_fname; 
   $user_lname = $user->user_lname; 
   $user_username = $user->user_username; 
   $user_userLink = $user->user_userLink; 
   $user_regDate = $user->user_regDate; 
   $user_title = $user->user_title;
   $user_aboutMe = $user->user_aboutMe;
   
}else{
   $user_fname = $this->input->post('user_fname'); 
   $user_lname = $this->input->post('user_fname'); 
   $user_username = $this->input->post('user_username'); 
  $user_userLink = $this->input->post('user_userLink'); 
    $user_title = $this->input->post('user_title'); 
   //$user_regDate = $this->input->post('user_regDate');
}

?>

<div>
    
      <?php if($this->session->flashdata('validation_message')):
         if($this->session->flashdata('type') == "validation_success"):
            $class = "alert-success";
        else:
            $class = "alert-danger";
        endif;
    ?>
        <div class="alert <?php echo $class ?>" id="">
                <?php  echo $this->session->flashdata('validation_message') ;?>             
        </div>
     <?php endif;?>
    
    <?php if(validation_errors()):?>
        <div class="alert alert-danger" id="">
                <?php  echo validation_errors('<p>','</p>') ;?>             
        </div>
     <?php endif;?>
    
     
    <form class="form-horizontal" method="post" action="<?php echo base_url("user/update/$user_userLink") ?>">
        
        <div class="form-group">
          <label for="users_title" class="col-sm-2 control-label">Title</label>

          <div class="col-sm-10">
              <input type="radio" name="user_title" value="Mr" <?php echo (($user_title == 'Mr')? "checked": '') ?>/>Mr. &nbsp;
              <input type="radio" name="user_title" value="Mrs" <?php echo (($user_title == 'Mrs')? "checked":'') ?>/>Mrs. &nbsp;
              <input type="radio" name="user_title" value="Ms" <?php echo (($user_title == 'Ms')? "checked":'') ?>/>Ms.
<!--              <input type="text" class="form-control" id="inputName" placeholder="Name" name="fname" value="<?php echo $user_fname ?>">-->
          </div>
        </div>
        <div class="form-group">
          <label for="inputName" class="col-sm-2 control-label">First Name</label>

          <div class="col-sm-10">
              <input type="text" class="form-control" id="inputName" placeholder="Name" name="fname" value="<?php echo $user_fname ?>">
          </div>
        </div>
          <div class="form-group">
          <label for="inputName" class="col-sm-2 control-label">Last Name</label>

          <div class="col-sm-10">
              <input type="text" class="form-control" id="inputName" placeholder="Name" name="lname"  value="<?php echo $user_lname ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-2 control-label">Email/Username</label>

          <div class="col-sm-10">
              <input type="email" class="form-control" id="inputEmail" placeholder="Email" readonly="" value="<?php echo $user_username ?>">
          </div>
        </div>


        <div class="form-group">
          <label for="inputAboutMe" class="col-sm-2 control-label">About Me</label>

          <div class="col-sm-10">
              <textarea class="form-control" id="inputAboutMe" placeholder="something about me" name="user_aboutMe"><?php echo $user_aboutMe ?></textarea>
          </div>
        </div>

         <div class="form-group">
           <label for="password" class="col-sm-2 control-label"> 

           </label>
           <div class="col-sm-10">
              Please leave blank if you don't want to change password 
          </div>
         </div>
        <div class="form-group">
          <label for="password" class="col-sm-2 control-label">Password</label>

          <div class="col-sm-10">
              <input type="text" class="form-control" id="password" placeholder="password" name="password">
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <?php echo form_hidden('page', base_url().$this->uri->uri_string) ?>
              <input type="submit" name="edit_user" value="Submit" class="btn btn-danger"/>
             
          </div>
        </div>
      </form>
</div>