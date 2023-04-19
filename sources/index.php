<?php
if (!defined('SOURCES')) die("Error");

$slider = $d->rawQuery("select * from table_photo where find_in_set('hienthi',status) and date_deleted = 0 order by numb,id desc", array());

$product = $d->rawQuery("select * from table_product where find_in_set('noibat',status) and find_in_set('hienthi',status) and date_deleted = 0 order by numb, id desc", array());

$productlist = $d->rawQuery("select * from table_product_list where find_in_set('noibat',status) and find_in_set('hienthi',status) and date_deleted = 0 order by numb, id desc", array());

$newsnb = $d->rawQuery("select * from table_news where find_in_set('noibat',status) and find_in_set('hienthi',status) and date_deleted = 0 order by numb, id desc", array());

$albumnb = $d->rawQuery("select * from table_photo where type = ? and find_in_set('hienthi',status) and date_deleted = 0 order by numb, id desc", array('album'));
