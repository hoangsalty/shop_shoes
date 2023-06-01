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
            $data1['transId_momo'] = $transId;
            $d->where('id', $extraData);
            $d->update('table_order', $data1);

            $data['partner_code'] = $partnerCode;
            $data['order_id'] = $extraData;
            $data['amount'] = $amount;
            $data['order_info'] = $orderInfo;
            $data['order_type'] = $orderType;
            $data['trans_id'] = $transId;
            $data['pay_type'] = $payType;
            $d->insert('table_momo', $data);

            unset($_SESSION['cart']);
            $func->transfer2("Giao Dịch MOMO Thành Công!", $configBase);
        } else {
            $d->rawQuery("delete from table_order where id = ?", array($extraData));
            $d->rawQuery("delete from table_order_detail where id_order = ?", array($extraData));
        }
    } else {
        $d->rawQuery("delete from table_order where id = ?", array($extraData));
        $d->rawQuery("delete from table_order_detail where id_order = ?", array($extraData));
    }
}
