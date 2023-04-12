<header class="header">
    <div class="header__top">
        <div class="wrap-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa-solid fa-envelope"></i><?= $optsetting['email'] ?></li>
                            <li class="d-inline-flex">
                                <marquee><?= $optsetting['slogan'] ?></marquee>
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
                        <div class="header__top__right__auth">
                            <a href="#"><i class="fa-solid fa-user"></i> Login</a>
                        </div>
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
                        <span><?= $optsetting['hotline'] ?></span>
                    </div>
                </div>
                <div class="header__cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Giỏ hàng
                </div>
            </div>
        </div>
    </div>
</header>