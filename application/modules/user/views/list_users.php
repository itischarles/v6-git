
    <table id="example2" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th>Name</th>
        <th>Role</th>
        <th>Status</th>
        <th>Action</th>
       
      </tr>
      </thead>
    
      <tfoot>
      <tr>
         <th>Name</th>
        <th>Role</th>
        <th>Status</th>
         <th>Date Registered</th>
        <th>Action</th>
      </tr>
      </tfoot>
      
      
      <tbody>
          <?php if(empty($users)): ?>
          <tr>
              <td>There are no users to display</td>
          </tr>
          <?php endif;?>
          
          <?php if(!empty($users)): ?>
          <?php foreach($users as $key=>$user):?>
          <tr>
              <td><?php echo ucwords($user->user_fname." ".$user->user_lname) ?></td>
              <td><?php  //echo ucwords($user->user_fname." ".$user->user_lname) ?></td>
              <td><?php  echo writeStatus($user->user_isActive) ?></td>
              <td><?php  echo changeDateFormat($user->user_regDate) ?></td>
             <td>
                 <a href="<?php  echo base_url('user/'.$user->user_userLink) ?>" title="View User">
                     <i class="fa fa-eye"></i> <span></span> 
                 </a>
                 &nbsp;&nbsp;|&nbsp;&nbsp;
                 
                 <?php if($user->user_isActive == 1): ?>
                 <a href="<?php  echo base_url('user/'.$user->user_userLink) ?>/deactivate" title="Deactivate User">
                     <i class="fa fa-battery-empty"></i> <span></span> 
                 </a>
                 
                 <?php else:?>
                  <a href="<?php  echo base_url('user/'.$user->user_userLink) ?>/reactivate" title="Reactivate User">
                      &nbsp;<i class="fa fa-battery-full"></i> <span></span> 
                 </a>
                 <?php endif;?>
                 
                 </td>
          </tr>
           <?php endforeach;?>
          <?php endif;?>
      </tbody>
    </table>
