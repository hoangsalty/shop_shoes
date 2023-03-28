<?php
if (!defined('SOURCES')) die("Error");

switch ($act) {
    case "login":
        if (!empty($_SESSION['admin']['active'])) $func->transfer("Trang không tồn tại", "index.php", false);
        else $template = "user/login";
        break;
    case "logout":
        logout();
        break;

    case "man":
        viewMans();
        $template = "user/mans";
        break;
    case "add":
        $template = "user/man_add";
        break;
    case "edit":
        editMan();
        $template = "user/man_add";
        break;
    case "save":
        saveMan();
        break;
    case "delete":
        deleteMan();
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

/* View mans */
function viewMans()
{
    global $d, $func, $curPage, $items, $paging;

    $where = "";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (username like '%$keyword%' or fullname like '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from table_user where id <> 0 and id <> 1 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from table_user where id <> 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=user&act=man";
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit man */
function editMan()
{
    global $d, $func, $curPage, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man&p=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from table_user where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=user&act=man&p=" . $curPage, false);
        }
    }
}
