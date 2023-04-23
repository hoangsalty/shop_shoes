<header class="header">
    <div class="header__top">
        <div class="wrap-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa-solid fa-envelope"></i>
                                <?= $optsetting['email'] ?>
                            </li>
                            <li class="d-inline-flex">
                                <marquee>
                                    <?= $optsetting['slogan'] ?>
                                </marquee>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="#"><i class="fa-brands fa-facebook"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                            <a href="#"><i class="fa-brands fa-pinterest"></i></a>
                        </div>

                        <?php if (array_key_exists('account', $_SESSION) && $_SESSION['account']['active'] == true) { ?>
                            <div class="user-header">
                                <a href="account/thong-tin">
                                    <span>Hi,<?= $_SESSION['account']['username'] ?></span>
                                </a>
                                <a href="account/dang-xuat">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Đăng xuất</span>
                                </a>
                            </div>
                        <?php } else { ?>
                            <div class="user-header">
                                <a href="account/dang-nhap">
                                    <i class="fas fa-sign-in-alt"></i>
                                    <span>Đăng nhập</span>
                                </a>
                                <a href="account/dang-ky">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Đăng ký</span>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header__bottom">
        <div class="wrap-content">
            <div class="flex__header__bottom">
                <div class="header__logo">
                    <a href="">
                        <?= $func->getImage(['class' => 'w-100', 'width' => $config['logo']['width'], 'height' => $config['logo']['height'], 'upload' => UPLOAD_PHOTO_L, 'image' => $logo['photo'], 'alt' => $logo['name']]) ?>
                    </a>
                </div>
                <div class="header__search">
                    <input type="text" id="keyword" placeholder="Nhập từ khóa tìm kiếm" onkeypress="doEnter(event,'keyword');" />
                    <p onclick="onSearch('keyword');">Tìm kiếm</p>
                </div>
                <div class="header__hotline">
                    <div class="header__hotline__icon animate__animated animate__infinite animate__tada">
                        <i class="fa-solid fa-phone-flip"></i>
                    </div>
                    <div class="header__hotline__text">
                        <p>Hotline</p>
                        <span>
                            <?= $optsetting['hotline'] ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>