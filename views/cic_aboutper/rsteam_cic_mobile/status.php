<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>
<div id="aboutper_wrap">
  <div class="ab_right">
    <ul class="right_title">    
        <li>
            <p><?=$this->lang->line(0)?></p>
        </li>
        <li class="b_title">
            <p><?=$this->lang->line(1)?></p>
        </li>
    </ul>


    <dl class="status">
        <dt>
            <h3><img src="<?php echo base_url('assets/images/super_50.png');?>" alt="<?=$this->lang->line(2)?>"/><u><?=$this->lang->line(3)?></u>
            </h3> <strong><?php echo number_format($superpoint) ?> / 400,000,000</strong>
        </dt>
    
        <dd>
            <ul>
                <li class="tit">
                <?=$this->lang->line(4)?>
                </li>
                <li>
                <img src="<?php echo base_url('assets/images/check.png');?>" alt="<?=$this->lang->line(5)?>"/> <p> <?=$this->lang->line(6)?></p></li>
                <br>
                <br>
                
                <li><img src="<?php echo base_url('assets/images/check.png');?>" alt="<?=$this->lang->line(5)?>"/> <p>  <?=$this->lang->line(7)?></p></li>
                <br>
                <br>
               
                <li><img src="<?php echo base_url('assets/images/check.png');?>" alt="<?=$this->lang->line(5)?>"/> <p> <?=$this->lang->line(8)?></p></li>
                </li>
            </ul>
        </dd>
    </dl>

    <div class="bt">
        <a href="<?php echo base_url('Mission')?>" class="btn1 btn_yellow"><?=$this->lang->line(9)?></a>
    </div>

  </div>
       
    
</div>