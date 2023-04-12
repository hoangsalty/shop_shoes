<div class="title-main"><span><?= $rowDetail['name'] ?></span></div>
<div class="time-main"><i class="fas fa-calendar-week"></i><span>Ngày đăng: <?= date("d/m/Y h:i A", $rowDetail['date_created']) ?></span></div>
<?php if (!empty($rowDetail['content'])) { ?>
    <div class="content-main w-clear"><?= $func->decodeHtmlChars($rowDetail['content']) ?></div>
    <div class="share">
        <b>Chia sẻ:</b>
        <?php /*
        <div class="social-plugin w-clear">
            <?php
            $params = array();
            $params['oaid'] = $optsetting['oaidzalo'];
            echo $func->markdown('social/share', $params);
            ?>
        </div>
       */  ?>
    </div>
<?php } else { ?>
    <div class="alert alert-warning w-100" role="alert">
        <strong>Nội dung cập nhật</strong>
    </div>
<?php } ?>
<?php if (!empty($news)) { ?>
    <div class="share othernews mb-3">
        <b>Bài viết khác:</b>
        <ul class="list-news-other">
            <?php foreach ($news as $k => $v) { ?>
                <li><a class="text-decoration-none" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>"><?= $v['name'] ?> - <?= date("d/m/Y", $v['date_created']) ?></a></li>
            <?php } ?>
        </ul>
        <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
    </div>
<?php } ?>