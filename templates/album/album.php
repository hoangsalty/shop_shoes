<div class="title-main"><span><?= $titleMain ?></span></div>
<div class="content-main">
    <div class="row">
        <?php if (!empty($album)) {
            foreach ($album as $k => $v) { ?>
                <div class="album col-lg-3 col-md-4 col-6">
                    <a class="album-item text-decoration-none transition" href="<?= $v['link'] ?>" title="<?= $v['name'] ?>">
                        <div class="image scale-img">
                            <?= $func->getImage(['class' => 'w-100', 'width' => $config['album']['width'], 'height' => $config['album']['height'], 'upload' => UPLOAD_PHOTO_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                        </div>
                        <div class="info">
                            <h3 class="name text-split"><?= $v['name'] ?> </h3>
                        </div>
                    </a>
                </div>
            <?php }
        } else { ?>
            <div class="col-12">
                <div class="alert alert-warning w-100" role="alert">
                    <strong>Không tìm thấy kết quả</strong>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="clear"></div>
    <div class="col-12">
        <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
    </div>
</div>