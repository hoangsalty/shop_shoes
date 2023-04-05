<div class="title-main"><span><?= (!empty($titleCate)) ? $titleCate : @$titleMain ?></span></div>
<div class="content-main">
    <div class="row">
        <?php if (!empty($product)) {
            foreach ($product as $k => $v) { ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="product" data-margin="20">
                        <div class="box-product">
                            <div class="box-image">
                                <a class="pic-product scale-img" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>">
                                    <?= $func->getImage(['class' => 'w-100', 'width' => $config['product']['width'], 'height' => $config['product']['height'], 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                                </a>
                                <p class="social-product transition">
                                    <a href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>" class="view-product text-decoration-none">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a class="cart-add addcart" data-id="<?= $v['id'] ?>" data-action="addnow">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="info-product">
                                <h3 class="name-product">
                                    <a class="text-decoration-none transition text-split" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>"><?= $v['name'] ?></a>
                                </h3>
                                <p class="price-product">
                                    <span class="price-new">
                                        <?= ($v['regular_price']) ? $func->formatMoney($v['regular_price']) : '' ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        } else { ?>
            <div class="col-12">
                <div class="alert alert-warning w-100" role="alert">
                    <strong>"Không tìm thấy kết quả</strong>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="clear"></div>
    <div class="col-12">
        <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
    </div>
</div>