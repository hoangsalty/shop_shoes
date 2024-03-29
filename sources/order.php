<?php
if (!defined('SOURCES')) {
    require_once "../api/config.php";
    /* die("Error"); */
}

/* Tỉnh thành */
$city = $func->getProvince();

if (isset($_POST['thanhtoan'])) {
    $message = '';
    $response = array();

    /* Data */
    $dataOrder = (!empty($_POST['dataOrder'])) ? $_POST['dataOrder'] : array();
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
        $city = (!empty($dataOrder['city'])) ? htmlspecialchars($dataOrder['city']) : '';
        $district = (!empty($dataOrder['district'])) ? htmlspecialchars($dataOrder['district']) : '';
        $ward = (!empty($dataOrder['ward'])) ? htmlspecialchars($dataOrder['ward']) : '';

        $address = htmlspecialchars($dataOrder['address']) . ', ' . strtok($ward, '__') . ', ' . strtok($district, '__') . ', ' . strtok($city, '__');

        /* Payment */
        $order_payment = (!empty($dataOrder['payments'])) ? htmlspecialchars($dataOrder['payments']) : '';

        /* Ship */
        $ship_price = (!empty($dataOrder['ship_price'])) ? $dataOrder['ship_price'] : 0;

        /* Price */
        $temp_price = (!empty($dataOrder['temp_price'])) ? $dataOrder['temp_price'] : 0;
        $total_price = (!empty($ship_price)) ? $temp_price + $ship_price : $temp_price;

        /* Cart */
        $orderDetails = (!empty($_SESSION['cart'])) ? $_SESSION['cart'] : array();
    }

    if (!empty($orderDetails)) {
        foreach ($orderDetails as $i => $v) {
            $outOfProduct = $d->rawQueryOne("select * from table_product where id=? and quantity <= 0", array($v['productid']));
            if (!empty($outOfProduct)) {
                $response['messages'][] = 'Sản phẩm <a target="_blank" href="' . $outOfProduct['slug'] . '"><b>' . $outOfProduct['name'] . '</b></a> đã hết nên không thể thanh toán';
            }
        }
    }

    /* Valid data */
    if (empty($dataOrder['payments'])) {
        $response['messages'][] = 'Chưa chọn hình thức thanh toán';
    }

    if (empty($dataOrder['fullname'])) {
        $response['messages'][] = 'Họ tên không được trống';
    }

    if (empty($dataOrder['phone'])) {
        $response['messages'][] = 'Số điện thoại không được trống';
    }

    if (!empty($dataOrder['phone']) && !$func->isPhone($dataOrder['phone'])) {
        $response['messages'][] = 'Số điện thoại không hợp lệ';
    }

    if (empty($dataOrder['city'])) {
        $response['messages'][] = 'Chưa chọn tỉnh/thành phố';
    }

    if (empty($dataOrder['district'])) {
        $response['messages'][] = 'Chưa chọn quận/huyện';
    }

    if (empty($dataOrder['ward'])) {
        $response['messages'][] = 'Chưa chọn phường/xã';
    }

    if (empty($dataOrder['address'])) {
        $response['messages'][] = 'Địa chỉ không được trống';
    }

    if (empty($dataOrder['email'])) {
        $response['messages'][] = 'Email không được trống';
    }

    if (!empty($dataOrder['email']) && !$func->isEmail($dataOrder['email'])) {
        $response['messages'][] = 'Email không hợp lệ';
    }

    if (!empty($response)) {
        /* Errors */
        $response['status'] = 404;
        $message = json_encode($response);
        echo $message;
        return;
    }

    //Momo - VNPay
    if ($order_payment == "momo") {
        header('Content-type: text/html; charset=utf-8');

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = $config['momo']['partnerCode'];
        $accessKey = $config['momo']['accessKey'];
        $secretKey = $config['momo']['secretKey'];

        $orderInfo = "Thanh toán qua ATM MoMo";
        $amount = $total_price;
        $orderId = time() . "";

        $redirectUrl = $configBase . 'payment-momo';
        $ipnUrl = $configBase . 'payment-momo';
        $requestId = time() . "";

        $requestType = "payWithATM";
        //$requestType = "captureWallet";

        $extraData = '';

        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $func->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        if (!empty($jsonResult)) {
            $_SESSION['dataOrder'] = $dataOrder;
            $func->transfer("Di chuyển đến trang thanh toán MOMO", $jsonResult['payUrl']);
        } else {
            $func->transfer("Phát sinh lỗi với thanh toán MOMO", $configBase, false);
        }
        return;
    } else if ($order_payment == "vnpay") {
        $vnp_TxnRef = $code; //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $total_price * 100; // Số tiền thanh toán
        $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = "NCB"; //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        $_SESSION['dataOrder'] = $dataOrder;

        $response['status'] = 201;
        $response['link'] = $vnp_Url;
        $response['messages'][] = "Di chuyển đến trang thanh toán VNPay...";
        $message = json_encode($response);
        echo $message;
        return;
    }

    /* lưu đơn hàng */
    $data_donhang = array();
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

                // Cập nhật số lượng sản phẩm
                $old_value = $d->rawQueryOne("select quantity from table_product where id = ? limit 0,1", array($pid));
                $data_product['quantity'] = $old_value['quantity'] - $q;
                $d->where('id', $pid);
                $d->update('table_product', $data_product);

                // Thêm order detail
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

        $currentOrder = $d->rawQueryOne("select * from table_order where id=? limit 0,1", array($id_insert));
        $tempCart = $_SESSION['cart'];

        /* Xóa giỏ hàng */
        unset($_SESSION['cart']);

        $response['status'] = 200;
        $response['currentOrder'] = $currentOrder;
        $response['tempCart'] = $tempCart;
        $response['link'] = $configBase . 'account?act=thong-tin#order';
        $response['messages'][] = "Thông tin đơn hàng đã được gửi thành công. Hệ thống sẽ tự động đưa bạn đến với khu vực đơn hàng...";
        $message = json_encode($response);
        echo $message;
        return;
    } else {
        $statusOrder = 404;
        $message = 'Lỗi lưu đơn hàng.';
        include(TEMPLATE . "order/order_status.php");
        exit();
    }
}
