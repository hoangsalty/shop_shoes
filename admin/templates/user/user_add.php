<?php
if ($act == "add")
    $labelAct = "Thêm mới";
else if ($act == "edit" || $act == 'info')
    $labelAct = "Chỉnh sửa";

$linkMan = "index.php?com=user&act=list";

$status = array("hoatdong" => "Hoạt động", "khoa" => "Khóa");
?>
<!-- Main content -->
<section class="content">
    <form id="form_user" class="validation-form" novalidate method="post" enctype="multipart/form-data">
        <div class="card-header text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <input type="hidden" name="id" value="<?= @$item['id'] ?>">
            <input type="hidden" name="changepass" value="<?= @$_REQUEST['changepass'] ?>">
        </div>

        <div class="box_response"></div>

        <div class="row">
            <?php if (isset($_REQUEST['changepass']) && $_REQUEST['changepass'] == 1) { ?>
                <div class="col-xl-12">
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Đổi mật khẩu</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-xl-4 col-lg-6 col-md-6">
                                    <label for="old-password">Mật khẩu cũ:</label>
                                    <input type="password" class="form-control text-sm" name="old-password" id="old-password" placeholder="Mật khẩu cũ" required>
                                </div>
                                <div class="form-group col-xl-4 col-lg-6 col-md-6">
                                    <label for="new-password">
                                        <span class="d-inline-block align-middle">Mật khẩu mới:</span>
                                    </label>
                                    <div class="row align-items-center">
                                        <input type="password" class="form-control text-sm" name="new-password" id="new-password" placeholder="Mật khẩu mới" required>
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 col-lg-6 col-md-6">
                                    <label for="renew-password">Nhập lại mật khẩu mới:</label>
                                    <input type="password" class="form-control text-sm" name="renew-password" id="renew-password" placeholder="Nhập lại mật khẩu mới" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
                        <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-xl-4">
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Avatar</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            /* Photo detail */
                            $photoDetail = array();
                            $photoDetail['upload'] = UPLOAD_USER_L;
                            $photoDetail['image'] = (!empty($item)) ? $item['photo'] : '';
                            /* Image */
                            include TEMPLATE . LAYOUT . "image.php";
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title"><?= $labelAct ?> tài khoản</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="id_permission">Danh sách nhóm quyền:</label>
                                    <?= $func->getPermission(@$item['permission']) ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">Tài khoản: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-sm" name="data[username]" id="username" placeholder="Tài khoản" value="<?= @$item['username'] ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fullname">Họ tên: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-sm" name="data[fullname]" id="fullname" placeholder="Họ tên" value="<?= @$item['fullname'] ?>" required>
                                </div>
                                <?php if ($act == 'add') { ?>
                                    <div class="form-group col-md-6">
                                        <label for="password">Mật khẩu:</label>
                                        <input type="password" class="form-control text-sm" name="data[password]" id="password" placeholder="Mật khẩu" <?= ($act == "add") ? 'required' : ''; ?>>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="confirm_password">Nhập lại mật khẩu:</label>
                                        <input type="password" class="form-control text-sm" name="confirm_password" id="confirm_password" placeholder="Nhập lại mật khẩu" <?= ($act == "add") ? 'required' : ''; ?>>
                                    </div>
                                <?php } ?>
                                <div class="form-group col-md-6">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control text-sm" name="data[email]" id="email" placeholder="Email" value="<?= @$item['email'] ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">Điện thoại:</label>
                                    <input type="text" class="form-control text-sm" name="data[phone]" id="phone" placeholder="Điện thoại" value="<?= @$item['phone'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="gender">Giới tính:</label>
                                    <select class="form-control select2 text-sm" name="data[gender]" id="gender" required>
                                        <option value="">Chọn giới tính</option>
                                        <option <?= ((@$item['gender'] == 1) ? 'selected' : '') ?> value="1">Nam</option>
                                        <option <?= ((@$item['gender'] == 2) ? 'selected' : '') ?> value="2">Nữ</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="birthday">Ngày sinh:</label>
                                    <input type="text" class="form-control text-sm max-date" name="data[birthday]" id="birthday" placeholder="Ngày sinh" value="<?= ((!empty($item['birthday'])) ? date("d/m/Y", $item['birthday']) : '') ?>" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Địa chỉ:</label>
                                    <input type="text" class="form-control text-sm" name="data[address]" id="address" placeholder="Địa chỉ" value="<?= @$item['address'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status">Trạng thái:</label>
                                    <select class="form-control select2 text-sm" name="data[status]" id="data[status]" required>
                                        <option value="">Chọn trạng thái</option>
                                        <?php foreach ($status as $i => $v) { ?>
                                            <option <?= ((@$item['status'] == $i) ? 'selected' : '') ?> value="<?= $i ?>"><?= $v ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </form>
</section>