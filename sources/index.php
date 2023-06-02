<?php
if (!defined('SOURCES')) die("Error");

$static = $d->rawQueryOne("select * from table_static where date_deleted = 0 limit 0,1", array());
$product = $d->rawQuery("select * from table_product where find_in_set('noibat',status) and find_in_set('hienthi',status) and date_deleted = 0 order by numb, id desc", array());
$productlist = $d->rawQuery("select * from table_product_list where find_in_set('noibat',status) and find_in_set('hienthi',status) and date_deleted = 0 order by numb, id desc", array());
$newsnb = $d->rawQuery("select * from table_news where find_in_set('noibat',status) and find_in_set('hienthi',status) and date_deleted = 0 and type = ? order by numb, id desc", array('tin-tuc'));
$albumnb = $d->rawQuery("select * from table_photo where type = ? and find_in_set('hienthi',status) and date_deleted = 0 order by numb, id desc", array('album'));
