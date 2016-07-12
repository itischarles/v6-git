
 
<div class="container-fluid" style="">

        <div class="col-md-5 col-md-offset-0">
              <h3 class="page-title">Portfolio</h3>

              <table class="table table-responsive col-70 table-striped">

             <tr>
                 <th>Reference</th>
                 <td><?php echo $portfolio->portfolioReference ?>

                 </td>
             </tr>
             <tr>
                 <th>Name</th>
                 <td><?php echo $portfolio->portfolioName?>

                 </td>
             </tr>



         </table>

       <div class="text-right col-70">

           <a href="<?php echo base_url("unitisation/portfolio/".$portfolio->portfolioURL."/edit") ?>" class="btn btn-warning">
              <span class="glyphicon glyphicon-edit"></span>
              Edit
          </a>  

       </div>


   </div>

    
</div>