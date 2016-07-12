<div>
      <?php if(!empty($permissions)):?>
        <table class="table table-responsive">
            <?php $sn = 1;?>
            <?php foreach($permissions as $key=>$permission):?>
            <tr>
                <td><?php echo $sn?></td>
                <td><?php echo $permission->permName?></td>
            </tr>
            <?php $sn++?>
            <?php endforeach;?>
        </table>              
        <?php endif; ?>
</div>
