<div class="menu-res">
    <div class="menu-bar-res">
        <a id="hamburger" href="#menu" title="Menu"><span></span></a>
        <a class="logo_mmenu" href="">
            <?= $func->getImage(['class' => '', 'width' => $config['logo_mmenu']['width'], 'height' => $config['logo_mmenu']['height'], 'upload' => UPLOAD_PHOTO_L, 'image' => $logo['photo'], 'alt' => $logo['name']]) ?>
        </a>
        <div class="search-res">
            <p class="icon-search transition"><i class="fa fa-search"></i></p>
            <div class="search-grid w-clear">
                <input type="text" name="keyword-res" id="keyword-res" placeholder="Nhập từ khóa tìm kiếm" onkeypress="doEnter(event,'keyword-res');" />
                <p onclick="onSearch('keyword-res');"><i class="fa fa-search"></i></p>
            </div>
        </div>
    </div>
    <nav id="menu">
        <ul>
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
        </ul>
    </nav>
</div>