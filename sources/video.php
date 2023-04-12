<?php
if (!defined('SOURCES')) die("Error");

/* Lấy tất cả video */
$where = "";
$where = "type = ? and act <> ? and find_in_set('hienthi',status)";
$params = array($type, 'photo_static');

$curPage = $getPage;
$perPage = 10;
$startpoint = ($curPage * $perPage) - $perPage;
$limit = " limit " . $startpoint . "," . $perPage;
$sql = "select * from table_photo where $where order by numb,id desc $limit";
$video = $d->rawQuery($sql, $params);
$sqlNum = "select count(*) as 'num' from table_photo where $where order by numb,id desc";
$count = $d->rawQueryOne($sqlNum, $params);
$total = (!empty($count)) ? $count['num'] : 0;
$url = $func->getCurrentPageURL();
$paging = $func->pagination($total, $perPage, $curPage, $url);

/* breadCrumbs */
if (!empty($titleMain)) $breadcr->set($com, $titleMain);
$breadcrumbs = $breadcr->get();
