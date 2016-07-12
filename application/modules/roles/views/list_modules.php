<div>
      <?php if(!empty($modules)):?>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>S/n</th>
                    <th>Module Name</th>
                    <th>Description</th>
                </tr>
            </thead>
            <?php $sn = 1;?>
            <?php foreach($modules as $key=>$module):?>
            <tr>
                <td><?php echo $sn?></td>
                <td><?php echo $module->moduleName?></td>
                <td><?php echo $module->moduleDescription?></td>
            </tr>
            <?php $sn++?>
            <?php endforeach;?>
        </table>              
        <?php endif; ?>
</div>
