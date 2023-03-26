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
                <li class="breadcrumb-item"><a href="index.php" title="Dashboard">Dashboard</a></li>
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
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here" disabled><i class="far fa-save mr-2"></i>Lưu tại trang</button>
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
                        <?php if ($type != 'video') { ?>
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
    </form>
</section>