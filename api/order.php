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

    if ($status == 'dahuy') {
        $order = $d->rawQueryOne("select * from table_order where id = ? limit 0,1", array($id));
        if (!empty($order) && $order['order_payment'] == 'vnpay') {
            $vnpay_order = $d->rawQueryOne("select * from table_vnpay where order_id = ? limit 0,1", array($id));
            function callAPI_auth($method, $url, $data)
            {
                $curl = curl_init();
                switch ($method) {
                    case "POST":
                        curl_setopt($curl, CURLOPT_POST, 1);
                        if ($data)
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                        break;
                    case "PUT":
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                        if ($data)
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                        break;
                    default:
                        if ($data)
                            $url = sprintf("%s?%s", $url, http_build_query($data));
                }
                // OPTIONS:
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json'
                ));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                // EXECUTE:
                $result = curl_exec($curl);
                if (!$result) {
                    die("Connection Failure");
                }
                curl_close($curl);
                return $result;
            }

            $vnp_RequestId = rand(1, 10000); // Mã truy vấn
            $vnp_Command = "refund"; // Mã api
            $vnp_TransactionType = '02'; // 02 hoàn trả toàn phần - 03 hoàn trả một phần
            $vnp_TxnRef = $order["code"]; // Mã tham chiếu của giao dịch
            $vnp_Amount = $order["total_price"] * 100; // Số tiền hoàn trả
            $vnp_OrderInfo = "Hoan Tien Giao Dich"; // Mô tả thông tin
            $vnp_TransactionNo = "0"; // Tuỳ chọn, "0": giả sử merchant không ghi nhận được mã GD do VNPAY phản hồi.
            $vnp_TransactionDate = date('YmdHis', $order["date_created"]); // Thời gian ghi nhận giao dịch
            $ispTxnRequest = array(
                "vnp_RequestId" => $vnp_RequestId,
                "vnp_Version" => "2.1.0",
                "vnp_Command" => $vnp_Command,
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_TransactionType" => $vnp_TransactionType,
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_Amount" => $vnp_Amount,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_TransactionNo" => $vnp_TransactionNo,
                "vnp_TransactionDate" => $vnp_TransactionDate,
                "vnp_CreateBy" => "ADMIN",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            );

            $format = '%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s';

            $dataHash = sprintf(
                $format,
                $ispTxnRequest['vnp_RequestId'], //1
                $ispTxnRequest['vnp_Version'], //2
                $ispTxnRequest['vnp_Command'], //3
                $ispTxnRequest['vnp_TmnCode'], //4
                $ispTxnRequest['vnp_TransactionType'], //5
                $ispTxnRequest['vnp_TxnRef'], //6
                $ispTxnRequest['vnp_Amount'], //7
                $ispTxnRequest['vnp_TransactionNo'],  //8
                $ispTxnRequest['vnp_TransactionDate'], //9
                $ispTxnRequest['vnp_CreateBy'], //10
                $ispTxnRequest['vnp_CreateDate'], //11
                $ispTxnRequest['vnp_IpAddr'], //12
                $ispTxnRequest['vnp_OrderInfo'] //13
            );

            $checksum = hash_hmac('SHA512', $dataHash, $vnp_HashSecret);
            $ispTxnRequest["vnp_SecureHash"] = $checksum;
            $txnData = callAPI_auth("POST", $apiUrl, json_encode($ispTxnRequest));
            $ispTxn = json_decode($txnData, true);
        }



        $products_in_order = $d->rawQuery("select * from table_order_detail where id_order = ?", array($id));
        if (!empty($products_in_order)) {
            foreach ($products_in_order as $i => $v) {
                $product = $d->rawQueryOne("select * from table_product where id = ?", array($v['id_product']));

                if (!empty($product)) {
                    $current_product_quantity = $product['quantity'];
                    $order_product_quantity = $v['quantity'];

                    $data = array();
                    $data['quantity'] = $current_product_quantity + $order_product_quantity;
                    $d->where('id', $v['id_product']);
                    $d->update('table_product', $data);
                }
            }
        }
    }
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
                                        <th><?= $func->getImage(['class' => 'rounded img-preview', 'width' => 100, 'height' => 80, 'upload' => UPLOAD_PRODUCT_L, 'image' => $v2['photo']]) ?></th>
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
                                    <a id="cancel-order" data-id="<?= $v1['id'] ?>" href="javascript:void()" class="change_order_status">Hủy đơn hàng</a>
                                <?php } ?>

                                <div class="price-procart">
                                    <div class="total-procart">
                                        <p class="mr-3">Phí Ship:</p>
                                        <p class="total-price load-price-total"><?= $func->formatMoney($v1['ship_price']) ?></p>
                                    </div>

                                    <div class="total-procart">
                                        <p class="mr-3">Tổng tiền:</p>
                                        <p class="total-price load-price-total"><?= $func->formatMoney($v1['total_price']) ?></p>
                                    </div>
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
