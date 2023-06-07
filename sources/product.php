<?php
if (!defined('SOURCES')) die("Error");

@$id = htmlspecialchars($_GET['id']);
@$idl = htmlspecialchars($_GET['id_list']);
@$idb = htmlspecialchars($_GET['id_brand']);

if ($id != '') {
    /* Lấy sản phẩm detail */
    $rowDetail = $d->rawQueryOne("select * from table_product where id = ? and find_in_set('hienthi',status) limit 0,1", array($id));
    /* Cập nhật lượt xem */
    $views = array();
    $views['view'] = $rowDetail['view'] + 1;
    $d->where('id', $rowDetail['id']);
    $d->update('table_product', $views);
    /* Lấy danh mục */
    $productList = $d->rawQueryOne("select * from table_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_list']));
    /* Lấy thương hiệu */
    $productBrand = $d->rawQueryOne("select * from table_brand where id = ? and find_in_set('hienthi',status)", array($rowDetail['id_brand']));
    /* Lấy gallery */
    $rowDetailPhoto = $d->rawQuery("select photo from table_gallery where id_parent = ? order by id desc", array($rowDetail['id']));
    /* Lấy màu */
    $productColor = $d->rawQuery("select id_color from table_product_color where id_product = ? and id_color > 0", array($rowDetail['id']));
    $productColor = (!empty($productColor)) ? $func->joinCols($productColor, 'id_color') : array();
    if (!empty($productColor)) {
        $rowColor = $d->rawQuery("select * from table_color where id in ($productColor) and find_in_set('hienthi',status) order by id desc");
    }
    /* Lấy size */
    $productSize = $d->rawQuery("select id_size from table_product_size where id_product = ? and id_size > 0", array($rowDetail['id']));
    $productSize = (!empty($productSize)) ? $func->joinCols($productSize, 'id_size') : array();
    if (!empty($productSize)) {
        $rowSize = $d->rawQuery("select id, name from table_size where id in ($productSize) and find_in_set('hienthi',status) order by id desc");
    }

    /* Lấy sản phẩm cùng loại */
    $where = "";
    $where = "id <> ? and id_list = ? and find_in_set('hienthi',status)";
    $params = array($id, $rowDetail['id_list']);

    $curPage = $getPage;
    $perPage = 8;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from table_product where $where order by id desc $limit";
    $product = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from table_product where $where order by id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* Comment */
    $comment = new Comments($d, $func, $rowDetail['id']);

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($productList)) $breadcr->set($productList['slug'], $productList['name']);
    $breadcr->set($rowDetail['slug'], $rowDetail['name']);
    $breadcrumbs = $breadcr->get();
} else if ($idl != '') {
    /* Lấy cấp 1 detail */
    $productList = $d->rawQueryOne("select * from table_list where id = ? limit 0,1", array($idl));
    $titleCate = $productList['name'];

    /* Lấy sản phẩm */
    $where = "";
    $where = "id_list = ? and find_in_set('hienthi',status)";
    $params = array($idl);

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

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($productList)) $breadcr->set($productList['slug'], $productList['name']);
    $breadcrumbs = $breadcr->get();
} else if ($idb != '') {
    /* Lấy brand detail */
    $productBrand = $d->rawQueryOne("select * from table_brand where id = ? limit 0,1", array($idb));
    $titleCate = $productBrand['name'];

    /* Lấy sản phẩm */
    $where = "";
    $where = "id_brand = ? and find_in_set('hienthi',status)";
    $params = array($productBrand['id']);

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

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($productBrand)) $breadcr->set($productBrand['slug'], $productBrand['name']);
    $breadcrumbs = $breadcr->get();
} else {
    /* Lấy tất cả sản phẩm */
    $where = "";
    $where = "find_in_set('hienthi',status)";
    $params = array();

    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from table_product where $where order by id desc $limit";
    $product = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from table_product where $where order by id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    $breadcrumbs = $breadcr->get();
}
