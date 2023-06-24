<?php
include "config.php";

$cmd = (!empty($_POST['cmd'])) ? htmlspecialchars($_POST['cmd']) : '';
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$status = (!empty($_POST['status'])) ? htmlspecialchars($_POST['status']) : '';

$where_select = (!empty($_POST['where_select'])) ? htmlspecialchars($_POST['where_select']) : '';
$where = '';

if ($cmd == 'change-status' && $id > 0) {
    $data = array();
    $data['order_status'] = (!empty($status)) ? $status : "";
    $d->where('id', $id);
    $d->update('table_order', $data);
} else if ($cmd == 'show-order-by-status') {
    if (array_key_exists("account", $_SESSION) && $_SESSION["account"]['active'] == true) { ?>
        <?php
        $iduser = $_SESSION["account"]['id'];
        if ($where_select !== 'undefined') $where .= " and order_status = '$where_select'";
        $donhang = $d->rawQuery("select * from table_order where id_user = ? $where order by date_created desc", array($iduser));
        if (!empty($donhang)) { ?>
            <?php foreach ($donhang as $v1) {
                $chitiet = $d->rawQuery("select * from table_order_detail where id_order = ?", array($v1['id']));
                $tinhtrang = $v1["order_status"];
                $orderColor = '';

                if ($tinhtrang == 'moidat') $orderColor = 'text-primary';
                if ($tinhtrang == 'daxacnhan') $orderColor = 'text-info';
                if ($tinhtrang == 'danggiaohang') $orderColor = 'text-warning';
                if ($tinhtrang == 'dagiao') $orderColor = 'text-success';
                if ($tinhtrang == 'dahuy') $orderColor = 'btn btn-danger btn-sm';

            ?>
                <div class="box-ql-donhang">
                    <div class="top-cart">
                        <div class="title-cart">
                            <p>Đơn hàng: <span><?= $v1['code'] ?></span></p>
                            <p class="order_status_show <?= $orderColor ?>"><?= $func->convertOrderStatus($tinhtrang) ?></p>
                        </div>
                        <div class="list-procart">
                            <table class="table">
                                <thead>
                                    <th scope="col" width="50" class="text-center">STT</th>
                                    <th scope="col" width="130px" class="text-center">Hình ảnh</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col" width="100px" class="text-center">Ngày đặt</th>
                                    <th scope="col" width="200px" class="text-right">Thành tiền</th>
                                </thead>
                                <?php foreach ($chitiet as $k2 => $v2) {
                                    $pid = $v2['id_product'];
                                    $quantity = $v2['quantity'];
                                    $proinfo = $cart->getProductInfo($pid);
                                    $pro_price = $v2['price'];
                                    $pro_price_qty = $pro_price * $quantity;
                                ?>
                                    <tbody>
                                        <th class="text-center"><span><?= $k2 + 1 ?></span></th>
                                        <th><?= $func->getImage(['class' => 'rounded img-preview', 'width' => 100, 'height' => 80, 'upload' => UPLOAD_PRODUCT_L, 'image' => $v2['photo'], 'alt' => $v2['name']]) ?></th>
                                        <th>
                                            <h3 class="name-procart"><a class="text-decoration-none" target="_blank" title="<?= $v2['name'] ?>" href="<?= $proinfo['slug'] ?>"><?= $v2['name'] ?></a></h3>
                                            <span>x<?= $quantity ?></span>
                                        </th>
                                        <th class="text-center"><span><?= date("d/m/Y", $v1['date_created']) ?></span></th>
                                        <th class="text-right">
                                            <span class="total-price"><?= $func->formatMoney($pro_price_qty) ?></span>
                                        </th>
                                    </tbody>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="money-procart">
                            <div class="d-flex align-items-center justify-content-between">
                                <?php if ($tinhtrang == 'moidat') { ?>
                                    <a id="cancel-order" data-id="<?= $v1['id'] ?>" data-status="dahuy" href="javascript:void()" class="change_order_status">Hủy đơn hàng</a>
                                <?php } ?>

                                <div class="total-procart">
                                    <p class="mr-3">Tổng tiền:</p>
                                    <p class="total-price load-price-total"><?= $func->formatMoney($v1['total_price']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="wrap_empty-cart">
                <a href="san-pham" class="sty_btn_info empty-cart">
                    <i class="fa fa-cart-arrow-down"></i>
                    <p>Bạn chưa có đơn hàng <?= $func->convertOrderStatus($where_select) ?> nào</p>
                    <span>Vào mua hàng</span>
                </a>
            </div>
        <?php } ?>
<?php }
}
