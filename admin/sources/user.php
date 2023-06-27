<?php
if (!defined('SOURCES')) {
    require_once "../api/config.php";
    /* die("Error"); */
}

$act = (isset($_REQUEST['act'])) ? htmlspecialchars($_REQUEST['act']) : '';
$cur_Page = (isset($_REQUEST['cur_Page'])) ? htmlspecialchars($_REQUEST['cur_Page']) : '';

switch ($act) {
    case "login":
        if (!empty($_SESSION['account']['active'])) {
            header('Location: ' . $configBase . ADMIN);
        } else
            $template = "user/login";
        break;
    case "logout":
        logout();
        break;

    case "list":
        ViewUsers();
        $template = "user/users";
        break;
    case "add":
        $template = "user/user_add";
        break;
    case "edit":
    case "info":
        editUser();
        $template = "user/user_add";
        break;
    case "save":
        saveUser();
        break;
    case "delete":
        deleteUser();
        break;
}

/* Logout admin */
function logout()
{
    global $d, $func;

    /* Hủy bỏ quyền */
    $data['login_session'] = '';
    $d->where('id', $_SESSION['account']['id']);
    $d->update('table_user', $data);

    /* Hủy bỏ login */
    unset($_SESSION['account']);
    $func->redirect("index.php?com=user&act=login");
}

