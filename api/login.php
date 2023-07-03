<?php
include "config.php";

/* Data */
$username = (!empty($_POST['username'])) ? htmlspecialchars($_POST['username']) : '';
$password = (!empty($_POST['password'])) ? $_POST['password'] : '';
$passwordMD5 = md5($password);

$account = $d->rawQueryOne("select * from table_user where username = ? limit 0,1", array($username));
if (!empty($account)) {
    if ($account['password'] == $passwordMD5) {
        /* Tạo login session */
        $id_user = $account['id'];
        $lastlogin = time();
        $login_session = md5($account['password'] . $lastlogin);
        $d->rawQuery("update table_user set login_session = ?, lastlogin = ? where id = ?", array($login_session, $lastlogin, $id_user));

        /* Tạo session login */
        $_SESSION['account']['active'] = true;
        $_SESSION['account']['id'] = $account['id'];
        $_SESSION['account']['username'] = $account['username'];
        $_SESSION['account']['fullname'] = $account['fullname'];
        $_SESSION['account']['address'] = $account['address'];
        $_SESSION['account']['photo'] = $account['photo'];
        $_SESSION['account']['phone'] = $account['phone'];
        $_SESSION['account']['email'] = $account['email'];
        $_SESSION['account']['role'] = $account['permission'];
        $_SESSION['account']['login_session'] = $login_session;
        $_SESSION['account']['status'] = $account['status'];

        /* Nhớ mật khẩu */
        $time_expiry = time() + 3600;
        setcookie('login_account_id', $account['id'], $time_expiry, '/');
        setcookie('login_account_session', $login_session, $time_expiry, '/');

        $statusCode = 200;
        $statusMsg = 'Đăng nhập thành công';
    } else {
        $statusCode = 404;
        $statusMsg = 'Tên đăng nhập hoặc mật khẩu không chính xác';
    }
} else {
    $statusCode = 404;
    $statusMsg = 'Tên đăng nhập hoặc mật khẩu không chính xác';
}

/* Kiểm tra trạng thái */
if ((!empty($_SESSION['account']['status']) && $_SESSION['account']['status'] == 'khoa')) {
    unset($_SESSION['account']);
    setcookie('login_account_id', "", -1, '/');
    setcookie('login_account_session', "", -1, '/');

    $statusCode = 404;
    $statusMsg = "Tài khoản của bạn hiện tại đang bị KHÓA";
}

$response['status'] = $statusCode;
$response['message'] = $statusMsg;

echo json_encode($response);
