<?php
$func = new Functions($d);

/* Request data */
$type = (!empty($_REQUEST['type'])) ? htmlspecialchars($_REQUEST['type']) : '';
$com = (!empty($_REQUEST['com'])) ? htmlspecialchars($_REQUEST['com']) : '';
$act = (!empty($_REQUEST['act'])) ? htmlspecialchars($_REQUEST['act']) : '';
$id_parent = (!empty($_REQUEST['id_parent'])) ? htmlspecialchars($_REQUEST['id_parent']) : '';
$id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : '';
$curPage = (!empty($_GET['page'])) ? htmlspecialchars($_GET['page']) : 1;

/* Kiểm tra trạng thái */
if ((!empty($_SESSION['admin']['status']) && $_SESSION['admin']['status'] == 'khoa')) {
    unset($_SESSION['admin']);
    $func->transfer("Tài khoản của bạn hiện tại đang bị KHÓA, bạn vui lòng liên hệ với phía quản trị viên để được hỗ trợ", "../index.php", false);
}

/* Kiểm tra quyền */
if ((!empty($_SESSION['admin']['role']) && $_SESSION['admin']['role'] == 'user')) {
    unset($_SESSION['admin']);
    $func->transfer("Bạn không có quyền truy cập vào khu vực này", "../index.php", false);
}


/* Include sources */
if (file_exists(SOURCES . $com . '.php')) include SOURCES . $com . ".php";
else $template = "index";
?>