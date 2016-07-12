<?php

/* 
 * this widget will display all the available roles and will check/select the roles the given
 * user has alredy
 */?>
<?php 
// we are expecting to see the list of user's existing roles in object.
//lets build a regular array from users_roles object with roleID as key so we can easily do in_array comparison
if(!isset($user_roles)):
    $user_roles = array();
endif;

$userRoles = array();

if(!empty($user_roles)):
    foreach($user_roles as $key=>$user_role):
        $userRoles[] = $user_role->roleID;
    endforeach;
endif;

?>

<div id="updateUserRoles">
    <h5> Update User's Roles</h5>
    <?php if(!empty($roles)):?>
    
    <div id="feedback_msg"></div>
    
    <?php echo form_open(base_url('roles/user/'.$user->user_userLink.'/update-roles'),'class="form-horizontal"')?>
    <div class="form-group">
        <label for="usersRoles" class="col-sm-2 control-label">Select Roles</label>

        <div class="col-sm-10">
            <ul class="list list-unstyled">
                <?php foreach($roles as $key=>$role):?>
                    <li>
                        <?php $checked = (in_array($role->roleID, $userRoles) ? "checked" : '') ;?>
                        <input type="checkbox" name="roles[]" value="<?php echo $role->roleID ?>" <?php echo $checked ?>/>
                        <?php echo $role->roleName ?>
                    </li>
                 <?php endforeach;?>
            </ul>
        </div>
    </div>
    
    
     <div class="form-group">
        <label for="" class="col-sm-2 control-label"></label>

        <div class="col-sm-6">
            <input type="hidden" name="tkn" value="<?php echo $this->session->userdata('Ajax_token'); ?>"/>
            <input type="hidden" name="updateUserRoles" value="Update"/>
            <input type="submit" name="updateUserRoles" value="Update" class="pull-right"/>
        </div>
    </div>
    
    <?php echo form_close()?>
           
    <?php endif; ?>
</div>