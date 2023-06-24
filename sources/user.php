<?php
if (!defined('SOURCES')) {
    require_once "../api/config.php";
    /* die("Error"); */
}

$action = '';
if (isset($match)) {
    $action = htmlspecialchars($match['params']['action']);
} else {
    if (isset($_REQUEST['act'])) {
        $action = htmlspecialchars($_REQUEST['act']);
    }
}

switch ($action) {
    case 'thong-tin':
        if (empty($_SESSION['account']['active']))
            $func->transfer("Trang không tồn tại", $configBase, false);
        $template = "account/info";
        infoMember();
        break;

    case 'luu-thong-tin':
        saveMemer();
        break;

    case 'dang-xuat':
        if (empty($_SESSION['account']['active']))
            $func->transfer("Trang không tồn tại", $configBase, false);
        logout();

    default:
        header('HTTP/1.0 404 Not Found', true, 404);
        include("404.php");
        exit();
}

function saveMemer()
{
    global $d, $func, $configBase;

    $message = '';
    $response = array();
    $iduser = $_SESSION['account']['id'];

    if ($iduser) {
        $message = '';
        $response = array();
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
            $response['link'] = $configBase . "account/thong-tin";
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
    } else {
        $response['status'] = 404;
        $response['messages'][] = 'Trang không tồn tại';
    }

    $response['link'] = $configBase . "account/thong-tin";
    $message = json_encode($response);
    echo $message;
    return;
}

function infoMember()
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
