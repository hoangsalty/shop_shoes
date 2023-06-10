<?php
$func = new Functions($d);

/* Request data */
$type = (!empty($_REQUEST['type'])) ? htmlspecialchars($_REQUEST['type']) : '';
$com = (!empty($_REQUEST['com'])) ? htmlspecialchars($_REQUEST['com']) : '';
$act = (!empty($_REQUEST['act'])) ? htmlspecialchars($_REQUEST['act']) : '';
$id_parent = (!empty($_REQUEST['id_parent'])) ? htmlspecialchars($_REQUEST['id_parent']) : '';
$id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : '';
$curPage = (!empty($_GET['page'])) ? htmlspecialchars($_GET['page']) : 1;

/* Check login */
$func->checkLogin();

/* Kiểm tra trạng thái */
if ((!empty($_SESSION['account']['status']) && $_SESSION['account']['status'] == 'khoa')) {
    $func->transferAdmin("Tài khoản của bạn hiện tại đang bị KHÓA, bạn vui lòng liên hệ với phía quản trị viên để được hỗ trợ", "../", false);
}

/* Kiểm tra quyền */
if ((!empty($_SESSION['account']['role']) && $_SESSION['account']['role'] == 'user')) {
    $func->transferAdmin("Bạn không có quyền truy cập vào khu vực này", "../", false);
}


/* Include sources */
if (file_exists(SOURCES . $com . '.php'))
    include SOURCES . $com . ".php";
else
    $template = "index";
?>