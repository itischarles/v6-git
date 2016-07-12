<?php //display active link  
    $module = (isset($module) ? strtolower($module) :'');
?> 


<ul class="sidebar-menu">
    <li class="header">Account Menu</li>          

    <li><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> <span>Home</span></a></li>
    <li><a href="#"><i class="fa fa-book"></i> <span>Invoices</span></a></li>
  
    
     <li class="treeview <?php echo ($module == 'unitisation' ?'active':'')?>">
          <a href="<?php echo base_url('unitisation') ?>">
            <i class="fa fa-dashboard"></i> <span>Unitisation</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('unitisation/portfolio') ?>"><i class="fa fa-list-ul"></i> Portfolios</a></li>  
            <li><a href="<?php echo base_url('unitisation/portfolio/new') ?>"><i class="fa fa-plus-circle"></i> Add New Portfolio</a></li>
            <li><a href="<?php echo base_url('unitisation/portfolio/search') ?>"><i class="fa fa-search-plus"></i> Search Portfolio</a></li>
            <li><a href="<?php echo base_url('unitisation/valuation/upload') ?>"><i class="fa fa-upload"></i> Upload Valuation</a></li>
            
            <li><a href="<?php echo base_url('unitisation/reports') ?>"><i class="fa fa-line-chart"></i>Reports</a></li>
            
          </ul>
    </li>
    
    
     <li class="treeview <?php echo ($module == 'product' ?'active':'')?>">
          <a href="<?php echo base_url('product') ?>">
            <i class="fa fa-dashboard"></i> <span>Products</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('product') ?>"><i class="fa fa-list-ul"></i> Manage Products</a></li>  
            <li><a href="<?php echo base_url('product/type') ?>"><i class="fa fa-plus-circle"></i>Manage Product Types</a></li>
            <li><a href="<?php echo base_url('product/provider') ?>"><i class="fa fa-search-plus"></i> Manage Products Providers</a></li>
    
          </ul>
    </li>
    
    
     <li class="treeview <?php echo ($module == 'adviser' ?'active':'')?>">
          <a href="<?php echo base_url('adviser') ?>">
            <i class="fa fa-dashboard"></i> <span>IFAs</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('adviser') ?>"><i class="fa fa-list-ul"></i> Manage IFAs</a></li>  
<!--            <li><a href="<?php echo base_url('product/type') ?>"><i class="fa fa-plus-circle"></i>Manage Product Types</a></li>
            <li><a href="<?php echo base_url('product/provider') ?>"><i class="fa fa-search-plus"></i> Manage Products Providers</a></li>
    -->
          </ul>
    </li>
    
    
    
    <li><a href="<?php echo base_url('settings') ?>"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
    <li><a href="#"><i class="fa fa-envelope"></i> <span>Messages</span></a></li>

    <li class="treeview <?php echo ($module == 'user' ?'active':'')?>">
          <a href="<?php echo base_url('user/search') ?>">
            <i class="fa fa-users"></i> <span>Users</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('user/search') ?>"><i class="fa fa-list-ul"></i> Users</a></li>  
            <li><a href="<?php echo base_url('user/create') ?>"><i class="fa fa-user-plus"></i> Add New</a></li>
          </ul>
        </li>
        
     <li class="treeview <?php echo ($module == 'client' ?'active':'')?>">
          <a href="<?php echo base_url('client') ?>">
            <i class="fa fa-users"></i> <span>Clients</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('client/') ?>"><i class="fa fa-list-ul"></i> Clients</a></li>  
            <li><a href="<?php echo base_url('client/create') ?>"><i class="fa fa-user-plus"></i> Add New</a></li>
          </ul>
    </li>
  
  </ul>


