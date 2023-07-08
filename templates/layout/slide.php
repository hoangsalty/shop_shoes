<div class="slideshow">
    <div class="slideshow__slider owl-carousel control-owl">
        <?php foreach ($slider as $v) { ?>
            <div class="slideshow-item" owl-item-animation>
                <div class="images">
                    <a class="slideshow-image" href="<?= $v['link'] ?>" target="_blank" title="<?= $v['name'] ?>">
                        <?= $func->getImage(['class' => 'w-100', 'width' => $config['slideshow']['width'], 'height' => $config['slideshow']['height'], 'upload' => UPLOAD_PHOTO_L, 'image' => $v['photo']]) ?>
                    </a>
                </div>
                <div class="info">
                    <div class="wrap-content">
                        <label>Webcome to</label>
                        <span class="text-split"><?= $v['name'] ?></span>
                        <p class="text-split"><?= $v['desc'] ?></p>
                        <a href="<?= $v['link'] ?>" target="_blank">Xem thêm</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>