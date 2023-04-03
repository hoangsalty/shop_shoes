<div class="slideshow">
    <div class="wrap-content">
        <div class="slideshow__main">
            <div class="slideshow__slider owl-carousel control-owl">
                <?php foreach ($slider as $v) { ?>
                    <div class="slideshow-item" owl-item-animation>
                        <a class="slideshow-image" href="<?= $v['link'] ?>" target="_blank" title="<?= $v['name'] ?>">
                            <?= $func->getImage(['class' => 'w-100', 'width' => $config['slideshow']['width'], 'height' => $config['slideshow']['height'], 'upload' => UPLOAD_PHOTO_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>