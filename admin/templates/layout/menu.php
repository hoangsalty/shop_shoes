<aside class="main-sidebar sidebar-dark-primary elevation-4">


    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
            <div class="image">
                <?php
                            $rowDetail = $d->rawQueryOne("select * from table_user where id = ? limit 0,1", array($_SESSION['account']['id']));

                 echo $func->getImage(['class' => 'img-circle elevation-2', 'width' => 50, 'height' => 50, 'upload' => UPLOAD_USER_L, 'image' => $rowDetail['photo'], 'alt' => $_SESSION['account']['fullname']]) 
                ?>
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <?= $_SESSION['account']['fullname'] ?>
                </a>
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
                        <p>Bảng điều khiển</p>
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
                        if ($com == 'product' && ($act == 'man_list' || $act == 'add_list' || $act == 'edit_list'))
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=man_list" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Loại sản phẩm</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'product' && ($act == 'man_brand' || $act == 'add_brand' || $act == 'edit_brand'))
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=man_brand" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hãng sản phẩm</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'product' && ($act == 'man_color' || $act == 'add_color' || $act == 'edit_color'))
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=man_color" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Màu sản phẩm</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'product' && ($act == 'man_size' || $act == 'add_size' || $act == 'edit_size'))
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=man_size" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Size sản phẩm</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'product' && ($act == 'man' || $act == 'add' || $act == 'edit'))
                            $active = "active"; ?>
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
                if ($com == 'news' && $_GET['type'] == 'tin-tuc') {
                    $active = 'active';
                }
                ?>
                <li class="nav-item">
                    <a href="index.php?com=news&act=man&type=tin-tuc" class="nav-link <?= $active ?>">
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
                        if ($com == 'static' && $_GET['type'] == 'gioi-thieu')
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=static&act=update&type=gioi-thieu" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Giới thiệu</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'static' && $_GET['type'] == 'footer')
                            $active = "active"; ?>
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
                        <p>Quản lý media<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                        $active = "";
                        if ($com == 'photo' && $_GET['type'] == 'logo')
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=photo&act=photo_static&type=logo" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Logo</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'photo' && $_GET['type'] == 'slideshow')
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=photo&act=man_photo&type=slideshow" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Slideshow</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'photo' && $_GET['type'] == 'album')
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=photo&act=man_photo&type=album" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Album</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'photo' && $_GET['type'] == 'video')
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=photo&act=man_photo&type=video" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Video</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php
                $active = "";
                if ($com == 'user' && ($act == 'man' || $act == 'add' || $act == 'edit'))
                    $active = "active"; ?>
                <li class="nav-item">
                    <a href="index.php?com=user&act=man" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>Quản lý tài khoản</p>
                    </a>
                </li>

                <?php
                $active = "";
                $menuopen = "";
                if ($com == 'order' || ($com == 'news' && $_GET['type'] == 'hinh-thuc-thanh-toan')) {
                    $active = 'active';
                    $menuopen = 'menu-open';
                }
                ?>
                <li class="nav-item <?= $menuopen ?>">
                    <a href="#" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>Quản lý đơn hàng<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                        $active = "";
                        if ($com == 'news') $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=news&act=man&type=hinh-thuc-thanh-toan" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hình thức thanh toán</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'order') $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=order&act=man" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Đơn hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>Quản lý liên hệ</p>
                    </a>
                </li>

                <?php
                $active = "";
                if ($com == 'setting') $active = "active"; ?>
                <li class="nav-item">
                    <a href="index.php?com=setting&act=update" class="nav-link <?= $active ?>">
                        <i class="nav-icon text-sm fas fa-cogs"></i>
                        <p>Thiết lập thông tin</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>