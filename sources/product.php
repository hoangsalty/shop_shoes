<?php
if (!defined('SOURCES')) die("Error");

@$id = htmlspecialchars($_GET['id']);
@$idl = htmlspecialchars($_GET['idl']);

if ($id != '') {
    /* Lấy sản phẩm detail */
    $rowDetail = $d->rawQueryOne("select id, name, slug, desc, content, code, view, id_brand, id_list, id_cat, id_item, id_sub, photo, options, sale_price, regular_price from table_product where id = ? and find_in_set('hienthi',status) limit 0,1", array($id));

    /* Cập nhật lượt xem */
    $views = array();
    $views['view'] = $rowDetail['view'] + 1;
    $d->where('id', $rowDetail['id']);
    $d->update('product', $views);

    /* Lấy tags */
    $productTags = $d->rawQuery("select id_tags from table_product_tags where id_parent = ?", array($rowDetail['id']));
    $productTags = (!empty($productTags)) ? $func->joinCols($productTags, 'id_tags') : array();

    // if (!empty($productTags)) {
    //     $rowTags = $d->rawQuery("select id, name, slug from #_tags where type='" . $type . "' and id in ($productTags) and find_in_set('hienthi',status) order by numb,id desc");
    // }

    /* Lấy màu */
    $productColor = $d->rawQuery("select id_color from table_product_sale where id_parent = ?", array($rowDetail['id']));
    $productColor = (!empty($productColor)) ? $func->joinCols($productColor, 'id_color') : array();

    // if (!empty($productColor)) {
    //     $rowColor = $d->rawQuery("select type_show, photo, color, id from #_color where type='" . $type . "' and id in ($productColor) and find_in_set('hienthi',status) order by numb,id desc");
    // }

    /* Lấy size */
    $productSize = $d->rawQuery("select id_size from table_product_sale where id_parent = ?", array($rowDetail['id']));
    $productSize = (!empty($productSize)) ? $func->joinCols($productSize, 'id_size') : array();

    if (!empty($productSize)) {
        $rowSize = $d->rawQuery("select id, name from #_size where id in ($productSize) and find_in_set('hienthi',status) order by numb,id desc");
    }

    /* Lấy cấp 1 */
    $productList = $d->rawQueryOne("select id, name, slug from table_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_list']));

    /* Lấy hình ảnh con */
    // $rowDetailPhoto = $d->rawQuery("select photo from #_gallery where id_parent = ? and com='product' and kind='man' and val = ? and find_in_set('hienthi',status) order by numb,id desc", array($rowDetail['id'], 'san-pham', 'san-pham'));

    /* Lấy sản phẩm cùng loại */
    $where = "";
    $where = "id <> ? and id_list = ? and find_in_set('hienthi',status)";
    $params = array($id, $rowDetail['id_list']);

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

    /* Comment */
    // $comment = new Comments($d, $func, $rowDetail['id'], $rowDetail['type']);

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($productList)) $breadcr->set($productList[$sluglang], $productList['name']);
    $breadcr->set($rowDetail[$sluglang], $rowDetail['name']);
    $breadcrumbs = $breadcr->get();
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
