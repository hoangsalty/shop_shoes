<?php
$linkSave = "index.php?com=photo&act=save_static&type=" . $type;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Quản lý hình ảnh</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form id="form_static_photo" class="validation-form" novalidate method="post" enctype="multipart/form-data">
        <div class="card-header text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <input type="hidden" id="type" name="type" value="<?= $type ?>">
        </div>

        <div class="box_response"></div>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Chi tiết Logo</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="upload-file">
                        <p>Upload hình ảnh:</p>
                        <label class="upload-file-label mb-2" for="file">
                            <div class="upload-file-image rounded mb-3">
                                <?= $func->getImage(['class' => 'rounded img-preview', 'width' => 98, 'height' => 31, 'upload' => UPLOAD_PHOTO_L, 'image' => (!empty($item['photo'])) ? $item['photo'] : '', 'alt' => (!empty($item['name'])) ? $item['name'] : '']) ?>
                            </div>
                            <div class="custom-file my-custom-file">
                                <input type="file" class="custom-file-input" name="file" id="file" lang="vi">
                                <label class="custom-file-label mb-0" data-browse="Chọn" for="file">Chọn file</label>
                            </div>
                        </label>
                        <strong class="d-block text-sm"><?php echo "Width: " . $config['logo']['width'] . " px - Height: " . $config['logo']['height'] . " px (.jpg|.gif|.png|.jpeg|.gif)" ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>