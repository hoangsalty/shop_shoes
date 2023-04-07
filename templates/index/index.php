<?php if (!empty($productlist)) { ?>
    <section class="wrap-categories">
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
    <section class="wrap-product">
        <div class="wrap-content">
            <div class="title-product-main">
                <div class="title-main">
                    <span>sản phẩm nổi bật</span>
                </div>
                <?php if (count($productlist)) { ?>
                    <div class="title-product-list d-flex justify-content-center align-items-center flex-wrap">
                        <a class="text-decoration-none a-title-product active" data-list=""><span>Tất cả sản phẩm</span></a>
                        <?php foreach ($productlist as $key => $vl) { ?>
                            <a class="text-decoration-none a-title-product" data-list="<?= $vl['id'] ?>"><span><?= $vl['name'] ?></span></a>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="paging-product-list"></div>
        </div>
    </section>
<?php } ?>

<?php if (!empty($newsnb)) { ?>
    <section class="wrap-newsnb">
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
                                <span class="ngaydang"><i class="fa-solid fa-calendar-days"></i><?= date("d/m/Y", $v['date_created']) ?></span>
                                <h3 class="name">
                                    <a class="text-decoration-none transition text-split" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>"><?= $v['name'] ?></a>
                                </h3>
                                <div class="desc text-split"><?= $v['desc'] ?></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>