/* View users */
function ViewUsers()
{
    global $d, $func, $curPage, $items, $paging;

    $where = "";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (username like '%$keyword%' or fullname like '%$keyword%' or email like '%$keyword%' or permission like '%$keyword%' or status like '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from table_user where id <> 1 $where order by id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from table_user where id <> 1 $where order by id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=user&act=list";
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit user */
function editUser()
{
    global $d, $func, $curPage, $item, $act;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($act == 'edit' && empty($id)) {
        $func->transferAdmin("Không nhận được dữ liệu", "index.php?com=user&act=list&page=" . $curPage, false);
    } else {
        if ($act == 'info' && !empty($_SESSION['account']['username'])) {
            $item = $d->rawQueryOne("select * from table_user where username = ? limit 0,1", array($_SESSION['account']['username']));
        } else {
            $item = $d->rawQueryOne("select * from table_user where id = ? limit 0,1", array($id));
        }
        if (empty($item)) {
            $func->transferAdmin("Dữ liệu không có thực", "index.php?com=user&act=list&page=" . $curPage, false);
        }
    }
}
/* Save user */
function saveUser()
{
    global $d, $strUrl, $func, $cur_Page;

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    $changepass = (!empty($_POST['changepass']) && ($_POST['changepass'] == 1)) ? true : false;
    if ($changepass) {
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
            $response['link'] = "index.php?com=user&act=info&changepass=1";
            $message = json_encode($response);
            echo $message;
            return;
        }

        /* Change to new password */
        $data['password'] = md5($new_pass);
        /* Save data */
        $d->where('username', $_SESSION['account']['username']);
        if ($d->update('table_user', $data)) {
            unset($_SESSION['account']);
            $response['status'] = 200;
            $response['messages'][] = 'Cập nhật dữ liệu thành công';
            $response['link'] = "index.php?com=user&act=login";
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Cập nhật dữ liệu bị lỗi';
            $response['link'] = "index.php?com=user&act=info";
        }
    } else {
        if ($data) {
            foreach ($data as $column => $value) {
                $data[$column] = ($column == 'password') ? $value : htmlspecialchars($func->checkInput($value));
            }

            $birthday = $data['birthday'];
            $data['birthday'] = strtotime(str_replace("/", "-", $data['birthday']));
        }

        /* Valid data */
        if (empty($data['permission'])) {
            $response['messages'][] = 'Chưa chọn nhóm quyền';
        }

        if (empty($data['username'])) {
            $response['messages'][] = 'Tài khoản không được trống';
        }

        if (!empty($data['username']) && !$func->isAlphaNum($data['username'])) {
            $response['messages'][] = 'Tài khoản chỉ được nhập chữ thường và số (chữ thường không dấu, ghi liền nhau, không khoảng trắng)';
        }

        if (!empty($data['username'])) {
            if ($func->checkExist($data['username'], 'username', 'user', $id)) {
                $response['messages'][] = 'Tài khoản đã tồn tại';
            }
        }

        if (!empty($data['email'])) {
            if ($func->checkExist($data['email'], 'email', 'user', $id)) {
                $response['messages'][] = 'Email đã tồn tại';
            }
        }

        if (empty($id) || !empty($data['password'])) {
            if (empty($data['password'])) {
                $response['messages'][] = 'Mật khẩu không được trống';
            }

            if (!empty($data['password']) && empty($_POST['confirm_password'])) {
                $response['messages'][] = 'Xác nhận mật khẩu không được trống';
            }

            if (!empty($data['password']) && !empty($_POST['confirm_password']) && !$func->isMatch($data['password'], $_POST['confirm_password'])) {
                $response['messages'][] = 'Mật khẩu không trùng khớp';
            }
        }

        if (empty($data['fullname'])) {
            $response['messages'][] = 'Họ tên không được trống';
        }

        if (empty($data['email'])) {
            $response['messages'][] = 'Email không được trống';
        }

        if (!empty($data['email']) && !$func->isEmail($data['email'])) {
            $response['messages'][] = 'Email không hợp lệ';
        }

        if (!empty($data['phone']) && !$func->isPhone($data['phone'])) {
            $response['messages'][] = 'Số điện thoại không hợp lệ';
        }

        if (empty($data['gender'])) {
            $response['messages'][] = 'Chưa chọn giới tính';
        }

        if (empty($birthday)) {
            $response['messages'][] = 'Ngày sinh không được trống';
        }

        if (!empty($birthday) && !$func->isDate($birthday)) {
            $response['messages'][] = 'Ngày sinh không hợp lệ';
        }

        if (empty($data['address'])) {
            $response['messages'][] = 'Địa chỉ không được trống';
        }

        if (!empty($response)) {
            /* Errors */
            $response['status'] = 404;
            if ($id) {
                $response['link'] = "index.php?com=user&act=edit&id=" . $id;
            } else {
                $response['link'] = "index.php?com=user&act=add";
            }
            $message = json_encode($response);
            echo $message;
            return;
        }

        /* Save data */
        if ($id) {
            $data['date_updated'] = time();
            if (!empty($data['password'])) {
                $password = $data['password'];
                $confirm_password = !empty($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
                $data['password'] = md5($password);
            } else {
                unset($data['password']);
            }

            $d->where('id', $id);
            if ($d->update('table_user', $data)) {
                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    if ($photo = $func->uploadImage("file", UPLOAD_USER)) {
                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $id);
                        $d->update('table_user', $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                $response['status'] = 200;
                $response['messages'][] = 'Cập nhật dữ liệu thành công';
            } else {
                $response['status'] = 404;
                $response['messages'][] = 'Cập nhật dữ liệu bị lỗi';
            }
            $response['link'] = "index.php?com=user&act=edit&id=" . $id;
        } else {
            $data['date_created'] = time();

            if (!empty($data['password'])) {
                $data['password'] = md5($data['password']);
            }

            if ($d->insert('table_user', $data)) {
                $id_insert = $d->getLastInsertId();

                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    if ($photo = $func->uploadImage("file", UPLOAD_USER)) {
                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $id_insert);
                        $d->update('table_user', $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                $response['status'] = 200;
                $response['messages'][] = 'Lưu dữ liệu thành công';
                $response['link'] = "index.php?com=user&act=edit&id=" . $id_insert;
            } else {
                $response['status'] = 404;
                $response['messages'][] = 'Lưu dữ liệu thất bại';
                $response['link'] = "index.php?com=user&act=list&page=" . $cur_Page;
            }
        }
    }

    $message = json_encode($response);
    echo $message;
    return;
}

/* Delete admin */
function deleteUser()
{
    global $d, $strUrl, $func, $cur_Page;

    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id from table_user where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("delete from table_user where id = ?", array($id));

            $response['status'] = 200;
            $response['messages'][] = 'Xóa dữ liệu thành công';
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Xóa dữ liệu bị lỗi';
        }
    } elseif (isset($_REQUEST['listid'])) {
        $listid = explode(",", $_REQUEST['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id from table_user where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("delete from table_user where id = ?", array($id));
            }
        }
        $response['status'] = 200;
        $response['messages'][] = 'Xóa dữ liệu thành công';
    } else {
        $response['status'] = 404;
        $response['messages'][] = 'Không nhận được dữ liệu';
    }

    $response['link'] = "index.php?com=user&act=list&page=" . $cur_Page . $strUrl;
    $message = json_encode($response);
    echo $message;
    return;
}
