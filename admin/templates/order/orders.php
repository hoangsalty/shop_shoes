<?php
$linkMan = "index.php?com=order&act=list";
$linkEdit = "index.php?com=order&act=edit";
$linkDelete = "index.php?com=order&act=delete";
?>
<!-- Main content -->
<section class="content">
    <div class="card-header text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="sources/order.php" data-act="delete" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
        <div class="form-inline form-search d-inline-block align-middle ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="Tìm kiếm" aria-label="Tìm kiếm" value="<?= (isset($_GET['keyword'])) ? $_GET['keyword'] : '' ?>" onkeypress="doEnter(event,'keyword','<?= $linkMan ?>')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','<?= $linkMan ?>')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline text-sm">
        <div class="card-header">
            <h3 class="card-title">Tìm kiếm đơn hàng</h3>
        </div>
        <div class="card-body row">
            <div class="form-group col-4">
                <label>Ngày đặt:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control float-right text-sm" name="order_date" id="order_date" value="<?= (isset($_GET['order_date'])) ? $_GET['order_date'] : '' ?>" readonly>
                </div>
            </div>
            <div class="form-group col-4">
                <label>Tình trạng:</label>
                <?= $func->orderStatus() ?>
            </div>
            <div class="form-group col-4">
                <label>Hình thức thanh toán:</label>
                <?= $func->orderPayments() ?>
            </div>
            <div class="form-group text-center mt-2 mb-0 col-12">
                <a class="btn btn-sm bg-gradient-success text-white" onclick="actionOrder('<?= $linkMan ?>')" title="Tìm kiếm"><i class="fas fa-search mr-1"></i>Tìm kiếm</a>
                <a class="btn btn-sm bg-gradient-danger text-white ml-1" href="<?= $linkMan ?>" title="Hủy lọc"><i class="fas fa-times mr-1"></i>Hủy lọc</a>
            </div>
        </div>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="align-middle" width="5%">
                    <div class="custom-control custom-checkbox my-checkbox">
                        <input type="checkbox" class="custom-control-input" id="selectall-checkbox">
                        <label for="selectall-checkbox" class="custom-control-label"></label>
                    </div>
                </th>
                <th class="align-middle">Mã đơn hàng</th>
                <th class="align-middle" style="width:15%">Họ tên</th>
                <th class="align-middle">Ngày đặt</th>
                <th class="align-middle">Hình thức thanh toán</th>
                <th class="align-middle">Tổng giá</th>
                <th class="align-middle">Tình trạng</th>
                <th class="align-middle text-center">Thao tác</th>
            </tr>
        </thead>
        <?php if (empty($items)) { ?>
            <tbody>
                <tr>
                    <td colspan="100" class="text-center">Không có dữ liệu</td>
                </tr>
            </tbody>
        <?php } else { ?>
            <tbody>
                <?php 
                foreach ($items as $i => $order) { ?>
                    <tr class="order_table">
                        <td class="align-middle">
                            <div class="custom-control custom-checkbox my-checkbox">
                                <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?= $order['id'] ?>" value="<?= $order['id'] ?>">
                                <label for="select-checkbox-<?= $order['id'] ?>" class="custom-control-label"></label>
                            </div>
                        </td>
                        <td class="align-middle">
                            <a class="text-primary" href="<?= $linkEdit ?>&id=<?= $order['id'] ?>" title="<?= $order['code'] ?>"><?= $order['code'] ?></a>
                        </td>
                        <td class="align-middle">
                            <a class="text-primary" href="<?= $linkEdit ?>&id=<?= $order['id'] ?>" title="<?= $order['fullname'] ?>"><?= $order['fullname'] ?></a>
                        </td>
                        <td class="align-middle"><?= date("d/m/Y - h:i:s A", $order['date_created']) ?></td>
                        <td class="align-middle">
                            <span class="text-info"><?= $func->getInfoDetailSlug('name', 'news', $order['order_payment']) ?></span>
                        </td>
                        <td class="align-middle">
                            <span class="text-danger font-weight-bold"><?= $func->formatMoney($order['total_price']) ?></span>
                        </td>
                        <td class="align-middle order_status">
                            <?php if ($order['order_status'] == 'moidat') { ?>
                                <span class="badge bg-primary">Mới đặt</span>
                            <?php } else if ($order['order_status'] == 'daxacnhan') { ?>
                                <span class="badge bg-info">Đã xác nhận</span>
                            <?php } else if ($order['order_status'] == 'danggiaohang') { ?>
                                <span class="badge bg-warning">Đang giao hàng</span>
                            <?php } else if ($order['order_status'] == 'dagiao') { ?>
                                <span class="badge bg-success">Đã giao</span>
                            <?php } else if ($order['order_status'] == 'dahuy') { ?>
                                <span class="badge bg-danger">Đã hủy</span>
                            <?php } ?>
                        </td>
                        <td class="align-middle text-center text-md text-nowrap">
                            <?php $arr = explode(',', $order['order_status']);
                            if (in_array('moidat', $arr)) { ?>
                                <a class="btn btn-success btn-sm update-order mr-2" href="javascript:void(0)" data-id="<?= $order['id'] ?>" data-table="table_order" data-newstatus="daxacnhan" title="Xác nhận"><i class="fas fa-check-square"></i></a>
                            <?php } ?>
                            <a class="btn btn-primary btn-sm mr-2" href="<?= $linkEdit ?>&id=<?= $order['id'] ?>" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-danger btn-sm" id="delete-item" data-id="<?= $order['id'] ?>" data-url="sources/order.php" data-act="delete" title="Xóa"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
    <?php if ($paging) { ?>
        <div class="card-header text-sm pb-0"><?= $paging ?></div>
    <?php } ?>
</section>