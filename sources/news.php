<?php
if (!defined('SOURCES')) die("Error");

@$id = htmlspecialchars($_GET['id']);

if ($id != '') {
    /* Lấy bài viết detail */
    $rowDetail = $d->rawQueryOne("select * from table_news where id = ? and find_in_set('hienthi',status) limit 0,1", array($id));

    /* Cập nhật lượt xem */
    // $views = array();
    // $views['view'] = $rowDetail['view'] + 1;
    // $d->where('id', $rowDetail['id']);
    // $d->update('news', $views);

    /* Lấy bài viết cùng loại */
    $where = "";
    $where = "id <> ? and find_in_set('hienthi',status)";
    $params = array($id);

    $curPage = $getPage;
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from table_news where $where order by numb,id desc $limit";
    $news = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from table_news where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);


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
    $sql = "select * from table_news where $where and type='tin-tuc' order by numb,id desc $limit";
    $news = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from table_news where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    $breadcrumbs = $breadcr->get();
}
