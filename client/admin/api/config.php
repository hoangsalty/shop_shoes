<?php
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 3600);
session_set_cookie_params(3600);
session_cache_expire(60);
session_start();

define('LIBRARIES', '../../libraries/');
define('SOURCES', '../sources/');

require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
new AutoLoad();
$d = new PDODb($config['database']);
$func = new Functions($d);