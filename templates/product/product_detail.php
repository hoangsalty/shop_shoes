<div class="product-details mb-5">
    <div class="row">
        <div class="left-pro-detail col-lg-6 mb-4">
            <div class="product__details__pic__right mb-1">
                <?= $func->getImage(['class' => '', 'width' => 540, 'height' => 400, 'upload' => UPLOAD_PRODUCT_L, 'image' => $rowDetail['photo'], 'alt' => $rowDetail['name']]) ?>
                <?php foreach ($rowDetailPhoto as $i => $v) { ?>
                    <?= $func->getImage(['class' => '', 'width' => 540, 'height' => 400, 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $rowDetail['name']]) ?>
                <?php } ?>
            </div>

            <?php if (!empty($rowDetailPhoto)) { ?>
                <div class="product__details__pic__left">
                    <?= $func->getImage(['class' => '', 'width' => 100, 'height' => 100, 'upload' => UPLOAD_PRODUCT_L, 'image' => $rowDetail['photo'], 'alt' => $rowDetail['name']]) ?>
                    <?php foreach ($rowDetailPhoto as $i => $v) { ?>
                        <?= $func->getImage(['class' => '', 'width' => 100, 'height' => 100, 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $rowDetail['name']]) ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <div class="right-pro-detail col-lg-6 mb-4">
            <p class="title-pro-detail"><?= $rowDetail['name'] ?></p>
            <ul class="attr-pro-detail">
                <li class="">
                    <label class="attr-label-pro-detail">Lượt xem:</label>
                    <div class="attr-content-pro-detail"><?= $rowDetail['view'] ?></div>
                </li>
                <?php if (!empty($rowDetail['code'])) { ?>
                    <li class="">
                        <label class="attr-label-pro-detail">Mã sản phẩm:</label>
                        <div class="attr-content-pro-detail"><?= $rowDetail['code'] ?></div>
                    </li>
                <?php } ?>
                <?php if (!empty($productBrand['id'])) { ?>
                    <li class="">
                        <label class="attr-label-pro-detail">Thương hiệu:</label>
                        <div class="attr-content-pro-detail"><a class="text-decoration-none" href="<?= $productBrand['slug'] ?>" title="<?= $productBrand['name'] ?>"><?= $productBrand['name'] ?></a></div>
                    </li>
                <?php } ?>
                <li class="">
                    <label class="attr-label-pro-detail">Giá:</label>
                    <div class="attr-content-pro-detail">
                        <?php if ($rowDetail['sale_price']) { ?>
                            <span class="price-new-pro-detail"><?= $func->formatMoney($rowDetail['sale_price']) ?></span>
                            <span class="price-old-pro-detail"><?= $func->formatMoney($rowDetail['regular_price']) ?></span>
                        <?php } else { ?>
                            <span class="price-new-pro-detail"><?= ($rowDetail['regular_price']) ? $func->formatMoney($rowDetail['regular_price']) : 'Liên hệ' ?></span>
                        <?php } ?>
                    </div>
                </li>

                <?php if (!empty($rowSize)) { ?>
                    <li class="size-block-pro-detail ">
                        <label class="attr-label-pro-detail">Size:</label>
                        <div class="attr-content-pro-detail">
                            <?php foreach ($rowSize as $k => $v) { ?>
                                <label for="size-pro-detail-<?= $v['id'] ?>" class="size-pro-detail text-decoration-none">
                                    <input type="radio" value="<?= $v['id'] ?>" id="size-pro-detail-<?= $v['id'] ?>" name="size-pro-detail" data-id="<?= $v['id'] ?>"><?= $v['name'] ?>
                                </label>
                            <?php } ?>
                        </div>
                    </li>
                <?php } ?>
                <?php if (!empty($rowColor)) { ?>
                    <li class="color-block-pro-detail ">
                        <label class="attr-label-pro-detail">Color:</label>
                        <div class="attr-content-pro-detail">
                            <?php foreach ($rowColor as $k => $v) { ?>
                                <label for="color-pro-detail-<?= $v['id'] ?>" class="color-pro-detail text-decoration-none" data-idproduct="<?= $rowDetail['id'] ?>" style="background-color: #<?= $v['color'] ?>">
                                    <input type="radio" value="<?= $v['id'] ?>" id="color-pro-detail-<?= $v['id'] ?>" name="color-pro-detail" data-id="<?= $v['id'] ?>">
                                </label>
                            <?php } ?>
                        </div>
                    </li>
                <?php } ?>
                <li class="">
                    <label class="attr-label-pro-detail">Số lượng:</label>
                    <div class="attr-content-pro-detail">
                        <div class="quantity-pro-detail">
                            <span class="quantity-minus-pro-detail counter-procart">-</span>
                            <input type="number" class="qty-pro" min="1" value="1" readonly />
                            <span class="quantity-plus-pro-detail counter-procart">+</span>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="desc-pro-detail"><?= nl2br($func->decodeHtmlChars($rowDetail['desc'])) ?></div>

            <div class="cart-pro-detail">
                <a class="btn_addcart addcart rounded-0 mr-2" data-id="<?= $rowDetail['id'] ?>" data-action="addnow">
                    <i class="fas fa-shopping-bag mr-1"></i>
                    <span>Thêm vào giỏ hàng</span>
                </a>
                <a class="btn_buynow addcart rounded-0" data-id="<?= $rowDetail['id'] ?>" data-action="buynow">
                    <i class="fas fa-shopping-bag mr-1"></i>
                    <span>Mua ngay</span>
                </a>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="tabs-pro-detail">
                <ul class="nav nav-tabs" id="tabsProDetail">
                    <li class="nav-item">
                        <a class="nav-link active" id="info-pro-detail-tab" data-toggle="tab" href="#info-pro-detail">Thông tin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="review-pro-detail-tab" data-toggle="tab" href="#review-pro-detail">Đánh giá</a>
                    </li>
                </ul>
                <div class="tab-content" id="tabsProDetailContent">
                    <div class="tab-pane fade show autoHeight active" id="info-pro-detail" role="tabpanel">
                        <?= $func->decodeHtmlChars($rowDetail['content']) ?>
                    </div>
                    <div class="tab-pane fade autoHeight" id="review-pro-detail" role="tabpanel">
                        <?php include TEMPLATE . "product/comment.php" ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="title-main"><span>Sản phẩm cùng loại</span></div>
<div class="content-main ">
    <?php if (!empty($product)) { ?>
        <div class="slick_more_product">
            <?= $func->GetProducts($product) ?>
        </div>
    <?php } else { ?>
        <div class="col-12">
            <div class="alert alert-warning w-100" role="alert">
                <strong>Khong tìm thấy kết quả</strong>
            </div>
        </div>
    <?php } ?>
    <div class="clear"></div>
    <div class="col-12">
        <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
    </div>
</div>