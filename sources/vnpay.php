<?php

if (empty($_GET["vnp_Amount"])) {
    $func->transfer("Dữ liệu không có thực.", $configBase, false);
}

if (!empty($_GET["vnp_Amount"])) {
    $vnp_Amount = $_GET['vnp_Amount'];
    $vnp_BankCode = $_GET['vnp_BankCode'];
    $vnp_BankTranNo = $_GET['vnp_BankTranNo'];
    $vnp_CardType = $_GET['vnp_CardType'];
    $vnp_OrderInfo = $_GET['vnp_OrderInfo'];
    $vnp_PayDate = $_GET['vnp_PayDate'];
    $vnp_ResponseCode = $_GET['vnp_ResponseCode'];
    $vnp_TmnCode = $_GET['vnp_TmnCode'];
    $vnp_TransactionNo = $_GET['vnp_TransactionNo'];
    $vnp_TransactionStatus = $_GET['vnp_TransactionStatus'];
    $vnp_TxnRef = $_GET['vnp_TxnRef'];

    $message = '';

    if ($vnp_ResponseCode == '00') {
        /* Data */
        $dataOrder = (!empty($_SESSION['dataOrder'])) ? $_SESSION['dataOrder'] : array();
        /* Check data */
        if (!empty($dataOrder)) {
            /* Info */
            $code = $vnp_TxnRef;
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
            $orderDetails = (!empty($_SESSION['cart'])) ? $_SESSION['cart'] : array();

            /* lưu đơn hàng */
            $data_donhang = array();
            $data_donhang['transId'] = $vnp_TransactionNo;
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
                if (!empty($orderDetails)) {
                    foreach ($orderDetails as $key => $value) {
                        $pid = $value['productid'];
                        $q = $value['qty'];
                        $proinfo = $cart->getProductInfo($pid);
                        $regular_price = $proinfo['regular_price'];
                        $sale_price = $proinfo['sale_price'];
                        $color = ($value['color'] > 0) ? $value['color'] : NULL;
                        $size = ($value['size'] > 0) ? $value['size'] : NULL;
                        $code_order = $value['code'];

                        if ($q == 0) continue;

                        $data_orderdetail = array();
                        $data_orderdetail['id_product'] = $pid;
                        $data_orderdetail['id_order'] = $id_insert;
                        $data_orderdetail['photo'] = $proinfo['photo'];
                        $data_orderdetail['name'] = $proinfo['name'];
                        $data_orderdetail['code'] = $code;
                        $data_orderdetail['id_color'] = $color;
                        $data_orderdetail['id_size'] = $size;
                        if ($sale_price > 0) {
                            $data_orderdetail['price'] = $sale_price;
                        } else {
                            $data_orderdetail['price'] = $regular_price;
                        }
                        $data_orderdetail['quantity'] = $q;
                        $d->insert('table_order_detail', $data_orderdetail);
                    }
                }

                //VNPay detail
                $data_vnpay = array();
                $data_vnpay['order_id'] = $id_insert;
                $data_vnpay['vnp_amount'] = $vnp_Amount;
                $data_vnpay['vnp_bankcode'] = $vnp_BankCode;
                $data_vnpay['vnp_banktranno'] = $vnp_BankTranNo;
                $data_vnpay['vnp_cardtype'] = $vnp_CardType;
                $data_vnpay['vnp_orderinfo'] = $vnp_OrderInfo;
                $data_vnpay['vnp_paydate'] = $vnp_PayDate;
                $data_vnpay['vnp_tmncode'] = $vnp_TmnCode;
                $data_vnpay['vnp_transactionno'] = $vnp_TransactionNo;
                $d->insert('table_vnpay', $data_vnpay);

                /* Xóa giỏ hàng và đơn hàng session */
                unset($_SESSION['cart']);
                unset($_SESSION['dataOrder']);
                $message = 'Thanh toán qua VNPay Thành Công!';
                //$func->transfer("Thanh toán qua VNPay Thành Công!", $configBase);
            } else {
                $message = 'Lỗi lưu đơn hàng';
                //$func->transfer("Lỗi lưu đơn hàng.", $configBase, false);
            }
        }
    } else {
        $func->transfer("Lỗi thanh toán thất bại.", $configBase, false);
        //Lỗi nếu thanh toán thất bại
    }
}
