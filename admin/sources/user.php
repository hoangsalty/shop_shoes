<?php
if (!defined('SOURCES'))
    die("Error");

switch ($act) {
    case "login":
        if (!empty($_SESSION['admin']['active']))
            $func->transfer("Trang không tồn tại", "index.php", false);
        else
            $template = "user/login";
        break;
    case "logout":
        logout();
        break;

    case "man":
        ViewUsers();
        $template = "user/mans";
        break;
    case "add":
        $template = "user/man_add";
        break;
    case "edit":
        editUser();
        $template = "user/man_add";
        break;
    case "save":
        saveUser();
        break;
}

/* Logout admin */
function logout()
{
    global $d, $func;

    /* Hủy bỏ quyền */
    $data['login_session'] = '';
    $d->where('id', $_SESSION['admin']['id']);
    $d->update('table_user', $data);

    /* Hủy bỏ login */
    unset($_SESSION['admin']);
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
    $sql = "select * from table_user where date_deleted = 0 and id <> 1 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from table_user where date_deleted = 0 and id <> 1 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=user&act=man";
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit user */
function editUser()
{
    global $d, $func, $curPage, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man&page=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from table_user where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=user&act=man&page=" . $curPage, false);
        }
    }
}
/* Save user */
function saveUser()
{
    global $d, $func, $flash, $curPage, $config;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man&page=" . $curPage, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
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
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if (empty($id)) {
            $func->redirect("index.php?com=user&act=add");
        } else {
            $func->redirect("index.php?com=user&act=edit&id=" . $id);
        }
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
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", UPLOAD_USER, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from table_user where id = ? limit 0,1", array($id));
                    if (!empty($row)) {
                        unlink(UPLOAD_USER . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('table_user', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=user&act=man&page=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=user&act=man&page=" . $curPage, false);
        }
    } else {
        $data['date_created'] = time();
        /*lay stt*/
        $list_numb = $d->rawQuery("select numb from table_user order by numb desc ", array());
        $new_numb = (!empty($list_numb)) ? $list_numb[0]['numb'] + 1 : 1;

        if (!empty($data['password'])) {
            $data['password'] = md5($data['password']);
        }

        if ($d->insert('table_user', $data)) {
            $id_insert = $d->getLastInsertId();

            /*update stt*/
            $d->rawQuery("update table_user set numb = ? where id = " . $id_insert, array($new_numb));

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                if ($photo = $func->uploadImage("file", UPLOAD_USER, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('table_user', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=user&act=man&page=" . $curPage);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=user&act=man", false);
        }
    }
}
