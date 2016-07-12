 <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.0.1
    </div>
    <strong>Copyright &copy;2016</strong> All rights  reserved.
  </footer>

</div>
<!-- ./wrapper -->


<script type="text/javascript">
     var jsconfig = {
        baseurl: "<?php echo base_url(); ?>"
    };      
</script>
    
<!-- jQuery 2.2.0 -->
<script src="<?php echo base_url() ?>third_party/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script src="<?php echo base_url('third_party/jquery-ui-1-11-4/jquery-ui.min.js') ?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url() ?>third_party/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url() ?>third_party/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url() ?>third_party/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>third_party/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!--<script src="<?php //echo base_url() ?>assets/dist/js/demo.js"></script>-->


<?php // extral javascript file you loaded to a page ?>
<?php if(isset($mod_js) &&(!empty($mod_js))): ?>

    <?php if(!is_array($mod_js)):
         $mod_js = array($mod_js);
        endif;
       
    
        foreach($mod_js as $js):?>
            <script src="<?php echo $js ?>"></script>
        <?php endforeach; ?>    
<?php endif;?>
        

</body>
</html>