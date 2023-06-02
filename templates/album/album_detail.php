<div class="title-main"><span><?= $rowDetail['name'] ?></span></div>
<div class="content-main album-gallery form-row w-clear">
    <?php if (!empty($rowDetailPhoto)) {
        foreach ($rowDetailPhoto as $k => $v) { ?>
            <div class="album col-6 col-md-4 col-lg-3 col-xl-3">
                <a class="album-image scale-img" href="<?= UPLOAD_PRODUCT_L . $v['photo'] ?>" title="<?= $rowDetail['name'] ?>">
                    <?= $func->getImage(['upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $rowDetail['name']]) ?>
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