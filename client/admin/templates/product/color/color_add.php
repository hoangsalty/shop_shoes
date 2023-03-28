<?php
if ($act == "add_color") $labelAct = "Thêm mới";
else if ($act == "edit_color") $labelAct = "Chỉnh sửa";

$linkMan = "index.php?com=product&act=man_color";
if ($act == 'add_color') $linkFilter = "index.php?com=product&act=add_color";
else if ($act == 'edit_color') $linkFilter = "index.php?com=product&act=edit_color&id=" . $id;

if ($act == 'add_color') $linkSave = "index.php?com=product&act=save_color";
else if ($act == 'edit_color') $linkSave = "index.php?com=product&act=save_color&id=" . $id;
?>

<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?> màu sản phẩm</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form class="validation-form" novalidate method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here" disabled><i class="far fa-save mr-2"></i>Lưu tại trang</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title"><?= ($act == "edit_color") ? "Cập nhật" : "Thêm mới"; ?> màu sắc sản phẩm</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group">
                        <label for="name">Tiêu đề:</label>
                        <input type="text" class="form-control text-sm" name="data[name]" id="name" placeholder="Tiêu đề" value="<?= (!empty($flash->has('name'))) ? $flash->get('name') : @$item['name'] ?>" required>
                    </div>

                    <div class="form-group col-md-3 col-sm-4">
                        <label class="d-block" for="color">Màu sắc:</label>
                        <input type="text" class="form-control jscolor text-sm" name="data[color]" id="color" maxlength="7" value="<?= (!empty($flash->has('color'))) ? $flash->get('color') : ((!empty($item['color'])) ? $item['color'] : '#000000') ?>">
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>