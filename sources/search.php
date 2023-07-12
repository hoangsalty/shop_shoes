<?php
if (!defined('SOURCES')) die("Error");

/* Tìm kiếm sản phẩm */
if (!empty($_GET['keyword'])) {
    $tukhoa = htmlspecialchars($_GET['keyword']);
    $tukhoa = $func->changeTitle($tukhoa);

    if ($tukhoa) {
        $where = "";
        $where = "(name LIKE ? or slug LIKE ? or code LIKE ?) and find_in_set('hienthi',status)";
        $params = array("%$tukhoa%", "%$tukhoa%", "%$tukhoa%");

        $curPage = $getPage;
        $perPage = 20;
        $startpoint = ($curPage * $perPage) - $perPage;
        $limit = " limit " . $startpoint . "," . $perPage;
        $sql = "select * from table_product where $where order by id desc $limit";
        $product = $d->rawQuery($sql, $params);
        $sqlNum = "select count(*) as 'num' from table_product where $where order by id desc";
        $count = $d->rawQueryOne($sqlNum, $params);
        $total = (!empty($count)) ? $count['num'] : 0;
        $url = $func->getCurrentPageURL();
        $paging = $func->pagination($total, $perPage, $curPage, $url);
    }
}

/* breadCrumbs */
$breadcr->set('', $titleMain);
$breadcrumbs = $breadcr->get();
