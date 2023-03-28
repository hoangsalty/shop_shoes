<?php
if ($act == "add_size") $labelAct = "Thêm mới";
else if ($act == "edit_size") $labelAct = "Chỉnh sửa";

$linkMan = "index.php?com=product&act=man_size";
if ($act == 'add_size') $linkFilter = "index.php?com=product&act=add_size";
else if ($act == 'edit_size') $linkFilter = "index.php?com=product&act=edit_size&id=" . $id;

if ($act == 'add_size') $linkSave = "index.php?com=product&act=save_size";
else if ($act == 'edit_size') $linkSave = "index.php?com=product&act=save_size&id=" . $id;
?>

<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?> size sản phẩm</li>
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

        <div class="row">
            <div class="col-xl-12"">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tiêu đề:</label>
                        <input type="text" class="form-control text-sm" name="data[name]" id="name" placeholder="Tiêu đề" value="<?= (!empty($flash->has('name'))) ? $flash->get('name') : @$item['name'] ?>" required>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>