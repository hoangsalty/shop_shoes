<?php
if (!defined('SOURCES'))
    die("Error");

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
    global $d, $func, $flash, $type;

    /* Check post */
    if (empty($_REQUEST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=static&act=update&type=" . $type, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $static = $d->rawQueryOne("select * from table_static where type = ? limit 0,1", array($type));
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

        $data['type'] = $type;
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
    $dataSlug['id'] = isset($static['id']) ? $static['id'] : 0;
    $checkSlug = $func->checkSlug($dataSlug);
    if ($checkSlug == 'exist') {
        $response['messages'][] = 'Đường dẫn đã tồn tại';
    } else if ($checkSlug == 'empty') {
        $response['messages'][] = 'Đường dẫn không được trống';
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
        $func->redirect("index.php?com=static&act=update&type=" . $type);
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
                    $row = $d->rawQueryOne("select id, photo from table_static where id = ? limit 0,1", array($static['id']));
                    if (!empty($row)) {
                        unlink(UPLOAD_NEWS . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $static['id']);
                    $d->update('table_static', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=static&act=update&type=" . $type);
        } else {
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=static&act=update&type=" . $type);
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

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=static&act=update&type=" . $type);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=static&act=update&type=" . $type, false);
        }
    }
}