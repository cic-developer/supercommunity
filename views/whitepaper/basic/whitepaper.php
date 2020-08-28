<?php
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash'  => $this->security->get_csrf_hash()
    );
?>
<div>
    백서 페이지입니다. 해당 부분에 자유롭게 디자인하시면 됩니다.
</div>
