<div class="title-main"><span><?= $rowDetail['name'] ?></span></div>
<div class="time-main mb-3"><i class="fas fa-calendar-week mr-2"></i><span>Ngày đăng: <?= date("d/m/Y h:i A", $rowDetail['date_created']) ?></span></div>
<?php if (!empty($rowDetail['content'])) { ?>
    <div class="content-main w-clear"><?= $func->decodeHtmlChars($rowDetail['content']) ?></div>
<?php } else { ?>
    <div class="alert alert-warning w-100" role="alert">
        <strong>Nội dung cập nhật</strong>
    </div>
<?php } ?>