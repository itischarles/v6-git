<div class="row">
    <div class="col-md-6">
      <!-- Invoice CHART -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Roles</h3>

          <div class="box-tools pull-right fa-us">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="" style="height:250px">
              
              <?php if(!empty($roles)):?>
              <table class="table table-responsive">
                 <thead>
                    <tr>
                        <th>S/n</th>
                        <th>Role Name</th>
                        <th>Action</th>
                    </tr>
                </thead> 
                  
                  
                  <?php $sn = 1;?>
                  <?php foreach($roles as $key=>$role):?>
                  <tr>
                      <td><?php echo $sn?></td>
                      <td><?php echo $role->roleName?></td>
                      <td>
                          <a href="<?php echo base_url('roles/'.$role->roleID.'/permisssions')?>" class="manageRolesPermissions ls-modal">
                              Manage Permissions
                          </a>
                      </td>
                    
                    
                  </tr>
                  <?php $sn++?>
                  <?php endforeach;?>
              </table>              
              <?php endif; ?>
              
              
              <h5>Add New Role/Group</h5>
              <?php $this->load->view('roles/roles_form') ?>
       
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

          
          
          <!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Permissions</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
                
                  <div class="" style="height:250px">              
                    <?php echo Modules::run('roles/Permissions/listAllPermissions_widget') ?>
                </div>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col (LEFT) -->
        
        
        
        <div class="col-md-6">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Define Permission for Roles</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
               <div class="" style="height:250px">              
                    <?php echo Modules::run('roles/Auth_modules/listAllModules_widget') ?>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Avaliable Modules</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                 <div class="" style="height:250px">              
                    <?php echo Modules::run('roles/Auth_modules/listAllModules_widget') ?>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col (RIGHT) -->
      </div>
      <!-- /.row -->
      
      
      
      
      
<!--     Modal -->
  <div class="modal fade" id="manageRolesPermissions" role="dialog">
    <div class="modal-dialog">
    
<!--       Modal content-->
      <div class="modal-content">
             <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Manage Permissions for <?php echo ($role ? $role->roleName : '')?></h4>
          </div>


            <div class="modal-body">
                    hello paaaa
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
      </div>
      
    </div>
  </div>  
    
  


      
      
      
      
      
      


