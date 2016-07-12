
<?php 
$auth_lib = new Auth_lib();


$user_fname = ($user->user_fname ? $user->user_fname : ''); 
$user_lname = ($user->user_lname ? $user->user_lname : ''); 
$user_username = ($user->user_username ? $user->user_username : ''); 
$user_userLink = ($user->user_userLink ? $user->user_userLink : ''); 
$user_regDate = ($user->user_fname ? $user->user_regDate : ''); 
$user_title = ($user->user_fname ? $user->user_title : ''); 
$user_aboutMe = ($user->user_aboutMe ? $user->user_aboutMe : ''); 
//$user_photo_128 = $user->user_photo_128;

$user_photo_128 = 'user_profile/0/user0-128x128.png';
?>


    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url().$user_photo_128 ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo ucwords($user_fname." ".$user_lname) ?></h3>

             
              <div class="text-muted text-center">
              <?php echo Modules::run('roles/Auth_user_role/displayUserRoles_widget',$user->userID ) ?>
              </div>
              

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>User Since:</b> <a class="pull-right"> <?php echo changeDateFormat($user_regDate, "jS M. Y") ?></a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right"><?php echo $user_username ?></a>
                </li>
                
              </ul>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
<!--              <strong><i class="fa fa-book margin-r-5"></i> Education</strong>-->

              <p class="text-muted">
                  <?php echo $user_aboutMe?>
              </p>

<!--              <hr>-->

              <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>

<!--              <p class="text-muted">Malibu, California</p>-->

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>

              <li><a href="#settings" data-toggle="tab">Update Profile</a></li>
              
              <?php if($auth_lib->is_superAdmin()):?>
                    <li><a href="#userRole" data-toggle="tab">Update Roles</a></li>
              <?php endif;?>
              
              
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                
                   <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">You</a> sent an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-user bg-aqua"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                      <h3 class="timeline-header no-border"><a href="#">You</a> did something
                      </h3>
                    </div>
                  </li>
                  <!-- END timeline item -->
             
                  
                
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>

              </div>
                
                
      

              
              
              <div class="tab-pane" id="settings">              
                  <?php echo Modules::run("user/profile_form_widget", $user->user_userLink) ?>                
              </div>
                
                
              <div class="tab-pane" id="userRole">  
                 
                  <?php echo Modules::run("roles/Auth_user_role/addRolesToUser_widget", $user->userID) ?>                
              </div>
                
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
 