<div class="product-details mb-3">
    <div class="wrap_productdetail">
        <div class="d-flex flex-wrap">
            <div class="left-pro-detail d-flex flex-wrap col-lg-6 mb-4">
                <?php if (!empty($rowDetailPhoto)) { ?>
                    <div class="product__details__pic__left col-lg-3">
                        <?= $func->getImage(['class' => '', 'width' => 100, 'height' => 120, 'upload' => UPLOAD_PRODUCT_L, 'image' => $rowDetail['photo']]) ?>
                        <?php foreach ($rowDetailPhoto as $i => $v) { ?>
                            <?= $func->getImage(['class' => '', 'width' => 100, 'height' => 120, 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo']]) ?>
                        <?php } ?>
                    </div>
                <?php } ?>

                <div class="product__details__pic__right mb-1 col-lg-9">
                    <?= $func->getImage(['class' => '', 'width' => 540, 'height' => 455, 'upload' => UPLOAD_PRODUCT_L, 'image' => $rowDetail['photo']]) ?>
                    <?php foreach ($rowDetailPhoto as $i => $v) { ?>
                        <?= $func->getImage(['class' => '', 'width' => 540, 'height' => 455, 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo']]) ?>
                    <?php } ?>
                </div>
            </div>
            <div class="right-pro-detail col-lg-6 mb-4">
                <p class="title-pro-detail"><?= $rowDetail['name'] ?></p>
                <div class="comment-star">
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <span style="width: <?= $comment->avgStar() ?>%">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </span>
                </div>
                <ul class="attr-pro-detail">
                    <li class="">
                        <label class="attr-label-pro-detail">Lượt xem:</label>
                        <div class="attr-content-pro-detail"><?= $rowDetail['view'] ?></div>
                    </li>
                    <li class="">
                        <?php $status = '';
                        if ($rowDetail['quantity'] <= 0) {
                            $status = '<span class="d-inline-block text-danger">Hết hàng</span>';
                        } else {
                            $status = '<span class="d-inline-block text-success">Còn hàng</span>';
                        }
                        ?>

                        <label class="attr-label-pro-detail">Tình trạng:</label>
                        <div class="attr-content-pro-detail"><?= $status ?></div>
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
                                <input type="number" class="qty-pro" min="1" value="1" data-pid="<?= $rowDetail['id'] ?>" readonly />
                                <span class="quantity-plus-pro-detail counter-procart">+</span>
                            </div>
                        </div>
                    </li>
                </ul>

                <?php /* <div class="desc-pro-detail"><?= $func->decodeHtmlChars($rowDetail['desc']) ?></div> */ ?>

                <div class="cart-pro-detail">
                    <?php $disabled = '';
                    if ($rowDetail['quantity'] <= 0) {
                        $disabled = 'disabled';
                    }
                    ?>
                    <a type="button" class="btn_addcart addcart rounded-0 mr-2 <?= $disabled ?>" data-id="<?= $rowDetail['id'] ?>" data-action="addnow">
                        <i class="fa-solid fa-cart-shopping fa-bounce mr-1"></i>
                        <span>Thêm vào giỏ hàng</span>
                    </a>
                    <a type="button" class="btn_buynow addcart rounded-0 <?= $disabled ?>" data-id="<?= $rowDetail['id'] ?>" data-action="buynow">
                        <i class="fa-solid fa-bag-shopping fa-beat mr-1"></i>
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
</div>

<div class="wrap_productdetail p-3">
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
</div>