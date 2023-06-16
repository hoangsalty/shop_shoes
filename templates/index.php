<!DOCTYPE html>
<html lang="vi|en">

<head>
    <?php include TEMPLATE . LAYOUT . "head.php"; ?>
    <?php include TEMPLATE . LAYOUT . "css.php"; ?>
</head>

<body>
    <div class="wap_main">
        <?php
        if ($com != 'payment-momo' && $com != 'payment-vnpay' && $com != 'gio-hang') {
            include TEMPLATE . LAYOUT . "header.php";
            include TEMPLATE . LAYOUT . "menu.php";
            include TEMPLATE . LAYOUT . "mmenu.php";
            include TEMPLATE . LAYOUT . "slide.php";
            if ($source != 'index') include TEMPLATE . LAYOUT . "breadcrumb.php";
        }
        ?>
        <div class="wrap-main <?= ($source == 'index') ? 'wrap-home' : '' ?>">
            <?php include TEMPLATE . $template . ".php"; ?>
        </div>
        <?php
        if ($com != 'payment-momo' && $com != 'payment-vnpay' && $com != 'gio-hang') {
            include TEMPLATE . LAYOUT . "footer.php";
            include TEMPLATE . LAYOUT . "modal.php";
        }
        include TEMPLATE . LAYOUT . "js.php";
        ?>
    </div>
</body>

</html>