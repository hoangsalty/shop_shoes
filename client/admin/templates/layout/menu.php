<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="" class="brand-link">
        <img src="assets/images/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="assets/images/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php
                $active = "";
                $menuopen = "";
                if ($com == '') {
                    $active = 'active';
                }
                ?>
                <li class="nav-item">
                    <a href="index.php" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php
                $active = "";
                $menuopen = "";
                if ($com == 'product') {
                    $active = 'active';
                    $menuopen = 'menu-open';
                }
                ?>
                <li class="nav-item <?= $menuopen ?>">
                    <a href="#" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>Quản lý sản phẩm<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                        $active = "";
                        if ($com == 'product' && ($act == 'man_list' || $act == 'add_list' || $act == 'edit_list')) $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=man_list" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Loại sản phẩm</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'product' && ($act == 'man_brand' || $act == 'add_brand' || $act == 'edit_brand')) $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=man_brand" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hãng sản phẩm</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'product' && ($act == 'man_color' || $act == 'add_color' || $act == 'edit_color')) $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=man_color" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Màu sản phẩm</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'product' && ($act == 'man_size' || $act == 'add_size' || $act == 'edit_size')) $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=man_size" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Size sản phẩm</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'product' && ($act == 'man' || $act == 'add' || $act == 'edit')) $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=man" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sản phẩm</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php
                $active = "";
                if ($com == 'news') {
                    $active = 'active';
                }
                ?>
                <li class="nav-item">
                    <a href="index.php?com=news&act=man" class="nav-link <?= $active ?>">
                        <i class="nav-icon far fa-newspaper"></i>
                        <p>Quản lý tin tức</p>
                    </a>
                </li>

                <?php
                $active = "";
                $menuopen = "";
                if ($com == 'static') {
                    $active = 'active';
                    $menuopen = 'menu-open';
                }
                ?>
                <li class="nav-item <?= $menuopen ?>">
                    <a href="#" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>Quản lý trang tĩnh<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                        $active = "";
                        if ($com == 'static' && $_GET['type'] == 'gioi-thieu') $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=static&act=update&type=gioi-thieu" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Giới thiệu</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'static' && $_GET['type'] == 'footer') $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=static&act=update&type=footer" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Footer</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php
                $active = "";
                $menuopen = "";
                if ($com == 'photo') {
                    $active = 'active';
                    $menuopen = 'menu-open';
                }
                ?>
                <li class="nav-item <?= $menuopen ?>">
                    <a href="#" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-image"></i>
                        <p>Quản lý hình ảnh<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                        $active = "";
                        if ($com == 'photo' && $_GET['type'] == 'logo') $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=photo&act=photo_static&type=logo" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Logo</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'photo' && $_GET['type'] == 'slideshow' && ($act == 'man_photo' || $act == 'add_photo' || $act == 'edit_photo')) $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=photo&act=man_photo&type=slideshow" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Slideshow</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'photo' && $_GET['type'] == 'album' && ($act == 'man_photo' || $act == 'add_photo' || $act == 'edit_photo')) $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=photo&act=man_photo&type=album" class="nav-link <?= $active ?>">
                                <i class="nav-icon fas fa-images"></i>
                                <p>Album</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'photo' && $_GET['type'] == 'video' && ($act == 'man_photo' || $act == 'add_photo' || $act == 'edit_photo')) $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=photo&act=man_photo&type=video" class="nav-link <?= $active ?>">
                                <i class="nav-icon fas fa-video"></i>
                                <p>Quản lý video</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>Quản lý tài khoản</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Quản lý đánh giá</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>Quản lý liên hệ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>Quản lý đơn hàng</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-industry"></i>
                        <p>Quản lý nhập hàng</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>