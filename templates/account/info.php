<div class="flex_info">
    <div class="left_info">
        <div class="flex_info_user">
            <?= $func->getImage(['class' => 'img-circle', 'width' => 50, 'height' => 50, 'upload' => UPLOAD_USER_L, 'image' => $rowDetail['photo'], 'alt' => $rowDetail['fullname']]) ?>
            <div class="info_user">
                <p class="name_user"><?= $rowDetail['fullname'] ?></p>
                <p class="username_user"><?= $rowDetail['username'] ?></p>
            </div>
        </div>

        <ul class="list_mananger">
            <li>
                <img src="assets/images/user_acc.png" alt="">
                <a class="d-block sty_list act" data-vitri="1">Quản lý thông tin</a>
            </li>
            <li>
                <img src="assets/images/order_acc.png" alt="">
                <a class="d-block sty_list" data-vitri="2">Quản lý đơn hàng</a>
            </li>
        </ul>
    </div>
    <div class="right_info">
        <div class="container_load_info load1">
            <div class="wrap_info_user">
                <div class="top_info_user">
                    <h1>Hồ sơ của tôi</h1>
                    <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
                </div>
                <form class="form-user validation-user" novalidate method="post" action="account/thong-tin" enctype="multipart/form-data">

                    <div class="bottom_info_user">
                        <div class="form_user">
                            <?= $flash->getMessages("frontend") ?>
                            <table class="table_form">
                                <tr>
                                    <td><label>Tên</label></td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-sm" id="fullname" name="fullname" placeholder="" value="<?= $rowDetail['fullname'] ?>">
                                            <div class="invalid-feedback">Vui lòng nhập tên</div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><label>Tên đăng nhập</label></td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-sm" id="username" name="username" placeholder="" value="<?= $rowDetail['username'] ?>" readonly required>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><label>Ngày sinh</label></td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-sm" id="birthday" name="birthday" placeholder="" value="<?= date("d/m/Y", $rowDetail['birthday']) ?>" required autocomplete="off">
                                            <div class="invalid-feedback">Vui lòng chọn ngày sinh</div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><label>Email</label></td>
                                    <td>
                                        <div class="input-group">
                                            <input type="email" class="form-control text-sm" id="email" name="email" placeholder="" value="<?= $rowDetail['email'] ?>" required>
                                            <div class="invalid-feedback">Vui lòng nhập địa chỉ email</div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><label>Điện thoại</label></td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" class="form-control text-sm" id="phone" name="phone" placeholder="" value="<?= $rowDetail['phone'] ?>" required>
                                            <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><label>Địa chỉ</label></td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-sm" id="address" name="address" placeholder="" value="<?= $rowDetail['address'] ?>" required>
                                            <div class="invalid-feedback">Vui lòng nhập địa chỉ</div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><label>Giới tính</label></td>
                                    <td>
                                        <div class="input-group">
                                            <div class="radio-user custom-control custom-radio">
                                                <input type="radio" id="nam" name="gender" class="custom-control-input" <?= (($rowDetail['gender'] == 1) ? 'checked' : '') ?> value="1" required>
                                                <label class="custom-control-label" for="nam">Nam</label>
                                            </div>
                                            <div class="radio-user custom-control custom-radio">
                                                <input type="radio" id="nu" name="gender" class="custom-control-input" <?= (($rowDetail['gender'] == 2) ? 'checked' : '') ?> value="2" required>
                                                <label class="custom-control-label" for="nu">Nữ</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><label></label></td>
                                    <td>
                                        <div class="button-user">
                                            <input type="submit" class="sty_btn_info btn-block" name="info-user" value="Lưu">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="avatar_user">
                            <div class="photoUpload-zone">
                                <div class="photoUpload-detail" id="photoUpload-preview">
                                    <?= $func->getImage(['class' => 'rounded', 'size-error' => '250x250x1', 'upload' => UPLOAD_USER_L, 'image' => $rowDetail['photo'], 'alt' => 'Alt Photo']) ?>
                                </div>
                                <label class="photoUpload-file" id="photo-zone" for="file-zone">
                                    <input type="file" name="file" id="file-zone">
                                    <p class="photoUpload-choose btn btn-sm">Chọn Ảnh</p>
                                </label>
                                <div class="photoUpload-dimension">Width: 100 px - Height: 100 px (.jpg|.gif|.png|.jpeg|.gif)</div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <div class="container_load_info load2">
            <div class="title-user">
                <span>Thông tin đơn hàng</span>
            </div>
            <?php if (array_key_exists("account", $_SESSION) && $_SESSION["account"]['active'] == true) { ?>
                <?php
                $iduser = $_SESSION["account"]['id'];
                $donhang = $d->rawQuery("select * from table_order where id_user = ?", array($iduser));
                if (!empty($donhang)) { ?>
                    <?php foreach ($donhang as $v1) {
                        $chitiet = $d->rawQuery("select * from table_order_detail where id_order = ?", array($v1['id']));
                        $tinhtrang = $v1["order_status"];
                    ?>
                        <div class="wrap-cart box-ql-donhang">
                            <div class="top-cart">
                                <div class="title-cart">
                                    <p>Đơn hàng: <span><?= $v1['code'] ?></span></p>
                                    <p><?= $func->convertOrderStatus($tinhtrang) ?></p>
                                </div>
                                <div class="list-procart">
                                    <table class="table">
                                        <thead>
                                            <th scope="col" width="50">STT</th>
                                            <th scope="col" width="150px">Hình ảnh</th>
                                            <th scope="col">Tên sản phẩm</th>
                                            <th scope="col" width="100px">Ngày đặt</th>
                                            <th scope="col" class="text-center">Số lượng</th>
                                            <th scope="col">Thành tiền</th>
                                        </thead>
                                        <?php foreach ($chitiet as $k2 => $v2) {
                                            $pid = $v2['id_product'];
                                            $quantity = $v2['quantity'];
                                            $proinfo = $cart->getProductInfo($pid);
                                            $pro_price = $v2['price'];
                                            $pro_price_qty = $pro_price * $quantity;
                                        ?>
                                            <tbody>
                                                <th><?= $k2 ?></th>
                                                <th><?= $func->getImage(['class' => 'rounded img-preview', 'width' => 150, 'height' => 100, 'upload' => UPLOAD_PRODUCT_L, 'image' => $v2['photo'], 'alt' => $v2['name']]) ?></th>
                                                <th>
                                                    <h3 class="name-procart"><a class="text-decoration-none" target="_blank" title="<?= $v2['name'] ?>" href="<?= $proinfo['slug'] ?>"><?= $v2['name'] ?></a></h3>
                                                </th>
                                                <th><?= date("d/m/Y", $v1['date_created']) ?></th>
                                                <th class="text-center"><?= $quantity ?></th>
                                                <th>
                                                    <p class="total-price load-price-total"><?= $func->formatMoney($pro_price_qty) ?></p>
                                                </th>
                                            </tbody>
                                        <?php } ?>
                                    </table>
                                </div>
                                <div class="money-procart">
                                    <div class="total-procart d-flex align-items-center justify-content-between">
                                        <p>Tổng tiền:</p>
                                        <p class="total-price load-price-total"><?= $func->formatMoney($v1['total_price']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <a href="san-pham" class="sty_btn_info empty-cart">
                        <i class="fa fa-cart-arrow-down"></i>
                        <p>Bạn chưa có đơn hàng nào</p>
                        <span>Vào mua hàng</span>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>