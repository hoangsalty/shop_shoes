<?php
if (!defined('SOURCES')) die("Error");

@$id = htmlspecialchars($_GET['id']);

if ($id != '') {
    /* Lấy bài viết detail */
    $rowDetail = $d->rawQueryOne("select * from table_news where id = ? and find_in_set('hienthi',status) limit 0,1", array($id));

    /* Lấy bài viết khác */
    $news = $d->rawQuery("select * from table_news where id <> " . $rowDetail['id'] . " and find_in_set('noibat',status) and find_in_set('hienthi',status) and type = ? order by id desc", array('tin-tuc'));

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    $breadcr->set($rowDetail['slug'], $rowDetail['name']);
    $breadcrumbs = $breadcr->get();
} else {
    /* Lấy tất cả bài viết */
    $where = "";
    $where = "find_in_set('hienthi',status)";
    $params = array();

    $curPage = $getPage;
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from table_news where $where and type='tin-tuc' order by id desc $limit";
    $news = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from table_news where $where order by id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    $breadcrumbs = $breadcr->get();
}
