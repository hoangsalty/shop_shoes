<?php
if (!defined('SOURCES')) die("Error");

$logo = $d->rawQueryOne("select * from table_photo where date_deleted = 0 and type = ?", array('logo'));
$splistht = $d->rawQuery("select * from table_list where find_in_set('hienthi',status)", array());
$slider = $d->rawQuery("select * from table_photo where find_in_set('hienthi',status) and type = ? order by id desc", array('slideshow'));
