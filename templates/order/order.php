<?php /* 
<form class="form-cart validation-cart" novalidate method="post" action="" enctype="multipart/form-data">
<div class="wrap-cart">
   <?= $flash->getMessages("frontend") ?>
   <div class="row">
       <?php if (!empty($_SESSION['cart'])) { ?>
           <div class="top-cart col-12 col-lg-7">
               <p class="title-cart">Giỏ hàng của bạn:</p>
               <div class="list-procart">
                   <div class="procart procart-label">
                       <div class="form-row">
                           <div class="pic-procart col-3 col-md-2">Hình ảnh</div>
                           <div class="info-procart col-6 col-md-5">Tên sản phẩm</div>
                           <div class="quantity-procart col-3 col-md-2">Số lượng</div>
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
                           <div class="form-row">
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
                                   <div class="quantity-counter-procart quantity-counter-procart-<?= $code ?>">
                                       <span class="counter-procart-minus counter-procart">-</span>
                                       <input type="number" class="quantity-procart" min="1" value="<?= $quantity ?>" data-pid="<?= $pid ?>" data-code="<?= $code ?>" readonly />
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
                               <input type="radio" class="custom-control-input" id="payments-<?= $value['slug'] ?>" name="dataOrder[payments]" value="<?= $value['slug'] ?>" <?= (!empty($flashPayment) && $flashPayment == $value['slug']) ? 'checked' : '' ?> required>
                               <label class="payments-label custom-control-label" for="payments-<?= $value['slug'] ?>" data-payments="<?= $value['slug'] ?>"><?= $value['name'] ?></label>
                               <div class="payments-info payments-info-<?= $value['slug'] ?> transition"><?= str_replace("\n", "<br>", $value['desc']) ?></div>
                           </div>
                       <?php } ?>

                       <div class="payments-cart custom-control custom-radio">
                           <input type="radio" class="custom-control-input" id="payments-momo" name="dataOrder[payments]" value="momo" <?= (!empty($flashPayment) && $flashPayment == 'momo') ? 'checked' : '' ?> required>
                           <label class="payments-label custom-control-label" for="payments-momo" data-payments="momo"><img src="assets/images/momo_icon.png" alt=""> Thanh toán qua Momo</label>
                           <div class="payments-info payments-info-momo transition">Thanh toán qua cổng thanh toán momo</div>
                       </div>

                   <div class="payments-cart custom-control custom-radio">
                           <input type="radio" class="custom-control-input" id="payments-vnpay" name="dataOrder[payments]" value="vnpay" <?= (!empty($flashPayment) && $flashPayment == 'vnpay') ? 'checked' : '' ?> required>
                           <label class="payments-label custom-control-label" for="payments-vnpay" data-payments="vnpay"><img src="assets/images/vnpay_icon.png" alt=""> Thanh toán qua VNPay</label>
                           <div class="payments-info payments-info-vnpay transition">Thanh toán qua cổng thanh toán VNPay</div>
                       </div>
                   </div>
                   <p class="title-cart">Thông tin giao hàng:</p>
                   <div class="information-cart">
                       <div class="form-row">
                           <div class="input-cart col-md-6">
                               <input type="text" class="form-control text-sm" id="fullname" name="dataOrder[fullname]" placeholder="Họ tên" value="<?= !empty($_SESSION['account']['fullname']) ? $_SESSION['account']['fullname'] : '' ?>" required />
                               <div class="invalid-feedback">Vui lòng nhập họ tên</div>
                           </div>
                           <div class="input-cart col-md-6">
                               <input type="number" class="form-control text-sm" id="phone" name="dataOrder[phone]" placeholder="Số điện thoại" value="<?= !empty($_SESSION['account']['phone']) ? $_SESSION['account']['phone'] : '' ?>" required />
                               <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                           </div>
                       </div>
                       <div class="input-cart">
                           <input type="email" class="form-control text-sm" id="email" name="dataOrder[email]" placeholder="Email" value="<?= !empty($_SESSION['account']['email']) ? $_SESSION['account']['email'] : '' ?>" required />
                           <div class="invalid-feedback">Vui lòng nhập email</div>
                       </div>
                       <p class="title-cart">Khu vực ship:</p>

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
                           <input type="text" class="form-control text-sm" id="address" name="dataOrder[address]" placeholder="Địa chỉ" value="<?= !empty($_SESSION['account']['address']) ? $_SESSION['account']['address'] : '' ?>" required />
                           <div class="invalid-feedback">Vui lòng nhập địa chỉ</div>
                       </div>
                       <div class="input-cart">
                           <textarea class="form-control text-sm" id="requirements" name="dataOrder[requirements]" placeholder="Yêu cầu khác"><?= (!empty($flash->has('requirements'))) ? $flash->get('requirements') : '' ?></textarea>
                       </div>
                   </div>

                   <div class="btn_submit">
                       <input type="submit" class="btn btn-primary btn-cart w-100" name="thanhtoan" value="Thanh toán" />
                   </div>
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
*/ ?>

