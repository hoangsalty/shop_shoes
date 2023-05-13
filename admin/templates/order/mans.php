<?php
$linkMan = $linkFilter = "index.php?com=order&act=man";
$linkEdit = "index.php?com=order&act=edit";
$linkDelete = "index.php?com=order&act=delete";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Quản lý đơn hàng</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-shopping-bag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-primary font-weight-bold text-capitalize text-sm">Mới đặt</span>
                    <p class="info-box-text text-sm mb-0">Số lượng: <span class="text-danger font-weight-bold"><?= $allNewOrder ?></span></p>
                    <p class="info-box-text text-sm mb-0">Tổng giá: <span class="text-danger font-weight-bold"><?= $func->formatMoney($totalNewOrder) ?></span></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-thumbs-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-info font-weight-bold text-capitalize text-sm">Đã xác nhận</span>
                    <p class="info-box-text text-sm mb-0">Số lượng: <span class="text-danger font-weight-bold"><?= $allConfirmOrder ?></span></p>
                    <p class="info-box-text text-sm mb-0">Tổng giá: <span class="text-danger font-weight-bold"><?= $func->formatMoney($totalConfirmOrder) ?></span></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-success font-weight-bold text-capitalize text-sm">Đã giao</span>
                    <p class="info-box-text text-sm mb-0">Số lượng: <span class="text-danger font-weight-bold"><?= $allDeliveriedOrder ?></span></p>
                    <p class="info-box-text text-sm mb-0">Tổng giá: <span class="text-danger font-weight-bold"><?= $func->formatMoney($totalDeliveriedOrder) ?></span></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-danger font-weight-bold text-capitalize text-sm">Đã hủy</span>
                    <p class="info-box-text text-sm mb-0">Số lượng: <span class="text-danger font-weight-bold"><?= $allCanceledOrder ?></span></p>
                    <p class="info-box-text text-sm mb-0">Tổng giá: <span class="text-danger font-weight-bold"><?= $func->formatMoney($totalCanceledOrder) ?></span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
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
            <div class="form-group col-md-3 col-sm-3">
                <label>Ngày đặt:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control float-right text-sm" name="order_date" id="order_date" value="<?= (isset($_GET['order_date'])) ? $_GET['order_date'] : '' ?>" readonly>
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <label>Tình trạng:</label>
                <?= $func->orderStatus() ?>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <label>Hình thức thanh toán:</label>
                <?= $func->orderPayments() ?>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <label>Tỉnh thành:</label>
                <select class="select-place_city form-control select2" id="id_city" name="data[id_city]">
                    <option value="0">Chọn danh mục</option>
                    <?php foreach ($list_city as $k => $v) { ?>
                        <option value="<?= $v['id'] ?>" <?php if (isset($_REQUEST['city']) && ($v["id"] == (int)$_REQUEST['city'])) echo "selected"; ?>><?= $v['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <label>Quận huyện:</label>
                <select class="select-place_district form-control select2" id="id_district" name="data[id_district]">
                    <option value="0">Chọn danh mục</option>
                    <?php foreach ($list_district as $k => $v) { ?>
                        <option value="<?= $v['id'] ?>" <?php if (isset($_REQUEST['district']) && ($v["id"] == (int)$_REQUEST['district'])) echo "selected"; ?>><?= $v['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <label>Phường xã:</label>
                <select class="select-place_ward form-control select2" id="id_ward" name="data[id_ward]">
                    <option value="0">Chọn danh mục</option>
                    <?php foreach ($list_ward as $k => $v) { ?>
                        <option value="<?= $v['id'] ?>" <?php if (isset($_REQUEST['ward']) && ($v["id"] == (int)$_REQUEST['ward'])) echo "selected"; ?>><?= $v['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-6 col-sm-6">
                <label>Khoảng giá:</label>
                <input type="text" class="primary" id="range_price" name="range_price">
            </div>
            <div class="form-group text-center mt-2 mb-0 col-12">
                <a class="btn btn-sm bg-gradient-success text-white" onclick="actionOrder('<?= $linkFilter ?>')" title="Tìm kiếm"><i class="fas fa-search mr-1"></i>Tìm kiếm</a>
                <a class="btn btn-sm bg-gradient-danger text-white ml-1" href="<?= $linkMan ?>" title="Hủy lọc"><i class="fas fa-times mr-1"></i>Hủy lọc</a>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title card-title-order d-inline-block align-middle float-none">Danh sách đơn hàng</h3>
            <?php if (isset($config['order']['excelall']) && $config['order']['excelall'] == true) { ?>
                <a class="btn btn-sm bg-gradient-success btn-export-excel btn-sm d-inline-block align-middle ml-2 text-white" onclick="actionOrder('<?= $linkExcel ?>')" title="Xuất file Excel"><i class="far fa-file-excel mr-1"></i>Xuất file Excel</a>
            <?php } ?>
            <?php if (isset($config['order']['wordall']) && $config['order']['wordall'] == true) { ?>
                <a class="btn btn-sm bg-gradient-primary btn-export-word btn-sm d-inline-block align-middle ml-2 text-white" onclick="actionOrder('<?= $linkWord ?>')" title="Xuất file Word"><i class="far fa-file-word mr-1"></i>Xuất file Word</a>
            <?php } ?>
        </div>
        <div class="card-body table-responsive p-0">
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
                        <?php for ($i = 0; $i < count($items); $i++) { ?>
                            <tr class="order_table">
                                <td class="align-middle">
                                    <div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?= $items[$i]['id'] ?>" value="<?= $items[$i]['id'] ?>">
                                        <label for="select-checkbox-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <a class="text-primary" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['code'] ?>"><?= $items[$i]['code'] ?></a>
                                </td>
                                <td class="align-middle">
                                    <a class="text-primary" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['fullname'] ?>"><?= $items[$i]['fullname'] ?></a>
                                </td>
                                <td class="align-middle"><?= date("h:i:s A - d/m/Y", $items[$i]['date_created']) ?></td>
                                <td class="align-middle">
                                    <?php $order_payment = $func->getInfoDetail('name', 'news', $items[$i]['order_payment']); ?>
                                    <span class="text-info"><?= $order_payment['name'] ?></span>
                                </td>
                                <td class="align-middle">
                                    <span class="text-danger font-weight-bold"><?= $func->formatMoney($items[$i]['total_price']) ?></span>
                                </td>
                                <td class="align-middle order_status">
                                    <?php if ($items[$i]['order_status'] == 'moidat') { ?>
                                        <span class="badge bg-primary">Mới đặt</span>
                                    <?php } else if ($items[$i]['order_status'] == 'daxacnhan') { ?>
                                        <span class="badge bg-info">Đã xác nhận</span>
                                    <?php } else if ($items[$i]['order_status'] == 'danggiaohang') { ?>
                                        <span class="badge bg-warning">Đang giao hàng</span>
                                    <?php } else if ($items[$i]['order_status'] == 'dagiao') { ?>
                                        <span class="badge bg-success">Đã giao</span>
                                    <?php } else if ($items[$i]['order_status'] == 'dahuy') { ?>
                                        <span class="badge bg-danger">Đã hủy</span>
                                    <?php } ?>
                                </td>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a class="text-success update-order mr-2" href="javascript:void(0)" data-id="<?= $items[$i]['id'] ?>" data-table="table_order" data-newstatus="daxacnhan" title="Xác nhận"><i class="fas fa-check-square"></i></a>
                                    <a class="text-primary mr-2" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                                    <a class="text-danger" id="delete-item" data-url="<?= $linkDelete ?>&id=<?= $items[$i]['id'] ?>" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php if ($paging) { ?>
        <div class="card-footer text-sm pb-0"><?= $paging ?></div>
    <?php } ?>
</section>