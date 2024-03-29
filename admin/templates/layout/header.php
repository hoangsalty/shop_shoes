<?php
$countNotify = 0;

/* Order */
$orderNotify = $d->rawQuery("select id from table_order where order_status = 'moidat'");
$countNotify += count($orderNotify);

/* Comment */
$commentNotify = $d->rawQuery("select id from table_comment where find_in_set('new-admin',status)");
$countNotify += count($commentNotify);

?>

<!-- Header -->
<nav class="main-header navbar navbar-expand navbar-white">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="" class="nav-link">Xin chào, <?= $_SESSION['account']['fullname'] ?> !</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item d-sm-inline-block">
            <a href="../" target="_blank" class="nav-link" title="Trang chủ"><i class="fas fa-reply"></i> Trang chủ</a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="fas fa-cogs"></i>
            </a>
            <ul aria-labelledby="dropdownSubMenu-info" class="dropdown-menu dropdown-menu-right border-0 shadow">
                <li>
                    <a href="index.php?com=user&act=edit&id=<?= $_SESSION['account']['id'] ?>" class="dropdown-item">
                        <i class="fas fa-user-cog"></i>
                        <span>Thông tin tài khoản</span>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
                <li>
                    <a href="index.php?com=user&act=info&changepass=1" class="dropdown-item">
                        <i class="fas fa-key"></i>
                        <span>Đổi mật khẩu</span>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge text-bold"><?= $countNotify ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Thông báo</span>
                <div class="dropdown-divider"></div>
                <a href="index.php?com=order&act=list" class="dropdown-item">
                    <i class="fas fa-cart-arrow-down"></i> Đơn hàng
                    <span class="float-right text-danger text-sm text-bold"><?= count($orderNotify) ?> đơn hàng mới</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="index.php?com=product&act=list&comment_status=new" class="dropdown-item">
                    <i class="fas fa-comment-dots"></i> Comments
                    <span class="float-right text-danger text-sm text-bold"><?= count($commentNotify) ?> bình luận mới</span>
                </a>
                <div class="dropdown-divider"></div>
            </div>
        </li>

        <li class="nav-item d-sm-inline-block">
            <a href="index.php?com=user&act=logout" class="nav-link"><i class="fas fa-sign-out-alt mr-1"></i>Đăng xuất</a>
        </li>
    </ul>
</nav>