<?php if (!empty($productlist)) { ?>
    <section class="wrap-categories" data-margin="30" data-padding="50">
        <div class="wrap-content">
            <div class="categories__slider owl-carousel">
                <?php foreach ($productlist as $k => $v) { ?>
                    <div>
                        <div class="item-categories">
                            <a class="image" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>">
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

<?php $func->var_dump($productlist) ?>