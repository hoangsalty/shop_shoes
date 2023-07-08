<?php
if ($act == "add") $labelAct = "Thêm mới";
else if ($act == "edit") $labelAct = "Chỉnh sửa";

$linkMan = "index.php?com=product&act=list";

$status = array("noibat" => "Nổi bật", "hienthi" => "Hiển thị");
?>

<!-- Main content -->
<section class="content">
    <form id="form_product" class="validation-form" novalidate method="post" enctype="multipart/form-data">
        <div class="card-header text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <input type="hidden" name="id" value="<?= @$item['id'] ?>">
        </div>

        <div class="box_response"></div>

        <div class="row">
            <div class="col-xl-8">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Nội dung sản phẩm</h3>
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
                            <textarea class="form-control text-sm" name="data[desc]" id="desc" rows="5" placeholder="Mô tả"><?= $func->decodeHtmlChars(@$item['desc']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="content">Nội dung:</label>
                            <textarea class="form-control text-sm form-control-ckeditor" name="data[content]" id="content" rows="5" placeholder="Nội dung"><?= $func->decodeHtmlChars(@$item['content']) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin sản phẩm</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <?php $status_array = (!empty($item['status'])) ? explode(',', $item['status']) : array(); ?>
                                <?php if ($_GET['act'] == 'add') {
                                    foreach ($status as $key => $value) { ?>
                                        <div class="form-group d-inline-block mb-2 mr-2">
                                            <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                            <div class="custom-control custom-checkbox d-inline-block align-middle">
                                                <input type="checkbox" class="custom-control-input <?= $key ?>-checkbox" name="status[<?= $key ?>]" id="<?= $key ?>-checkbox" <?= ($key == 'hienthi') ? 'checked' : '' ?> value="<?= $key ?>">
                                                <label for="<?= $key ?>-checkbox" class="custom-control-label"></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php foreach ($status as $key => $value) { ?>
                                        <div class="form-group d-inline-block mb-2 mr-2">
                                            <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                            <div class="custom-control custom-checkbox d-inline-block align-middle">
                                                <input type="checkbox" class="custom-control-input <?= $key ?>-checkbox" name="status[<?= $key ?>]" id="<?= $key ?>-checkbox" <?= (empty($status_array) && empty($item['id']) ? 'checked' : in_array($key, $status_array)) ? 'checked' : '' ?> value="<?= $key ?>">
                                                <label for="<?= $key ?>-checkbox" class="custom-control-label"></label>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="d-block" for="code">Mã sản phẩm:</label>
                                <input type="text" class="form-control text-sm" name="data[code]" id="code" placeholder="Mã sản phẩm" value="<?= @$item['code'] ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="d-block" for="regular_price">Giá bán:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control format-price regular_price text-sm" name="data[regular_price]" id="regular_price" placeholder="Giá bán" value="<?= @$item['regular_price'] ?>">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><strong>VNĐ</strong></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="d-block" for="sale_price">Giá mới:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control format-price sale_price text-sm" name="data[sale_price]" id="sale_price" placeholder="Giá mới" value="<?= @$item['sale_price'] ?>">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><strong>VNĐ</strong></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="d-block" for="code">Số lượng:</label>
                                <input type="text" class="form-control format-price text-sm" name="data[quantity]" id="quantity" placeholder="Số lượng" value="<?= @$item['quantity'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <?php
                $slugchange = ($act == 'edit') ? 1 : 0;
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
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_list">Loại sản phẩm (C1):</label>
                                <?= $func->getAjaxCategory('list', 'Chọn loại') ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_cat">Loại sản phẩm (C2):</label>
                                <?= $func->getAjaxCategory('cat', 'Chọn loại') ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_color">Danh mục màu sắc:</label>
                                <?= $func->getColor(@$item['id']) ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_size">Danh mục kích thước:</label>
                                <?= $func->getSize(@$item['id']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Hình ảnh sản phẩm</h3>
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

            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Album sản phẩm</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <input type="hidden" name="gallery_table" id="gallery_table" value="gallery">

                    <div class="form-group">
                        <label for="filer-gallery" class="label-filer-gallery mb-3">Album hình: (.jpg|.png|.jpeg)</label>
                        <input type="file" name="files[]" id="filer-gallery" data-table="gallery" multiple="multiple">
                        <input type="hidden" class="col-filer" value="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
                    </div>

                    <?php if (!empty($gallery)) { ?>
                        <div class="form-group form-group-gallery">
                            <label class="label-filer">Album hiện tại:</label>
                            <div class="action-filer mb-3">
                                <a class="btn btn-sm bg-gradient-primary text-white check-all-filer mr-1"><i class="far fa-square mr-2"></i>Chọn tất cả</a>
                                <a class="btn btn-sm bg-gradient-danger text-white delete-all-filer" data-table="gallery"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
                            </div>
                            <div class="jFiler-items my-jFiler-items">
                                <ul id="jFilerSortable" class="row">
                                    <?php foreach ($gallery as $v) { ?>
                                        <li class="my-jFiler-item my-jFiler-item-<?= $v['id'] ?> col-2 mb-4" data-id="<?= $v['id'] ?>">
                                            <div class="jFiler-item-container border border-primary">
                                                <?= $func->getImage(['class' => 'rounded w-100', 'width' => 120, 'height' => 150, 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo']]) ?>
                                                <div class="jFiler-item-assets">
                                                    <ul class="list-inline pull-right d-flex align-items-center justify-content-between">
                                                        <li class="ml-1">
                                                            <a class="icon-jfi-trash jFiler-item-trash-action my-jFiler-item-trash" data-id="<?= $v['id'] ?>" data-table="gallery"></a>
                                                        </li>
                                                        <li class="mr-1">
                                                            <div class="custom-control custom-checkbox d-inline-block align-middle text-md">
                                                                <input type="checkbox" class="custom-control-input filer-checkbox" id="filer-checkbox-<?= $v['id'] ?>" value="<?= $v['id'] ?>">
                                                                <label for="filer-checkbox-<?= $v['id'] ?>" class="custom-control-label font-weight-normal">Chọn</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </form>
</section>