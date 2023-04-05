<?php if (!empty($static)) { ?>
    <div class="title-main"><span><?= $static['name'] ?></span></div>
    <div class="content-main w-clear"><?= $func->decodeHtmlChars($static['content']) ?></div>
    <div class="share">
        <b>Chia sẻ:</b>
        <div class="social-plugin w-clear">
            <?php
            $params = array();
            $params['oaid'] = $optsetting['oaidzalo'];
            echo $func->markdown('social/share', $params);
            ?>
        </div>
    </div>
<?php } else { ?>
    <div class="alert alert-warning w-100" role="alert">
        <strong>Đang cập nhật dữ liệu</strong>
    </div>
<?php } ?>