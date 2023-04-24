<?php
if (!defined('SOURCES'))
    die("Error");

$action = htmlspecialchars($match['params']['action']);

switch ($action) {
    case 'dang-nhap':
        $template = "account/login";
        if (!empty($_SESSION['account']['active']))
            $func->transfer2("Trang không tồn tại", $configBase, false);
        if (!empty($_POST['login-account']))
            login();
        break;

    case 'dang-ky':
        $template = "account/register";
        if (!empty($_SESSION['account']['active']))
            $func->transfer2("Trang không tồn tại", $configBase, false);
        if (!empty($_POST['register-account']))
            register();
        break;

    case 'quen-mat-khau':
        $template = "account/forgot_password";
        if (!empty($_SESSION['account']['active']))
            $func->transfer2("Trang không tồn tại", $configBase, false);
        if (!empty($_POST['forgot-password-account']))
            forgotPassword();
        break;

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
if (!empty($titleMain))
    $breadcr->set('', $titleMain);
$breadcrumbs = $breadcr->get();

function infoMember()
{
    global $d, $func, $flash, $rowDetail, $configBase;

    $iduser = $_SESSION['user']['id'];

    if ($iduser) {
        $rowDetail = $d->rawQueryOne("select fullname, username, gender, birthday, email, phone, address from #_member where id = ? limit 0,1", array($iduser));

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
                $row = $d->rawQueryOne("select id from #_member where id = ? and password = ? limit 0,1", array($iduser, $old_passwordMD5));

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

function login()
{
    global $d, $func, $flash, $configBase;

    /* Data */
    $username = (!empty($_POST['username'])) ? htmlspecialchars($_POST['username']) : '';
    $password = (!empty($_POST['password'])) ? $_POST['password'] : '';
    $passwordMD5 = md5($password);
    $remember = (!empty($_POST['remember-user'])) ? htmlspecialchars($_POST['remember-user']) : false;

    /* Valid data */
    if (empty($username)) {
        $response['messages'][] = 'Tên đăng nhập không được trống';
    }

    if (empty($password)) {
        $response['messages'][] = 'Mật khẩu không được trống';
    }

    if (!empty($response)) {
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set("message", $message);
        $func->redirect($configBase . "account/dang-nhap");
    }

    $account = $d->rawQueryOne("select * from table_user where username = ? and find_in_set('hoatdong',status) limit 0,1", array($username));
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
            if ($remember) {
                $time_expiry = time() + 3600 * 24;
                setcookie('login_account_id', $account['id'], $time_expiry, '/');
                setcookie('login_account_session', $login_session, $time_expiry, '/');
            } else {
                $time_expiry = time() + 1800;
                setcookie('login_account_id', $account['id'], $time_expiry, '/');
                setcookie('login_account_session', $login_session, $time_expiry, '/');
            }

            $func->transfer2("Đăng nhập thành công", $configBase);
        } else {
            $response['messages'][] = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
        }
    } else {
        $response['messages'][] = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
    }

    if (!empty($response)) {
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set("message", $message);
        $func->redirect($configBase . "account/dang-nhap");
    }
}

function register()
{
    global $d, $func, $flash, $configBase;

    /* Data */
    $message = '';
    $response = array();
    $username = (!empty($_POST['username'])) ? htmlspecialchars($_POST['username']) : '';
    $password = (!empty($_POST['password'])) ? $_POST['password'] : '';
    $passwordMD5 = md5($password);
    $repassword = (!empty($_POST['repassword'])) ? $_POST['repassword'] : '';
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

    if (empty($username)) {
        $response['messages'][] = 'Tài khoản không được trống';
    }

    if (!empty($username)) {
        if (!$func->isAlphaNum($username)) {
            $response['messages'][] = 'Tài khoản chỉ được nhập chữ thường và số (chữ thường không dấu, ghi liền nhau, không khoảng trắng)';
        }

        if ($func->checkExist($username, 'username', 'user')) {
            $response['messages'][] = 'Tài khoản đã tồn tại';
        }
    }

    if (empty($password)) {
        $response['messages'][] = 'Mật khẩu không được trống';
    }

    if (!empty($password) && empty($repassword)) {
        $response['messages'][] = 'Xác nhận mật khẩu không được trống';
    }

    if (!empty($password) && !empty($repassword) && !$func->isMatch($password, $repassword)) {
        $response['messages'][] = 'Mật khẩu không trùng khớp';
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

        if ($func->checkExist($email, 'email', 'user')) {
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
        $flash->set('username', $username);
        $flash->set('gender', $gender);
        $flash->set('birthday', $birthday);
        $flash->set('email', $email);
        $flash->set('phone', $phone);
        $flash->set('address', $address);

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);
        $func->redirect($configBase . "account/dang-ky");
    }

    /* Save data */
    $data = array();
    $data['date_created'] = time();
    $data['fullname'] = $fullname;
    $data['username'] = $username;
    $data['password'] = $passwordMD5;
    $data['email'] = $email;
    $data['phone'] = $phone;
    $data['address'] = $address;
    $data['gender'] = $gender;
    $data['birthday'] = strtotime(str_replace("/", "-", $birthday));
    $data['status'] = 'hoatdong';
    $data['permission'] = 'user';

    if ($d->insert('table_user', $data)) {
        $func->transfer2("Đăng ký thành viên thành công.", $configBase . "account/dang-nhap");
    } else {
        $func->transfer2("Đăng ký thành viên thất bại. Vui lòng thử lại sau.", $configBase, false);
    }
}

function forgotPassword()
{
    global $d, $setting, $emailer, $func, $flash, $configBase, $lang;

    /* Data */
    $message = '';
    $response = array();
    $username = (!empty($_POST['username'])) ? htmlspecialchars($_POST['username']) : '';
    $email = (!empty($_POST['email'])) ? htmlspecialchars($_POST['email']) : '';
    $newpass = substr(md5(rand(0, 999) * time()), 15, 6);
    $newpassMD5 = md5($newpass);

    /* Valid data */
    if (empty($username)) {
        $response['messages'][] = 'Tài khoản không được trống';
    }

    if (!empty($username) && !$func->isAlphaNum($username)) {
        $response['messages'][] = 'Tài khoản chỉ được nhập chữ thường và số (chữ thường không dấu, ghi liền nhau, không khoảng trắng)';
    }

    if (empty($email)) {
        $response['messages'][] = 'Email không được trống';
    }

    if (!empty($email) && !$func->isEmail($email)) {
        $response['messages'][] = 'Email không hợp lệ';
    }

    if (!empty($username) && !empty($email)) {
        $row = $d->rawQueryOne("select id from #_member where username = ? and email = ? limit 0,1", array($username, $email));

        if (empty($row)) {
            $response['messages'][] = 'Tên đăng nhập hoặc/và email không tồn tại';
        }
    }

    if (!empty($response)) {
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);
        $func->redirect($configBase . "account/quen-mat-khau");
    }

    /* Cập nhật mật khẩu mới */
    $data['password'] = $newpassMD5;
    $d->where('username', $username);
    $d->where('email', $email);
    $d->update('member', $data);

    /* Lấy thông tin người dùng */
    $row = $d->rawQueryOne("select id, username, password, fullname, email, phone, address from #_member where username = ? limit 0,1", array($username));

    /* Gán giá trị gửi email */
    $iduser = $row['id'];
    $tendangnhap = $row['username'];
    $matkhau = $row['password'];
    $tennguoidung = $row['fullname'];
    $emailnguoidung = $row['email'];
    $dienthoainguoidung = $row['phone'];
    $diachinguoidung = $row['address'];

    /* Thông tin đăng ký */
    $thongtindangky = '<td style="padding:3px 9px 9px 0px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top"><span style="text-transform:normal">Username: ' . $tendangnhap . '</span><br>Mật khẩu: *******' . substr($matkhau, -3) . '</td><td style="padding:3px 0px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">';
    if ($tennguoidung) {
        $thongtindangky .= '<span style="text-transform:capitalize">' . $tennguoidung . '</span><br>';
    }

    if ($emailnguoidung) {
        $thongtindangky .= '<a href="mailto:' . $emailnguoidung . '" target="_blank">' . $emailnguoidung . '</a><br>';
    }

    if ($diachinguoidung) {
        $thongtindangky .= $diachinguoidung . '<br>';
    }

    if ($dienthoainguoidung) {
        $thongtindangky .= 'Tel: ' . $dienthoainguoidung . '</td>';
    }

    /* Defaults attributes email */
    $emailDefaultAttrs = $emailer->defaultAttrs();

    /* Variables email */
    $emailVars = array(
        '{emailInfoSignupMember}',
        '{emailNewPasswordMember}'
    );
    $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

    /* Values email */
    $emailVals = array(
        $thongtindangky,
        $newpass
    );
    $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

    /* Send email admin */
    $arrayEmail = array(
        "dataEmail" => array(
            "name" => $tennguoidung,
            "email" => $email
        )
    );
    $subject = "Thư cấp lại mật khẩu từ " . $setting['name' . $lang];
    $message = str_replace($emailVars, $emailVals, $emailer->markdown('member/forgot-password'));
    $file = '';

    if ($emailer->send("customer", $arrayEmail, $subject, $message, $file)) {
        unset($_SESSION['user']);
        setcookie('login_member_id', "", -1, '/');
        setcookie('login_member_session', "", -1, '/');
        $func->transfer2("Cấp lại mật khẩu thành công. Vui lòng kiểm tra email: " . $email, $configBase);
    } else {
        $func->transfer2("Có lỗi xảy ra trong quá trình cấp lại mật khẩu. Vui lòng liện hệ với chúng tôi.", $configBase . "account/quen-mat-khau", false);
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
