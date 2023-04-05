<?php
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 3600);
session_set_cookie_params(3600);
session_cache_expire(60);
session_start();

define('LIBRARIES', '../../libraries/');
define('SOURCES', '../sources/');

require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
new AutoLoad();
$d = new PDODb($config['database']);
$func = new Functions($d);

$username = (!empty($_POST['username'])) ? $_POST['username'] : '';
$password = (!empty($_POST['password'])) ? $_POST['password'] : '';
$error = "";
$success = "";
$login_failed = false;

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
                $timenow = time();
                $id_user = $account['id'];
                $token = md5(time());
                $sessionhash = md5(sha1($account['password'] . $account['username']));

                /* Tạo login session */
                $d->rawQuery("update table_user set login_session = ?, lastlogin = ?, user_token = ? where id = ?", array($sessionhash, $timenow, $token, $id_user));

                /* Tạo session login */
                $_SESSION['admin']['active'] = true;
                $_SESSION['admin']['id'] = $account['id'];
                $_SESSION['admin']['username'] = $account['username'];
                $_SESSION['admin']['fullname'] = $account['fullname'];
                $_SESSION['admin']['phone'] = $account['phone'];
                $_SESSION['admin']['email'] = $account['email'];
                $_SESSION['admin']['role'] = $account['permission'];
                $_SESSION['admin']['user_token'] = $sessionhash;
                $_SESSION['admin']['password'] = $account['password'];
                $_SESSION['admin']['login_session'] = $sessionhash;
                $_SESSION['admin']['login_token'] = $token;
                $_SESSION['admin']['status'] = $account['status'];

                $success = "Đăng nhập thành công";
            } else {
                $login_failed = true;
                $error = "Mật khẩu không chính xác";
            }
        } else {
            $login_failed = true;
            $error = "Tên đăng nhập không tồn tại";
        }

        /* Xử lý khi đăng nhập thất bại */
        if ($login_failed) {
        }
    }
}

$data = array('success' => $success, 'error' => $error);
echo json_encode($data);
