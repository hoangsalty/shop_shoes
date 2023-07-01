<div class="menu">
    <div class="wrap-content">
        <div class="menu_container d-flex justify-content-between align-items-center">
            <div class="left">
                <a class="logo-header" href="">
                    <?= $func->getImage(['class' => '', 'width' => $config['logo']['width'], 'height' => $config['logo']['height'], 'upload' => UPLOAD_PHOTO_L, 'image' => $logo['photo'], 'alt' => $logo['name']]) ?>
                </a>
            </div>
            <div class="center">
                <ul class="menu-main">
                    <li>
                        <a class="<?php if ($com == '' || $com == 'index') echo 'active'; ?> transition" href="" title="Trang chủ">Trang chủ</a>
                    </li>
                    <li>
                        <a class="<?php if ($com == 'gioi-thieu') echo 'active'; ?> transition" href="gioi-thieu" title="Giới thiệu">Giới thiệu</a>
                    </li>
                    <?php if (count($splistht)) { ?>
                        <?php foreach ($splistht as $klist => $vlist) {
                            $spcatht = $d->rawQuery("select * from table_product_cat where id_list = '" . $vlist['id'] . "' and find_in_set('hienthi',status)");
                        ?>
                            <li>
                                <a class="transition" title="<?= $vlist['name'] ?>" href="<?= $vlist['slug'] ?>"><?= $vlist['name'] ?></a>
                                <?php if (!empty($spcatht)) { ?>
                                    <ul>
                                        <?php foreach ($spcatht as $kcat => $vcat) { ?>
                                            <li>
                                                <a class="transition" title="<?= $vcat['name'] ?>" href="<?= $vcat['slug'] ?>"><?= $vcat['name'] ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <li>
                        <a class="<?php if ($com == 'tin-tuc') echo 'active'; ?> transition" href="tin-tuc" title="Tin tức">Tin tức</a>
                    </li>
                    <li>
                        <a class="<?php if ($com == 'lien-he') echo 'active'; ?> transition" href="lien-he" title="Liên hệ">Liên hệ
                        </a>
                    </li>
                </ul>
            </div>
            <div class="right">
                <div class="search">
                    <p class="icon-search transition"><i class="fa fa-search"></i></p>
                    <div class="search-grid">
                        <input type="text" name="keyword" id="keyword" placeholder="Nhập từ khóa cần tìm" onkeypress="doEnter(event,'keyword');" />
                        <p onclick="onSearch('keyword');"><i class="fa fa-search"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>