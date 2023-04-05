<?php
if (!defined('SOURCES')) die("Error");

@$id = htmlspecialchars($_GET['id']);

/* Lấy tất cả sản phẩm */
$where = "";
$where = "find_in_set('hienthi',status)";
$params = array();

$curPage = $getPage;
$perPage = 8;
$startpoint = ($curPage * $perPage) - $perPage;
$limit = " limit " . $startpoint . "," . $perPage;
$sql = "select photo, name, slug, sale_price, regular_price, id from table_product where $where order by numb,id desc $limit";
$product = $d->rawQuery($sql, $params);
$sqlNum = "select count(*) as 'num' from table_product where $where order by numb,id desc";
$count = $d->rawQueryOne($sqlNum, $params);
$total = (!empty($count)) ? $count['num'] : 0;
$url = $func->getCurrentPageURL();
$paging = $func->pagination($total, $perPage, $curPage, $url);

/* breadCrumbs */
if (!empty($titleMain)) $breadcr->set($com, $titleMain);
$breadcrumbs = $breadcr->get();
