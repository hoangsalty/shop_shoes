<!DOCTYPE html>
<html lang="vi|en">

<head>
    <?php include TEMPLATE . LAYOUT . "head.php"; ?>
    <?php include TEMPLATE . LAYOUT . "css.php"; ?>
</head>

<body>
    <div class="wap_main">
        <?php
        include TEMPLATE . LAYOUT . "header.php";
        include TEMPLATE . LAYOUT . "menu.php";
        include TEMPLATE . LAYOUT . "mmenu.php";
        include TEMPLATE . LAYOUT . "slide.php";
        ?>
        <div class="wrap-main <?= ($source == 'index') ? 'wrap-home' : '' ?>">
            <?php include TEMPLATE . $template . ".php"; ?>
        </div>
        <?php
        include TEMPLATE . LAYOUT . "footer.php";
        include TEMPLATE . LAYOUT . "js.php";
        ?>
    </div>
</body>

</html>