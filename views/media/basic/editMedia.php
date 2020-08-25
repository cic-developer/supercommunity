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
<link rel="stylesheet" type="text/css" href="./views/media/basic/css/style.css" />
</head>
<body>
<?php //echo validation_errors(); ?>

<?php echo form_open(''); ?>
        <select name="wht_list">
            <?php for($i = 0; $i < count($white_list); $i++){ ?>
                <option value="<?=$white_list[$i]['wht_id']?>"><?=$white_list[$i]['wht_title']?></option>
            <?php } ?>
        </select>
        <?php foreach($media_type_list AS $mt){ ?>
            <label><input type="checkbox" value="<?=$mt['met_id']?>" name="met_type[]"/><?=$mt['met_title']?></label>
        <?php } ?>
        <?php if(!$media_type_list){ //미디어 type이 없는 경우?>
            <input type="hidden" value="0" name="met_type[]"/>
        <?php } ?>
        <input type="text" placeholder="내 미디어의 이름 입력" name="med_name" />
        <input type="text" placeholder="관리자 이름 입력" name="med_admin" />
        <input type="text" placeholder="내 미디어의 주소 입력" name="med_url" />
        <input type="submit" value="미디어 저장"/>
    </form>
    <script>
        $(document).ready(function(){
            let validation_err = <?=isset($validation_err) ? $validation_err : '' ?>;
            if(validation_err){
                alert(validation_err);
            }
        });
        </script>
</body>
</html>