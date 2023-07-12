<?php
/* Order */
$orderNotify = $d->rawQuery("select id from table_order");
/* Product */
$productNotify = $d->rawQuery("select id from table_product where find_in_set('hienthi',status)");
/* User */
$userNotify = $d->rawQuery("select id from table_user where permission=?", array('user'));
/* Comment */
$commentNotify = $d->rawQuery("select id from table_comment where find_in_set('new-admin',status)");


/* Lấy đơn hàng - mới đặt */
$order_count = $d->rawQueryOne("select count(id), sum(total_price) from table_order where order_status = 'moidat'");
$allNewOrder = $order_count['count(id)'];
$totalNewOrder = ($order_count['sum(total_price)'] > 0) ? $order_count['sum(total_price)'] : 0;

/* Lấy đơn hàng - đã xác nhận */
$order_count = $d->rawQueryOne("select count(id), sum(total_price) from table_order where order_status = 'daxacnhan'");
$allConfirmOrder = $order_count['count(id)'];
$totalConfirmOrder = ($order_count['sum(total_price)'] > 0) ? $order_count['sum(total_price)'] : 0;

/* Lấy đơn hàng - đã giao */
$order_count = $d->rawQueryOne("select count(id), sum(total_price) from table_order where order_status = 'dagiao'");
$allDeliveriedOrder = $order_count['count(id)'];
$totalDeliveriedOrder = ($order_count['sum(total_price)'] > 0) ? $order_count['sum(total_price)'] : 0;

/* Lấy đơn hàng - đã hủy */
$order_count = $d->rawQueryOne("select count(id), sum(total_price) from table_order where order_status = 'dahuy'");
$allCanceledOrder = $order_count['count(id)'];
$totalCanceledOrder = ($order_count['sum(total_price)'] > 0) ? $order_count['sum(total_price)'] : 0;

/* Chart */
function getBetweenDates($startDate, $endDate)
{
    $rangArray = [];

    $startDate = strtotime(str_replace("/", "-", $startDate));
    $endDate = strtotime(str_replace("/", "-", $endDate));

    for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
        $date = date('d-m-Y', $currentDate);
        $rangArray[] = $date;
    }

    return $rangArray;
}

$chart_date = (isset($_REQUEST['chart_date'])) ? htmlspecialchars($_REQUEST['chart_date']) : '';
$daysInMonth = array();

if (date('D') != 'Sun') {
    $staticstart = date('Y-m-d', strtotime('last Sunday'));
} else {
    $staticstart = date('Y-m-d');
}

if (date('D') != 'Sat') {
    $staticfinish = date('Y-m-d', strtotime('next Saturday'));
} else {
    $staticfinish = date('Y-m-d');
}

$daysInMonth = getBetweenDates($staticstart, $staticfinish);
$charts = array();
for ($i = 0; $i < count($daysInMonth); $i++) {
    $from_date = strtotime($daysInMonth[$i] . ' 12:00:00 AM');
    $to_date = strtotime($daysInMonth[$i] . ' 11:59:59 PM');

    $sqlData = $d->rawQueryOne("select sum(total_price) as totals from table_order where date_created >= ? and date_created <= ?", array($from_date, $to_date));
    $charts['series'][] = ($sqlData['totals']) ? $sqlData['totals'] : 0;
    $charts['labels'][] = $daysInMonth[$i];
}

if (!empty($chart_date)) {
    $chart_date = explode("-", $chart_date);
    $date_from = trim($chart_date[0]);
    $date_to = trim($chart_date[1]);
    $daysInMonth = getBetweenDates($date_from, $date_to);

    $charts = array();
    for ($i = 0; $i < count($daysInMonth); $i++) {
        $from_date = strtotime($daysInMonth[$i] . ' 12:00:00 AM');
        $to_date = strtotime($daysInMonth[$i] . ' 11:59:59 PM');

        $sqlData = $d->rawQueryOne("select sum(total_price) as totals from table_order where date_created >= ? and date_created <= ?", array($from_date, $to_date));
        $charts['series'][] = ($sqlData['totals']) ? $sqlData['totals'] : 0;
        $charts['labels'][] = $daysInMonth[$i];
    }
}
?>

<section class="content">
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-3">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= count($orderNotify) ?></h3>
                        <p>Đơn hàng</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="index.php?com=order&act=list" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= count($productNotify) ?></h3>
                        <p>Sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <a href="index.php?com=product&act=list" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= count($userNotify) ?></h3>
                        <p>Tài khoản thành viên</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="index.php?com=user&act=list" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <!-- small card -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= count($commentNotify) ?></h3>
                        <p>Đánh giá</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <a href="index.php?com=product&act=list&comment_status=new" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-shopping-bag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-primary font-weight-bold text-capitalize text-sm">Đơn hàng Mới đặt</span>
                        <p class="info-box-text text-sm mb-0">Số lượng: <span class="text-danger font-weight-bold"><?= $allNewOrder ?></span></p>
                        <p class="info-box-text text-sm mb-0">Tổng giá: <span class="text-danger font-weight-bold"><?= $func->formatMoney($totalNewOrder) ?></span></p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-thumbs-up"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-info font-weight-bold text-capitalize text-sm">Đơn hàng Đã xác nhận</span>
                        <p class="info-box-text text-sm mb-0">Số lượng: <span class="text-danger font-weight-bold"><?= $allConfirmOrder ?></span></p>
                        <p class="info-box-text text-sm mb-0">Tổng giá: <span class="text-danger font-weight-bold"><?= $func->formatMoney($totalConfirmOrder) ?></span></p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-success font-weight-bold text-capitalize text-sm">Đơn hàng Đã giao</span>
                        <p class="info-box-text text-sm mb-0">Số lượng: <span class="text-danger font-weight-bold"><?= $allDeliveriedOrder ?></span></p>
                        <p class="info-box-text text-sm mb-0">Tổng giá: <span class="text-danger font-weight-bold"><?= $func->formatMoney($totalDeliveriedOrder) ?></span></p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-danger font-weight-bold text-capitalize text-sm">Đơn hàng Đã hủy</span>
                        <p class="info-box-text text-sm mb-0">Số lượng: <span class="text-danger font-weight-bold"><?= $allCanceledOrder ?></span></p>
                        <p class="info-box-text text-sm mb-0">Tổng giá: <span class="text-danger font-weight-bold"><?= $func->formatMoney($totalCanceledOrder) ?></span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-4">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="text" class="form-control float-right text-sm" name="chart_date" id="chart_date" value="<?= (isset($_GET['chart_date'])) ? $_GET['chart_date'] : '' ?>" readonly>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group"><a type="button" class="btn btn-success" onclick="actionChart('index.php')">Thống Kê Doanh Thu</a></div>
        </div>

        <div id="doanhthuChart"></div>
    </div>
</section>