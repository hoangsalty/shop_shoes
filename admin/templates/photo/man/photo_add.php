<?php
if ($act == "add_photo") $labelAct = "Thêm mới";
else if ($act == "edit_photo") $labelAct = "Chỉnh sửa";

$linkMan = "index.php?com=photo&act=man_photo&type=" . $type;
if ($act == 'add_photo') $linkSave = "index.php?com=photo&act=save_photo&type=" . $type;
else if ($act == 'edit_photo') $linkSave = "index.php?com=photo&act=save_photo&type=" . $type . "&id=" . $id;

$name = '';
if ($type == 'logo') $name = 'Logo';
else if ($type == 'slideshow') $name = 'Slideshow';
else if ($type == 'album') $name = 'Album';
?>

<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?> <?= $name ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form class="validation-form" novalidate method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="row">
            <div class="col-xl-8">
                <div class=" card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Nội dung <?= $name ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if ($type != 'video' && $type != 'album') { ?>
                            <div class="form-group">
                                <label for="link">Link:</label>
                                <input type="text" class="form-control text-sm" name="data[link]" id="link" placeholder="Link" value="<?= (!empty($flash->has('link'))) ? $flash->get('link') : @$item['link'] ?>">
                            </div>
                        <?php } ?>
                        <?php if ($type == 'video') { ?>
                            <div class="form-group">
                                <label for="link_video">Link Video (Youtube):</label>
                                <input type="text" class="form-control text-sm" name="data[link_video]" id="link_video" onchange="youtubePreview(this.value,'#loadVideo');" placeholder="Video" value="<?= (!empty($flash->has('link_video'))) ? $flash->get('link_video') : @$item['link_video'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="link_video">Video preview:</label>
                                <?php if (!empty($item['link_video'])) { ?>
                                    <div><iframe id="loadVideo" width="500" <?= (@$item["link_video"] == '') ? "height='0px'" : "height='300px'"; ?> src="//www.youtube.com/embed/<?= $func->getYoutube($item['link_video']) ?>" frameborder="0" allowfullscreen></iframe></div>
                                <?php } else { ?>
                                    <div><iframe id="loadVideo" width="0px" height="0px" frameborder="0" allowfullscreen></iframe></div>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label for="name">Tiêu đề:</label>
                            <input type="text" class="form-control text-sm" name="data[name]" id="name" placeholder="Tiêu đề" value="<?= (!empty($flash->has('name'))) ? $flash->get('name') : @$item['name'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="desc">Mô tả:</label>
                            <textarea class="form-control text-sm" name="data[desc]" id="desc" rows="5" placeholder="Mô tả"><?= $func->decodeHtmlChars($flash->get('desc')) ?: $func->decodeHtmlChars(@$item['desc']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
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
                        $photoDetail['upload'] = UPLOAD_PHOTO_L;
                        $photoDetail['image'] = (!empty($item)) ? $item['photo'] : '';
                        $photoDetail['dimension'] = "Width: " . $config[$type]['width'] . " px - Height: " . $config[$type]['height'] . " px (.jpg|.gif|.png|.jpeg|.gif)";
                        /* Image */
                        include TEMPLATE . LAYOUT . "image.php";
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($type == 'album') { ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Album hình ảnh</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="filer-gallery" class="label-filer-gallery mb-3">Album hình: (.jpg|.gif|.png|.jpeg|.gif)</label>
                        <input type="file" name="files[]" id="filer-gallery" multiple="multiple">
                        <input type="hidden" class="col-filer" value="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
                        <input type="hidden" class="folder-filer" value="product">
                    </div>
                    <div class="form-group form-group-gallery">
                        <label class="label-filer">Album hiện tại:</label>
                        <div class="action-filer mb-3">
                            <a class="btn btn-sm bg-gradient-primary text-white check-all-filer mr-1"><i class="far fa-square mr-2"></i>Chọn tất cả</a>
                            <a class="btn btn-sm bg-gradient-danger text-white delete-all-filer" data-table="gallery_album"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
                        </div>
                        <div class="alert my-alert alert-sort-filer alert-info text-sm text-white bg-gradient-info"><i class="fas fa-info-circle mr-2"></i>Có thể chọn nhiều hình để di chuyển</div>
                        <div class="jFiler-items my-jFiler-items jFiler-row">
                            <ul class="jFiler-items-list jFiler-items-grid row scroll-bar" id="jFilerSortable">
                                <?php if (!empty($gallery)) { ?>
                                    <?php foreach ($gallery as $v) { ?>
                                        <li class="jFiler-item my-jFiler-item my-jFiler-item-<?= $v['id'] ?> col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6" data-id="<?= $v['id'] ?>">
                                            <div class="jFiler-item-container">
                                                <div class="jFiler-item-inner">
                                                    <div class="jFiler-item-thumb">
                                                        <div class="jFiler-item-thumb-image">
                                                            <?= $func->getImage(['class' => 'rounded', 'width' => 120, 'height' => 100, 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                                                            <i class="fas fa-arrows-alt"></i>
                                                        </div>
                                                    </div>
                                                    <div class="jFiler-item-assets jFiler-row">
                                                        <ul class="list-inline pull-right d-flex align-items-center justify-content-between">
                                                            <li class="ml-1">
                                                                <a class="icon-jfi-trash jFiler-item-trash-action my-jFiler-item-trash" data-id="<?= $v['id'] ?>" data-table="gallery_album"></a>
                                                            </li>
                                                            <li class="mr-1">
                                                                <div class="custom-control custom-checkbox d-inline-block align-middle text-md">
                                                                    <input type="checkbox" class="custom-control-input filer-checkbox" id="filer-checkbox-<?= $v['id'] ?>" value="<?= $v['id'] ?>">
                                                                    <label for="filer-checkbox-<?= $v['id'] ?>" class="custom-control-label font-weight-normal">Chọn</label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <input type="number" class="form-control form-control-sm my-jFiler-item-info rounded mb-1 text-sm" value="<?= $v['numb'] ?>" placeholder="Số thứ tự" data-info="numb" data-id="<?= $v['id'] ?>" />
                                                    <input type="text" class="form-control form-control-sm my-jFiler-item-info rounded text-sm" value="<?= $v['name'] ?>" placeholder="Tiêu đề" data-info="name" data-id="<?= $v['id'] ?>" />
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </form>
</section>