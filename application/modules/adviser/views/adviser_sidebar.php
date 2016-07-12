<ul class="sidebar-menu">
    
    <li class="header">Clients</li>          

    <li class="treeview">
        <a href="<?php echo base_url('adviser/clients') ?>">
            <i class="fa fa-users"></i> <span>Clients</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('adviser/clients') ?>"><i class="fa fa-list-ul"></i> Clients</a></li>  
            <li><a href="<?php echo base_url('adviser/create-client') ?>"><i class="fa fa-user-plus"></i> Add New</a></li>
        </ul>
    </li>

    
    <?php if (isset($is_super)){ if($is_super){?>
     <li class="header">Manage Advisers</li>          

    <li class="treeview">
        <a href="<?php echo base_url('adviser/list-advisers') ?>">
            <i class="fa fa-users"></i> <span>Advisers</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('adviser/list-advisers') ?>"><i class="fa fa-list-ul"></i> Advisers</a></li>  
        </ul>
    </li>
    <?php }} ?>
    

</ul>


