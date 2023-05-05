<div class="header">
    <div class="wrap-content">
        <div class="flex-header">
            <a class="logo-header" href="">
                <?= $func->getImage(['class' => '', 'width' => $config['logo']['width'], 'height' => $config['logo']['height'], 'upload' => UPLOAD_PHOTO_L, 'image' => $logo['photo'], 'alt' => $logo['name']]) ?>
            </a>

            <div class="flex-header">
                <?php if (array_key_exists('account', $_SESSION) && $_SESSION['account']['active'] == true) { ?>
                    <div class="user-header">
                        <a href="account/thong-tin">
                            <span>Hi, <?= $_SESSION['account']['fullname'] ?></span>
                        </a>
                        <a href="account/dang-xuat">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Đăng xuất</span>
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="user-header">
                        <a href="javascript::void()" type="button" data-toggle="modal" data-target="#popup-login">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Đăng nhập</span>
                        </a>
                        <a href="account/dang-ky">
                            <i class="fas fa-user-plus"></i>
                            <span>Đăng ký</span>
                        </a>
                    </div>
                <?php } ?>

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