<?php
if (!defined('SOURCES'))
    die("Error");

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$strUrl .= (isset($_REQUEST['keyword'])) ? "&keyword=" . htmlspecialchars($_REQUEST['keyword']) : "";

switch ($act) {
    case "man":
        viewNews();
        $template = "news/mans";
        break;
    case "add":
        $template = "news/man_add";
        break;
    case "edit":
        editNew();
        $template = "news/man_add";
        break;
    case "save":
        saveNew();
        break;
    case "delete":
        deleteNew();
        break;
}

/* View man */
function viewNews()
{
    global $d, $func, $strUrl, $curPage, $paging, $items, $type;

    $where = "";
    $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    $idbrand = (isset($_REQUEST['id_brand'])) ? htmlspecialchars($_REQUEST['id_brand']) : 0;
    if ($idlist)
        $where .= " and id_list=$idlist";
    if ($idbrand)
        $where .= " and id_brand=$idbrand";
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
    $url = "index.php?com=news&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit man */
function editNew()
{
    global $d, $func, $strUrl, $curPage, $item, $type;
    if (!empty($_REQUEST['id']))
        $id = htmlspecialchars($_REQUEST['id']);
    else
        $id = 0;

    if (empty($id)) {
        $func->transferAdmin("Không nhận được dữ liệu", "index.php?com=news&act=man&type=" . $type . "&page=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from table_news where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transferAdmin("Không có dữ liệu", "index.php?com=news&act=man&type=" . $type . "&page=" . $curPage . $strUrl, false);
        }
    }
}
/* Save man */
function saveNew()
{
    global $d, $strUrl, $func, $flash, $curPage, $type;
    /* Check post */
    if (empty($_REQUEST)) {
        $func->transferAdmin("Không nhận được dữ liệu", "index.php?com=news&act=man&type=" . $type . "&page=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    $data = (!empty($_REQUEST['data'])) ? $_REQUEST['data'] : null;

    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->checkInput($value));

            if (strpos($column, 'id_list') !== false || strpos($column, 'id_brand') !== false) {
                if (empty($value) || $value == 0) {
                    $data[$column] = NULL;
                }
            }
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
                if ($photo = $func->uploadImage("file", UPLOAD_NEWS)) {
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

            $func->transferAdmin("Cập nhật dữ liệu thành công", "index.php?com=news&act=edit&type=" . $type . "&page=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->transferAdmin("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=edit&type=" . $type . "&page=" . $curPage . $strUrl . "&id=" . $id, false);
        }
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

            $func->transferAdmin("Lưu dữ liệu thành công", "index.php?com=news&act=edit&type=" . $type . "&page=" . $curPage . $strUrl . "&id=" . $id_insert);
        } else {
            $func->transferAdmin("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man&type=" . $type . "&page=" . $curPage . $strUrl, false);
        }
    }
}
/* Delete man */
function deleteNew()
{
    global $d, $strUrl, $func, $curPage, $type;
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from table_news where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("delete from table_news where id = ?", array($id));
            $func->transferAdmin("Xóa dữ liệu thành công", "index.php?com=news&act=man&type=" . $type . "&page=" . $curPage . $strUrl);
        } else {
            $func->transferAdmin("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man&type=" . $type . "&page=" . $curPage . $strUrl, false);
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
        $func->transferAdmin("Xóa dữ liệu thành công", "index.php?com=news&act=man&type=" . $type . "&page=" . $curPage . $strUrl);
    } else {
        $func->transferAdmin("Không nhận được dữ liệu", "index.php?com=news&act=man&type=" . $type . "&page=" . $curPage . $strUrl, false);
    }
}