<form class="form-cart validation-cart" novalidate method="post" action="" enctype="multipart/form-data">
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

            <div class="content-debug">
                <?= $flash->getMessages("frontend") ?>
            </div>
            <div class="content-outter">
                <?php if (!empty($_SESSION['cart'])) { ?>
                    <div class="content-flex">
                        <div class="content">
                            <div class="infoBox">
                                <div class="title">Hình thức thanh toán</div>

                                <div class="payment-box">
                                    <?php $flashPayment = $flash->get('payments'); ?>
                                    <?php foreach ($payments_info as $key => $value) { ?>
                                        <div class="payments-cart custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="payments-<?= $value['slug'] ?>" name="dataOrder[payments]" value="<?= $value['slug'] ?>" <?= (!empty($flashPayment) && $flashPayment == $value['slug']) ? 'checked' : '' ?> required>
                                            <label class="payments-label custom-control-label" for="payments-<?= $value['slug'] ?>" data-payments="<?= $value['slug'] ?>"><?= $value['name'] ?></label>
                                            <div class="payments-info payments-info-<?= $value['slug'] ?> transition"><?= str_replace("\n", "<br>", $value['desc']) ?></div>
                                        </div>
                                    <?php } ?>

                                    <?php /* 
                               <div class="payments-cart custom-control custom-radio">
                                   <input type="radio" class="custom-control-input" id="payments-momo" name="dataOrder[payments]" value="momo" <?= (!empty($flashPayment) && $flashPayment == 'momo') ? 'checked' : '' ?> required>
                                   <label class="payments-label custom-control-label" for="payments-momo" data-payments="momo"><img src="assets/images/momo_icon.png" alt=""> Thanh toán qua Momo</label>
                                   <div class="payments-info payments-info-momo transition">Thanh toán qua cổng thanh toán momo</div>
                               </div>
                               */ ?>

                                    <div class="payments-cart custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="payments-vnpay" name="dataOrder[payments]" value="vnpay" <?= (!empty($flashPayment) && $flashPayment == 'vnpay') ? 'checked' : '' ?> required>
                                        <label class="payments-label custom-control-label" for="payments-vnpay" data-payments="vnpay"><img src="assets/images/vnpay_icon.png" alt=""> Thanh toán qua
                                            VNPay</label>
                                        <div class="payments-info payments-info-vnpay transition">Thanh toán qua cổng thanh toán
                                            VNPay</div>
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
                                        <div class="input-select">
                                            <select class="select-city-cart" id="city" name="dataOrder[city]" required>
                                                <option value="" selected disabled>Tỉnh thành *</option>
                                                <?php foreach ($city as $k => $v) { ?>
                                                    <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
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
                                            <input type="text" class="form-control text-sm" id="address" name="dataOrder[address]" placeholder="Địa chỉ" value="<?= !empty($_SESSION['account']['address']) ? $_SESSION['account']['address'] : '' ?>" required />
                                            <div class="invalid-feedback">Vui lòng nhập địa chỉ</div>
                                        </div>
                                    </div>
                                    <div class="form-input">
                                        <textarea rows="5" class="form-control text-sm" id="requirements" name="dataOrder[requirements]" placeholder="Yêu cầu khác"><?= (!empty($flash->has('requirements'))) ? $flash->get('requirements') : '' ?></textarea>
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
                                                <span class="total-price load-price-ship" rel="currency" id="price-ship">0đ</span>
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
                                            <p class="total-price load-price-temp">
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