<?php
if (!defined('SOURCES'))
    die("Error");

$action = htmlspecialchars($match['params']['action']);

switch ($action) {
    case 'thong-tin':
        $template = "account/info";
        if (empty($_SESSION['account']['active']))
            $func->transfer2("Trang không tồn tại", $configBase, false);
        infoMember();
        break;

    case 'dang-xuat':
        if (empty($_SESSION['account']['active']))
            $func->transfer2("Trang không tồn tại", $configBase, false);
        logout();

    default:
        header('HTTP/1.0 404 Not Found', true, 404);
        include("404.php");
        exit();
}

/* breadCrumbs */
if (!empty($titleMain)) $breadcr->set('', $titleMain);
$breadcrumbs = $breadcr->get();

function infoMember()
{
    global $d, $func, $flash, $rowDetail, $configBase;

    $iduser = $_SESSION['account']['id'];

    if ($iduser) {
        $rowDetail = $d->rawQueryOne("select * from table_user where id = ? limit 0,1", array($iduser));

        if (!empty($_POST['info-user'])) {
            $message = '';
            $response = array();
            $old_password = (!empty($_POST['old-password'])) ? $_POST['old-password'] : '';
            $old_passwordMD5 = md5($old_password);
            $new_password = (!empty($_POST['new-password'])) ? $_POST['new-password'] : '';
            $new_passwordMD5 = md5($new_password);
            $new_password_confirm = (!empty($_POST['new-password-confirm'])) ? $_POST['new-password-confirm'] : '';
            $fullname = (!empty($_POST['fullname'])) ? htmlspecialchars($_POST['fullname']) : '';
            $email = (!empty($_POST['email'])) ? htmlspecialchars($_POST['email']) : '';
            $phone = (!empty($_POST['phone'])) ? htmlspecialchars($_POST['phone']) : 0;
            $address = (!empty($_POST['address'])) ? htmlspecialchars($_POST['address']) : '';
            $gender = (!empty($_POST['gender'])) ? htmlspecialchars($_POST['gender']) : 0;
            $birthday = (!empty($_POST['birthday'])) ? htmlspecialchars($_POST['birthday']) : '';

            /* Valid data */
            if (empty($fullname)) {
                $response['messages'][] = 'Họ tên không được trống';
            }

            if (!empty($old_password)) {
                $isWrongPass = false;
                $row = $d->rawQueryOne("select id from table_user where id = ? and password = ? limit 0,1", array($iduser, $old_passwordMD5));

                if (empty($row['id'])) {
                    $isWrongPass = true;
                    $response['messages'][] = 'Mật khẩu cũ không chính xác';
                } else if (empty($new_password)) {
                    $isWrongPass = true;
                    $response['messages'][] = 'Mật khẩu mới không được trống';
                } else if (!empty($new_password) && empty($new_password_confirm)) {
                    $isWrongPass = true;
                    $response['messages'][] = 'Xác nhận mật khẩu mới không được trống';
                } else if ($new_password != $new_password_confirm) {
                    $isWrongPass = true;
                    $response['messages'][] = 'Mật khẩu mới và xác nhận mật khẩu mới không chính xác';
                }
            }

            if (empty($gender)) {
                $response['messages'][] = 'Chưa chọn giới tính';
            }

            if (empty($birthday)) {
                $response['messages'][] = 'Ngày sinh không được trống';
            }

            if (!empty($birthday) && !$func->isDate($birthday)) {
                $response['messages'][] = 'Ngày sinh không hợp lệ';
            }

            if (empty($email)) {
                $response['messages'][] = 'Email không được trống';
            }

            if (!empty($email)) {
                if (!$func->isEmail($email)) {
                    $response['messages'][] = 'Email không hợp lệ';
                }

                if ($func->checkExist($email, 'email', 'account', $iduser)) {
                    $response['messages'][] = 'Email đã tồn tại';
                }
            }

            if (!empty($phone) && !$func->isPhone($phone)) {
                $response['messages'][] = 'Số điện thoại không hợp lệ';
            }

            if (empty($address)) {
                $response['messages'][] = 'Địa chỉ không được trống';
            }

            if (!empty($response)) {
                /* Flash data */
                $flash->set('fullname', $fullname);
                $flash->set('gender', $gender);
                $flash->set('birthday', $birthday);
                $flash->set('email', $email);
                $flash->set('phone', $phone);
                $flash->set('address', $address);

                /* Errors */
                $response['status'] = 'danger';
                $message = base64_encode(json_encode($response));
                $flash->set('message', $message);
                $func->redirect($configBase . "account/thong-tin");
            }

            if (!empty($old_password) && empty($isWrongPass)) {
                $data['password'] = $new_passwordMD5;
            }

            $data['fullname'] = $fullname;
            $data['email'] = $email;
            $data['phone'] = $phone;
            $data['address'] = $address;
            $data['gender'] = $gender;
            $data['birthday'] = strtotime(str_replace("/", "-", $birthday));

            $d->where('id', $iduser);
            if ($d->update('member', $data)) {
                if ($old_password) {
                    unset($_SESSION['user']);
                    setcookie('login_member_id', "", -1, '/');
                    setcookie('login_member_session', "", -1, '/');
                    $func->transfer2("Cập nhật thông tin thành công", $configBase . "account/dang-nhap");
                } else {
                    $func->transfer2("Cập nhật thông tin thành công", $configBase . "account/thong-tin");
                }
            } else {
                $func->transfer2("Cập nhật thông tin thất bại", $configBase . "account/thong-tin", false);
            }
        }
    } else {
        $func->transfer2("Trang không tồn tại", $configBase, false);
    }
}

function logout()
{
    global $d, $func, $configBase;

    unset($_SESSION['account']);
    setcookie('login_account_id', "", -1, '/');
    setcookie('login_account_session', "", -1, '/');

    $func->redirect($configBase);
}
