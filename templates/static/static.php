<?php if (!empty($static)) { ?>
    <div class="title-main"><span><?= $static['name'] ?></span></div>
    <div class="content-main w-clear"><?= $func->decodeHtmlChars($static['content']) ?></div>
<?php } else { ?>
    <div class="alert alert-warning w-100" role="alert">
        <strong>Đang cập nhật dữ liệu</strong>
    </div>
<?php } ?>