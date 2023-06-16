<?php
session_start();

define('LIBRARIES', '../../libraries/');
define('SOURCES', '../sources/');

require_once LIBRARIES . "config.php";

/* Load all files in folder class */
$files = glob(LIBRARIES . '/class/*.php');
foreach ($files as $file) require_once $file;

$d = new PDODb($config['database']);
$func = new Functions($d);