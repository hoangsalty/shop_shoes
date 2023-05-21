<?php if (!empty($productlist)) { ?>
    <section class="wrap-categories spacing">
        <div class="wrap-content">
            <div class="categories__slider owl-carousel control-owl">
                <?php foreach ($productlist as $k => $v) { ?>
                    <div>
                        <div class="item-categories">
                            <a class="image scale-img transition" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>">
                                <?= $func->getImage(['class' => '', 'width' => $config['product_list']['width'], 'height' => $config['product_list']['height'], 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                            </a>
                            <div class="info">
                                <h3 class="name">
                                    <a class="text-decoration-none transition text-split" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>"><?= $v['name'] ?></a>
                                </h3>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>

<?php if (count($product)) { ?>
    <section class="wrap-product spacing">
        <div class="wrap-content">
            <div class="title-main">
                <span>sản phẩm nổi bật</span>
            </div>
            <?php if (count($productlist)) { ?>
                <div class="list_monnb list_splist mb-4">
                    <a class="d-inline-block active" role="button" data-list="0">Tất cả</a>
                    <?php foreach ($productlist as $k => $v) { ?>
                        <a class="d-inline-block" role="button" data-list="<?= $v['id'] ?>"><?= $v['name'] ?></a>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="page_splist"></div>
        </div>
    </section>
<?php } ?>

<?php if (count($albumnb)) { ?>
    <section class="wrap-album spacing">
        <div class="wrap-content">
            <div class="title-main">
                <span>Thư viện ảnh</span>
            </div>
            <div class="main-album">
                <div class="row">
                    <?php foreach ($albumnb as $k => $v) { ?>
                        <div class="album col-lg-3 col-md-4 col-6">
                            <a class="album-item text-decoration-none transition" href="<?= $v['link'] ?>" title="<?= $v['name'] ?>">
                                <div class="image scale-img">
                                    <?= $func->getImage(['class' => 'w-100', 'width' => $config['album']['width'], 'height' => $config['album']['height'], 'upload' => UPLOAD_PHOTO_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                                </div>
                                <div class="info">
                                    <h3 class="name text-split"><?= $v['name'] ?> </h3>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php if (!empty($newsnb)) { ?>
    <section class="wrap-newsnb spacing">
        <div class="wrap-content">
            <div class="title-main">
                <span>Tin tức</span>
            </div>
            <div class="newsnb__owl owl-carousel control-owl">
                <?php foreach ($newsnb as $k => $v) { ?>
                    <div>
                        <div class="item-newsnb">
                            <a class="image scale-img transition" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>">
                                <?= $func->getImage(['class' => 'w-100', 'width' => $config['news']['width'], 'height' => $config['news']['height'], 'upload' => UPLOAD_NEWS_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                            </a>
                            <div class="info">
                                <a class="name text-split" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>"><?= $v['name'] ?></a>
                                <span class="ngaydang"><i class="fas fa-calendar-day"></i><?= date("d/m/Y", $v['date_created']) ?></span>
                                <div class="desc text-split"><?= $v['desc'] ?></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>