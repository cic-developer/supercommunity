<?php
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash'  => $this->security->get_csrf_hash()
    );
?>
<?php echo form_open_multipart(''); ?>
        <table>
            <colgroup>
                <col width="10%">
                <col width="10%">
                <col width="10%">
            </colgroup>
            <thead>
                <th>참여미션</th>
                <th>지급/예정 토큰</th>
                <th>승인여부</th>
            </thead>
            <tbody>
<?php foreach($view['judList'] AS $data){?>
                <tr>
                    <td><?=$this->session->userdata('lang') == 'korean' ? $data['mis_title'] : $data['mis_title_en']?></td>
                    <td><?=$data['jud_expected_value']?></td>
                    <td><?=$data['jud_ko_state']?></td>
                </tr>
<?php }?>
            </tbody>
        </table>
<?php echo form_close(); ?>

<?php print_r($view['page'])  ?>

<script>
    $(document).ready(function(){
        let validation_err = '<?=isset($validation_err) ? $validation_err : '' ?>';
        if(validation_err){
            alert(validation_err);
        }
    });
</script>
