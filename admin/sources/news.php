<?php
if (!defined('SOURCES')) {
    require_once "../api/config.php";
    /* die("Error"); */
}

$act = (isset($_REQUEST['act'])) ? htmlspecialchars($_REQUEST['act']) : '';
$cur_Page = (isset($_REQUEST['cur_Page'])) ? htmlspecialchars($_REQUEST['cur_Page']) : '';
$cur_Type = (isset($_REQUEST['cur_Type'])) ? htmlspecialchars($_REQUEST['cur_Type']) : '';

/* Cấu hình đường dẫn trả về */
$strUrl = "";
if (isset($_REQUEST['keyword'])) $strUrl .= "&keyword=" . htmlspecialchars($_REQUEST['keyword']);

switch ($act) {
    case "list":
        viewNews();
        $template = "news/news";
        break;
    case "add":
        $template = "news/new_add";
        break;
    case "edit":
        editNew();
        $template = "news/new_add";
        break;
    case "save":
        saveNew();
        break;
    case "delete":
        deleteNew();
        break;
}

/* View new */
function viewNews()
{
    global $d, $func, $strUrl, $curPage, $paging, $items, $type;

    $where = "";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (name LIKE '%$keyword%')";
    }
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $items = $d->rawQuery("select * from table_news where id > 0 and type = ? $where order by id desc $limit", array($type));
    $sqlNum = "select count(*) as 'num' from table_news where id > 0 and type = ? $where order by id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=news&act=list" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit new */
function editNew()
{
    global $d, $func, $strUrl, $curPage, $item, $type;
    if (!empty($_REQUEST['id']))
        $id = htmlspecialchars($_REQUEST['id']);
    else
        $id = 0;

    if (empty($id)) {
        $func->transferAdmin("Không nhận được dữ liệu", "index.php?com=news&act=list&type=" . $type . "&page=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from table_news where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transferAdmin("Không có dữ liệu", "index.php?com=news&act=list&type=" . $type . "&page=" . $curPage . $strUrl, false);
        }
    }
}
/* Save new */
function saveNew()
{
    global $d, $strUrl, $func, $cur_Page, $cur_Type;

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    $data = (!empty($_REQUEST['data'])) ? $_REQUEST['data'] : null;

    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->checkInput($value));
        }

        if (!empty($_REQUEST['slug']))
            $data['slug'] = $func->changeTitle(htmlspecialchars($_REQUEST['slug']));
        else
            $data['slug'] = (!empty($data['name'])) ? $func->changeTitle($data['name']) : '';

        if (isset($_REQUEST['status'])) {
            $status = '';
            foreach ($_REQUEST['status'] as $attr_column => $attr_value)
                if ($attr_value != "")
                    $status .= $attr_value . ',';

            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "hienthi";
        }

        $data['type'] = $cur_Type;
    }
    /* Valid data */
    $checkTitle = $func->checkTitle($data);
    if (!empty($checkTitle)) {
        foreach ($checkTitle as $k => $v) {
            $response['messages'][] = $v;
        }
    }
    $dataSlug = array();
    $dataSlug['slug'] = $data['slug'];
    $dataSlug['id'] = $id;
    $checkSlug = $func->checkSlug($dataSlug);
    if ($checkSlug == 'exist') {
        $response['messages'][] = 'Đường dẫn đã tồn tại';
    } else if ($checkSlug == 'empty') {
        $response['messages'][] = 'Đường dẫn không được trống';
    }

    if (!empty($response)) {
        /* Errors */
        $response['status'] = 404;
        if ($id) {
            $response['link'] = "index.php?com=news&act=edit&type=" . $cur_Type . $strUrl . "&id=" . $id;
        } else {
            $response['link'] = "index.php?com=news&act=add&type=" . $cur_Type . $strUrl;
        }
        $message = json_encode($response);
        echo $message;
        return;
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);

        if ($d->update('table_news', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                if ($photo = $func->uploadImage("file", UPLOAD_NEWS)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('table_news', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $response['status'] = 200;
            $response['messages'][] = 'Cập nhật dữ liệu thành công';
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Cập nhật dữ liệu bị lỗi';
        }
        $response['link'] = "index.php?com=news&act=edit&type=" . $cur_Type . $strUrl . "&id=" . $id;
    } else {
        $data['date_created'] = time();

        if ($d->insert('table_news', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                if ($photo = $func->uploadImage("file", UPLOAD_NEWS)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('table_news', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $response['status'] = 200;
            $response['messages'][] = 'Lưu dữ liệu thành công';
            $response['link'] = "index.php?com=news&act=edit&type=" . $cur_Type . $strUrl . "&id=" . $id_insert;
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Lưu dữ liệu thất bại';
            $response['link'] = "index.php?com=product&act=list&type=" . $cur_Type . "&page=" . $cur_Page . $strUrl;
        }
    }

    $message = json_encode($response);
    echo $message;
    return;
}
/* Delete new */
function deleteNew()
{
    global $d, $strUrl, $cur_Page, $cur_Type;

    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from table_news where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("delete from table_news where id = ?", array($id));

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
            $row = $d->rawQueryOne("select id, photo from table_news where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("delete from table_news where id = ?", array($id));
            }
        }
        $response['status'] = 200;
        $response['messages'][] = 'Xóa dữ liệu thành công';
    } else {
        $response['status'] = 404;
        $response['messages'][] = 'Không nhận được dữ liệu';
    }

    $response['link'] = "index.php?com=news&act=list&type=" . $cur_Type . "&page=" . $cur_Page . $strUrl;
    $message = json_encode($response);
    echo $message;
    return;
}
