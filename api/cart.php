<?php
include "config.php";

$cmd = (!empty($_POST['cmd'])) ? htmlspecialchars($_POST['cmd']) : '';
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$color = (!empty($_POST['color'])) ? htmlspecialchars($_POST['color']) : 0;
$size = (!empty($_POST['size'])) ? htmlspecialchars($_POST['size']) : 0;
$quantity = (!empty($_POST['quantity'])) ? htmlspecialchars($_POST['quantity']) : 1;
$code = (!empty($_POST['code'])) ? htmlspecialchars($_POST['code']) : '';
$oldValue = (!empty($_POST['oldValue'])) ? htmlspecialchars($_POST['oldValue']) : 0;

if ($cmd == 'plus') {
    $quantityDB = $d->rawQueryOne("select quantity from table_product where id = ? limit 0,1", array($id));

    $totalQty = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $i => $v) {
            if ($_SESSION['cart'][$i]['productid'] == $id) {
                $totalQty += $_SESSION['cart'][$i]['qty'];
            }
        }
    }

    if (($quantityDB['quantity'] - $totalQty) > 0) {
        $newValue = $oldValue + 1;
        if (!empty($quantityDB) && $newValue > $quantityDB['quantity']) {
            $newValue = $quantityDB['quantity'];
        }

        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $i => $v) {
                if ($code == $_SESSION['cart'][$i]['code']) {
                    $_SESSION['cart'][$i]['qty'] = $newValue;
                    break;
                }
            }
        }

        $data = array('quantity' => $newValue);
        echo json_encode($data);
    } else {
        if (!empty($quantityDB) && $oldValue >= $quantityDB['quantity']) {
            $oldValue = 1;
        }

        $data = array('quantity' => $oldValue);
        echo json_encode($data);
    }
} else if ($cmd == 'minus' && $oldValue > 1) {
    $newValue = $oldValue - 1;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $i => $v) {
            if ($code == $_SESSION['cart'][$i]['code']) {
                $_SESSION['cart'][$i]['qty'] = $newValue;
                break;
            }
        }
    }

    $data = array('quantity' => $newValue);
    echo json_encode($data);
} else if ($cmd == 'add-cart' && $id > 0) {
    $quantityDB = $d->rawQueryOne("select quantity from table_product where id = ? limit 0,1", array($id));
    if ($quantity > $quantityDB['quantity']) {
        $data = array('status' => 404, 'message' => 'Sản phẩm này đã hết.');
        echo json_encode($data);
    } else {
        $totalQty = 0;
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $i => $v) {
                if ($_SESSION['cart'][$i]['productid'] == $id) {
                    $totalQty += $_SESSION['cart'][$i]['qty'];
                }
            }
        }

        if (($quantityDB['quantity'] - ($totalQty + $quantity)) >= 0) {
            $cart->addToCart($quantity, $id, $color, $size);
            $max = (!empty($_SESSION['cart'])) ? count($_SESSION['cart']) : 0;
            $data = array('status' => 200, 'max' => $max);
            echo json_encode($data);
        } else {
            $last = $quantityDB['quantity'] - $totalQty;
            $data = array('quantity' => $last, 'status' => 404, 'message' => 'Không đủ sản phẩm tồn theo số lượng thêm vào giỏ hàng');
            echo json_encode($data);
        }
    }
} else if ($cmd == 'update-cart' && $id > 0 && $code != '') {
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $i => $v) {
            if ($code == $_SESSION['cart'][$i]['code']) {
                $_SESSION['cart'][$i]['qty'] = $quantity;
                break;
            }
        }
    }

    $proinfo = $cart->getProductInfo($id);
    $regular_price = $func->formatMoney($proinfo['regular_price'] * $quantity);
    $sale_price = $func->formatMoney($proinfo['sale_price'] * $quantity);
    $temp = $cart->getOrderTotal();
    $tempText = $func->formatMoney($temp);
    $total = $cart->getOrderTotal();
    $totalText = $func->formatMoney($total);
    $data = array(
        'regularPrice' => $regular_price,
        'salePrice' => $sale_price,
        'tempText' => $tempText,
        'totalText' => $totalText,
    );

    echo json_encode($data);
} else if ($cmd == 'update-ship-total') {
    $ship = (!empty($_POST['ship_price'])) ? htmlspecialchars($_POST['ship_price']) : 0;

    $temp = $cart->getOrderTotal();
    $tempText = $func->formatMoney($temp);

    $total = $cart->getOrderTotal() + $ship;
    $totalText = $func->formatMoney($total);

    $data = array(
        'shipPrice' => $ship,
        'tempPrice' => $temp,
        'tempText' => $tempText,
        'totalPrice' => $total,
        'totalText' => $totalText,
    );

    echo json_encode($data);
} else if ($cmd == 'delete-cart' && $code != '') {
    $cart->removeProduct($code);
    $max = (!empty($_SESSION['cart'])) ? count($_SESSION['cart']) : 0;
    $temp = $cart->getOrderTotal();
    $tempText = $func->formatMoney($temp);
    $total = $cart->getOrderTotal();
    $totalText = $func->formatMoney($total);
    $data = array('max' => $max, 'tempText' => $tempText, 'totalText' => $totalText);

    echo json_encode($data);
} else if ($cmd == 'popup-cart') { ?>
    <form class="form-cart" method="post" action="" enctype="multipart/form-data">
        <div class="wrap-cart">
            <?php if (!empty($_SESSION['cart'])) { ?>
                <div class="top-cart border-right-0">
                    <div class="list-procart">
                        <div class="procart procart-label">
                            <div class="form-row">
                                <div class="pic-procart col-3 col-md-2">Hình ảnh</div>
                                <div class="info-procart col-6 col-md-5">Tên sản phẩm</div>
                                <div class="quantity-procart col-3 col-md-2">Số lượng</div>
                                <div class="price-procart col-3 col-md-3">Thành tiền</div>
                            </div>
                        </div>
                        <?php $max = count($_SESSION['cart']);
                        for ($i = 0; $i < $max; $i++) {
                            $pid = $_SESSION['cart'][$i]['productid'];
                            $quantity = $_SESSION['cart'][$i]['qty'];
                            $color = ($_SESSION['cart'][$i]['color']) ? $_SESSION['cart'][$i]['color'] : 0;
                            $size = ($_SESSION['cart'][$i]['size']) ? $_SESSION['cart'][$i]['size'] : 0;
                            $code = ($_SESSION['cart'][$i]['code']) ? $_SESSION['cart'][$i]['code'] : '';
                            $proinfo = $cart->getProductInfo($pid);

                            $pro_price = $proinfo['regular_price'];
                            $pro_price_new = $proinfo['sale_price'];
                            $pro_price_qty = $pro_price * $quantity;
                            $pro_price_new_qty = $pro_price_new * $quantity; ?>
                            <div class="procart procart-<?= $code ?>">
                                <div class="form-row">
                                    <div class="pic-procart col-3 col-md-2">
                                        <a class="text-decoration-none" href="<?= $proinfo['slug'] ?>" target="_blank" title="<?= $proinfo['name'] ?>">
                                            <?= $func->getImage(['class' => 'w-100', 'width' => 85, 'height' => 90, 'upload' => UPLOAD_PRODUCT_L, 'image' => $proinfo['photo']]) ?>
                                        </a>
                                        <a class="del-procart text-decoration-none" data-code="<?= $code ?>">
                                            <i class="fa fa-times-circle"></i>
                                            <span>Xóa</span>
                                        </a>
                                    </div>
                                    <div class="info-procart col-6 col-md-5">
                                        <h3 class="name-procart"><a class="text-decoration-none" href="<?= $proinfo['slug'] ?>" target="_blank" title="<?= $proinfo['name'] ?>"><?= $proinfo['name'] ?></a></h3>
                                        <div class="properties-procart">
                                            <?php if ($size) {
                                                $size_detail = $d->rawQueryOne("select name from table_size where id = ? limit 0,1", array($size)); ?>
                                                <p>Size: <strong><?= $size_detail['name'] ?></strong></p>
                                            <?php } ?>
                                            <?php if ($color) {
                                                $color_detail = $d->rawQueryOne("select name from table_color where id = ? limit 0,1", array($color)); ?>
                                                <p>Màu: <strong><?= $color_detail['name'] ?></strong></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="quantity-procart col-3 col-md-2">
                                        <div class="quantity-counter-procart quantity-counter-procart-<?= $code ?>">
                                            <span class="counter-procart-minus counter-procart">-</span>
                                            <input type="number" class="quantity-procart" min="1" value="<?= $quantity ?>" data-pid="<?= $pid ?>" data-code="<?= $code ?>" readonly />
                                            <span class="counter-procart-plus counter-procart">+</span>
                                        </div>
                                    </div>
                                    <div class="price-procart col-3 col-md-3">
                                        <?php if ($proinfo['sale_price']) { ?>
                                            <p class="price-new-cart load-price-new-<?= $code ?>">
                                                <?= $func->formatMoney($pro_price_new_qty) ?>
                                            </p>
                                            <p class="price-old-cart load-price-<?= $code ?>">
                                                <?= $func->formatMoney($pro_price_qty) ?>
                                            </p>
                                        <?php } else { ?>
                                            <p class="price-new-cart load-price-<?= $code ?>">
                                                <?= $func->formatMoney($pro_price_qty) ?>
                                            </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="money-procart">
                        <div class="total-procart">
                            <p>Tạm tính:</p>
                            <p class="total-price load-price-temp"><?= $func->formatMoney($cart->getOrderTotal()) ?></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="san-pham" class="buymore-cart text-decoration-none" title="Tiếp tục mua hàng">
                            <i class="fa fa-angle-double-left"></i>
                            <span>Tiếp tục mua hàng</span>
                        </a>
                        <a class="btn btn-dark btn-sm btn-cart" href="gio-hang" title="Thanh toán">Thanh toán</a>
                    </div>
                </div>
            <?php } else { ?>
                <a href="" class="empty-cart text-decoration-none w-100">
                    <i class="fas fa-cart-plus"></i>
                    <p>Không tồn tại sản phẩm trong giỏ hàng</p>
                    <span class="btn btn-warning">Về trang chủ</span>
                </a>
            <?php } ?>
        </div>
    </form>
<?php } ?>