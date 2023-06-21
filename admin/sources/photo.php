<?php
if (!defined('SOURCES')) {
    require_once "../api/config.php";
    /* die("Error"); */
}

$act = (isset($_REQUEST['act'])) ? htmlspecialchars($_REQUEST['act']) : '';
$cur_Page = (isset($_REQUEST['cur_Page'])) ? htmlspecialchars($_REQUEST['cur_Page']) : '';
$cur_Type = (isset($_REQUEST['cur_Type'])) ? htmlspecialchars($_REQUEST['cur_Type']) : '';

switch ($act) {
        /* Photos */
    case "list":
        viewPhotos();
        $template = "photo/photos";
        break;
    case "add_photo":
        $template = "photo/photo_add";
        break;
    case "edit_photo":
        editPhoto();
        $template = "photo/photo_add";
        break;
    case "save_photo":
        savePhoto();
        break;
    case "delete_photo":
        deletePhoto();
        break;

        /* Photo static */
    case "photo_static":
        viewPhotoStatic();
        $template = "photo/photo_static";
        break;
    case "save_static":
        savePhotoStatic();
        break;
}

/* View photo static */
function viewPhotoStatic()
{
    global $d, $item, $type;

    $item = $d->rawQueryOne("select * from table_photo where type = ? limit 0,1", array($type));
}

/* Save photo static */
function savePhotoStatic()
{
    global $d, $func, $cur_Type;

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $row = $d->rawQueryOne("select id from table_photo where type = ? limit 0,1", array($cur_Type));
    $id = (!empty($row['id']) && $row['id'] > 0) ? $row['id'] : 0;
    $data['status'] = "hienthi";
    $data['type'] = $cur_Type;

    if (!empty($response)) {
        /* Errors */
        $response['status'] = 404;
        $response['link'] = "index.php?com=photo&act=photo_static&type=" . $cur_Type;
        $message = json_encode($response);
        echo $message;
        return;
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('type', $cur_Type);
        if ($d->update('table_photo', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                if ($photo = $func->uploadImage("file", UPLOAD_PHOTO)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('table_photo', $photoUpdate);
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

        if ($func->hasFile("file")) {
            if ($d->insert('table_photo', $data)) {
                $id_insert = $d->getLastInsertId();

                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    if ($photo = $func->uploadImage("file", UPLOAD_PHOTO)) {
                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $id_insert);
                        $d->update('table_photo', $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                $response['status'] = 200;
                $response['messages'][] = 'Lưu dữ liệu thành công';
            } else {
                $response['status'] = 404;
                $response['messages'][] = 'Lưu dữ liệu bị lỗi';
            }
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Dữ liệu rỗng';
        }
    }

    $response['link'] = "index.php?com=photo&act=photo_static&type=" . $cur_Type;
    $message = json_encode($response);
    echo $message;
    return;
}

/* View photo */
function viewPhotos()
{
    global $d, $func, $curPage, $items, $paging, $type;

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;

    $sql = "select * from table_photo where type = ? order by id desc $limit";
    $items = $d->rawQuery($sql, array($type));

    $sqlNum = "select count(*) as 'num' from table_photo where type = ? order by id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));

    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=photo&act=list&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit photo */
function editPhoto()
{
    global $d, $func, $curPage, $item, $type, $gallery;
    if (!empty($_REQUEST['id']))
        $id = htmlspecialchars($_REQUEST['id']);
    else
        $id = 0;

    if (empty($id)) {
        $func->transferAdmin("Không nhận được dữ liệu", "index.php?com=photo&act=list&type=" . $type . "&page=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from table_photo where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transferAdmin("Không nhận được dữ liệu", "index.php?com=photo&act=list&type=" . $type . "&page=" . $curPage, false);
        } else {
            $gallery = $d->rawQuery("select * from table_gallery_album where id_parent = ? order by id desc", array($id));
        }
    }
}

/* Save photo */
function savePhoto()
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

    /* Valid data link */
    if (!empty($data['link']) && !$func->isUrl($data['link'])) {
        $response['messages'][] = 'Đường dẫn không hợp lệ';
    }

    if ($cur_Type == 'video') {
        /* Valid data video */
        if (empty($data['link_video'])) {
            $response['messages'][] = 'Đường dẫn video không được trống';
        }
        if (!empty($data['link_video']) && !$func->isYoutube($data['link_video'])) {
            $response['messages'][] = 'Đường dẫn video không hợp lệ';
        }
    }

    if (!empty($response)) {
        /* Errors */
        $response['status'] = 404;
        if ($id) {
            $response['link'] = "index.php?com=photo&act=edit_photo&type=" . $cur_Type . "&id=" . $id;
        } else {
            $response['link'] = "index.php?com=photo&act=add_photo&type=" . $cur_Type;
        }
        $message = json_encode($response);
        echo $message;
        return;
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('type', $cur_Type);
        if ($d->update('table_photo', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                if ($photo = $func->uploadImage("file", UPLOAD_PHOTO)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('table_photo', $photoUpdate);
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

        if ($d->insert('table_photo', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                if ($photo = $func->uploadImage("file", UPLOAD_PHOTO)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('table_photo', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $response['status'] = 200;
            $response['messages'][] = 'Thêm dữ liệu thành công';
            $response['link'] = "index.php?com=photo&act=edit_photo&type=" . $cur_Type . "&id=" . $id_insert;
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Thêm dữ liệu bị lỗi';
            $response['link'] = "index.php?com=photo&act=photos&type=" . $cur_Type . "&page=" . $cur_Page;
        }
    }

    $message = json_encode($response);
    echo $message;
    return;
}

/* Delete photo */
function deletePhoto()
{
    global $d, $strUrl, $cur_Page, $cur_Type;

    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id from table_photo where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("delete from table_photo where id = ?", array($id));

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
            $row = $d->rawQueryOne("select id from table_photo where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("delete from table_photo where id = ?", array($id));
            }
        }
        $response['status'] = 200;
        $response['messages'][] = 'Xóa dữ liệu thành công';
    } else {
        $response['status'] = 404;
        $response['messages'][] = 'Không nhận được dữ liệu';
    }
    
    $response['link'] = "index.php?com=photo&act=list&type=" . $cur_Type . "&page=" . $cur_Page;
    $message = json_encode($response);
    echo $message;
    return;
}
