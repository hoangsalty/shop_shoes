<?php if (!empty($productlist)) { ?>
    <div class="wrap-categories spacing">
        <div class="wrap-content">
            <div class="title-main">
                <span>Loại sản phẩm</span>
            </div>
            <div class="categories__slider owl-carousel control-owl">
                <?php foreach ($productlist as $k => $v) { ?>
                    <div>
                        <div class="item-categories">
                            <a class="image scale-img" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>">
                                <?= $func->getImage(['class' => '', 'width' => $config['product_list']['width'], 'height' => $config['product_list']['height'], 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo']]) ?>
                            </a>
                            <div class="info">
                                <h3 class="name transition">
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
            <div class="product__slider owl-carousel control-owl">
                <?php foreach ($product as $k => $v) { ?>
                    <div>
                        <div class="product">
                            <div class="box-product">
                                <div class="box-image">
                                    <a class="pic-product scale-img" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>">
                                        <?= $func->getImage(['class' => 'w-100', 'width' => $config['product']['width'], 'height' => $config['product']['height'], 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo']]) ?>
                                    </a>
                                    <p class="social-product transition">
                                        <a href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>" class="view-product">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="cart-add addcart" data-id="<?= $v['id'] ?>" data-action="addnow">
                                            <i class="fas fa-cart-plus"></i>
                                        </a>
                                    </p>
                                </div>
                                <div class="info-product">
                                    <a class="name-product text-split" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>"><?= $v['name'] ?></a>
                                    <p class="price-product">
                                        <?php if ($v['sale_price'] > 0) { ?>
                                            <span class="price-new"><?= $func->formatMoney($v['sale_price']) ?></span>
                                            <span class="price-old"><?= $func->formatMoney($v['regular_price']) ?></span>
                                            <span class="price-per"><?= '-' . round(100 - ($v['sale_price'] / $v['regular_price'] * 100)) . '%' ?></span>
                                        <?php } else { ?>
                                            <?php if ($v['regular_price'] != 0) $giapro = $func->formatMoney($v['regular_price']);
                                            else $giapro = 'Liên hệ'; ?>
                                            <span class="price-text">Giá: </span>
                                            <span class="price-new"><?= $giapro ?></span>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (count($productlist)) { ?>
    <?php foreach ($productlist as $klist => $vlist) {
        $productcat = $d->rawQuery("select * from table_product_cat where id_list = ? and find_in_set('noibat',status) and find_in_set('hienthi',status) order by id desc", array($vlist['id']));
    ?>
        <section class="section-4">
            <div class="wrap-content">
                <div class="title-top flexbox">
                    <div class="title-main">
                        <span><?= $vlist['name'] ?></span>
                    </div>
                    <div class="title-product-cat">
                        <div class="title-product-<?= $vlist['id'] ?> d-flex justify-content-center align-items-center flex-wrap gap-20">
                            <a class="a-title-product active" data-list="<?= $vlist['id'] ?>" data-cat="0">
                                Tất cả
                            </a>
                            <?php foreach ($productcat as $k => $v) { ?>
                                <a class="a-title-product" data-list="<?= $vlist['id'] ?>" data-cat="<?= $v['id'] ?>">
                                    <?= $v['name'] ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="load-page-category load-page-pronb<?= $vlist['id'] ?>" data-rel="<?= $vlist['id'] ?>"></div>
            </div>
        </section>
    <?php } ?>
<?php } ?>

<?php if (count($albumnb)) { ?>
    <section class="wrap-album spacing">
        <div class="wrap-content">
            <div class="title-main">
                <span>Thư viện ảnh</span>
            </div>
            <div class="main-album album-gallery">
                <div class="grid_album grid_container">
                    <?php foreach ($albumnb as $k => $v) { ?>
                        <div class="grid-item">
                            <a class="album_item transition" href="<?= UPLOAD_PHOTO_L . $v['photo'] ?>" title="<?= $v['name'] ?>">
                                <div class="images transition">
                                    <?= $func->getImage(['class' => 'w-100', 'width' => $config['album']['width'], 'height' => $config['album']['height'], 'upload' => UPLOAD_PHOTO_L, 'image' => $v['photo']]) ?>
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
                                <?= $func->getImage(['class' => 'w-100', 'width' => $config['news']['width'], 'height' => $config['news']['height'], 'upload' => UPLOAD_NEWS_L, 'image' => $v['photo']]) ?>
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