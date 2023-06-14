<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

$vnp_TmnCode = "7XEELYTQ"; //Mã định danh merchant kết nối (Terminal Id)
$vnp_HashSecret = "JEYHBZREKPBADWSGQPJEGMYOJKERBRKI"; //Secret key
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = $configBase . "payment-vnpay";
$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
$apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
//Config input format
//Expire
$startTime = date("YmdHis");
$expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
