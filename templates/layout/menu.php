<div class="menu">
    <div class="wrap-content">
        <div class="d-flex justify-content-between">
            <div class="left">
                <div class="menu-left">
                    <div class="left-dm">
                        <div class="title">
                            <i class="fa-solid fa-bars"></i>
                            <span>Danh mục sản phẩm</span>
                        </div>
                        <ul class="ul-menu list-inline scroll-maded <?= ($source != 'index') ? 'hidden-menu' : '' ?>">
                            <?php foreach ($splistht as $klist => $vlist) { ?>
                                <li class="xdvt">
                                    <a class="has-child transition" title="<?= $vlist['name'] ?>" href="<?= $vlist['slug'] ?>"><?= $vlist['name'] ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="right">
                <ul class="d-flex align-items-center justify-content-between">
                    <li>
                        <a class="<?php if ($com == '' || $com == 'index') echo 'active'; ?> transition" href="" title="Trang chủ">Trang chủ</a>
                    </li>
                    <li>
                        <a class="<?php if ($com == 'gioi-thieu') echo 'active'; ?> transition" href="gioi-thieu" title="Giới thiệu">Giới thiệu</a>
                    </li>
                    <li>
                        <a class="<?php if ($com == 'khuyen-mai') echo 'active'; ?> transition" href="khuyen-mai" title="Khuyến mãi">Khuyến mãi</a>
                    </li>
                    <li>
                        <a class="<?php if ($com == 'thu-vien-anh') echo 'active'; ?> transition" href="thu-vien-anh" title="Thư viện ảnh">Thư viện ảnh</a>
                    </li>
                    <li>
                        <a class="<?php if ($com == 'video') echo 'active'; ?> transition" href="video" title="Video">Video</a>
                    </li>
                    <li>
                        <a class="<?php if ($com == 'tin-tuc') echo 'active'; ?> transition" href="tin-tuc" title="Tin tức">Tin tức</a>
                    </li>
                    <li>
                        <a class="<?php if ($com == 'lien-he') echo 'active'; ?> transition" href="lien-he" title="Liên hệ">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>