<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>

<div id="aboutper_wrap">
  <div class="ab_left">
      <h4>
        <?php echo  $this->lang->line(0)?>
      </h4>
  </div>
  <div class="ab_right">
    <ul class="right_title">    
        <li>
            <p><?php echo  $this->lang->line(1)?></p>
        </li>
        <li class="b_title">
            <p><?php echo  $this->lang->line(2)?></p>
        </li>
    </ul>


    <dl class="status">
        <dt>
            <h3><img src="<?php echo base_url('assets/images/super_50.png');?>" alt="<?php echo $this->lang->line(3)?>"/>
            <u><?php echo  $this->lang->line(4)?></u></h3> <strong><?php echo number_format($superpoint) ?> / 4,000,000,000</strong>
        </dt>
    
        <dd>
            <ul>
                <li class="tit">
                <?php echo  $this->lang->line(5)?>
                </li>
                <li>
                <img src="<?php echo base_url('assets/images/check.png');?>" alt="<?php echo  $this->lang->line(6)?>"/> <p><?php echo  $this->lang->line(7)?></p>
                </li>
                <li>
                <img src="<?php echo base_url('assets/images/check.png');?>" alt="체크아이콘"/> <p><?php echo  $this->lang->line(8)?></p>
                </li>
                <li>
                <img src="<?php echo base_url('assets/images/check.png');?>" alt="체크아이콘"/> <p><?php echo  $this->lang->line(9)?></p>
                </li>
            </ul>
        </dd>
    </dl>

    <div class="bt">
        <a href="<?php echo base_url('Mission')?>" class="btn1 btn_yellow"><?php echo  $this->lang->line(10)?></a>
    </div>

  </div>
       
    
</div>