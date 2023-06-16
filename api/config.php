<?php
session_start();

define('LIBRARIES', '../libraries/');

require_once LIBRARIES . "config.php";

/* Load all files in folder class */
$files = glob(LIBRARIES . '/class/*.php');
foreach ($files as $file) require_once $file;

$d = new PDODb($config['database']);
$func = new Functions($d);
$cart = new Cart($d);

/* Setting */
$sqlCache = "select * from table_setting";
$setting = $d->rawQueryOne($sqlCache, null);
$optsetting = (!empty($setting['options'])) ? json_decode($setting['options'], true) : null;
