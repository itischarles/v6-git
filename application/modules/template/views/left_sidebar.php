  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel" style="display: none">
        <div class="pull-left image">
          <img src="<?php echo base_url() ?>user_profile/0/user0-160x160.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $userprofile_name ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      
      
      <!-- search form -->
      <!--
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      
     <?php if(isset($sidebar_view)):
         $this->load->view($sidebar_view);
     endif; ?>
      
      
      <!-- user speciffic sidebar-->
      <?php $this->load->view('template/user-sidebar'); ?>
      
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->