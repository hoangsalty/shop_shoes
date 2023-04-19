<div class="grid-pro-detail">
    <div class="row">
        <div class="left-pro-detail col-md-5">
            <a id="Zoom-1" class="MagicZoom" data-options="zoomMode: on; hint: off; rightClick: true; selectorTrigger: hover; expandCaption: false; history: false;" href="<?= UPLOAD_PRODUCT_L . $rowDetail['photo'] ?>" title="<?= $rowDetail['name'] ?>">
                <?= $func->getImage(['class' => 'w-100', 'width' => 540, 'height' => 400, 'upload' => UPLOAD_PRODUCT_L, 'image' => $rowDetail['photo'], 'alt' => $rowDetail['name']]) ?>
            </a>
            <?php if (!empty($rowDetailPhoto)) { ?>
                <div class="gallery-thumb-pro">
                    <div class="gallery__slider owl-carousel control-owl">
                        <div class="gallery-item" owl-item-animation>
                            <a class="thumb-pro-detail" data-zoom-id="Zoom-1" href="<?= UPLOAD_PRODUCT_L . $rowDetail['photo'] ?>" title="<?= $rowDetail['name'] ?>">
                                <?= $func->getImage(['class' => 'w-100', 'width' => 75, 'height' => 75, 'upload' => UPLOAD_PRODUCT_L, 'image' => $rowDetail['photo'], 'alt' => $rowDetail['name']]) ?>
                            </a>
                        </div>
                        <?php foreach ($rowDetailPhoto as $v) { ?>
                            <div class="gallery-item" owl-item-animation>
                                <a class="thumb-pro-detail" data-zoom-id="Zoom-1" href="<?= UPLOAD_PRODUCT_L . $v['photo'] ?>" title="<?= $rowDetail['name'] ?>">
                                    <?= $func->getImage(['class' => 'w-100', 'width' => 75, 'height' => 75, 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $rowDetail['name']]) ?>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="right-pro-detail col-md-7">
            <p class="title-pro-detail mb-2"><?= $rowDetail['name'] ?></p>
            <div class="desc-pro-detail"><?= nl2br($func->decodeHtmlChars($rowDetail['desc'])) ?></div>
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
                        <label class="attr-label-pro-detail d-block">Size:</label>
                        <div class="attr-content-pro-detail d-block">
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
                        <label class="attr-label-pro-detail d-block">Color:</label>
                        <div class="attr-content-pro-detail d-block">
                            <?php foreach ($rowColor as $k => $v) { ?>
                                <label for="color-pro-detail-<?= $v['id'] ?>" class="color-pro-detail text-decoration-none" data-idproduct="<?= $rowDetail['id'] ?>" style="background-color: #<?= $v['color'] ?>">
                                    <input type="radio" value="<?= $v['id'] ?>" id="color-pro-detail-<?= $v['id'] ?>" name="color-pro-detail" data-id="<?= $v['id'] ?>">
                                </label>
                            <?php } ?>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <div class="cart-pro-detail">
                <a class="btn btn-success addcart rounded-0 mr-2" data-id="<?= $rowDetail['id'] ?>" data-action="addnow">
                    <i class="fas fa-shopping-bag mr-1"></i>
                    <span>Thêm vào giỏ hàng</span>
                </a>
                <a class="btn btn-dark addcart rounded-0" data-id="<?= $rowDetail['id'] ?>" data-action="buynow">
                    <i class="fas fa-shopping-bag mr-1"></i>
                    <span>Mua ngay</span>
                </a>
            </div>
        </div>
    </div>
    <div class="tabs-pro-detail">
        <ul class="nav nav-tabs" id="tabsProDetail">
            <li class="nav-item">
                <a class="nav-link active" id="info-pro-detail-tab" data-bs-toggle="tab" href="#info-pro-detail">Thông tin sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="review-pro-detail-tab" data-bs-toggle="tab" href="#review-pro-detail">Reviews</a>
            </li>
        </ul>
        <div class="tab-content pt-4 pb-4" id="tabsProDetailContent">
            <div class="tab-pane fade show autoHeight active" id="info-pro-detail" role="tabpanel">
                <?= $func->decodeHtmlChars($rowDetail['content']) ?>
            </div>
            <div class="tab-pane fade" id="review-pro-detail" role="tabpanel">
            </div>
        </div>
    </div>
</div>
<div class="title-main"><span>Sản phẩm cùng loại</span></div>
<div class="content-main ">
    <?php if (!empty($product)) {
    } else { ?>
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