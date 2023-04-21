<?php
if (!defined('SOURCES')) die("Error");

/* breadCrumbs */
if (!empty($titleMain)) $breadcr->set($com, $titleMain);
$breadcrumbs = $breadcr->get();

/* Tỉnh thành */
$city = $d->rawQuery("select name, id from table_city order by id asc");

/* Hình thức thanh toán */
$payments_info = $d->rawQuery("select * from table_news where date_deleted = 0 and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('hinh-thuc-thanh-toan'));

if (!empty($_POST['thanhtoan'])) {
    /* Check order */
    if (empty($_SESSION['cart'])) {
        $func->transfer("Đơn hàng không hợp lệ. Vui lòng thử lại sau.", "index.php", false);
    }

    /* Data */
    $dataOrder = (!empty($_POST['dataOrder'])) ? $_POST['dataOrder'] : null;

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
        $address = htmlspecialchars($dataOrder['address']) . ', ' . $ward_text['name'] . ', ' . $district_text['name'] . ', ' . $city_text['name'];

        /* Payment */
        $order_payment = (!empty($dataOrder['payments'])) ? htmlspecialchars($dataOrder['payments']) : 0;
        $order_payment_data = $func->getInfoDetail('name', 'news', $order_payment);
        $order_payment_text = $order_payment_data['name'];

        /* Ship */
        $ship_data = (!empty($dataOrder['ward'])) ? $func->getInfoDetail('ship_price', "ward", $dataOrder['ward']) : array();
        $ship_price = (!empty($ship_data['ship_price'])) ? $ship_data['ship_price'] : 0;

        /* Price */
        $temp_price = $cart->getOrderTotal();
        $total_price = (!empty($ship_price)) ? $cart->getOrderTotal() + $ship_price : $cart->getOrderTotal();

        /* Cart */
        $order_detail = '';
        $max = (!empty($_SESSION['cart'])) ? count($_SESSION['cart']) : 0;
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
        /* Flash data */
        if (!empty($dataOrder)) {
            foreach ($dataOrder as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set("message", $message);
        $func->redirect("gio-hang");
    }

    /* lưu đơn hàng */
    $data_donhang = array();
    //$data_donhang['id_user'] = (!empty($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : 0;
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
    $data_donhang['numb'] = 1;

    /* lưu đơn hàng chi tiết */
    if ($d->insert('table_order', $data_donhang)) {
        $id_insert = $d->getLastInsertId();

        for ($i = 0; $i < $max; $i++) {
            $pid = $_SESSION['cart'][$i]['productid'];
            $q = $_SESSION['cart'][$i]['qty'];
            $proinfo = $cart->getProductInfo($pid);
            $regular_price = $proinfo['regular_price'];
            $sale_price = $proinfo['sale_price'];
            $color = $_SESSION['cart'][$i]['color'];
            $size = $_SESSION['cart'][$i]['size'];
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
            $data_donhangchitiet['regular_price'] = $regular_price;
            $data_donhangchitiet['sale_price'] = $sale_price;
            $data_donhangchitiet['quantity'] = $q;
            $d->insert('table_order_detail', $data_donhangchitiet);
        }
    }

    /* Xóa giỏ hàng */
    unset($_SESSION['cart']);
    $func->transfer("Thông tin đơn hàng đã được gửi thành công.", "../index.php");
}
