<?php
if (!defined('SOURCES')) die("Error");

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
    global $d, $func, $flash, $config, $com;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=setting&act=update", false);
    }

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
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        if (!empty($option)) {
            foreach ($option as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);
        $func->redirect("index.php?com=setting&act=update");
    }

    /* Save data */
    if (!empty($row)) {
        $d->where('id', $id);
        if ($d->update('table_setting', $data)) {
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=setting&act=update");
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=setting&act=update", false);
        }
    } else {
        if ($d->insert('table_setting', $data)) {
            $func->transfer("Thêm dữ liệu thành công", "index.php?com=setting&act=update");
        } else {
            $func->transfer("Thêm dữ liệu bị lỗi", "index.php?com=setting&act=update", false);
        }
    }
}
