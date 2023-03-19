<?php
if (!defined('SOURCES')) die("Error");

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('id_list', 'id_brand');
if (isset($_REQUEST['data'])) {
    $dataUrl = isset($_REQUEST['data']) ? $_REQUEST['data'] : null;
    if ($dataUrl) {
        foreach ($arrUrl as $k => $v) {
            if (isset($dataUrl[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($dataUrl[$arrUrl[$k]]);
        }
    }
} else {
    foreach ($arrUrl as $k => $v) {
        if (isset($_REQUEST[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($_REQUEST[$arrUrl[$k]]);
    }
    if (isset($_REQUEST['keyword'])) $strUrl .= "&keyword=" . htmlspecialchars($_REQUEST['keyword']);
}
switch ($act) {
        /* Man */
    case "man":
        viewMans();
        $template = "product/man/mans";
        break;
    case "add":
        $template = "product/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "product/man/man_add";
        break;
    case "save":
        saveMan();
        break;
    case "delete":
        deleteMan();
        break;

        /* List */
    case "man_list":
        viewLists();
        $template = "product/list/lists";
        break;
    case "add_list":
        $template = "product/list/list_add";
        break;
    case "edit_list":
        editList();
        $template = "product/list/list_add";
        break;
    case "save_list":
        saveList();
        break;
    case "delete_list":
        deleteList();
        break;

        /* Brand */
    case "man_brand":
        viewBrands();
        $template = "product/brand/brands";
        break;
    case "add_brand":
        $template = "product/brand/brand_add";
        break;
    case "edit_brand":
        editBrand();
        $template = "product/brand/brand_add";
        break;
    case "save_brand":
        saveBrand();
        break;
    case "delete_brand":
        deleteBrand();
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
    $items = $d->rawQuery("select * from table_product where id > 0 $where and date_deleted = 0 order by numb,id desc $limit", array());
    $sqlNum = "select count(*) as 'num' from table_product where id > 0 $where and date_deleted = 0 order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array());
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit man */
function editMan()
{
    global $d, $func, $strUrl, $curPage, $item, $gallery;
    if (!empty($_REQUEST['id']))
        $id = htmlspecialchars($_REQUEST['id']);
    else
        $id = 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&page=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from table_product where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transfer("Không có dữ liệu", "index.php?com=product&act=man&page=" . $curPage . $strUrl, false);
        } else {
            $gallery = $d->rawQuery("select * from table_gallery where id_parent = ? order by numb,id desc", array($id));
        }
    }
}
/* Save man */
function saveMan()
{
    global $d, $strUrl, $func, $flash, $curPage;
    /* Check post */
    if (empty($_REQUEST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&page=" . $curPage . $strUrl, false);
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
        $data['regular_price'] = (isset($data['regular_price']) && $data['regular_price'] != '') ? str_replace(",", "", $data['regular_price']) : 0;
        $data['sale_price'] = (isset($data['sale_price']) && $data['sale_price'] != '') ? str_replace(",", "", $data['sale_price']) : 0;
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
    if (!empty($data['regular_price']) && !$func->isNumber($data['regular_price'])) {
        $response['messages'][] = 'Giá bán không hợp lệ';
    }
    if (!empty($data['sale_price']) && !$func->isNumber($data['sale_price'])) {
        $response['messages'][] = 'Giá mới không hợp lệ';
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
            $func->redirect("index.php?com=product&act=edit&page=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=product&act=add&page=" . $curPage . $strUrl);
        }
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);

        if ($d->update('table_product', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from table_product where id = ? limit 0,1", array($id));
                    if (!empty($row)) {
                        unlink(UPLOAD_PRODUCT . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('table_product', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            if ($savehere) {
                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=edit&page=" . $curPage . $strUrl . "&id=" . $id);
            } else {
                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man&page=" . $curPage . $strUrl);
            }
        } else {
            if ($savehere) {
                $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=edit&page=" . $curPage . $strUrl . "&id=" . $id, false);
            } else {
                $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man&page=" . $curPage . $strUrl, false);
            }
        }
    } else {
        $data['date_created'] = time();
        /*lay stt*/
        $list_numb = $d->rawQuery("select numb from table_product order by numb desc ", array());
        $new_numb = (!empty($list_numb)) ? $list_numb[0]['numb'] + 1 : 1;

        if ($d->insert('table_product', $data)) {
            $id_insert = $d->getLastInsertId();

            /*update stt*/
            $d->rawQuery("update table_product set numb = ? where id = " . $id_insert, array($new_numb));
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('table_product', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            if ($savehere) {
                $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=edit&page=" . $curPage . $strUrl . "&id=" . $id_insert);
            } else {
                $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man&page=" . $curPage . $strUrl);
            }
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man&page=" . $curPage . $strUrl, false);
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
        $row = $d->rawQueryOne("select id, photo from table_product where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("update table_product set date_deleted = ? where id = ?", array(time(), $id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man&page=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man&page=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_REQUEST['listid'])) {
        $listid = explode(",", $_REQUEST['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from table_product where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("update table_product set date_deleted = ? where id = ?", array(time(), $id));
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man&page=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&page=" . $curPage . $strUrl, false);
    }
}
/* Delete man */
function permDeleteMan()
{
    global $d, $strUrl, $func, $curPage, $com;
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from table_product where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            unlink(UPLOAD_PRODUCT . $row['photo']);
            $d->rawQuery("delete from table_product where id = ?", array($id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man&page=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man&page=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_REQUEST['listid'])) {
        $listid = explode(",", $_REQUEST['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from table_product where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                unlink(UPLOAD_PRODUCT . $row['photo']);
                $d->rawQuery("delete from table_product where id = ?", array($id));
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man&page=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&page=" . $curPage . $strUrl, false);
    }
}

/* View list */
function viewLists()
{
    global $d, $func, $strUrl, $curPage, $paging, $items;
    $where = "";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (name LIKE '%$keyword%')";
    }
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $items = $d->rawQuery("select * from table_product_list where id > 0 $where and date_deleted = 0 order by numb,id desc $limit", array());
    $sqlNum = "select count(*) as 'num' from table_product_list where id > 0 $where and date_deleted = 0 order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array());
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_list" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit list */
function editList()
{
    global $d, $func, $strUrl, $curPage, $item;
    if (!empty($_REQUEST['id']))
        $id = htmlspecialchars($_REQUEST['id']);
    else
        $id = 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_list&page=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from table_product_list where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transfer("Không có dữ liệu", "index.php?com=product&act=man_list&page=" . $curPage . $strUrl, false);
        }
    }
}
/* Save list */
function saveList()
{
    global $d, $strUrl, $func, $flash, $curPage;
    /* Check post */
    if (empty($_REQUEST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_list&page=" . $curPage . $strUrl, false);
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
    if (!empty($data['regular_price']) && !$func->isNumber($data['regular_price'])) {
        $response['messages'][] = 'Giá bán không hợp lệ';
    }
    if (!empty($data['sale_price']) && !$func->isNumber($data['sale_price'])) {
        $response['messages'][] = 'Giá mới không hợp lệ';
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
            $func->redirect("index.php?com=product&act=edit_list&page=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=product&act=add_list&page=" . $curPage . $strUrl);
        }
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);

        if ($d->update('table_product_list', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from table_product_list where id = ? limit 0,1", array($id));
                    if (!empty($row)) {
                        unlink(UPLOAD_PRODUCT . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('table_product_list', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            if ($savehere) {
                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=edit_list&page=" . $curPage . $strUrl . "&id=" . $id);
            } else {
                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_list&page=" . $curPage . $strUrl);
            }
        } else {
            if ($savehere) {
                $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=edit_list&page=" . $curPage . $strUrl . "&id=" . $id, false);
            } else {
                $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_list&page=" . $curPage . $strUrl, false);
            }
        }
    } else {
        $data['date_created'] = time();
        /*lay stt*/
        $list_numb = $d->rawQuery("select numb from table_product_list order by numb desc ", array());
        $new_numb = (!empty($list_numb)) ? $list_numb[0]['numb'] + 1 : 1;

        if ($d->insert('table_product_list', $data)) {
            $id_insert = $d->getLastInsertId();

            /*update stt*/
            $d->rawQuery("update table_product_list set numb = ? where id = " . $id_insert, array($new_numb));
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('table_product_list', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            if ($savehere) {
                $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=edit_list&page=" . $curPage . $strUrl . "&id=" . $id_insert);
            } else {
                $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_list&page=" . $curPage . $strUrl);
            }
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_list&page=" . $curPage . $strUrl, false);
        }
    }
}
/* Delete list */
function deleteList()
{
    global $d, $strUrl, $func, $curPage, $com;
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from table_product_list where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("update table_product_list set date_deleted = ? where id = ?", array(time(), $id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_list&page=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_list&page=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_REQUEST['listid'])) {
        $listid = explode(",", $_REQUEST['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from table_product_list where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("update table_product_list set date_deleted = ? where id = ?", array(time(), $id));
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_list&page=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_list&page=" . $curPage . $strUrl, false);
    }
}

/* View brand */
function viewBrands()
{
    global $d, $func, $strUrl, $curPage, $paging, $items;
    $where = "";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (name LIKE '%$keyword%')";
    }
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $items = $d->rawQuery("select * from table_product_brand where id > 0 $where and date_deleted = 0 order by numb,id desc $limit", array());
    $sqlNum = "select count(*) as 'num' from table_product_brand where id > 0 $where and date_deleted = 0 order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array());
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_brand" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit brand */
function editBrand()
{
    global $d, $func, $strUrl, $curPage, $item;
    if (!empty($_REQUEST['id']))
        $id = htmlspecialchars($_REQUEST['id']);
    else
        $id = 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_brand&page=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from table_product_brand where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transfer("Không có dữ liệu", "index.php?com=product&act=man_brand&page=" . $curPage . $strUrl, false);
        }
    }
}
/* Save brand */
function saveBrand()
{
    global $d, $strUrl, $func, $flash, $curPage;
    /* Check post */
    if (empty($_REQUEST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_brand&page=" . $curPage . $strUrl, false);
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

            if (strpos($column, 'id_brand') !== false || strpos($column, 'id_brand') !== false) {
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
    if (!empty($data['regular_price']) && !$func->isNumber($data['regular_price'])) {
        $response['messages'][] = 'Giá bán không hợp lệ';
    }
    if (!empty($data['sale_price']) && !$func->isNumber($data['sale_price'])) {
        $response['messages'][] = 'Giá mới không hợp lệ';
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
            $func->redirect("index.php?com=product&act=edit_brand&page=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=product&act=add_brand&page=" . $curPage . $strUrl);
        }
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);

        if ($d->update('table_product_brand', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from table_product_brand where id = ? limit 0,1", array($id));
                    if (!empty($row)) {
                        unlink(UPLOAD_PRODUCT . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('table_product_brand', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            if ($savehere) {
                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=edit_brand&page=" . $curPage . $strUrl . "&id=" . $id);
            } else {
                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_brand&page=" . $curPage . $strUrl);
            }
        } else {
            if ($savehere) {
                $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=edit_brand&page=" . $curPage . $strUrl . "&id=" . $id, false);
            } else {
                $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_brand&page=" . $curPage . $strUrl, false);
            }
        }
    } else {
        $data['date_created'] = time();
        /*lay stt*/
        $brand_numb = $d->rawQuery("select numb from table_product_brand order by numb desc ", array());
        $new_numb = (!empty($brand_numb)) ? $brand_numb[0]['numb'] + 1 : 1;

        if ($d->insert('table_product_brand', $data)) {
            $id_insert = $d->getLastInsertId();

            /*update stt*/
            $d->rawQuery("update table_product_brand set numb = ? where id = " . $id_insert, array($new_numb));
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('table_product_brand', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            if ($savehere) {
                $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=edit_brand&page=" . $curPage . $strUrl . "&id=" . $id_insert);
            } else {
                $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_brand&page=" . $curPage . $strUrl);
            }
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_brand&page=" . $curPage . $strUrl, false);
        }
    }
}
/* Delete brand */
function deleteBrand()
{
    global $d, $strUrl, $func, $curPage, $com;
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from table_product_brand where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("update table_product_brand set date_deleted = ? where id = ?", array(time(), $id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_brand&page=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_brand&page=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_REQUEST['listid'])) {
        $listid = explode(",", $_REQUEST['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from table_product_brand where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("update table_product_brand set date_deleted = ? where id = ?", array(time(), $id));
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_brand&page=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_brand&page=" . $curPage . $strUrl, false);
    }
}
