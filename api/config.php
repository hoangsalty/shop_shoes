<?php
session_start();

define('LIBRARIES', '../libraries/');

require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
new AutoLoad();
$d = new PDODb($config['database']);
$func = new Functions($d);
$cart = new Cart($d);

/* Setting */
$sqlCache = "select * from table_setting";
$setting = $d->rawQueryOne($sqlCache, null);
$optsetting = (!empty($setting['options'])) ? json_decode($setting['options'], true) : null;
