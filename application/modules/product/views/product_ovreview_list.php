
<a class="pull-right btn btn-primary" href="<?php echo base_url('product')?>" >Product list Page</a>
<br>
<br>

<div class="">
<table id="example2" class="table table-bordered table-hover table-responsive">
  
  <tbody>
    <tr>
      <th scope="row">Product ID</th>
      <td><?php echo $products->productID; ?> </td>
    </tr>
    <tr>
      <th scope="row">Name</th>
      <td><?php echo $products->name; ?> </td>
    </tr>
    <tr>
      <th scope="row">Active</th>
      <td><?php echo $products->active; ?> </td>
    </tr>
    <tr>
      <th scope="row">Product Type</th>
      <td><?php echo $products->type_name; ?> </td>
    </tr>
    <tr>
      <th scope="row">Product Provider</th>
      <td><?php echo $products->productProviderName; ?> </td>
    </tr>
    <tr>
      <th scope="row">Reference</th>
      <td><?php echo $products->reference; ?> </td>
    </tr>
    <tr>
      <th scope="row">Initial Charge Percentage</th>
      <td><?php echo $products->initialChargePercentage; ?> </td>
    </tr>
    <tr>
      <th scope="row">Initial Charge Fixed</th>
      <td><?php echo $products->initialChargeFixed; ?> </td>
    </tr>
    <tr>
      <th scope="row">Annual Charge Percentage</th>
      <td><?php echo $products->annualChargePercentage; ?> </td>
    </tr>
    <tr>
      <th scope="row">Annual Charge Percentage Cap</th>
      <td><?php echo $products->annualChargePercentageCap; ?> </td>
    </tr>
    <tr>
      <th scope="row">Annual Charge Fixed</th>
      <td><?php echo $products->annualChargeFixed; ?> </td>
    </tr>
    <tr>
      <th scope="row">key Features Path</th>
      <td><?php echo $products->keyFeaturesPath; ?> </td>
    </tr>
    <tr>
      <th scope="row">Illustration Title</th>
      <td><?php echo $products->illustrationTitle; ?> </td>
    </tr>
    <tr>
      <th scope="row">Application Form</th>
      <td><?php echo $products->applicationForm; ?> </td>
    </tr>
     
  </tbody>

    
    </table>
</div>