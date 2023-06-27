<?php
if ($act == "add") $labelAct = "Thêm mới";
else if ($act == "edit") $labelAct = "Chỉnh sửa";

$linkMan = "index.php?com=news&act=list&type=" . $type;

$name = '';
if ($type == 'tin-tuc') $name = 'Tin tức';
else if ($type == 'hinh-thuc-thanh-toan') $name = 'Hình thức thanh toán';
?>

<!-- Main content -->
<section class="content">
    <form id="form_news" class="validation-form" novalidate method="post" enctype="multipart/form-data">
        <div class="card-header text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <input type="hidden" id="id" name="id" value="<?= @$item['id'] ?>">
            <input type="hidden" id="type" name="type" value="<?= $type ?>">
        </div>

        <div class="box_response"></div>

        <div class="row">
            <div class="col-xl-8">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Nội dung <?= $name ?></h3>
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
            </div>
            <div class="col-xl-4">
                <div class="card card-primary card-outline text-sm">
                    <?php
                    $slugchange = ($act == 'edit') ? 1 : 0;
                    include TEMPLATE . LAYOUT . "slug.php";
                    ?>
                </div>

                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Hình ảnh <?= $name ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        /* Photo detail */
                        $photoDetail = array();
                        $photoDetail['upload'] = UPLOAD_NEWS_L;
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