

<a class="btn btn-primary pull-right" href="<?php echo base_url("product/provider/create")?>">ADD</a>
<br/> <br/>
<table id="example2" class="table table-bordered table-hover">
    <thead>
    
                       <tr>
                        
                          <th>Provider Name</th>
                          <th>AddressLine1</th>
                          <th>AddressLine2</th>
                          <th>AddressLine3</th>
                          <th>City</th>
                          <th>Postcode</th>
                          <th>Email</th>
                          <th>Telephone</th>
                          <th>Actions</th>
                      </tr>
                  
    </thead>
  
    <tfoot>
    <tr>
                        
                           <th>Provider Name</th>
                          <th>AddressLine1</th>
                          <th>AddressLine2</th>
                          <th>AddressLine3</th>
                          <th>City</th>
                          <th>Postcode</th>
                          <th>Email</th>
                          <th>Telephone</th>
                          <th>Actions</th>
                      </tr>
    </tfoot>
     <tbody>
        <?php
         //print_r($product_provider);
        if(empty($product_provider)): ?>
        <tr>
            <td colspan="5">There are no product type to display</td>
        </tr>
        <?php endif;?>
        
        <?php if(!empty($product_provider)): ?>
        <?php foreach($product_provider as $row):?>
        <tr>
                                 
                                  <td><?php echo $row->productProviderName; ?></td>
                                  <td><?php echo $row->productProviderAddressLine1; ?></td>
                                  <td><?php echo $row->productProviderAddressLine2; ?></td>
                                  <td><?php echo $row->productProviderAddressLine3; ?></td>
                                  <td><?php echo $row->productProviderCity; ?></td>
                                  <td><?php echo $row->productProviderPostcode; ?></td>
                                  <td><?php echo $row->productProviderEmail; ?></td>
                                  <td><?php echo $row->productProviderTel; ?></td>
           <td>
                
               
               <a class="btn btn-primary btn-xs" href="<?php  echo base_url('product/provider/'.$row->productProviderID.'/view') ?>" title="View Product Provider">
                   <i class="fa fa-eye"></i> <span></span> 
               </a>
               <a class="btn btn-primary btn-xs" href="<?php  echo base_url('product/provider/'.$row->productProviderID.'/update') ?>" title="Edit Product Provider">
                   <i class="fa fa-pencil"></i> <span></span>
               </a>
              
               
               <a class="btn btn-primary btn-xs" href="<?php  echo base_url('product/provider/'.$row->productProviderID.'/delete') ?>" title="Delete Product Provider">
                   <i class="fa fa-trash"></i> <span></span> 
               </a>
              
               
          </td>
        </tr>
         <?php endforeach;?>
        <?php endif;?>
    </tbody>
  </table>