<?php 
    $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); 
?>

<div id="aboutper_wrap">
  <div class="ab_right">
    <ul class="right_title"> <!--오른쪽 타이틀-->   
        <li>
           <p><?=$this->lang->line(0)?></p>
        </li>
        <li class="b_title">
           <p><?=$this->lang->line(1)?></p>
        </li>
    </ul>

    <dl class="provision">
        <dt class="first_dt">
            <?=$this->lang->line(2)?>
        </dt>
        <dd><!--1단 내용-->
            <p><?=$this->lang->line(3)?></p>
        </dd>
        <dt><!--2단 내용-->
            <?=$this->lang->line(4)?>
        </dt>
        <dd>
        <p><?=$this->lang->line(5)?></p>
        </dd>
       
        <dt><!--3단 내용-->
            <?=$this->lang->line(6)?>
        </dt>
        <dd>
            <p><?=$this->lang->line(7)?>
        </p></dd>
    </dl>

    <div class="bt">
        <a href="<?php echo base_url('Mission')?>" class="btn1 btn_yellow"><?=$this->lang->line(8)?></a>
    </div>
  </div><!--//오른쪽 타이틀-->  

</div>