<div class="login-box ">

  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg login-title">Sign in </p>

    <?php echo form_open() ?>
    
    <?php if(validation_errors()):?>
    <div class="alert alert-danger"> <?php echo validation_errors('<p>','</p>') ?></div>
    <?php endif;?>
    
        <?php if(isset($login_error)):?>
            <p class="alert alert-danger"><?php echo $login_error?></p>
        <?php endif;?>
            
      <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Email" name="email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">

        <div class="col-xs-4">
            <button type="submit" class="btn btn-default btn-block btn-flat" name="login" value="Sign in">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    <?php echo form_close() ?>


   <hr/>
    <div class="row">
       
        <div class="col-sm-6"> 
                <p class="text-center"><a href="#">I forgot my password</a> </p>
        </div>
        <div class="col-sm-6"> 
            <p class="text-center"><a href="<?php echo base_url('adviser/register') ?>">Register if an IFA</a></p>
        </div>
      
    </div>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
