<div class="menu">
    <div class="wrap-content">
        <ul class="menu-main">
            <li>
                <a class="<?php if ($com == '' || $com == 'index') echo 'active'; ?> transition" href="" title="Trang chủ">Trang chủ</a>
            </li>
            <li>
                <a class="<?php if ($com == 'gioi-thieu') echo 'active'; ?> transition" href="gioi-thieu" title="Giới thiệu">Giới thiệu</a>
            </li>
            <?php if (count($splistht)) { ?>
                <?php foreach ($splistht as $klist => $vlist) {
                    $spcatht = $d->rawQuery("select * from table_product_cat where id_list = '" . $vlist['id'] . "' and find_in_set('hienthi',status)", array());
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
                <a class="<?php if ($com == 'video') echo 'active'; ?> transition" href="video" title="Video">Video</a>
            </li>
            <li>
                <a class="<?php if ($com == 'lien-he') echo 'active'; ?> transition" href="lien-he" title="Liên hệ">Liên hệ
                </a>
            </li>
        </ul>
    </div>
</div>