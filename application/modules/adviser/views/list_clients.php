<script>
    var sMod = 'ListClients';
    var sBaseURL = '<?php echo($ajax_url); ?>';
    var aParaPlanners = <?php echo(json_encode($para_planners)); ?>;
    var sFirmID = "<?php echo($firmID); ?>";

</script>

<?php if (validation_errors()): ?>
    <div class="aler alert-danger">
        <?php echo validation_errors('<p>', '</p>'); ?>
    </div>
<?php endif; ?>

<input type="hidden" id="thisClientUrl" name="thisClientUrl" value="" />

<div id="divPPContainer" class="box box-primary" style="border:1px solid gray;padding:8px;width:220px;height:300px;position:absolute;display:none;">


    <div id="divAdviserListTitle" style="padding:5px;color: #ffffff; background-color: #0d6aad;width:200px;">
        Para-Planners of Firm
    </div>
    <div id="divPPList" style="overflow-y: scroll;width:200px;height:200px;">
        Loading Advisers...
    </div>
    <br>
    <input id="btnCancel" class="btn pull-right" style="display:inline;" type="button" value="Cancel">&nbsp;
    <input id="btnAssign" class="btn btn-primary pull-right" style="display:inline;" type="button" value="Assign">

</div>


<table id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th></th>
            <th>Reference</th>
            <th>Name</th>
            <th>Email</th>
            <th>Owned IFA</th>
            <th>Bank No.</th>
            <th width="120">Bank Balance</th>
            <th>Actions</th>

        </tr>
    </thead>

    <tfoot>
        <tr>
            <th></th> 
            <th>Reference</th>
            <th>Name</th>
            <th>Email</th>
            <th>Owned IFA</th>
            <th>Bank No.</th>
            <th>Bank Balance</th>
            <th>Actions</th>
        </tr>
    </tfoot>


    <tbody>

        <tr>
            <td colspan="8" style='background-color:lightgray;'><b>My Clients</b></td>
        </tr>

        <?php if (empty($clients)) { ?>
            <tr>
                <td colspan="7">There are no clients to display</td>
            </tr>
        <?php } ?>


        <?php if (!empty($clients)) { ?>
            <?php foreach ($clients as $key => $client) { ?>
                <tr>
                    <td><i class='fa fa-star'></i></td>
                    <td><?php echo $client->client_reference ?></td>
                    <td><?php echo $client->titleName . '. ' . ucwords($client->client_fname . " " . $client->client_lname) ?></td>
                    <td><?php echo $client->client_email ?></td>
                    <td><?php echo $client->user_fname . ' ' . $client->user_lname ?></td>

                    <td><?php echo $client->client_bank_number ?></td>
                    <td><div class="pull-right"><?php echo $client->client_bank_balance ?></div></td>


                    <td>

                        <div style="display:block;margin:auto;">
                            <a class="ancAssign"  id="<?php echo ($client->clientUrl); ?>"  href="#" title="Assign IFA">
                                &nbsp;<i class='fa fa-hand-o-left' style="color:brown"></i>
                            </a>

                            <a href="<?php echo base_url('client/' . $client->clientUrl) ?>/edit" title="Edit Client">
                                &nbsp;<i class='fa fa-pencil' style="color: #292;"></i>
                            </a>

                            <?php if (false) { ?>
                                <a href="<?php echo base_url('client/' . $client->clientUrl) ?>/deactivate" title="Re-Activate Client">
                                    &nbsp;<i class='fa fa-battery-empty'></i>
                                </a>

                            <?php } else { ?>
                                <a href="<?php echo base_url('client/' . $client->clientUrl) ?>/reactivate" title="Deactivate Client">
                                    &nbsp;<i class="fa fa-battery-full"></i>
                                </a>
                            <?php } ?>
                        </div>

                    </td>


                </tr>
            <?php } ?>
        <?php } ?>


        <?php if (!empty($assigned_clients)) { ?>

            <tr>
                <td colspan="8" style='background-color:lightgray;'><b>Clients Assigned to Me</b></td>
            </tr>


            <?php foreach ($assigned_clients as $key => $client) { ?>
                <tr>
                    <td><i class='fa fa-star'></i></td>
                    <td><?php echo $client->client_reference ?></td>
                    <td><?php echo $client->titleName . '. ' . ucwords($client->client_fname . " " . $client->client_lname) ?></td>
                    <td><?php echo $client->client_email ?></td>
                    <td><?php echo $client->user_fname . ' ' . $client->user_lname ?></td>

                    <td><?php echo $client->client_bank_number ?></td>
                    <td class="pull-right"><div><?php echo $client->client_bank_balance ?></div></td>


                    <td>
                        <div style="display:block;margin:auto;">
                            <a class="ancAssign"  id="<?php echo ($client->clientUrl); ?>"  href="#" title="Assign IFA">
                                &nbsp;<i class='fa fa-hand-o-left' style="color:brown"></i>
                            </a>

                            <a href="<?php echo base_url('client/' . $client->clientUrl) ?>/edit" title="Edit Client">
                                &nbsp;<i class='fa fa-pencil' style="color: #292;"></i>
                            </a>

                            <?php if (false) { ?>
                                <a href="<?php echo base_url('client/' . $client->clientUrl) ?>/deactivate" title="Re-Activate Client">
                                    &nbsp;<i class='fa fa-battery-empty'></i>
                                </a>

                            <?php } else { ?>
                                <a href="<?php echo base_url('client/' . $client->clientUrl) ?>/reactivate" title="Deactivate Client">
                                    &nbsp;<i class="fa fa-battery-full"></i>  
                                </a>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>



    </tbody>
</table>
