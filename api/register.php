<?php
include "config.php";

/* Data */
$username = (!empty($_POST['username'])) ? htmlspecialchars($_POST['username']) : '';
$password = (!empty($_POST['password'])) ? $_POST['password'] : '';
$passwordMD5 = md5($password);
$fullname = (!empty($_POST['fullname'])) ? htmlspecialchars($_POST['fullname']) : '';
$email = (!empty($_POST['email'])) ? htmlspecialchars($_POST['email']) : '';
$phone = (!empty($_POST['phone'])) ? htmlspecialchars($_POST['phone']) : 0;
$address = (!empty($_POST['address'])) ? htmlspecialchars($_POST['address']) : '';
$birthday = (!empty($_POST['birthday'])) ? htmlspecialchars($_POST['birthday']) : '';

/* Kiểm tra tài khoản có tồn tại chưas */
$usernameExist = $d->rawQueryOne("select username from table_user where username = ? limit 0,1", array($username));
$emailExist = $d->rawQueryOne("select email from table_user where email = ? limit 0,1", array($email));
if (!empty($usernameExist)) {
    $statusCode = 404;
    $statusMsg = "Tên tài khoản đã tồn tại";
}
if (!empty($emailExist)) {
    $statusCode = 404;
    $statusMsg = "Email đã tồn tại";
}

if (empty($usernameExist) && empty($emailExist)) {
    /* Save data */
    $data = array();
    $data['date_created'] = time();
    $data['fullname'] = $fullname;
    $data['username'] = $username;
    $data['password'] = $passwordMD5;
    $data['email'] = $email;
    $data['phone'] = $phone;
    $data['address'] = $address;
    $data['birthday'] = strtotime(str_replace("/", "-", $birthday));
    $data['status'] = 'hoatdong';
    $data['permission'] = 'user';

    if ($d->insert('table_user', $data)) {
        $statusCode = 200;
        $statusMsg = 'Đăng ký thành công, vui lòng chờ hệ thống tự động đăng nhập giúp bạn';
    } else {
        $statusCode = 404;
        $statusMsg = 'Đã có lỗi với việc lưu database đăng ký';
    }
}

$response['status'] = $statusCode;
$response['message'] = $statusMsg;

echo json_encode($response);
