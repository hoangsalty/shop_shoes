<?php
if (!defined('SOURCES')) die("Error");

$static = $d->rawQueryOne("select * from table_static limit 0,1");
$brand = $d->rawQuery("select * from table_product_brand where find_in_set('hienthi',status) order by id desc");
$product = $d->rawQuery("select * from table_product where find_in_set('noibat',status) and find_in_set('hienthi',status) order by id desc");
$productlist = $d->rawQuery("select * from table_product_list where find_in_set('noibat',status) and find_in_set('hienthi',status) order by id desc");
$newsnb = $d->rawQuery("select * from table_news where find_in_set('noibat',status) and find_in_set('hienthi',status) and type = ? order by id desc", array('tin-tuc'));
$albumnb = $d->rawQuery("select * from table_photo where type = ? and find_in_set('hienthi',status) order by id desc", array('album'));
