<?php
session_start();

define('LIBRARIES', './libraries/');
define('TEMPLATE', './templates/');
define('ASSETS', './assets/');
define('SOURCES', './sources/');
define('LAYOUT', './layout/');

/* Config */
require_once LIBRARIES . "config.php";

/* Load all files in folder class */
$files = glob(LIBRARIES . '/class/*.php');
foreach ($files as $file) require_once $file;

$d = new PDODb($config['database']);
$flash = new Flash();
$router = new AltoRouter();
$func = new Functions($d);
$breadcr = new BreadCrumbs($d);
$cart = new Cart($d);

/* Router */
require_once LIBRARIES . "router.php";

/* Template */
include TEMPLATE . "index.php";
