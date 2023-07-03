<?php
if (!defined('SOURCES')) {
    require_once "../api/config.php";
    /* die("Error"); */
}

$act = (isset($_REQUEST['act'])) ? htmlspecialchars($_REQUEST['act']) : '';
$cur_Page = (isset($_REQUEST['cur_Page'])) ? htmlspecialchars($_REQUEST['cur_Page']) : '';

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$strUrl .= (isset($_REQUEST['order_status'])) ? "&order_status=" . htmlspecialchars($_REQUEST['order_status']) : "";
$strUrl .= (isset($_REQUEST['order_payment'])) ? "&order_payment=" . htmlspecialchars($_REQUEST['order_payment']) : "";
$strUrl .= (isset($_REQUEST['order_date'])) ? "&order_date=" . htmlspecialchars($_REQUEST['order_date']) : "";
$strUrl .= (isset($_REQUEST['keyword'])) ? "&keyword=" . htmlspecialchars($_REQUEST['keyword']) : "";

switch ($act) {
    case "list":
        viewOrders();
        $template = "order/orders";
        break;
    case "edit":
        editOrder();
        $template = "order/order_add";
        break;
    case "save":
        saveOrder();
        break;
    case "delete":
        deleteOrder();
        break;
}

/* View order */
function viewOrders()
{
    global $d, $func, $strUrl, $curPage, $items, $paging, $minTotal, $maxTotal, $allNewOrder, $totalNewOrder, $allConfirmOrder, $totalConfirmOrder, $allDeliveriedOrder, $totalDeliveriedOrder, $allCanceledOrder, $totalCanceledOrder;

    $where = "";
    $order_status = (isset($_REQUEST['order_status'])) ? htmlspecialchars($_REQUEST['order_status']) : '';
    $order_payment = (isset($_REQUEST['order_payment'])) ? htmlspecialchars($_REQUEST['order_payment']) : '';
    $order_date = (isset($_REQUEST['order_date'])) ? htmlspecialchars($_REQUEST['order_date']) : 0;
    if ($order_status)
        $where .= " and order_status='$order_status'";
    if ($order_payment)
        $where .= " and order_payment='$order_payment'";
    if ($order_date) {
        $order_date = explode("-", $order_date);
        $date_from = trim($order_date[0] . ' 12:00:00 AM');
        $date_to = trim($order_date[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $where .= " and date_created<=$date_to and date_created>=$date_from";
    }

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (fullname LIKE '%$keyword%' or email LIKE '%$keyword%' or phone LIKE '%$keyword%' or code LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from table_order where id > 0 $where order by date_created desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from table_order where id > 0 $where order by date_created desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=order&act=list" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* Lấy tổng giá min */
    $minTotal = $d->rawQueryOne("select min(total_price) from table_order");
    if ($minTotal['min(total_price)'])
        $minTotal = $minTotal['min(total_price)'];
    else
        $minTotal = 0;

    /* Lấy tổng giá max */
    $maxTotal = $d->rawQueryOne("select max(total_price) from table_order");
    if ($maxTotal['max(total_price)'])
        $maxTotal = $maxTotal['max(total_price)'];
    else
        $maxTotal = 0;
}

/* Edit order */
function editOrder()
{
    global $d, $func, $curPage, $item, $order_detail;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transferAdmin("Không nhận được dữ liệu", "index.php?com=order&act=list&page=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from table_order where id = ? limit 0,1", array($id));

        if (empty($item)) {
            $func->transferAdmin("Dữ liệu không có thực", "index.php?com=order&act=list&page=" . $curPage, false);
        } else {
            /* Lấy chi tiết đơn hàng */
            $order_detail = $d->rawQuery("select * from table_order_detail where id_order = ? order by id desc", array($id));
        }
    }
}
/* Save order */
function saveOrder()
{
    global $d, $func, $cur_Page, $strUrl;

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    $data = (!empty($_REQUEST['data'])) ? $_REQUEST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->checkInput($value));
        }
    }

    /* Save data */
    if ($id) {
        $d->where('id', $id);
        if ($d->update('table_order', $data)) {
            $response['status'] = 200;
            $response['messages'][] = 'Cập nhật dữ liệu thành công';
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Cập nhật dữ liệu bị lỗi';
        }
        $response['link'] = "index.php?com=order&act=edit" . $strUrl . "&id=" . $id;
    } else {
        $response['status'] = 404;
        $response['messages'][] = 'Dữ liệu rỗng';
        $response['link'] = "index.php?com=order&act=list&page=" . $cur_Page;
    }

    $message = json_encode($response);
    echo $message;
    return;
}
/* Delete order */
function deleteOrder()
{
    global $d, $cur_Page;

    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        $row = $d->rawQueryOne("select id from table_order where id = ? limit 0,1", array($id));

        if (!empty($row)) {
            $d->rawQuery("delete from table_vnpay where order_id = ?", array($id));
            $d->rawQuery("delete from table_order_detail where id_order = ?", array($id));
            $d->rawQuery("delete from table_order where id = ?", array($id));

            $response['status'] = 200;
            $response['messages'][] = 'Xóa dữ liệu thành công';
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Xóa dữ liệu bị lỗi 1';
        }
    } elseif (isset($_REQUEST['listid'])) {
        $listid = explode(",", $_REQUEST['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id from table_order where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("delete from table_vnpay where order_id = ?", array($id));
                $d->rawQuery("delete from table_order_detail where id_order = ?", array($id));
                $d->rawQuery("delete from table_order where id = ?", array($id));
            }
        }

        $response['status'] = 200;
        $response['messages'][] = 'Xóa dữ liệu thành công';
    } else {
        $response['status'] = 404;
        $response['messages'][] = 'Xóa dữ liệu bị lỗi';
    }

    $response['link'] = "index.php?com=order&act=list&page=" . $cur_Page;
    $message = json_encode($response);
    echo $message;
    return;
}
