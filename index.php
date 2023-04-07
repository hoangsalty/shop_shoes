<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 3600);
session_set_cookie_params(3600);
session_cache_expire(60);
session_start();

define('LIBRARIES', './libraries/');
define('TEMPLATE', './templates/');
define('ASSETS', './assets/');
define('SOURCES', './sources/');
define('LAYOUT', './layout/');

/* Config */
require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
new AutoLoad();
$d = new PDODb($config['database']);
$flash = new Flash();
$router = new AltoRouter();
$func = new Functions($d);
$breadcr = new BreadCrumbs($d);

/* Router */
require_once LIBRARIES . "router.php";

/* Template */
include TEMPLATE . "index.php";
