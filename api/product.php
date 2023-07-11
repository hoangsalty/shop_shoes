<?php
include "config.php";

/* Paginations */
$pagingAjax = new PaginationsAjax();
$pagingAjax->perpage = (!empty($_GET['perpage'])) ? htmlspecialchars($_GET['perpage']) : 1;
$eShow = htmlspecialchars($_GET['eShow']);
$idList = (!empty($_GET['idList'])) ? htmlspecialchars($_GET['idList']) : 0;
$idCat = (!empty($_GET['idCat'])) ? htmlspecialchars($_GET['idCat']) : 0;
$page = (!empty($_GET['page'])) ? htmlspecialchars($_GET['page']) : 1;
$start = ($page - 1) * $pagingAjax->perpage;
$pageLink = "api/product.php?perpage=" . $pagingAjax->perpage;
$tempLink = "";
$where = "";
$params = array();

/* Math url */
if ($idList) {
    $tempLink .= "&idList=" . $idList;
    $where .= " and id_list = ?";
    array_push($params, $idList);
}
if ($idCat) {
    $tempLink .= "&idCat=" . $idCat;
    $where .= " and id_cat = ?";
    array_push($params, $idCat);
}
$tempLink .= "&page=";
$pageLink .= $tempLink;

/* Get data */
$sql = "select * from table_product where find_in_set('noibat',status) and find_in_set('hienthi',status) $where order by id desc";
$sqlCache = $sql . " limit $start, $pagingAjax->perpage";
$items = $d->rawQuery($sqlCache, $params);

/* Count all data */
$countItems = count($d->rawQuery($sql, $params));

/* Get page result */
$pagingItems = $pagingAjax->getAllPageLinks($countItems, $pageLink, $eShow);
?>
<?php if ($countItems) { ?>
    <?= $func->GetProducts($items) ?>
    <div class="pagination-ajax"><?= $pagingItems ?></div>
<?php } else { ?>
    <div class="col-12">
        <div class="alert alert-warning" role="alert">
            <strong>Không tìm thấy kết quả</strong>
        </div>
    </div>
<?php } ?>