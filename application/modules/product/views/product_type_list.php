

<a class="btn btn-primary pull-right" href="<?php echo base_url("product/type/create")?>">ADD</a>
<br/> <br/>
<table id="example2" class="table table-bordered table-hover">
    <thead>
    
                       <tr>
                        
                          <th>Type Name</th>
                          <th>Default Growth Rate low</th>
                          <th>Default Growth Rate mid</th>
                          <th>Default Growth Rate high</th>
                          <th>Max Mid Growth Rate</th>
                          <th>Actions</th>
                      </tr>
                  
    </thead>
  
    <tfoot>
    <tr>
                          
                          <th>Type Name</th>
                          <th>Default Growth Rate low</th>
                          <th>Default Growth Rate mid</th>
                          <th>Default Growth Rate high</th>
                          <th>Max Mid Growth Rate</th>
                          <th>Actions</th>
                      </tr>
    </tfoot>
     <tbody>
        <?php
         // print_r($product_type);
        if(empty($product_type)): ?>
        <tr>
            <td colspan="5">There are no product type to display</td>
        </tr>
        <?php endif;?>
        
        <?php if(!empty($product_type)): ?>
        <?php foreach($product_type as $row):?>
        <tr>
                                 
                                  <td><?php echo $row->type_name; ?></td>
                                  <td><?php echo $row->default_growth_rate_low; ?></td>
                                  <td><?php echo $row->default_growth_rate_mid; ?></td>
                                  <td><?php echo $row->default_growth_rate_high; ?></td>
                                  <td><?php echo $row->max_mid_growth_rate; ?></td>
           <td>
                
               <a class="btn btn-primary btn-xs" href="<?php  echo base_url('product/type/'.$row->productTypeID.'/view') ?>" title="View Product Type">
                   <i class="fa fa-eye"></i> <span></span>
               </a>
               <a class="btn btn-primary btn-xs" href="<?php  echo base_url('product/type/'.$row->productTypeID.'/update') ?>" title="Edit Product Type">
                   <i class="fa fa-pencil"></i> <span></span>
               </a>
              
               
               <a class="btn btn-primary btn-xs" href="<?php  echo base_url('product/type/'.$row->productTypeID.'/delete') ?>" title="Delete Product Type">
                   <i class="fa fa-trash"></i> <span></span> 
               </a>
              
               
          </td>
        </tr>
         <?php endforeach;?>
        <?php endif;?>
    </tbody>
  </table>