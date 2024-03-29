<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-start align-items-center">
            <div class="image">
                <?php $rowDetail = $d->rawQueryOne("select * from table_user where id = ? limit 0,1", array($_SESSION['account']['id'])); ?>
                <?= $func->getImage(['class' => 'img-circle elevation-2', 'width' => 50, 'height' => 50, 'upload' => UPLOAD_USER_L, 'image' => $rowDetail['photo']]) ?>
            </div>
            <a href="#" class="d-block ml-3 text-light font-weight"><?= $_SESSION['account']['fullname'] ?></a>
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
                        if ($com == 'product' && ($act == 'list_list' || $act == 'add_list' || $act == 'edit_list'))
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=list_list" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Loại sản phẩm (C1)</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'product' && ($act == 'list_cat' || $act == 'add_cat' || $act == 'edit_cat'))
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=list_cat" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Loại sản phẩm (C2)</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'product' && ($act == 'list_color' || $act == 'add_color' || $act == 'edit_color'))
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=list_color" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Màu sản phẩm</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'product' && ($act == 'list_size' || $act == 'add_size' || $act == 'edit_size'))
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=list_size" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Size sản phẩm</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'product' && ($act == 'list' || $act == 'add' || $act == 'edit'))
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=product&act=list" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sản phẩm</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php
                $active = "";
                $menuopen = "";
                if ($com == 'news') {
                    $active = 'active';
                    $menuopen = 'menu-open';
                }
                ?>
                <li class="nav-item <?= $menuopen ?>">
                    <a href="#" class="nav-link <?= $active ?>">
                        <i class="nav-icon far fa-newspaper"></i>
                        <p>Quản lý bài viết<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                        $active = "";
                        if ($com == 'news' && $_GET['type'] == 'tin-tuc') {
                            $active = 'active';
                        }
                        ?>
                        <li class="nav-item">
                            <a href="index.php?com=news&act=list&type=tin-tuc" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Quản lý tin tức</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'news' && $_GET['type'] == 'chinh-sach') {
                            $active = 'active';
                        }
                        ?>
                        <li class="nav-item">
                            <a href="index.php?com=news&act=list&type=chinh-sach" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Quản lý chính sách</p>
                            </a>
                        </li>
                    </ul>
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
                        <i class="nav-icon fas fa-file-signature"></i>
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
                            <a href="index.php?com=photo&act=list&type=slideshow" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Slideshow</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'photo' && $_GET['type'] == 'album')
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=photo&act=list&type=album" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Album</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'photo' && $_GET['type'] == 'video')
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=photo&act=list&type=video" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Video</p>
                            </a>
                        </li>

                        <?php
                        $active = "";
                        if ($com == 'photo' && $_GET['type'] == 'social')
                            $active = "active"; ?>
                        <li class="nav-item">
                            <a href="index.php?com=photo&act=list&type=social" class="nav-link <?= $active ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Social</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php
                $active = "";
                if ($com == 'user' && ($act == 'list' || $act == 'add' || $act == 'edit'))
                    $active = "active"; ?>
                <li class="nav-item">
                    <a href="index.php?com=user&act=list" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>Quản lý tài khoản</p>
                    </a>
                </li>

                <?php
                $active = "";
                if ($com == 'order') $active = "active"; ?>
                <li class="nav-item">
                    <a href="index.php?com=order&act=list" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>Đơn hàng</p>
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