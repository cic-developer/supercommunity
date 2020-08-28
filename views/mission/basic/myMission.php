<?php
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash'  => $this->security->get_csrf_hash()
    );
?>

<!doctype html>
<html lang="ko">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,height=device-height">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;500;700&display=swap" rel="stylesheet">
    </head>
    <body>
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
                        <td><?=$data['mis_title']?></td>
                        <td><?=$data['jud_expected_value']?></td>
                        <td><?=$data['jud_ko_state']?></td>
                    </tr>
<?php }?>
                </tbody>
            </table>
        </form>
<?php print_r($view['page'])  ?>
        <script>
            $(document).ready(function(){
                let validation_err = '<?=isset($validation_err) ? $validation_err : '' ?>';
                if(validation_err){
                    alert(validation_err);
                }
            });
        </script>
    </body>
</html>