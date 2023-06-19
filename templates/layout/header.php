<div class="header">
    <div class="wrap-content">
        <div class="header_container d-flex justify-content-between align-items-center">
            <div class="hotline_header">Hotline: <?= $optsetting['hotline'] ?></div>
            <div class="login_header text-right">
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
                        <a href="javascript::void()" type="button" data-toggle="modal" data-target="#popup-register">
                            <i class="fas fa-user-plus"></i>
                            <span>Đăng ký</span>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>