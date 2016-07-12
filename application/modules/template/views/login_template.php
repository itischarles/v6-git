
<div>
  <div class="login-logo">
      <a href="<?php echo base_url()?>">
          <img src="<?php echo base_url('images/im-logo-text.png')?>" alt="IM Logo"/>
    </a>
  </div>

      <?php if(isset($content_view)){
            $this->load->view($content_view);

        } ?>

    
</div>