<?php

if (!empty($_GET["partnerCode"])) {
    $secretKey = $config['momo']["secretKey"]; //Put your secret key in there
    $accessKey = $config['momo']['accessKey'];
    $partnerCode = $_GET["partnerCode"];
    $orderId = $_GET["orderId"];
    $requestId = $_GET["requestId"];
    $amount = $_GET["amount"];
    $orderInfo = $_GET["orderInfo"];
    $orderType = $_GET["orderType"];
    $transId = $_GET["transId"];
    $resultCode = $_GET["resultCode"];
    $message = $_GET["message"];
    $payType = $_GET["payType"];
    $responseTime = $_GET["responseTime"];
    $extraData = $_GET["extraData"]; // Order ID in DB
    $m2signature = $_GET["signature"]; //MoMo signature

    //Checksum
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&message=" . $message . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
        "&orderType=" . $orderType . "&partnerCode=" . $partnerCode . "&payType=" . $payType . "&requestId=" . $requestId . "&responseTime=" . $responseTime .
        "&resultCode=" . $resultCode . "&transId=" . $transId;

    $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);

    if ($m2signature == $partnerSignature) {
        if ($resultCode == '0') {
            /* Data */
            $dataOrder = (!empty($_SESSION['dataOrder'])) ? $_SESSION['dataOrder'] : array();

            /* Check data */
            if (!empty($dataOrder)) {
                /* Info */
                $code = strtoupper($func->stringRandom(6));
                $order_date = time();
                $fullname = (!empty($dataOrder['fullname'])) ? htmlspecialchars($dataOrder['fullname']) : '';
                $email = (!empty($dataOrder['email'])) ? htmlspecialchars($dataOrder['email']) : '';
                $phone = (!empty($dataOrder['phone'])) ? htmlspecialchars($dataOrder['phone']) : '';
                $requirements = (!empty($dataOrder['requirements'])) ? htmlspecialchars($dataOrder['requirements']) : '';

                /* Place */
                $city = (!empty($dataOrder['city'])) ? htmlspecialchars($dataOrder['city']) : 0;
                $district = (!empty($dataOrder['district'])) ? htmlspecialchars($dataOrder['district']) : 0;
                $ward = (!empty($dataOrder['ward'])) ? htmlspecialchars($dataOrder['ward']) : 0;
                $city_text = $func->getInfoDetail('name', "city", $city);
                $district_text = $func->getInfoDetail('name', "district", $district);
                $ward_text = $func->getInfoDetail('name', "ward", $ward);
                $address = htmlspecialchars($dataOrder['address']);

                /* Payment */
                $order_payment = (!empty($dataOrder['payments'])) ? htmlspecialchars($dataOrder['payments']) : '';

                /* Ship */
                $ship_data = (!empty($dataOrder['ward'])) ? $func->getInfoDetail('ship_price', "ward", $dataOrder['ward']) : array();
                $ship_price = (!empty($ship_data['ship_price'])) ? $ship_data['ship_price'] : 0;

                /* Price */
                $temp_price = $cart->getOrderTotal();
                $total_price = (!empty($ship_price)) ? $cart->getOrderTotal() + $ship_price : $cart->getOrderTotal();

                /* Cart */
                $order_detail = '';
                $max = (!empty($_SESSION['cart'])) ? count($_SESSION['cart']) : 0;

                /* lưu đơn hàng */
                $data_donhang = array();
                $data_donhang['transId_momo'] = $transId;
                $data_donhang['id_user'] = (!empty($_SESSION['account']['id'])) ? $_SESSION['account']['id'] : 0;
                $data_donhang['code'] = $code;
                $data_donhang['fullname'] = $fullname;
                $data_donhang['phone'] = $phone;
                $data_donhang['address'] = $address;
                $data_donhang['email'] = $email;
                $data_donhang['order_payment'] = $order_payment;
                $data_donhang['ship_price'] = $ship_price;
                $data_donhang['temp_price'] = $temp_price;
                $data_donhang['total_price'] = $total_price;
                $data_donhang['requirements'] = $requirements;
                $data_donhang['date_created'] = $order_date;
                $data_donhang['order_status'] = 'moidat';
                $data_donhang['city'] = $city;
                $data_donhang['district'] = $district;
                $data_donhang['ward'] = $ward;

                /* lưu đơn hàng chi tiết */
                if ($d->insert('table_order', $data_donhang)) {
                    $id_insert = $d->getLastInsertId();

                    //Order detail
                    for ($i = 0; $i < $max; $i++) {
                        $pid = $_SESSION['cart'][$i]['productid'];
                        $q = $_SESSION['cart'][$i]['qty'];
                        $proinfo = $cart->getProductInfo($pid);
                        $regular_price = $proinfo['regular_price'];
                        $sale_price = $proinfo['sale_price'];
                        $color = ($_SESSION['cart'][$i]['color'] > 0) ? $_SESSION['cart'][$i]['color'] : NULL;
                        $size = ($_SESSION['cart'][$i]['size'] > 0) ? $_SESSION['cart'][$i]['size'] : NULL;
                        $code_order = $_SESSION['cart'][$i]['code'];

                        if ($q == 0) continue;

                        $data_donhangchitiet = array();
                        $data_donhangchitiet['id_product'] = $pid;
                        $data_donhangchitiet['id_order'] = $id_insert;
                        $data_donhangchitiet['photo'] = $proinfo['photo'];
                        $data_donhangchitiet['name'] = $proinfo['name'];
                        $data_donhangchitiet['code'] = $code;
                        $data_donhangchitiet['id_color'] = $color;
                        $data_donhangchitiet['id_size'] = $size;
                        if ($sale_price > 0) {
                            $data_donhangchitiet['price'] = $sale_price;
                        } else {
                            $data_donhangchitiet['price'] = $regular_price;
                        }
                        $data_donhangchitiet['quantity'] = $q;
                        $d->insert('table_order_detail', $data_donhangchitiet);
                    }

                    //Momo detail
                    $data['partner_code'] = $partnerCode;
                    $data['order_id'] = $id_insert;
                    $data['amount'] = $amount;
                    $data['order_info'] = $orderInfo;
                    $data['order_type'] = $orderType;
                    $data['trans_id'] = $transId;
                    $data['pay_type'] = $payType;
                    $d->insert('table_momo', $data);

                    /* Xóa giỏ hàng và đơn hàng session */
                    unset($_SESSION['cart']);
                    unset($_SESSION['dataOrder']);
                    $func->transfer2("Giao Dịch MOMO Thành Công!", $configBase);
                } else {
                    $func->transfer2("Lỗi lưu đơn hàng.", $configBase, false);
                }
            }
        } else {
            //Lỗi nếu thanh toán thất bại
        }
    } else {
        //Lỗi khi $m2signature != $partnerSignature (bảo mật)
    }
}
