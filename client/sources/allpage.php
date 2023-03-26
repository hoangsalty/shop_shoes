<?php
if (!defined('SOURCES')) die("Error");

$product = $d->rawQuery("select * from table_product where find_in_set('hienthi',status) and date_deleted = 0 order by numb,id", array());

$splistht = $d->rawQuery("select * from table_product_list where find_in_set('hienthi',status) and date_deleted = 0", array());
