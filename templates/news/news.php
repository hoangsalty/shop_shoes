<div class="title-main"><span><?= (!empty($titleCate)) ? $titleCate : @$titleMain ?></span></div>
<div class="content-main">
    <div class="row">
        <?php if (!empty($news)) {
            foreach ($news as $k => $v) { ?>
                <div class="news col-lg-4 col-md-6">
                    <div class="item-newsnb">
                        <a class="image scale-img transition" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>">
                            <?= $func->getImage(['class' => 'w-100', 'width' => $config['news']['width'], 'height' => $config['news']['height'], 'upload' => UPLOAD_NEWS_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                        </a>
                        <div class="info">
                            <span class="ngaydang"><i class="fa-solid fa-calendar-days"></i><?= date("d/m/Y", $v['date_created']) ?></span>
                            <h3 class="name">
                                <a class="text-decoration-none transition text-split" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>"><?= $v['name'] ?></a>
                            </h3>
                            <div class="desc text-split"><?= $v['desc'] ?></div>
                        </div>
                    </div>
                </div>
            <?php }
        } else { ?>
            <div class="col-12">
                <div class="alert alert-warning w-100" role="alert">
                    <strong><?= khongtimthayketqua ?></strong>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="clear"></div>
    <div class="col-12">
        <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
    </div>
</div>