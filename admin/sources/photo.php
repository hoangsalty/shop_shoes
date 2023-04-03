<?php
if (!defined('SOURCES')) die("Error");

switch ($act) {
        /* Photos */
    case "man_photo":
        viewPhotos();
        $template = "photo/man/photos";
        break;
    case "add_photo":
        $template = "photo/man/photo_add";
        break;
    case "edit_photo":
        editPhoto();
        $template = "photo/man/photo_add";
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
        $template = "photo/static/photo_static";
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
    global $d, $func, $flash, $type;

    /* Post dữ liệu */
    $row = $d->rawQueryOne("select id from table_photo where type = ? limit 0,1", array($type));
    $message = '';
    $response = array();
    $id = (!empty($row['id']) && $row['id'] > 0) ? $row['id'] : 0;

    $data['status'] = "hienthi";
    $data['type'] = $type;

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
        $func->redirect("index.php?com=photo&act=photo_static&type=" . $type);
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('table_photo', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from table_photo where id = ? limit 0,1", array($id));
                    if (!empty($row)) {
                        unlink(UPLOAD_PHOTO . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('table_photo', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=photo&act=photo_static&type=" . $type);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=photo&act=photo_static&type=" . $type, false);
        }
    } else {
        $data['date_created'] = time();

        if ($func->hasFile("file")) {
            if ($d->insert('table_photo', $data)) {
                $id_insert = $d->getLastInsertId();

                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    $file_name = $func->uploadName($_FILES["file"]["name"]);
                    if ($photo = $func->uploadImage("file", UPLOAD_PHOTO, $file_name)) {
                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $id_insert);
                        $d->update('table_photo', $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                $func->transfer("Lưu dữ liệu thành công", "index.php?com=photo&act=photo_static&type=" . $type);
            } else {
                $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=photo&act=photo_static&type=" . $type, false);
            }
        } else {
            $func->transfer("Dữ liệu rỗng", "index.php?com=photo&act=photo_static&type=" . $type, false);
        }
    }
}

/* View photo */
function viewPhotos()
{
    global $d, $func, $curPage, $items, $paging, $type;

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;

    $sql = "select * from table_photo where type = ? and date_deleted = 0 order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));

    $sqlNum = "select count(*) as 'num' from table_photo where type = ? and date_deleted = 0 order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));

    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=photo&act=man_photo&type=" . $type;
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
        $func->transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from table_photo where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
        } else {
            $gallery = $d->rawQuery("select * from table_gallery_album where id_parent = ? order by numb,id desc", array($id));
        }
    }
}

/* Save photo */
function savePhoto()
{
    global $d, $func, $flash, $curPage, $type;

    /* Check post */
    if (!empty($_REQUEST)) {
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
    }

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

        $data['type'] = $type;
    }

    /* Valid data link */
    if (!empty($data['link']) && !$func->isUrl($data['link'])) {
        $response['messages'][] = 'Đường dẫn không hợp lệ';
    }

    if ($type == 'video') {
        /* Valid data video */
        if (empty($data['link_video'])) {
            $response['messages'][] = 'Đường dẫn video không được trống';
        }
        if (!empty($data['link_video']) && !$func->isYoutube($data['link_video'])) {
            $response['messages'][] = 'Đường dẫn video không hợp lệ';
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

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);
        if ($id) {
            $func->redirect("index.php?com=photo&act=edit_photo&type=" . $type . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=photo&act=edit_photo&type=" . $type);
        }
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('table_photo', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from table_photo where id = ? limit 0,1", array($id));
                    if (!empty($row)) {
                        unlink(UPLOAD_PHOTO . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('table_photo', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('table_photo', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                if ($photo = $func->uploadImage("file", UPLOAD_PHOTO, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('table_photo', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Thêm dữ liệu thành công", "index.php?com=photo&act=man_photo&type=" . $type);
        } else {
            $func->transfer("Thêm dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=" . $type, false);
        }
    }
}

/* Delete photo */
function deletePhoto()
{
    global $d, $func, $curPage, $type;
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id from table_photo where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("update table_photo set date_deleted = ? where id = ?", array(time(), $id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=photo&act=man_photo&type=" . $type . "&page=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=" . $type . "&page=" . $curPage, false);
        }
    } elseif (isset($_REQUEST['listid'])) {
        $listid = explode(",", $_REQUEST['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id from table_photo where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("update table_photo set date_deleted = ? where id = ?", array(time(), $id));
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=photo&act=man_photo&type=" . $type . "&page=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=" . $type . "&page=" . $curPage, false);
    }
}
