<div class="flex_info">
    <div class="left_info">
        <div class="flex_info_user">
            <?= $func->getImage(['class' => 'img-circle', 'width' => 50, 'height' => 50, 'upload' => UPLOAD_USER_L, 'image' => $rowDetail['photo'], 'alt' => $rowDetail['fullname']]) ?>
            <div class="info_user">
                <p class="name_user"><?= $rowDetail['fullname'] ?></p>
                <p class="username_user"><?= $rowDetail['username'] ?></p>
            </div>
        </div>

        <ul class="list_mananger nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <img src="assets/images/user_acc.png" alt="">
                <a href="#info" class="sty_list active" id="info-tab" data-toggle="tab" data-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">Quản lý tài khoản</a>
            </li>
            <li class="nav-item" role="presentation">
                <img src="assets/images/order_acc.png" alt="">
                <a href="#order" class="sty_list" id="order-tab" data-toggle="tab" data-target="#order" type="button" role="tab" aria-controls="order" aria-selected="false">Quản lý đơn hàng</a>
            </li>
        </ul>
        <a id="change_pass_user" type="button"><img src="assets/images/user_acc.png" alt=""> Đổi mật khẩu</a>
    </div>

    <div class="right_info">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                <div class="container_load_info">
                    <div class="wrap_info_user">
                        <div class="top_info_user">
                            <h1>Hồ sơ của tôi</h1>
                            <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
                        </div>
                        <form id="form_user" class="form-user validation-form" novalidate method="post" enctype="multipart/form-data">
                            <div class="bottom_info_user">
                                <div class="form_user">

                                    <div class="box_response"></div>

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
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="order" role="tabpanel" aria-labelledby="order-tab">
                <div class="container_load_info">
                    <?php
                    $row_status = array(
                        array('id' => 'moidat', 'name' => 'Mới đặt'),
                        array('id' => 'daxacnhan', 'name' => 'Đã xác nhận'),
                        array('id' => 'danggiaohang', 'name' => 'Đang giao hàng'),
                        array('id' => 'dagiao', 'name' => 'Đã giao'),
                        array('id' => 'dahuy', 'name' => 'Đã hủy'),
                    );
                    ?>
                    <div class="nav_status_order">
                        <a href="javascript:void()" data-status="" title="Tất cả"><span>Tất cả</span></a>
                        <?php foreach ($row_status as $i => $status) { ?>
                            <a href="javascript:void()" data-id="<?= $status['id'] ?>" title="<?= $status['name'] ?>"><span><?= $status['name'] ?></span></a>
                        <?php } ?>
                    </div>

                    <div class="status_order"></div>
                </div>
            </div>
        </div>
    </div>
</div>