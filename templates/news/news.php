<div class="title-main"><span><?= (!empty($titleCate)) ? $titleCate : @$titleMain ?></span></div>
<div class="content-main">
    <?php if (!empty($news)) { ?>
        <div class="css_flex_baiviet">
            <?php foreach ($news as $k => $v) { ?>
                <a class="news" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>">
                    <p class="pic-news scale-img">
                        <?= $func->getImage(['class' => 'w-100', 'width' => 222, 'height' => 166, 'upload' => UPLOAD_NEWS_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                    </p>
                    <div class="info-news">
                        <h3 class="name-news text-split"><?= $v['name'] ?></h3>
                        <p class="time-news">Ngày đăng: <?= date("d/m/Y", $v['date_created']) ?></p>
                        <div class="desc-news text-split"><?= $v['desc'] ?></div>
                        <span class="view-news">Xem chi tiết <i class="fas fa-long-arrow-alt-right"></i></span>
                    </div>
                </a>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="col-12">
            <div class="alert alert-warning w-100" role="alert">
                <strong>Không tìm thấy kết quả</strong>
            </div>
        </div>
    <?php } ?> <div class="clear"></div>
    <div class="col-12">
        <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
    </div>
</div>