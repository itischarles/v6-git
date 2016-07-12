

<div class="container-fluid">
  
    <div class="row">
        <div class="col-md-3 col-sm-3">
            <h2>My Company</h2>
        </div>

        <div class="col-md-3 col-sm-3">
            <?php echo heading(anchor(base_url('settings/company-details'),'Company Details'), 4) ?>
           
            
            <p> Edit your address details, contact details and other company information.</p>

        </div>
        <div class="col-md-3 col-sm-3">
                <?php echo heading(anchor(base_url('settings/company-logo'),'Company Logo'), 4) ?>
             
              <p>
                Upload or change your company logos for use on invoices
              </p>
            
        </div>

          <div class="col-md-3 col-sm-3">
                 <?php echo heading(anchor(base_url('user/search'),'Users'), 4) ?>
<!--              <h3> <a href="#">Users</a></h3>-->
                <p>
                  Add and manage users, passwords and control user access levels.
                </p>
              
        </div>
    </div>
    
    
    <hr/>
    
     <div class="row">
        <div class="col-md-3 col-sm-3">
            <h2>Templates</h2>
        </div>

        <div class="col-md-3 col-sm-3">
           
             <?php echo heading(anchor(base_url('settings/email-templates'),'Email Templates'), 4) ?>
              
              <p>
                Set up and manage your invoice and estimate email templates.
              </p>
            
        </div>
        <div class="col-md-3 col-sm-3">
            <?php //echo heading(anchor(base_url('products'),'Products'), 3) ?>
            
<!--              <p>
                Manage your list of commonly sold product or service items.
              </p>-->
            
        </div>

          <div class="col-md-3 col-sm-3">
            <?php //echo heading(anchor(base_url('settings/invoice-themes'),'Theme Gallery'), 3) ?>
              <?php //echo heading(anchor($_SERVER['PHP_SELF'],'Theme Gallery'), 3) ?>
<!--	      <h3> <a href="#">Theme Gallery</a></h3>
              <p>
                Choose a template for your invoices and estimates or create your own.
              </p>
            -->
              
        </div>
    </div>
    
    <hr/>
    
     <div class="row">
        <div class="col-md-3 col-sm-3">
            <h2>Uploads</h2>
        </div>

	 <div class="col-md-3 col-sm-3">
            <?php echo heading(anchor(base_url('client/uploadclients'),'New Clients'), 4) ?>
            
              <p>
                Upload new clients' CSV
              </p>
            
        </div>
        <div class="col-md-3 col-sm-3">
           
             <?php echo heading(anchor(base_url('client/upload-account-bal'),'Bank Balances'), 4) ?>
              
              <p>
                upload bank balances for client. this file is usually an xml file from your bank
              </p>
            
        </div>
        <div class="col-md-3 col-sm-3">
            <?php echo heading(anchor(base_url('invoices/upload-payment'),'Invoice Payment'), 4) ?>
            
              <p>
                Mark invoices as being paid by uploading a csv 
              </p>
            
        </div>

         
    </div>
    
         <div class="row">
        <div class="col-md-3 col-sm-3"> </div>

	 <div class="col-md-3 col-sm-3">
            <?php echo heading(anchor(base_url('financial-adviser/upload/adviser'),'IFAs'), 3) ?>
            
              <p>
                Upload New Independent Financial Advisers, Adviser Companies and Networks
              </p>
            
        </div>
        <div class="col-md-3 col-sm-3">
           
            
            
        </div>
        <div class="col-md-3 col-sm-3">
          
            
        </div>

         
    </div>
    
    
    
    <hr/>
    
    <div class="row">
        <div class="col-md-3 col-sm-3">
            <h2>Manage</h2>
        </div>

        <div class="col-md-3 col-sm-3">
           
             <?php echo heading(anchor(base_url('portfolios'),'Unitisation'), 4) ?>
              
              <p>Manage investment Portfolios and unitisation module </p>
            
        </div>
        <div class="col-md-3 col-sm-3">
            <?php echo heading(anchor(base_url('financial-adviser/advisers'),'Financial Advisers'), 4) ?>
              <p>Manage Financial Advisers, FA companies and Networks </p>
        </div>

          <div class="col-md-3 col-sm-3">
	      <?php echo heading(anchor(base_url('client'),'Clients'), 4) ?>
              
              <p>Manage clients </p>
              
        </div>
    </div>
    
      
     <div class="row">
        <div class="col-md-3 col-sm-3">
           
        </div>
        <div class="col-md-3 col-sm-3">

           <?php echo heading(anchor(base_url('roles'),'Roles & Permissions'), 4) ?>

            <p>Manage roles and permissions </p>

        </div>

        <div class="col-md-3 col-sm-3">
            
           <?php echo heading(anchor(base_url('product'),'Products'), 4) ?>
            <p>Manage roles and permissions </p>
            
        </div>
   

          <div class="col-md-3 col-sm-3">

              
        </div>
    </div>
    
       
    
     <hr/>
    
    <div class="row">
        <div class="col-md-3 col-sm-3">
            <h2>Setup</h2>
        </div>

        <div class="col-md-3 col-sm-3">
           
             <?php //echo heading(anchor(base_url('initial-setup'),'Inital System Setup'), 3) ?>
             <?php echo heading('Inital System Setup', 4) ?>  
              <p>
                Initial system setup is a one-off click to configure the system for first 'proper'
		use. subsequent clicks are ignored !!
              </p>
            
        </div>
        <div class="col-md-3 col-sm-3">
            
        </div>

          <div class="col-md-3 col-sm-3">
           
              
        </div>
    </div>
    
    <hr/>
</div>