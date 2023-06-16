<?php
session_start();

define('LIBRARIES', '../../libraries/');
define('SOURCES', '../sources/');

require_once LIBRARIES . "config.php";

/* Load all files in folder class */
$files = glob(LIBRARIES . '/class/*.php');
foreach ($files as $file) require_once $file;

$d = new PDODb($config['database']);
$func = new Functions($d);

$username = (!empty($_POST['username'])) ? $_POST['username'] : '';
$password = (!empty($_POST['password'])) ? $_POST['password'] : '';
$error = "";
$success = "";

if ($error == '') {
    /* Kiểm tra thông tin đăng nhập */
    if ($username == '' && $password == '') {
        $error = "Chưa nhập tên đăng nhập và mật khẩu";
    } else if ($username == '') {
        $error = "Chưa nhập tên đăng nhập";
    } else if ($password == '') {
        $error = "Chưa nhập mật khẩu";
    } else {
        /* Kiểm tra đăng nhập */
        $account = $d->rawQueryOne("select * from table_user where username = ? limit 0,1", array($username));

        if (!empty($account)) {
            if (($account['password'] == md5($password))) {
                $id_user = $account['id'];

                /* Tạo login session */
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

                $success = "Đăng nhập thành công";
            } else {
                $error = "Mật khẩu không chính xác";
            }
        } else {
            $error = "Tên đăng nhập không tồn tại";
        }
    }
}

$data = array('success' => $success, 'error' => $error);
echo json_encode($data);
