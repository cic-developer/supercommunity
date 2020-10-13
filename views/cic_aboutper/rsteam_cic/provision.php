<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>


<div id="aboutper_wrap">
  <div class="ab_left"><!--왼쪽 타이틀-->
      <h4>
        <?php echo $this->lang->line(0)?>
      </h4>
  </div>

  <div class="ab_right">
    <ul class="right_title"> <!--오른쪽 타이틀-->   
        <li>
           <p><?php echo $this->lang->line(1)?></p>
        </li>
        <li class="b_title">
           <p><?php echo $this->lang->line(2)?></p>
        </li>
    </ul>

    <dl class="provision">
        <dt class="first_dt">
            <?php echo $this->lang->line(3)?>
        </dt>
        <dd><!--1단 내용-->
            <?php echo $this->lang->line(4)?>
        </dd>
        <dt><!--2단 내용-->
            <?php echo $this->lang->line(5)?>
        </dt>
        <dd>
            <?php echo $this->lang->line(6)?>
        </dd>
       
        <dt><!--3단 내용-->
            <?php echo $this->lang->line(7)?>
        </dt>
        <dd>
            
            <?php echo $this->lang->line(8)?>
            
        </dd>
    </dl>

    <div class="bt">
        <a href="<?php echo base_url('Mission')?>" class="btn1 btn_yellow"><?php echo $this->lang->line(9)?></a>
    </div>
  </div><!--//오른쪽 타이틀-->  

</div>