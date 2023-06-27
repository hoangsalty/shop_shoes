<?php
if ($act == "add_cat") $labelAct = "Thêm mới";
else if ($act == "edit_cat") $labelAct = "Chỉnh sửa";

$linkMan = "index.php?com=product&act=man_cat";
?>

<!-- Main content -->
<section class="content">
    <form id="form_product_cat" method="post" class="validation-form" novalidate enctype="multipart/form-data">
        <div class="card-header text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
        </div>

        <div class="box_response"></div>

        <div class="row">
            <div class="col-xl-8">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Nội dung loại sản phẩm</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Tiêu đề:</label>
                            <input type="text" class="form-control text-sm for-slug" name="data[name]" id="name" placeholder="Tiêu đề" value="<?= @$item['name'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="desc">Mô tả:</label>
                            <textarea class="form-control text-sm <?= (isset($config['product']['desc_cke']) && $config['product']['desc_cke'] == true) ? 'form-control-ckeditor' : '' ?>" name="data[desc]" id="desc" rows="5" placeholder="Mô tả"><?= $func->decodeHtmlChars(@$item['desc']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <?php
                $slugchange = ($act == 'edit_cat') ? 1 : 0;
                include TEMPLATE . LAYOUT . "slug.php";
                ?>

                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Danh mục sản phẩm</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group-category row">
                            <div class="col-xl-6 col-sm-4">
                                <label class="d-block" for="id_list">Loại sản phẩm (C1):</label>
                                <?= $func->getAjaxCategory('list', 'Chọn loại') ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Hình ảnh loại sản phẩm</h3>
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
                        /* Image */
                        include TEMPLATE . LAYOUT . "image.php";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>