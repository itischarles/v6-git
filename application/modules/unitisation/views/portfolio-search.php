<?php
$name  = ($this->input->get('name') ? $this->input->get('name') : '');
$ref  = ($this->input->get('ref') ? $this->input->get('ref') : '');
?>





   

<div class="container-fluid" style="">

        <div>

       <div class="form_filter">

        <?php $formOptions = array('method'=>'get','class'=>'form-inline search-form')?>
        <?php echo form_open('', $formOptions)?>



         <div class="form-group form-padding-right-4">
            <label for="name"> Name</label>	
            <input type="text" name="name" value="<?php echo $name ?>"/>
        </div>
         <div class="form-group form-padding-right-4">
            <label for="ref"> Reference</label>	
            <input type="text" name="ref"  value="<?php echo $ref ?>" />
        </div>



        <div class="form-group form-padding-right-4">
            <button class="btn btn-primary-2">
                Search <span class="glyphicon glyphicon-search"></span>
            </button>

            <a href="<?php echo base_url('unitisation/portfolio/search?show-all=true')?>" class="btn btn-primary-2">Show All</a>

        </div>
        <?php echo form_close();?>
    </div>

          <br/>
     <table class="table table-responsive overview-table " id="csv_downloadable" data-tableName="csv_downloadable2">

         <thead>
            <tr>
                <th>s/n</th>
                <th>Reference</th>
                <th>Name</th>
                <th>Action</th>

            </tr>
        </thead>
        <tfoot>
           <tr>
                <th>s/n</th>
                <th>Reference</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </tfoot>

        <tbody>
           <?php if(!empty($portfolios)): ?>
            <?php $sn = 1;?>
             <?php foreach($portfolios as $key=>$portfolio):?>
            <?php //print_r($client)?>

            <tr>
                <td><?php echo $sn?></td>
                <td>
                    <?php echo anchor(base_url('unitisation/portfolio/'.$portfolio->portfolioURL."/view"),
                               $portfolio->portfolioReference
                             );?>
                </td>


             <td><?php echo ($portfolio->portfolioName)  ?></td>
             <td></td>
            </tr>
            
                <?php $sn++?>
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


</div>