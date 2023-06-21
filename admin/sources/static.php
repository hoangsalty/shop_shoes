<?php
if (!defined('SOURCES')) {
    require_once "../api/config.php";
    /* die("Error"); */
}

$act = (isset($_REQUEST['act'])) ? htmlspecialchars($_REQUEST['act']) : '';
$cur_Type = (isset($_REQUEST['cur_Type'])) ? htmlspecialchars($_REQUEST['cur_Type']) : '';

switch ($act) {
    case "update":
        viewStatic();
        $template = "static/man_add";
        break;
    case "save":
        saveStatic();
        break;
}

/* View static */
function viewStatic()
{
    global $d, $item, $type;

    $item = $d->rawQueryOne("select * from table_static where type = ? limit 0,1", array($type));
}
/* Save man */
function saveStatic()
{
    global $d, $func, $cur_Type;

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $static = $d->rawQueryOne("select * from table_static where type = ? limit 0,1", array($cur_Type));
    $data = (!empty($_REQUEST['data'])) ? $_REQUEST['data'] : null;

    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->checkInput($value));
        }

        $data['status'] = "hienthi";
        $data['type'] = $cur_Type;
    }
    /* Valid data */
    $checkTitle = $func->checkTitle($data);
    if (!empty($checkTitle)) {
        foreach ($checkTitle as $k => $v) {
            $response['messages'][] = $v;
        }
    }

    if (!empty($response)) {
        /* Errors */
        $response['status'] = 404;
        $response['link'] = "index.php?com=static&act=update&type=" . $cur_Type;
        $message = json_encode($response);
        echo $message;
        return;
    }

    /* Save data */
    if (!empty($static)) {
        $data['date_updated'] = time();
        $d->where('id', $static['id']);

        if ($d->update('table_static', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                if ($photo = $func->uploadImage("file", UPLOAD_NEWS)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $static['id']);
                    $d->update('table_static', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $response['status'] = 200;
            $response['messages'][] = 'Cập nhật dữ liệu thành công';
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Cập nhật dữ liệu bị lỗi';
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('table_static', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                if ($photo = $func->uploadImage("file", UPLOAD_NEWS)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('table_static', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $response['status'] = 200;
            $response['messages'][] = 'Lưu dữ liệu thành công';
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Lưu dữ liệu thất bại';
        }
    }

    $response['link'] = "index.php?com=static&act=update&type=" . $cur_Type;
    $message = json_encode($response);
    echo $message;
    return;
}
