

<a class="btn btn-primary pull-right" href="<?php echo base_url("product/create")?>">ADD</a>
<br/> <br/>
<table id="example2" class="table table-bordered table-hover">
    <thead>
    
                       <tr>
                          
                          <th>Name</th>
                          <th>active</th>
                          <th>Type</th>
                           <th>Provider</th>
                          <th>Actions</th>
                      </tr>
                  
    </thead>
  
    <tfoot>
    <tr>
                         
                          <th>Name</th>
                          <th>active</th>
                          <th>Type</th>
                           <th>Provider</th>
                          <th>Actions</th>
                      </tr>
    </tfoot>
     <tbody>
        <?php
       // print_r($products);
        if(empty($products)): ?>
        <tr>
            <td colspan="5">There are no products to display</td>
        </tr>
        <?php endif;?>
        
        <?php if(!empty($products)): ?>
        <?php foreach($products as $row):?>
        <tr>
                                 
                                  <td><?php echo $row->name; ?></td>
                                  <td><?php echo $row->active; ?></td>
                                  <td><?php echo $row->type_name; ?></td>
                                  <td><?php echo $row->productProviderName; ?></td>
                                 
           <td>
                <a class="btn btn-primary btn-xs" href="<?php  echo base_url('product/'.$row->productID.'/view') ?>" title="View Product Overview">
                   <i class="fa fa-eye"></i> <span></span> 
               </a>
               
               <a class="btn btn-primary btn-xs" href="<?php  echo base_url('product/'.$row->productID.'/update') ?>" title="Edit Product">
                   <i class="fa fa-pencil"></i> <span></span>
               </a>
              
               
               <a class="btn btn-primary btn-xs" href="<?php  echo base_url('product/'.$row->productID.'/delete') ?>" title="Delete Product">
                   <i class="fa fa-trash"></i> <span></span> 
               </a>
              
               
          </td>
        </tr>
         <?php endforeach;?>
        <?php endif;?>
    </tbody>
  </table>