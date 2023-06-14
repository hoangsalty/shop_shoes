<div class="wrap-about spacing">
    <div class="wrap-content">
        <div class="flex-about d-flex justify-content-between align-items-center flex-wrap">
            <div class="left">
                <a class="image-about scale-img transition" href="gioi-thieu" title="Giới thiệu">
                    <?= $func->getImage(['class' => '', 'width' => $config['about']['width'], 'height' => $config['about']['height'], 'upload' => UPLOAD_NEWS_L, 'image' => $static['photo'], 'alt' => $static['name']]) ?>
                </a>
            </div>
            <div class="right">
                <div class="main-about">
                    <h3 class="name"><?= $static['name'] ?></h3>
                    <div class="desc text-split"><?= $static['desc'] ?></div>
                    <a class="btn-xemthem transition" href="gioi-thieu" title="Giới thiệu">
                        Xem thêm
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($brand)) { ?>
    <div class="wrap-categories spacing">
        <div class="wrap-content">
            <div class="title-main">
                <span>Thương hiệu sản phẩm</span>
            </div>
            <div class="categories__slider owl-carousel control-owl">
                <?php foreach ($brand as $k => $v) { ?>
                    <div>
                        <div class="item-categories">
                            <a class="image scale-img transition" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>">
                                <?= $func->getImage(['class' => '', 'width' => $config['brand']['width'], 'height' => $config['brand']['height'], 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                            </a>
                            <div class="info">
                                <h3 class="name">
                                    <a class="transition text-split" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>"><?= $v['name'] ?></a>
                                </h3>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (count($product)) { ?>
    <div class="wrap-product spacing">
        <div class="wrap-content">
            <div class="title-main">
                <span>Sản phẩm nổi bật</span>
            </div>
            <div class="paging-product"></div>
        </div>
    </div>
<?php } ?>

<?php if (count($productlist)) {
    foreach ($productlist as $vlist) { ?>
        <div class="wrap-product spacing">
            <div class="wrap-content">
                <div class="title-main">
                    <span><?= $vlist['name'] ?></span>
                </div>
                <div class="paging-product-category paging-product-category-<?= $vlist['id'] ?>" data-list="<?= $vlist['id'] ?>"></div>
            </div>
        </div>
<?php }
} ?>

<?php if (count($albumnb)) { ?>
    <section class="wrap-album spacing">
        <div class="wrap-content">
            <div class="title-main">
                <span>Thư viện ảnh</span>
            </div>
            <div class="main-album album-gallery">
                <div class="row">
                    <?php foreach ($albumnb as $k => $v) { ?>
                        <div class="album col-lg-3 col-md-4 col-6">
                            <a class="album-item text-decoration-none transition" href="<?= UPLOAD_PHOTO_L . $v['photo'] ?>" title="<?= $v['name'] ?>">
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
                                <a class="view" href="<?= $v['slug'] ?>" tabindex="0">
                                    Xem thêm
                                    <i class="fa fa-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>