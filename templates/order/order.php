<div class="order_holder" id="order_holder">
    <form id="form_cart" class="form-cart validation-cart" novalidate method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="dataOrder[ship_price]" id="ship_price" value="0">
        <input type="hidden" name="dataOrder[temp_price]" id="temp_price" value="<?= $cart->getOrderTotal() ?>">
        <input type="hidden" name="dataOrder[total_price]" id="total_price" value="<?= $cart->getOrderTotal() ?>">

        <div id="popup-order">
            <div class="popup-content">
                <div class="header">
                    <a href="<?= $configBase ?>" data-dismiss="modal" class="back-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5 5L8.5 12L15.5 19" stroke="#666666" stroke-width="1.8" stroke-miterlimit="10" stroke-linecap="square"></path>
                        </svg>
                    </a>
                    <div class="heading">Thanh toán</div>
                </div>

                <div class="content-debug"></div>
                <div class="content-outter">
                    <?php if (!empty($_SESSION['cart'])) { ?>
                        <div class="content-flex">
                            <div class="content">
                                <div class="infoBox">
                                    <div class="title">Hình thức thanh toán</div>

                                    <div class="payment-box">
                                        <div class="payments-cart custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="payments-nhanhang" name="dataOrder[payments]" value="nhanhang" required>
                                            <label class="payments-label custom-control-label" for="payments-nhanhang" data-payments="nhanhang">Thanh toán khi nhận hàng</label>
                                        </div>

                                        <div class="payments-cart custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="payments-vnpay" name="dataOrder[payments]" value="vnpay" required>
                                            <label class="payments-label custom-control-label" for="payments-vnpay" data-payments="vnpay"><img src="assets/images/vnpay_icon.png" alt=""> Thanh toán qua VNPay</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="infoBox">
                                    <div class="title">Địa chỉ giao hàng</div>
                                    <div class="form-input-user">
                                        <div class="form-input">
                                            <div class="input-select">
                                                <select class="select-city-cart" id="city" name="dataOrder[city]" required>
                                                    <option value="" selected disabled>Tỉnh thành *</option>
                                                    <?php foreach ($city as $k => $v) { ?>
                                                        <option value="<?= $v['ProvinceName'] ?>__<?= $v['ProvinceID'] ?>"><?= $v['ProvinceName'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="trigger-select">Lựa chọn</div>
                                            </div>
                                        </div>

                                        <div class="form-input">
                                            <div class="input-select">
                                                <select class="select-district-cart select-district" id="district" name="dataOrder[district]" required>
                                                    <option value="" selected disabled>Quận huyện *</option>
                                                </select>
                                                <div class="trigger-select">Lựa chọn</div>
                                            </div>
                                        </div>

                                        <div class="form-input">
                                            <div class="input-select">
                                                <select class="select-ward-cart select-ward" id="ward" name="dataOrder[ward]" required>
                                                    <option value="" selected disabled>Phường xã *</option>
                                                </select>
                                                <div class="trigger-select">Lựa chọn</div>
                                            </div>
                                        </div>

                                        <div class="form-input">
                                            <div class="input-cart">
                                                <input type="text" class="form-control text-sm" id="address" name="dataOrder[address]" placeholder="Số nhà, ngõ (ngách, hẻm), đường phố, tổ (thôn, xóm, ấp)" value="<?= !empty($_SESSION['account']['address']) ? $_SESSION['account']['address'] : '' ?>" required />
                                                <div class="invalid-feedback">Vui lòng nhập địa chỉ</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="infoBox">
                                    <div class="title">Thông tin người nhận</div>

                                    <div class="form-input-user">
                                        <div class="form-input">
                                            <div class="input-cart">
                                                <div class="icn"><i class="fa-solid fa-user"></i></div>
                                                <input type="text" class="input-user-info" id="fullname" name="dataOrder[fullname]" placeholder="Họ tên" value="<?= !empty($_SESSION['account']['fullname']) ? $_SESSION['account']['fullname'] : '' ?>" required />
                                            </div>
                                            <div class="invalid-feedback">Vui lòng nhập họ tên</div>
                                        </div>

                                        <div class="form-input">
                                            <div class="input-cart">
                                                <div class="icn"><i class="fa-solid fa-phone"></i></div>
                                                <input type="text" class="input-user-info" id="phone" name="dataOrder[phone]" placeholder="Số điện thoại" value="<?= !empty($_SESSION['account']['phone']) ? $_SESSION['account']['phone'] : '' ?>" required />
                                            </div>
                                            <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                                        </div>

                                        <div class="form-input">
                                            <div class="input-cart">
                                                <div class="icn"><i class="fa-solid fa-at"></i></div>
                                                <input type="text" class="input-user-info" id="email" name="dataOrder[email]" placeholder="Email" value="<?= !empty($_SESSION['account']['email']) ? $_SESSION['account']['email'] : '' ?>" required />
                                            </div>
                                            <div class="invalid-feedback">Vui lòng nhập email</div>
                                        </div>

                                        <div class="form-input">
                                            <textarea rows="5" class="form-control text-sm" id="requirements" name="dataOrder[requirements]" placeholder="Yêu cầu khác"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="right-web">
                                <div class="footer-bill">
                                    <div class="infoGroup billGroup">
                                        <div class="label">Đơn hàng</div>
                                        <div class="bill-total" id="list-order-checkout">
                                            <?php foreach ($_SESSION['cart'] as $key => $cart_item) {
                                                $pid = $cart_item['productid'];
                                                $quantity = $cart_item['qty'];
                                                $color = ($cart_item['color']) ? $cart_item['color'] : 0;
                                                $size = ($cart_item['size']) ? $cart_item['size'] : 0;
                                                $code = ($cart_item['code']) ? $cart_item['code'] : '';
                                                $proinfo = $cart->getProductInfo($pid);
                                                $pro_price = $proinfo['regular_price'];
                                                $pro_price_new = $proinfo['sale_price'];
                                                $pro_price_qty = $pro_price * $quantity;
                                                $pro_price_new_qty = $pro_price_new * $quantity; ?>
                                                <div class="item-total procart-<?= $code ?>">
                                                    <div class="count">
                                                        x <input type="number" class="quantity-procart" min="1" value="<?= $quantity ?>" data-pid="<?= $pid ?>" data-code="<?= $code ?>" readonly />
                                                    </div>
                                                    <div class="info-item">
                                                        <a class="name-item" href="<?= $proinfo['slug'] ?>" target="_blank" title="<?= $proinfo['name'] ?>"><?= $proinfo['name'] ?></a>
                                                        <div class="properties-procart">
                                                            <?php if ($color) {
                                                                $color_detail = $d->rawQueryOne("select name from table_color where id = ? limit 0,1", array($color)); ?>
                                                                <p>Màu: <strong>
                                                                        <?= $color_detail['name'] ?>
                                                                    </strong></p>
                                                            <?php } ?>
                                                            <?php if ($size) {
                                                                $size_detail = $d->rawQueryOne("select name from table_size where id = ? limit 0,1", array($size)); ?>
                                                                <p>Size: <strong>
                                                                        <?= $size_detail['name'] ?>
                                                                    </strong></p>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <a class="del-procart ml-2" data-code="<?= $code ?>">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="bill-payment">
                                        <div class="total-bill-order">
                                            <div class="priceFlx">
                                                <div class="text">Tạm tính</div>
                                                <div class="price-detail">
                                                    <span class="total-price load-price-temp" id="checkout-cart-total" rel="currency">
                                                        <?= $func->formatMoney($cart->getOrderTotal()) ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="priceFlx chk-ship">
                                                <div class="text">Phí vận chuyển</div>
                                                <div class="price-detail chk-free-ship">
                                                    <span class="total-price load-price-ship" rel="currency" id="price-ship">0 ₫</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="policy-note">
                                            Bằng việc bấm vào nút “Đặt hàng”, tôi đồng ý với
                                            <a href="#" target="_blank">chính sách hoạt động</a>
                                            của website.
                                        </div>
                                    </div>
                                    <div class="total-checkout">
                                        <div class="text">Tổng tiền</div>
                                        <div class="price-bill">
                                            <div class="price-final" id="checkout-cart-price-final" rel="currency">
                                                <p class="total-price load-price-total">
                                                    <?= $func->formatMoney($cart->getOrderTotal()) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" class="complete-checkout-btn" name="thanhtoan" id="thanhtoan" value="Thanh toán" />
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="payment-content redirect-info">
                            <div class="empty-cart text-decoration-none w-100">
                                <i class="fas fa-cart-plus"></i>
                                <p>Không tồn tại sản phẩm trong giỏ hàng</p>
                                <a href=""><span class="btn btn-warning">Về trang chủ</span></a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </form>
</div>