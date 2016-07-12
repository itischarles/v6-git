<?php //print_r($client);?> 
  <?php if(isset($client->clientUrl)):?>

<ul class="sidebar-menu">
    <li class="header">Page Menu</li>          

  
    
    <li><a href="<?php echo base_url('client/'.$client->clientUrl."/view") ?>"><i class="fa fa-home"></i> <span>Client's Dashboard</span></a></li>
  
    <li><a href="#"><i class="fa fa-book"></i> <span>Invoices</span></a></li>
    <li><a href="#"><i class="fa fa-book"></i> <span>Portfolios</span></a></li>
<!--   <li><a href="<?php //echo base_url('client/'.$client->clientUrl.'/applications') ?>"><i class="fa fa-book"></i> <span>Applications</span></a></li>
   <li><a href="<?php //echo base_url('client/'.$client->clientUrl.'/applications') ?>"><i class="fa fa-book"></i> <span>Illustrations</span></a></li>
   -->
  
    <li><a href="#"><i class="fa fa-envelope"></i> <span>Messages</span></a></li>

    <li><a href="<?php echo base_url('client/'.$client->clientUrl.'/update') ?>"><i class="fa fa-edit"></i> Edit Details</a></li>
    
  </ul>

 <?php endif;?>