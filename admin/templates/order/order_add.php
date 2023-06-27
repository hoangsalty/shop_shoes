<?php
$linkMan = "index.php?com=order&act=list";
?>
<!-- Main content -->
<section class="content">
    <form id="form_order" class="validation-form" novalidate method="post" enctype="multipart/form-data">
        <div class="card-header text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <input type="hidden" name="id" value="<?= @$item['id'] ?>">
        </div>

        <div class="box_response"></div>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin chính</h3>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-3 col-sm-6">
                    <label>Mã đơn hàng:</label>
                    <p class="text-primary"><?= @$item['code'] ?></p>
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <label>Hình thức thanh toán:</label>
                    <?php (@$item['order_payment'] == "momo" || @$item['order_payment'] == "vnpay") ? $order_payment['name'] = @$item['order_payment'] : $order_payment = $func->getInfoDetailSlug('name', 'news', @$item['order_payment']); ?>
                    <p class="text-info cap"><?= $order_payment['name'] ?></p>
                </div>

                <div class="form-group col-md-3 col-sm-6">
                    <label>Mã giao dịch:</label>
                    <p class="text-info cap bold"><?= @$item['transId'] ?></p>
                </div>

                <div class="form-group col-md-3 col-sm-6">
                    <label>Họ tên:</label>
                    <p class="font-weight-bold text-uppercase text-success"><?= @$item['fullname'] ?></p>
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <label>Điện thoại:</label>
                    <p><?= @$item['phone'] ?></p>
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <label>Email:</label>
                    <p><?= @$item['email'] ?></p>
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <label>Địa chỉ:</label>
                    <p><?= @$item['address'] ?></p>
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <label>Ngày đặt:</label>
                    <p><?= date("d/m/Y - h:i:s A", @$item['date_created']) ?></p>
                </div>
                <div class="form-group col-12">
                    <label for="requirements">Yêu cầu khác:</label>
                    <textarea class="form-control text-sm" name="data[requirements]" id="requirements" rows="5" placeholder="Yêu cầu khác"><?= @$item['requirements'] ?></textarea>
                </div>
                <div class="form-group col-12">
                    <label for="order_status" class="mr-2">Tình trạng:</label>
                    <?= $func->orderStatus(@$item['order_status']) ?>
                </div>
            </div>
        </div>
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Chi tiết đơn hàng</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="align-middle text-center" width="10%">STT</th>
                            <th class="align-middle">Hình ảnh</th>
                            <th class="align-middle" style="width:30%">Tên sản phẩm</th>
                            <th class="align-middle text-center">Đơn giá</th>
                            <th class="align-middle text-right">Số lượng</th>
                            <th class="align-middle text-right">Tạm tính</th>
                        </tr>
                    </thead>
                    <?php if (empty($order_detail)) { ?>
                        <tbody>
                            <tr>
                                <td colspan="100" class="text-center">Không có dữ liệu</td>
                            </tr>
                        </tbody>
                    <?php } else { ?>
                        <tbody>
                            <?php foreach ($order_detail as $k => $v) { ?>
                                <tr>
                                    <td class="align-middle text-center"><?= ($k + 1) ?></td>
                                    <td class="align-middle">
                                        <a title="<?= $v['name'] ?>">
                                            <?= $func->getImage(['class' => 'rounded img-preview', 'width' => 55, 'height' => 55, 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-primary mb-1"><?= $v['name'] ?></p>
                                        <?php if ($v['id_size'] != '' || $v['id_size'] != '') { ?>
                                            <p class="mb-0">
                                                <?php if ($v['id_size'] != '') { ?>
                                                    <?php $size = $func->getInfoDetail('name', 'size', @$v['id_size']); ?>
                                                    <span class="pr-2">Size: <b><?= $size['name'] ?></b></span>
                                                <?php } ?>
                                                <?php if ($v['id_color'] != '') { ?>
                                                    <?php $color = $func->getInfoDetail('name', 'color', @$v['id_color']); ?>
                                                    <span>Màu: <b><?= $color['name'] ?></b> </span>
                                                <?php } ?>
                                            </p>
                                        <?php } ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="price-cart-detail">
                                            <span class="price-new-cart-detail"><?= $func->formatMoney($v['price']) ?></span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-right"><?= $v['quantity'] ?></td>
                                    <td class="align-middle text-right">
                                        <div class="price-cart-detail">
                                            <span class="price-new-cart-detail"><?= $func->formatMoney($v['price'] * $v['quantity']) ?></span>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="5" class="title-money-cart-detail">Tạm tính:</td>
                                <td colspan="1" class="cast-money-cart-detail"><?= $func->formatMoney($item['temp_price']) ?></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="title-money-cart-detail">Phí vận chuyển:</td>
                                <td colspan="1" class="cast-money-cart-detail">
                                    <?php if ($item['ship_price']) { ?>
                                        <?= $func->formatMoney($item['ship_price']) ?>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="title-money-cart-detail">Tổng giá trị đơn hàng:</td>
                                <td colspan="1" class="cast-money-cart-detail"><?= $func->formatMoney($item['total_price']) ?></td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </form>
</section>