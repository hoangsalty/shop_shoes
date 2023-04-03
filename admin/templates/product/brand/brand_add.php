<?php
if ($act == "add_brand") $labelAct = "Thêm mới";
else if ($act == "edit_brand") $labelAct = "Chỉnh sửa";

$linkMan = "index.php?com=product&act=man_brand";
if ($act == 'add_brand') $linkFilter = "index.php?com=product&act=add_brand";
else if ($act == 'edit_brand') $linkFilter = "index.php?com=product&act=edit_brand&id=" . $id;

if ($act == 'add_brand') $linkSave = "index.php?com=product&act=save_brand";
else if ($act == 'edit_brand') $linkSave = "index.php?com=product&act=save_brand&id=" . $id;
?>

<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?> hãng sản phẩm</li>
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
            <div class="col-xl-8">
                <?php
                $slugchange = ($act == 'edit_brand') ? 1 : 0;
                include TEMPLATE . LAYOUT . "slug.php";
                ?>
                <div class=" card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Nội dung hãng sản phẩm</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Tiêu đề:</label>
                            <input type="text" class="form-control text-sm for-seo" name="data[name]" id="name" placeholder="Tiêu đề" value="<?= (!empty($flash->has('name'))) ? $flash->get('name') : @$item['name'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="desc">Mô tả:</label>
                            <textarea class="form-control text-sm <?= (isset($config['product']['desc_cke']) && $config['product']['desc_cke'] == true) ? 'form-control-ckeditor' : '' ?>" name="data[desc]" id="desc" rows="5" placeholder="Mô tả"><?= $func->decodeHtmlChars($flash->get('desc')) ?: $func->decodeHtmlChars(@$item['desc']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Hình ảnh hãng sản phẩm</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        /* Photo detail */
                        $photoDetail = array();
                        $photoDetail['upload'] = UPLOAD_PRODUCT_L;
                        $photoDetail['image'] = (!empty($item)) ? $item['photo'] : '';
                        $photoDetail['dimension'] = "Width: " . $config['product']['width'] . " px - Height: " . $config['product']['height'] . " px (.jpg|.gif|.png|.jpeg|.gif)";
                        /* Image */
                        include TEMPLATE . LAYOUT . "image.php";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>