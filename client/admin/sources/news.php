<?php
if (!defined('SOURCES')) die("Error");

/* Cấu hình đường dẫn trả về */
$strUrl = "";
if (isset($_REQUEST['keyword'])) $strUrl .= "&keyword=" . htmlspecialchars($_REQUEST['keyword']);

switch ($act) {
    /* Man */
    case "man":
        viewMans();
        $template = "news/mans";
        break;
    case "add":
        $template = "news/man_add";
        break;
    case "edit":
        editMan();
        $template = "news/man_add";
        break;
    case "save":
        saveMan();
        break;
    case "delete":
        deleteMan();
        break;
}

/* View man */
function viewMans()
{
    global $d, $func, $strUrl, $curPage, $paging, $items;
    $where = "";
    $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    $idbrand = (isset($_REQUEST['id_brand'])) ? htmlspecialchars($_REQUEST['id_brand']) : 0;
    if ($idlist) $where .= " and id_list=$idlist";
    if ($idbrand) $where .= " and id_brand=$idbrand";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (name LIKE '%$keyword%')";
    }
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $items = $d->rawQuery("select * from table_news where id > 0 $where and date_deleted = 0 order by numb,id desc $limit", array());
    $sqlNum = "select count(*) as 'num' from table_news where id > 0 $where and date_deleted = 0 order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array());
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=news&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit man */
function editMan()
{
    global $d, $func, $strUrl, $curPage, $item;
    if (!empty($_REQUEST['id']))
        $id = htmlspecialchars($_REQUEST['id']);
    else
        $id = 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man&page=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from table_news where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transfer("Không có dữ liệu", "index.php?com=news&act=man&page=" . $curPage . $strUrl, false);
        }
    }
}
/* Save man */
function saveMan()
{
    global $d, $strUrl, $func, $flash, $curPage;
    /* Check post */
    if (empty($_REQUEST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man&page=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $savehere = (isset($_REQUEST['save-here'])) ? true : false;
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    $data = (!empty($_REQUEST['data'])) ? $_REQUEST['data'] : null;

    if ($data) {
        foreach ($data as $column => $value) {
            /* if (strpos($column, 'content') !== false || strpos($column, 'desc') !== false) {
                $data[$column] = htmlspecialchars($func->checkInput($value, 'iframe'));
            } else { */
            $data[$column] = htmlspecialchars($func->checkInput($value));

            if (strpos($column, 'id_list') !== false || strpos($column, 'id_brand') !== false) {
                if (empty($value) || $value == 0) {
                    $data[$column] = NULL;
                }
            }
            /* } */
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
            $func->redirect("index.php?com=news&act=edit&page=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=news&act=add&page=" . $curPage . $strUrl);
        }
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);

        if ($d->update('table_news', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", UPLOAD_NEWS, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from table_news where id = ? limit 0,1", array($id));
                    if (!empty($row)) {
                        unlink(UPLOAD_NEWS . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('table_news', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            if ($savehere) {
                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=edit&page=" . $curPage . $strUrl . "&id=" . $id);
            } else {
                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=man&page=" . $curPage . $strUrl);
            }
        } else {
            if ($savehere) {
                $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=edit&page=" . $curPage . $strUrl . "&id=" . $id, false);
            } else {
                $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man&page=" . $curPage . $strUrl, false);
            }
        }
    } else {
        $data['date_created'] = time();
        /*lay stt*/
        $list_numb = $d->rawQuery("select numb from table_news order by numb desc ", array());
        $new_numb = (!empty($list_numb)) ? $list_numb[0]['numb'] + 1 : 1;

        if ($d->insert('table_news', $data)) {
            $id_insert = $d->getLastInsertId();

            /*update stt*/
            $d->rawQuery("update table_news set numb = ? where id = " . $id_insert, array($new_numb));
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                if ($photo = $func->uploadImage("file", UPLOAD_NEWS, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('table_news', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            if ($savehere) {
                $func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=edit&page=" . $curPage . $strUrl . "&id=" . $id_insert);
            } else {
                $func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=man&page=" . $curPage . $strUrl);
            }
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man&page=" . $curPage . $strUrl, false);
        }
    }
}
/* Delete man */
function deleteMan()
{
    global $d, $strUrl, $func, $curPage, $com;
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from table_news where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("update table_news set date_deleted = ? where id = ?", array(time(), $id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man&page=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man&page=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_REQUEST['listid'])) {
        $listid = explode(",", $_REQUEST['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from table_news where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("update table_news set date_deleted = ? where id = ?", array(time(), $id));
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man&page=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man&page=" . $curPage . $strUrl, false);
    }
}
/* Delete man */
function permDeleteMan()
{
    global $d, $strUrl, $func, $curPage, $com;
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from table_news where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            unlink(UPLOAD_NEWS . $row['photo']);
            $d->rawQuery("delete from table_news where id = ?", array($id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man&page=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man&page=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_REQUEST['listid'])) {
        $listid = explode(",", $_REQUEST['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from table_news where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                unlink(UPLOAD_NEWS . $row['photo']);
                $d->rawQuery("delete from table_news where id = ?", array($id));
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man&page=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man&page=" . $curPage . $strUrl, false);
    }
}