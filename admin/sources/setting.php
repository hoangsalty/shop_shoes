<?php
if (!defined('SOURCES')) {
    require_once "../api/config.php";
    /* die("Error"); */
}

$act = (isset($_REQUEST['act'])) ? htmlspecialchars($_REQUEST['act']) : '';

switch ($act) {
    case "update":
        viewSetting();
        $template = "setting/man_add";
        break;
    case "save":
        saveSetting();
        break;
}

/* View setting */
function viewSetting()
{
    global $d, $item;
    $item = $d->rawQueryOne("select * from table_setting limit 0,1");
}

/* Save setting */
function saveSetting()
{
    global $d, $func;

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $row = $d->rawQueryOne("select id, options from table_setting where id = ? limit 0,1", array($id));
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    $option = (!empty($_POST['data[options]'])) ? $_POST['data[options]'] : null;
    if ($data) {
        foreach ($data as $i => $v) {
            if (is_array($v)) {
                foreach ($v as $i2 => $v2) {
                    $option[$i2] = $v2;
                }

                $data[$i] = json_encode($option);
            }
        }
    }

    /* Valid data */
    if (empty($option['address'])) {
        $response['messages'][] = 'Địa chỉ không được trống';
    }

    if (empty($option['email'])) {
        $response['messages'][] = 'Email không được trống';
    }

    if (!empty($option['email']) && !$func->isEmail($option['email'])) {
        $response['messages'][] = 'Email không hợp lệ';
    }

    if (empty($option['hotline'])) {
        $response['messages'][] = 'Hotline không được trống';
    }

    if (!empty($option['hotline']) && !$func->isPhone($option['hotline'])) {
        $response['messages'][] = 'Hotline không hợp lệ';
    }

    if (!empty($option['zalo']) && !$func->isPhone($option['zalo'])) {
        $response['messages'][] = 'Zalo không hợp lệ';
    }

    if (empty($option['website'])) {
        $response['messages'][] = 'Website không được trống';
    }

    if (!empty($option['website']) && !$func->isUrl($option['website'])) {
        $response['messages'][] = 'Website không hợp lệ';
    }

    if (!empty($option['fanpage']) && !$func->isFanpage($option['fanpage'])) {
        $response['messages'][] = 'Fanpage không hợp lệ';
    }

    $checkTitle = $func->checkTitle($data);

    if (!empty($checkTitle)) {
        foreach ($checkTitle as $k => $v) {
            $response['messages'][] = $v;
        }
    }

    if (!empty($response)) {
        /* Errors */
        $response['status'] = 404;
        $response['link'] = "index.php?com=setting&act=update";
        $message = json_encode($response);
        echo $message;
        return;
    }

    /* Save data */
    if (!empty($row)) {
        $d->where('id', $id);
        if ($d->update('table_setting', $data)) {
            $response['status'] = 200;
            $response['messages'][] = 'Cập nhật dữ liệu thành công';
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Cập nhật dữ liệu bị lỗi';
        }
    } else {
        if ($d->insert('table_setting', $data)) {
            $response['status'] = 200;
            $response['messages'][] = 'Lưu dữ liệu thành công';
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Lưu dữ liệu thất bại';
        }
    }

    $response['link'] = "index.php?com=setting&act=update";
    $message = json_encode($response);
    echo $message;
    return;
}
