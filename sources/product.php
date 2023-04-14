<?php
if (!defined('SOURCES')) die("Error");

@$id = htmlspecialchars($_GET['id']);
@$idl = htmlspecialchars($_GET['idl']);

if ($id != '') {
    /* Lấy sản phẩm detail */
    $rowDetail = $d->rawQueryOne("select * from table_product where id = ? and find_in_set('hienthi',status) and date_deleted = 0 limit 0,1", array($id));
    /* Cập nhật lượt xem */
    $views = array();
    $views['view'] = $rowDetail['view'] + 1;
    $d->where('id', $rowDetail['id']);
    $d->update('table_product', $views);
    /* Lấy cấp 1 */
    $productList = $d->rawQueryOne("select id, name, slug from table_product_list where id = ? and find_in_set('hienthi',status) and date_deleted = 0 limit 0,1", array($rowDetail['id_list']));
    /* Lấy gallery */
    $rowDetailPhoto = $d->rawQuery("select photo from table_gallery where id_parent = ? order by numb,id desc", array($rowDetail['id']));
    
    /* Lấy sản phẩm cùng loại */
    $where = "";
    $where = "id <> ? and id_list = ? and find_in_set('hienthi',status)";
    $params = array($id, $rowDetail['id_list']);

    $curPage = $getPage;
    $perPage = 8;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from table_product where $where order by numb,id desc $limit";
    $product = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from table_product where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);
} else if ($idl != '') {
    /* Lấy cấp 1 detail */
    $productList = $d->rawQueryOne("select id, name, slug, photo from table_product_list where id = ? limit 0,1", array($idl));

    /* Lấy sản phẩm */
    $where = "";
    $where = "id_list = ? and find_in_set('hienthi',status)";
    $params = array($idl);

    $curPage = $getPage;
    $perPage = 20;
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
    if (!empty($productList)) $breadcr->set($productList['slug'], $productList['name']);
    $breadcrumbs = $breadcr->get();
} else {
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
}
