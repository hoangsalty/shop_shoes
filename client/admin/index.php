<?php
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 3600);
session_set_cookie_params(3600);
session_cache_expire(60);
session_start();

define('LIBRARIES', '../libraries/');
define('SOURCES', './sources/');
define('TEMPLATE', './templates/');
define('LAYOUT', 'layout/');
define('ASSETS', './assets/');

require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
new AutoLoad();
$d = new PDODb($config['database']);
$flash = new Flash();
$func = new Functions($d);

/* Setting */
$setting = $d->rawQueryOne("select * from table_setting limit 0,1");
$optsetting = (isset($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'], true) : null;

/* Requick */
require_once LIBRARIES . "requick.php";
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrator</title>
    <!-- Css all -->
    <?php include TEMPLATE . LAYOUT . "css.php"; ?>
</head>

<body class="hold-transition <?= (!isset($_SESSION['admin']['active']) || $_SESSION['admin']['active'] == false) ? 'login-page' : '' ?>"">
    <!-- Loader -->
    <?php if ($template == 'index' || $template == 'user/login') include TEMPLATE . LAYOUT . "loader.php"; ?>

    <?php if (isset($_SESSION['admin']['active']) && ($_SESSION['admin']['active'] == true)) { ?>
        <!-- Main -->
        <div class="wrapper">
            <?php
            include TEMPLATE . LAYOUT . "header.php";
            include TEMPLATE . LAYOUT . "menu.php";
            ?>
            <div class="content-wrapper">
                <?php include TEMPLATE . $template . ".php"; ?>
            </div>
            <?php include TEMPLATE . LAYOUT . "footer.php"; ?>
        </div>
    <?php } else {
        include TEMPLATE . "user/login.php";
    } ?>

    <!-- Js all -->
    <?php include TEMPLATE . LAYOUT . "js.php"; ?>
</body>

</html>