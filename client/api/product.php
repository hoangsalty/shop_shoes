<?php
include "config.php";

/* Paginations */
include LIBRARIES . "class/class.PaginationsAjax.php";
$pagingAjax = new PaginationsAjax();
$pagingAjax->perpage = (!empty($_GET['perpage'])) ? htmlspecialchars($_GET['perpage']) : 1;
$eShow = htmlspecialchars($_GET['eShow']);
$idList = (!empty($_GET['idList'])) ? htmlspecialchars($_GET['idList']) : 0;
$p = (!empty($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;
$start = ($p - 1) * $pagingAjax->perpage;
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
$tempLink .= "&p=";
$pageLink .= $tempLink;

/* Get data */
$sql = "select * from table_product where date_deleted = 0 $where and find_in_set('noibat',status) and find_in_set('hienthi',status) order by numb,id desc";
$sqlCache = $sql . " limit $start, $pagingAjax->perpage";
$items = $d->rawQuery($sqlCache, $params);

/* Count all data */
$countItems = count($d->rawQuery($sql, $params));

/* Get page result */
$pagingItems = $pagingAjax->getAllPageLinks($countItems, $pageLink, $eShow);
?>
<?php if ($countItems) { ?>
    <div class="grid-page">
        <div class="row">
            <?php foreach ($items as $k => $v) { ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="product">
                        <div class="box-product text-decoration-none">
                            <div class="box-image">
                                <a class="pic-product scale-img" href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>">
                                    <?= $func->getImage(['class' => 'rounded img-preview', 'width' => $config['product']['width'], 'height' => $config['product']['height'], 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                                </a>
                                <p class="cart-product w-clear">
                                    <span class="btn btn-sm btn-success cart-add addcart mr-2" data-id="<?= $v['id'] ?>" data-action="addnow">Thêm vào giỏ hàng</span>
                                </p>
                            </div>
                            <div class="info">
                                <h3 class="name-product text-split"><?= $v['name'] ?></h3>
                                <p class="price-product">
                                    <span class="price-new">
                                        <?= ($v['regular_price']) ? $func->formatMoney($v['regular_price']) : '' ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="pagination-ajax"><?= $pagingItems ?></div>
<?php } ?>