<?php
if (!defined('SOURCES')) {
    require_once "../api/config.php";
    require_once LIBRARIES . "class/Email.php";
    $emailer = new Email($d);

    /* die("Error"); */
}

$action = '';
if (isset($_REQUEST['act'])) {
    $action = htmlspecialchars($_REQUEST['act']);
}

switch ($action) {
    case 'thong-tin':
        if (empty($_SESSION['account']['active'])) {
            header('HTTP/1.0 404 Not Found', true, 404);
            include("404.php");
            exit;
        };
        $template = "account/info";
        info();
        break;

    case 'quen-mat-khau':
        forgotPassword();
        break;

    case 'luu-thong-tin':
        save();
        break;

    case 'dang-xuat':
        logout();
        break;

    default:
        header('HTTP/1.0 404 Not Found', true, 404);
        include("404.php");
        exit();
}

function save()
{
    global $d, $func, $configBase;

    $message = '';
    $response = array();
    $iduser = $_SESSION['account']['id'];
    $changepass = (!empty($_REQUEST['changepass'])) ? htmlspecialchars($_REQUEST['changepass']) : 0;

    if ($iduser) {
        $message = '';
        $response = array();

        if ($changepass == 1) {
            $old_pass = (!empty($_POST['old-password'])) ? $_POST['old-password'] : '';
            $new_pass = (!empty($_POST['new-password'])) ? $_POST['new-password'] : '';
            $renew_pass = (!empty($_POST['renew-password'])) ? $_POST['renew-password'] : '';

            /* Valid data */
            if (empty($old_pass)) {
                $response['messages'][] = 'Mật khẩu cũ không được trống';
            }

            if (!empty($old_pass)) {
                $row = $d->rawQueryOne("select id, password from table_user where username = ? limit 0,1", array($_SESSION['account']['username']));

                if (empty($row['id']) || (!empty($row['id']) && ($row['password'] != md5($old_pass)))) {
                    $response['messages'][] = 'Mật khẩu cũ không chính xác';
                }
            }

            if (empty($new_pass)) {
                $response['messages'][] = 'Mật khẩu mới không được trống';
            }

            if (!empty($new_pass) && in_array($new_pass, array('123', '123qwe', '123456'))) {
                $response['messages'][] = 'Mật khẩu bạn đặt quá đơn giãn';
            }

            if (!empty($new_pass) && empty($renew_pass)) {
                $response['messages'][] = 'Xác nhận mật khẩu mới không được trống';
            }

            if (!empty($new_pass) && !empty($renew_pass) && !$func->isMatch($new_pass, $renew_pass)) {
                $response['messages'][] = 'Mật khẩu mới không trùng khớp';
            }

            if (!empty($response)) {
                /* Errors */
                $response['status'] = 404;
                $message = json_encode($response);
                echo $message;
                return;
            }

            /* Change to new password */
            $data['password'] = md5($new_pass);
            /* Save data */
            $d->where('id', $iduser);
            if ($d->update('table_user', $data)) {
                unset($_SESSION['account']);
                setcookie('login_member_id', "", -1, '/');
                setcookie('login_member_session', "", -1, '/');

                $response['status'] = 200;
                $response['link'] = $configBase;
                $response['messages'][] = 'Thay đổi mật khẩu thành công';
            } else {
                $response['status'] = 404;
                $response['messages'][] = 'Thay đổi mật khẩu bị lỗi';
            }
        } else {
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

                if ($func->checkExist($email, 'email', 'user', $iduser)) {
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
                /* Errors */
                $response['status'] = 404;
                $message = json_encode($response);
                echo $message;
                return;
            }

            $data['fullname'] = $fullname;
            $data['email'] = $email;
            $data['phone'] = $phone;
            $data['address'] = $address;
            $data['gender'] = $gender;
            $data['birthday'] = strtotime(str_replace("/", "-", $birthday));

            $d->where('id', $iduser);
            if ($d->update('table_user', $data)) {
                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    if ($photo = $func->uploadImage("file", '../upload/user/')) {
                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $iduser);
                        $d->update('table_user', $photoUpdate);
                    }
                }

                $response['status'] = 200;
                $response['messages'][] = 'Cập nhật thông tin thành công';
            } else {
                $response['status'] = 404;
                $response['messages'][] = 'Cập nhật thông tin thất bại';
            }
            $response['link'] = $configBase . "account/thong-tin";
        }
    } else {
        $response['status'] = 404;
        $response['messages'][] = 'Trang không tồn tại';
        $response['link'] = $configBase;
    }

    $message = json_encode($response);
    echo $message;
    return;
}

function info()
{
    global $d, $func, $configBase, $rowDetail;

    $iduser = $_SESSION['account']['id'];
    if (empty($iduser)) {
        $func->transfer("Không nhận được dữ liệu", $configBase, false);
    } else {
        $rowDetail = $d->rawQueryOne("select * from table_user where id = ? limit 0,1", array($iduser));
        if (empty($rowDetail)) {
            $func->transfer("Không có dữ liệu", $configBase, false);
        }
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

function forgotPassword()
{
    global $d, $setting, $emailer, $func;

    /* Data */
    $message = '';
    $response = array();
    $email = (!empty($_POST['email'])) ? htmlspecialchars($_POST['email']) : '';
    $newpass = substr(md5(rand(0, 999) * time()), 15, 6);
    $newpassMD5 = md5($newpass);

    /* Valid data */
    if (empty($email)) {
        $response['messages'][] = 'Email không được trống';
    }

    if (!empty($email) && !$func->isEmail($email)) {
        $response['messages'][] = 'Email không hợp lệ';
    }

    if (!empty($response)) {
        /* Errors */
        $response['status'] = 404;
        $message = json_encode($response);
        echo $message;
        return;
    }

    /* Cập nhật mật khẩu mới */
    $data['password'] = $newpassMD5;
    $d->where('email', $email);
    $d->update('table_user', $data);

    /* Lấy thông tin người dùng */
    $row = $d->rawQueryOne("select * from table_user where email = ? limit 0,1", array($email));

    $subject = "Thư cấp lại mật khẩu từ " . $setting['name'];
    $message = "Mật khẩu của bạn đã được đổi mới thành: <span style='color:green'>" . $newpass . "</span>";
    $message .= "<p>Vui lòng sử dụng mật khẩu này để đăng nhập và thay đổi sang mật khẩu của bạn</p>";

    if ($emailer->sendMail($email, $subject, $message)) {
        unset($_SESSION['account']);
        setcookie('login_member_id', "", -1, '/');
        setcookie('login_member_session', "", -1, '/');

        $response['status'] = 200;
        $response['messages'][] = "Cấp lại mật khẩu thành công. Vui lòng kiểm tra email: " . $email;
    } else {
        $response['status'] = 404;
        $response['messages'][] = "Có lỗi xảy ra trong quá trình cấp lại mật khẩu. Vui lòng liện hệ với chúng tôi.";
    }

    $message = json_encode($response);
    echo $message;
    return;
}
