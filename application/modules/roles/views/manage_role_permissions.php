<div>
<!--    <pre> <?php //print_r($is_checked)?></pre>-->
    <div id="feedback_msg"></div>
  <?php if(!empty($modules) &&(!empty($role))):?>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th></th>
                    <th>Choose Module</th>
                    <th>Choose Permission/s</th>
                </tr>
            </thead>
        </table>
            <?php $sn = 1;?>
            <?php foreach($modules as $key=>$module):?>
        
                <?php echo form_open(base_url('roles/'.$role->roleID.'/module/'.$module->moduleID.'/update-permissions'),"onSubmit='return manageRolePermForm({$module->moduleID})' id='formID_$module->moduleID'")?>
        
                <?php ?>
        
                <table class="table table-responsive">
                        
                    <tr>
                        <td><input type="checkbox" name="moduleID" value="<?php echo $module->moduleID ?>" <?php echo (key_exists($module->moduleID, $is_checked)? "checked":'') ?> /></td>
                        <td><?php echo $module->moduleName?></td>
                        <td>
                            <?php if(!empty($permissions)): ?>
                            <ul class="list list-inline">
                                <?php foreach($permissions as $key=>$permission): ?>  
                                <li>
                                    <?php $selectedModulePerms = (!empty($is_checked[$module->moduleID]) ?$is_checked[$module->moduleID] : array()) ;?>
                                     <input type="checkbox" name="permID[]" value="<?php echo $permission->permID ?>"
                                            <?php echo (key_exists($permission->permID, $selectedModulePerms)? "checked":'') ?>/> 
                                         <?php echo $permission->permName ?>
                                </li>

                                <?php endforeach;?>
                            </ul>

                            <?php endif;?>
                        </td>
                        
                        <td> <input type="submit" value="Update" name="UpdateRolePerm"/> 
                            <input type="hidden" value="Update" name="UpdateRolePerm"/> 
               
                            <input type="hidden" name="tkn" value="<?php echo $this->session->userdata('Ajax_token'); ?>"/>
                        </td>
                    </tr>
                </table>
        
        
                <?php echo form_close()?>
                <?php //break;?>
            <?php endforeach;?>
                     
            <?php endif; ?>
    
 
</div>


<!--       Modal content-->
<!--      <div class="modal-content">
             <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Manage Permissions for <?php echo ($role ? $role->roleName : '')?></h4>
          </div>


            <div class="modal-body">

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
      </div>-->