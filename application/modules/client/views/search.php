<?php

  
 $client_name  = ($this->input->get('client_name') ? $this->input->get('client_name') : '');
$client_ref  = ($this->input->get('client_ref') ? $this->input->get('client_ref') : '');
$postcode  = ($this->input->get('postcode') ? $this->input->get('postcode') : '');
$client_ni  = ($this->input->get('client_ni') ? $this->input->get('client_ni') : '');

?>





   

<div class="container-fluid">

   
  
	 <div class="row ">
		
	   <div class="form_filter">
	    
	    <?php $formOptions = array('method'=>'get','class'=>'form-inline search-form')?>
	    <?php echo form_open(base_url('client'),$formOptions)?>
	    
	 
	   
	     <div class="form-group form-padding-right-4">
		<label for="client_ref"> Client's Ref.</label>	
		<input type="text" name="client_ref" value="<?php echo $client_ref ?>"/>
	    </div>
	     <div class="form-group form-padding-right-4">
		<label for="client_name"> Name(s)</label>	
		<input type="text" name="client_name"  value="<?php echo $client_name ?>" />
	    </div>
	       
	     <div class="form-group form-padding-right-4">
		<label for="postcode"> Postcode</label>	
		<input type="text" name="postcode"  value="<?php echo $postcode ?>" />
	    </div>  
	    <div class="form-group form-padding-right-4">
		<label for="client_ni">NI Number</label>	
		<input type="text" name="client_ni"  value="<?php echo $client_ni ?>" />
	    </div>    
	    
	    <div class="form-group form-padding-right-4">
		<button class="btn btn-primary-2">
		    Search <span class="glyphicon glyphicon-search"></span>
		</button>
	
	    </div>
	    <?php echo form_close();?>
	</div>
           </div>
        
        
   <div class="row ">	
	 <table class="table table-responsive overview-table " id="csv_downloadable" data-tableName="csv_downloadable2">
            
             <thead>
                <tr>
                    <th></th>
                    <th class="date">Date Added</th>
		    <th>Ref.</th>
                    <th>Contact</th>
                    <th>Details</th>
                    <th>NI</th>
		    <th>Postcode</th>
                    <th>Account Balance</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
	    <tfoot>
               <tr>
                   <th></th>
                    <th class="date">Date Added</th>
		    <th>Ref.</th>
                    <th>Contact</th>
                    <th>Details</th>
		     <th>NI</th>
		    <th>Postcode</th>
                    <th>Account Balance</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </tfoot>
            
            <tbody>
               <?php if(!empty($clients)): ?>
                 <?php foreach($clients as $key=>$client):?>
                <?php //print_r($client)?>
               
                <tr>
                    <td><i class='fa fa-star'></i></td>
                    <td class="date"><?php echo changeDateFormat($client->client_date_created) ?></td>
		    <td><?php echo $client->client_reference ?></td>
		    <td>
                        <?php echo anchor(base_url('client/'.$client->clientUrl.'/view'),
                                    $client->title." ".$client->client_fname." ". $client->client_lname
                                 );?>
                    </td>
                    <td>
                        <span class="block-display"><?php echo $client->client_address_1 ?></span>
                        <span class="block-display"><?php echo $client->client_address_2." ". $client->client_address_3?></span>
                        <span class="block-display"><?php echo $client->client_town.", ". $client->client_postcode; ?></span>
                    
                    </td>
                 <td><?php echo ($client->client_NI)  ?></td>
		 <td><?php echo ($client->client_postcode)  ?></td>
                    <td><?php echo number_format($client->client_bank_balance,2)  ?></td>
                    <td><?php echo writeStatus($client->client_isActive ==1) ?></td>
                    <td>
                        <a href="<?php echo base_url('client/' . $client->clientUrl) ?>/view" title="View Client">
                                &nbsp;<i class='fa fa-eye'></i> 
                        </a>
                        
                        |
                        
                    <a href="<?php echo base_url('client/' . $client->clientUrl) ?>/edit" title="Edit Client">
                              &nbsp;<i class='fa fa-pencil' style="color: #292;"></i>
                    </a> 
                        
                      </td>
                </tr>
                 <?php endforeach;?>
                
                <?php endif;?>
            </tbody>
            
	    </table>
       
	    
	 <div>
            <?php 	
            if(isset($this->pagination)):

                echo "<span class='pagination_total_rec'>".

                show_pagination_text($this->pagination->cur_page, $this->pagination->per_page, 3)    .                           
                    "</span> &nbsp;&nbsp;&nbsp;&nbsp;";
                echo $this->pagination->create_links();  
            endif; 		    
                    ?>	
        </div>
	


    </div>
   
    
</div> <!-- end content-->
