<!DOCTYPE html>
<html lang="vi|en">

<head>
    <!-- Basehref -->
    <base href="<?= $configBase ?>" />
    <!-- UTF-8 -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Title, Keywords, Description -->
    <title>Shoes Shop</title>
    <meta name="keywords" content="Shoes Shop" />
    <meta name="description" content="Shoes Shop" />
    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="REFRESH" content="10; url=<?= $configBase ?>account/thong-tin#order">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <?php include TEMPLATE . LAYOUT . "css.php"; ?>
</head>

<body>
    <div class="wap_main">
        <div class="wrap-main <?= ($source == 'index') ? 'wrap-home' : '' ?>">
            <div class="payment-content redirect-info">
                <div>
                    <div class="item-info">
                        <div class="<?= $statusOrder == 200 ? 'icon-success' : 'icon-fail' ?>">
                            <?php if ($statusOrder == 200) { ?>
                                <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_hfevst90.json" background="transparent" speed="1" style="width: 120px; height: 120px;" loop autoplay></lottie-player>
                            <?php } ?>
                        </div>
                    </div>

                    <div>
                        <div class="item-info">
                            <h3>Thanh toán <?= $statusOrder != 200 ? 'không' : '' ?> thành công</h3>
                        </div>
                    </div>
                </div>

                <div class="item-info error">
                    <span style="color: #000000;">Thông tin: </span>
                    <span style="color: <?= $statusOrder == 200 ? '#63C000' : '#f5222d' ?>;"><?= $message ?></span>
                </div>

                <?php if (!empty($currentOrder)) { ?>
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="invoice p-3">
                                    <div class="payment border-top mt-3 mb-3 border-bottom table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="py-2">
                                                            <span class="d-block text-muted">Ngày đặt hàng</span>
                                                            <span><?= date("d/m/Y", $currentOrder['date_created']) ?></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="py-2">
                                                            <span class="d-block text-muted">Mã giao dịch</span>
                                                            <span><?= $currentOrder['code'] ?></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="py-2">
                                                            <span class="d-block text-muted">Phương thức thanh toán</span>
                                                            <span><?= $func->getInfoDetailSlug('name', 'news', $currentOrder['order_payment'])['name'] ?></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="py-2">
                                                            <span class="d-block text-muted">Địa chỉ giao hàng</span>
                                                            <span><?= $address ?></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="border-bottom table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <?php foreach ($tempCart as $i => $v) {
                                                    $pid = $v['productid'];
                                                    $quantity = $v['qty'];
                                                    $color = ($v['color']) ? $v['color'] : 0;
                                                    $size = ($v['size']) ? $v['size'] : 0;
                                                    $code = ($v['code']) ? $v['code'] : '';
                                                    $proinfo = $cart->getProductInfo($pid);
                                                    $pro_price = $proinfo['regular_price'];
                                                    $pro_price_new = $proinfo['sale_price'];
                                                    $pro_price_qty = $pro_price * $quantity;
                                                    $pro_price_new_qty = $pro_price_new * $quantity; ?>
                                                    <tr>
                                                        <td width="20%">
                                                            <?= $func->getImage(['class' => 'w-100', 'width' => 80, 'height' => 100, 'upload' => UPLOAD_PRODUCT_L, 'image' => $proinfo['photo'], 'alt' => $proinfo['name']]) ?>
                                                        </td>
                                                        <td width="60%" class="text-left">
                                                            <span class="font-weight-bold"><?= $proinfo['name'] ?></span>
                                                            <div class="product-qty">
                                                                <p class="d-block">Số lượng: <?= $quantity ?></span>
                                                                    <?php if ($color) {
                                                                        $color_detail = $d->rawQueryOne("select name from table_color where id = ? limit 0,1", array($color)); ?>
                                                                <p>Màu: <strong><?= $color_detail['name'] ?></strong></span>
                                                                <?php } ?>

                                                                <?php if ($size) {
                                                                    $size_detail = $d->rawQueryOne("select name from table_size where id = ? limit 0,1", array($size)); ?>
                                                                <p>Size: <strong><?= $size_detail['name'] ?></strong></span>
                                                                <?php } ?>

                                                            </div>
                                                        </td>
                                                        <td width="20%">
                                                            <div class="text-right">
                                                                <span class="font-weight-bold"><?= $func->formatMoney($pro_price_qty) ?></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row d-flex justify-content-end">
                                        <div class="col-md-5">
                                            <table class="table table-borderless">
                                                <tbody class="totals">
                                                    <tr>
                                                        <td>
                                                            <div class="text-left"> <span class="text-muted">Tạm tính</span> </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-right">
                                                                <span><?= $func->formatMoney($currentOrder['temp_price']) ?></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="text-left"> <span class="text-muted">Phí Ship</span> </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-right">
                                                                <span><?= $func->formatMoney($currentOrder['ship_price']) ?></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-top border-bottom">
                                                        <td>
                                                            <div class="text-left"> <span class="font-weight-bold">Tổng tiền</span> </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-right">
                                                                <span class="font-weight-bold"><?= $func->formatMoney($currentOrder['total_price']) ?></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <p class="font-weight-bold mb-0">Thanks for shopping with us!</p> <span><?= $setting['name'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="item-info">
                    Hãy bấm <a class="hover-momo-color hover-none-decoration" href="<?= $configBase ?>">Quay về</a> nếu đợi quá lâu !
                </div>
            </div>
        </div>
        <?php
        include TEMPLATE . LAYOUT . "js.php";
        ?>
    </div>
</body>

</html>