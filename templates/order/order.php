<form class="form-cart validation-cart" novalidate method="post" action="" enctype="multipart/form-data">
    <div class="wrap-cart">
        <?= $flash->getMessages("frontend") ?>
        <div class="row">
            <?php if (!empty($_SESSION['cart'])) { ?>
                <div class="top-cart col-12 col-lg-7">
                    <p class="title-cart">Giỏ hàng của bạn:</p>
                    <div class="list-procart">
                        <div class="procart procart-label">
                            <div class="row">
                                <div class="pic-procart col-3 col-md-2">Hình ảnh</div>
                                <div class="info-procart col-6 col-md-5">Tên sản phẩm</div>
                                <div class="quantity-procart col-3 col-md-2">
                                    <p>Số lượng</p>
                                    <p>Thành tiền</p>
                                </div>
                                <div class="price-procart col-3 col-md-3">Thành tiền</div>
                            </div>
                        </div>
                        <?php $max = count($_SESSION['cart']);
                        for ($i = 0; $i < $max; $i++) {
                            $pid = $_SESSION['cart'][$i]['productid'];
                            $quantity = $_SESSION['cart'][$i]['qty'];
                            $color = ($_SESSION['cart'][$i]['color']) ? $_SESSION['cart'][$i]['color'] : 0;
                            $size = ($_SESSION['cart'][$i]['size']) ? $_SESSION['cart'][$i]['size'] : 0;
                            $code = ($_SESSION['cart'][$i]['code']) ? $_SESSION['cart'][$i]['code'] : '';
                            $proinfo = $cart->getProductInfo($pid);
                            $pro_price = $proinfo['regular_price'];
                            $pro_price_new = $proinfo['sale_price'];
                            $pro_price_qty = $pro_price * $quantity;
                            $pro_price_new_qty = $pro_price_new * $quantity; ?>

                            <div class="procart procart-<?= $code ?>">
                                <div class="row">
                                    <div class="pic-procart col-3 col-md-2">
                                        <a class="text-decoration-none" href="<?= $proinfo['slug'] ?>" target="_blank" title="<?= $proinfo['name'] ?>">
                                            <?= $func->getImage(['class' => 'w-100', 'width' => 85, 'height' => 85, 'upload' => UPLOAD_PRODUCT_L, 'image' => $proinfo['photo'], 'alt' => $proinfo['name']]) ?>
                                        </a>
                                        <a class="del-procart text-decoration-none" data-code="<?= $code ?>" href="javascript::void(0)">
                                            <i class="fa fa-times-circle"></i>
                                            <span>Xóa</span>
                                        </a>
                                    </div>
                                    <div class="info-procart col-6 col-md-5">
                                        <h3 class="name-procart"><a class="text-decoration-none" href="<?= $proinfo['slug'] ?>" target="_blank" title="<?= $proinfo['name'] ?>"><?= $proinfo['name'] ?></a></h3>
                                        <div class="properties-procart">
                                            <?php if ($color) {
                                                $color_detail = $d->rawQueryOne("select name from table_color where id = ? limit 0,1", array($color)); ?>
                                                <p>Màu: <strong><?= $color_detail['name'] ?></strong></p>
                                            <?php } ?>
                                            <?php if ($size) {
                                                $size_detail = $d->rawQueryOne("select name from table_size where id = ? limit 0,1", array($size)); ?>
                                                <p>Size: <strong><?= $size_detail['name'] ?></strong></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="quantity-procart col-3 col-md-2">
                                        <div class="price-procart price-procart-rp">
                                            <?php if ($proinfo['sale_price']) { ?>
                                                <p class="price-new-cart load-price-new-<?= $code ?>">
                                                    <?= $func->formatMoney($pro_price_new_qty) ?>
                                                </p>
                                                <p class="price-old-cart load-price-<?= $code ?>">
                                                    <?= $func->formatMoney($pro_price_qty) ?>
                                                </p>
                                            <?php } else { ?>
                                                <p class="price-new-cart load-price-<?= $code ?>">
                                                    <?= $func->formatMoney($pro_price_qty) ?>
                                                </p>
                                            <?php } ?>
                                        </div>
                                        <div class="quantity-counter-procart quantity-counter-procart-<?= $code ?>">
                                            <span class="counter-procart-minus counter-procart">-</span>
                                            <input type="number" class="quantity-procart" min="1" value="<?= $quantity ?>" data-pid="<?= $pid ?>" data-code="<?= $code ?>" />
                                            <span class="counter-procart-plus counter-procart">+</span>
                                        </div>
                                    </div>
                                    <div class="price-procart col-3 col-md-3">
                                        <?php if ($proinfo['sale_price']) { ?>
                                            <p class="price-new-cart load-price-new-<?= $code ?>">
                                                <?= $func->formatMoney($pro_price_new_qty) ?>
                                            </p>
                                            <p class="price-old-cart load-price-<?= $code ?>">
                                                <?= $func->formatMoney($pro_price_qty) ?>
                                            </p>
                                        <?php } else { ?>
                                            <p class="price-new-cart load-price-<?= $code ?>">
                                                <?= $func->formatMoney($pro_price_qty) ?>
                                            </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="money-procart">
                        <div class="total-procart">
                            <p>Tạm tính:</p>
                            <p class="total-price load-price-temp"><?= $func->formatMoney($cart->getOrderTotal()) ?></p>
                        </div>
                        <div class="total-procart">
                            <p>Phí vận chuyển:</p>
                            <p class="total-price load-price-ship">0đ</p>
                        </div>
                        <div class="total-procart">
                            <p>Tổng tiền:</p>
                            <p class="total-price load-price-total"><?= $func->formatMoney($cart->getOrderTotal()) ?></p>
                        </div>
                    </div>
                </div>
                <div class="bottom-cart col-12 col-lg-5">
                    <div class="section-cart">
                        <p class="title-cart">Hình thức thanh toán:</p>
                        <div class="information-cart">
                            <?php $flashPayment = $flash->get('payments'); ?>
                            <?php foreach ($payments_info as $key => $value) { ?>
                                <div class="payments-cart custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="payments-<?= $value['id'] ?>" name="dataOrder[payments]" value="<?= $value['id'] ?>" <?= (!empty($flashPayment) && $flashPayment == $value['id']) ? 'checked' : '' ?> required>
                                    <label class="payments-label custom-control-label" for="payments-<?= $value['id'] ?>" data-payments="<?= $value['id'] ?>"><?= $value['name'] ?></label>
                                    <div class="payments-info payments-info-<?= $value['id'] ?> transition"><?= str_replace("\n", "<br>", $value['desc']) ?></div>
                                </div>
                            <?php } ?>
                        </div>
                        <p class="title-cart">Thông tin giao hàng:</p>
                        <div class="information-cart">
                            <div class="row">
                                <div class="input-cart col-md-6">
                                    <input type="text" class="form-control text-sm" id="fullname" name="dataOrder[fullname]" placeholder="Họ tên" value="<?= (!empty($flash->has('fullname'))) ? $flash->get('fullname') : '' ?>" required />
                                    <div class="invalid-feedback">Vui lòng nhập họ tên</div>
                                </div>
                                <div class="input-cart col-md-6">
                                    <input type="number" class="form-control text-sm" id="phone" name="dataOrder[phone]" placeholder="Số điện thoại" value="<?= (!empty($flash->has('phone'))) ? $flash->get('phone') : '' ?>" required />
                                    <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                                </div>
                            </div>
                            <div class="input-cart">
                                <input type="email" class="form-control text-sm" id="email" name="dataOrder[email]" placeholder="Email" value="<?= (!empty($flash->has('email'))) ? $flash->get('email') : '' ?>" required />
                                <div class="invalid-feedback">Vui lòng nhập email</div>
                            </div>
                            <div class="form-row">
                                <div class="input-cart col-md-4">
                                    <select class="select-city-cart custom-select text-sm" required id="city" name="dataOrder[city]">
                                        <option value="">Tỉnh thành</option>
                                        <?php foreach ($city as $k => $v) { ?>
                                            <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">Vui lòng chọn tỉnh thành</div>
                                </div>
                                <div class="input-cart col-md-4">
                                    <select class="select-district-cart select-district custom-select text-sm" required id="district" name="dataOrder[district]">
                                        <option value="">Quận huyện</option>
                                    </select>
                                    <div class="invalid-feedback">Vui lòng chọn quận huyện</div>
                                </div>
                                <div class="input-cart col-md-4">
                                    <select class="select-ward-cart select-ward custom-select text-sm" required id="ward" name="dataOrder[ward]">
                                        <option value="">Phường xã</option>
                                    </select>
                                    <div class="invalid-feedback">Vui lòng chọn phường xã</div>
                                </div>
                            </div>
                            <div class="input-cart">
                                <input type="text" class="form-control text-sm" id="address" name="dataOrder[address]" placeholder="Địa chỉ" value="<?= (!empty($flash->has('address'))) ? $flash->get('address') : '' ?>" required />
                                <div class="invalid-feedback">Vui lòng nhập địa chỉ</div>
                            </div>
                            <div class="input-cart">
                                <textarea class="form-control text-sm" id="requirements" name="dataOrder[requirements]" placeholder="Yêu cầu khác"><?= (!empty($flash->has('requirements'))) ? $flash->get('requirements') : '' ?></textarea>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary btn-cart w-100" name="thanhtoan" value="Thanh toán" />
                    </div>
                </div>
            <?php } else { ?>
                <a href="" class="empty-cart text-decoration-none w-100">
                    <i class="fas fa-cart-plus"></i>
                    <p>Không tồn tại sản phẩm trong giỏ hàng</p>
                    <span class="btn btn-warning">Về trang chủ</span>
                </a>
            <?php } ?>
        </div>
    </div>
</form>