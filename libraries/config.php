<?php
if (!defined('LIBRARIES')) die("Error");

/* Cấu hình chung */
$config = array(
    'database' => array(
        'server-name' => $_SERVER["SERVER_NAME"],
        'url' => '/shop_shoes/client/',
        'type' => 'mysql',
        'host' => 'localhost',
        'username' => 'root',
        'dbname' => 'db',
        'password' => '',
        'port' => 3306,
        'charset' => 'utf8mb4'
    ),
    'website' => array(
        'video' => array(
            'extension' => array('mp4'),
            'poster' => array(
                'width' => 700,
                'height' => 610,
                'extension' => '.jpg|.png|.jpeg'
            ),
            'allow-size' => '100Mb',
            'max-size' => 100 * 1024 * 1024
        ),
    ),
);
/*Ảnh Categories*/
$config['product_list']['width'] = 285;
$config['product_list']['height'] = 270;
/*Ảnh product*/
$config['product']['width'] = 285;
$config['product']['height'] = 270;
/*Ảnh news*/
$config['news']['width'] = 380;
$config['news']['height'] = 270;
/*Ảnh static*/
$config['static']['width'] = 270;
$config['static']['height'] = 270;
/*Ảnh album*/
$config['album']['width'] = 270;
$config['album']['height'] = 270;
/*Ảnh slideshow*/
$config['slideshow']['width'] = 895;
$config['slideshow']['height'] = 430;
/*Ảnh video*/
$config['video']['width'] = 300;
$config['video']['height'] = 300;
/*Ảnh logo*/
$config['logo']['width'] = 100;
$config['logo']['height'] = 100;
/*Ảnh avatar user*/
$config['user']['width'] = 100;
$config['user']['height'] = 100;

/* Path */
define('ROOT', str_replace(basename(__DIR__), '', __DIR__));
define('ADMIN', 'admin');

/* Cấu hình mặc định */
$http = 'http://';
$configUrl = $config['database']['server-name'] . $config['database']['url'];
$configBase = $http . $configUrl;

/* Cấu hình upload */
include LIBRARIES . "upload.php";
