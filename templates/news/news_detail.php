<div class="row">
    <div class="col-lg-9">
        <div class="title-main-detail"><span><?= $rowDetail['name'] ?></span></div>
        <div class="time-main mb-3"><i class="fas fa-calendar-week mr-2"></i><span>Ngày đăng: <?= date("d/m/Y h:i A", $rowDetail['date_created']) ?></span></div>
        <?php if (!empty($rowDetail['content'])) { ?>
            <div class="content-main w-clear"><?= $func->decodeHtmlChars($rowDetail['content']) ?></div>
        <?php } else { ?>
            <div class="alert alert-warning w-100" role="alert">
                <strong>Nội dung cập nhật</strong>
            </div>
        <?php } ?>
    </div>
    <div class="col-lg-3">
        <div class="sticky_right_news">
            <div class="title_news_right">Bài viết khác</div>
            <div class="box_news_right">
                <?php foreach ($news as $k => $v) { ?>
                    <a class="news_item d-flex align-items-center" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>">
                        <p class="pic-news scale-img">
                            <?= $func->getImage(['class' => 'w-100', 'width' => 90, 'height' => 70, 'upload' => UPLOAD_NEWS_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                        </p>
                        <div class="info-news">
                            <h3 class="name-news text-split"><?= $v['name'] ?></h3>
                            <span class="view-news">Xem chi tiết <i class="fas fa-long-arrow-alt-right"></i></span>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>