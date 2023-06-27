<?php
if (!defined('SOURCES')) {
    require_once "../api/config.php";
    /* die("Error"); */
}

$act = (isset($_REQUEST['act'])) ? htmlspecialchars($_REQUEST['act']) : '';
$cur_Page = (isset($_REQUEST['cur_Page'])) ? htmlspecialchars($_REQUEST['cur_Page']) : '';

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('id_list', 'id_cat', 'id_brand');
if (isset($_POST['data'])) {
    $dataUrl = isset($_POST['data']) ? $_POST['data'] : null;
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
        /* Product */
    case "list":
        viewProducts();
        $template = "product/products";
        break;
    case "add":
        $template = "product/product_add";
        break;
    case "edit":
        editProduct();
        $template = "product/product_add";
        break;
    case "save":
        saveProduct();
        break;
    case "delete":
        deleteProduct();
        break;

        /* List */
    case "list_list":
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

        /* Cat */
    case "list_cat":
        viewCats();
        $template = "product/cat/cats";
        break;
    case "add_cat":
        $template = "product/cat/cat_add";
        break;
    case "edit_cat":
        editCat();
        $template = "product/cat/cat_add";
        break;
    case "save_cat":
        saveCat();
        break;
    case "delete_cat":
        deleteCat();
        break;

        /* Size */
    case "list_size":
        viewSizes();
        $template = "product/size/sizes";
        break;
    case "add_size":
        $template = "product/size/size_add";
        break;
    case "edit_size":
        editSize();
        $template = "product/size/size_add";
        break;
    case "save_size":
        saveSize();
        break;
    case "delete_size":
        deleteSize();
        break;

        /* Color */
    case "list_color":
        viewColors();
        $template = "product/color/colors";
        break;
    case "add_color":
        $template = "product/color/color_add";
        break;
    case "edit_color":
        editColor();
        $template = "product/color/color_add";
        break;
    case "save_color":
        saveColor();
        break;
    case "delete_color":
        deleteColor();
        break;
}

/* View man */
function viewProducts()
{
    global $d, $func, $strUrl, $curPage, $paging, $items, $comment;
    $where = "";
    $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
    $idbrand = (isset($_REQUEST['id_brand'])) ? htmlspecialchars($_REQUEST['id_brand']) : 0;
    $comment_status = (!empty($_REQUEST['comment_status'])) ? htmlspecialchars($_REQUEST['comment_status']) : '';

    if ($idlist) $where .= " and id_list=$idlist";
    if ($idcat) $where .= " and id_cat=$idcat";
    if ($idbrand) $where .= " and id_brand=$idbrand";

    if ($comment_status == 'new') {
        $comment = $d->rawQuery("select distinct id_parent from table_comment where find_in_set('new-admin',status)", array());
        $idcomment = (!empty($comment)) ? $func->joinCols($comment, 'id_parent') : 0;
        $where .= " and id in ($idcomment)";
    }


    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (name LIKE '%$keyword%')";
    }
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $items = $d->rawQuery("select * from table_product where id > 0 $where order by id desc $limit", array());
    $sqlNum = "select count(*) as 'num' from table_product where id > 0 $where order by id desc";
    $count = $d->rawQueryOne($sqlNum, array());
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=list" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
    /* Comment */
    $comment = new Comments($d, $func);
}
/* Edit man */
function editProduct()
{
    global $d, $func, $strUrl, $curPage, $item, $gallery;

    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if (empty($id)) {
        $func->transferAdmin("Không nhận được dữ liệu", "index.php?com=product&act=list&page=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from table_product where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transferAdmin("Không có dữ liệu", "index.php?com=product&act=list&page=" . $curPage . $strUrl, false);
        } else {
            $gallery = $d->rawQuery("select * from table_gallery where id_parent = ? order by id desc", array($id));
        }
    }
}
/* Save man */
function saveProduct()
{
    global $d, $strUrl, $func, $cur_Page;

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    $data = (!empty($_REQUEST['data'])) ? $_REQUEST['data'] : null;
    $dataColor = (!empty($_POST['dataColor'])) ? $_POST['dataColor'] : null;
    $dataSize = (!empty($_POST['dataSize'])) ? $_POST['dataSize'] : null;

    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->checkInput($value));

            if (strpos($column, 'id_list') !== false || strpos($column, 'id_cat') !== false || strpos($column, 'id_brand') !== false) {
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
        /* Errors */
        $response['status'] = 404;
        if ($id) {
            $response['link'] = "index.php?com=product&act=edit" . $strUrl . "&id=" . $id;
        } else {
            $response['link'] = "index.php?com=product&act=add" . $strUrl;
        }
        $message = json_encode($response);
        echo $message;
        return;
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);

        if ($d->update('table_product', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('table_product', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            if (!empty($dataSize)) {
                $d->rawQuery("delete from table_product_size where id_product = ?", array($id));

                $dataSale_detail = array(
                    'id' => 'id_size',
                    'data' => $dataSize
                );

                foreach ($dataSale_detail['data'] as $v_sale) {
                    $dataSale = array(
                        'id_product' => $id,
                        $dataSale_detail['id'] => $v_sale
                    );

                    $d->insert('table_product_size', $dataSale);
                }
            } else {
                $d->rawQuery("delete from table_product_size where id_product = ?", array($id));
            }

            if (!empty($dataColor)) {
                $d->rawQuery("delete from table_product_color where id_product = ?", array($id));

                $dataSale_detail = array(
                    'id' => 'id_color',
                    'data' => $dataColor
                );

                foreach ($dataSale_detail['data'] as $v_sale) {
                    $dataSale = array(
                        'id_product' => $id,
                        $dataSale_detail['id'] => $v_sale
                    );

                    $d->insert('table_product_color', $dataSale);
                }
            } else {
                $d->rawQuery("delete from table_product_color where id_product = ?", array($id));
            }

            $response['status'] = 200;
            $response['messages'][] = 'Cập nhật dữ liệu thành công';
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Cập nhật dữ liệu bị lỗi';
        }
        $response['link'] = "index.php?com=product&act=edit" . $strUrl . "&id=" . $id;
    } else {
        $data['date_created'] = time();

        if ($d->insert('table_product', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('table_product', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $galleryFiles = (!empty($_FILES['files'])) ? $_FILES['files'] : array();
            /* Gallery */
            if (!empty($galleryFiles)) {
                for ($index = 0; $index < count($galleryFiles['name']); $index++) {
                    $_FILES['file_gallery'] = array(
                        'name' => $galleryFiles['name'][$index],
                        'type' => $galleryFiles['type'][$index],
                        'tmp_name' => $galleryFiles['tmp_name'][$index],
                        'error' => $galleryFiles['error'][$index],
                        'size' => $galleryFiles['size'][$index]
                    );

                    /* Xử lý lưu image */
                    $data_file = array();
                    $data_file['id_parent'] = $id_insert;
                    $data_file['status'] = 'hienthi';
                    $data_file['date_created'] = time();

                    if ($d->insert('table_gallery', $data_file)) {
                        $id_phot_inserted = $d->getLastInsertId();

                        if ($func->hasFile("file_gallery")) {
                            $photoUpdate = array();
                            if ($photo = $func->uploadImage("file_gallery", UPLOAD_PRODUCT)) {
                                $photoUpdate['photo'] = $photo;
                                $d->where('id', $id_phot_inserted);
                                $d->update('table_gallery', $photoUpdate);
                                unset($photoUpdate);
                                unset($_FILES['file_gallery']);
                            }
                        }
                    }
                }
            }

            if (!empty($dataSize)) {
                $d->rawQuery("delete from table_product_size where id_product = ?", array($id_insert));

                $dataSale_detail = array(
                    'id' => 'id_size',
                    'data' => $dataSize
                );

                foreach ($dataSale_detail['data'] as $v_sale) {
                    $dataSale = array(
                        'id_product' => $id_insert,
                        $dataSale_detail['id'] => $v_sale
                    );

                    $d->insert('table_product_size', $dataSale);
                }
            } else {
                $d->rawQuery("delete from table_product_size where id_product = ?", array($id_insert));
            }

            if (!empty($dataColor)) {
                $d->rawQuery("delete from table_product_color where id_product = ?", array($id_insert));

                $dataSale_detail = array(
                    'id' => 'id_color',
                    'data' => $dataColor
                );

                foreach ($dataSale_detail['data'] as $v_sale) {
                    $dataSale = array(
                        'id_product' => $id_insert,
                        $dataSale_detail['id'] => $v_sale
                    );

                    $d->insert('table_product_color', $dataSale);
                }
            } else {
                $d->rawQuery("delete from table_product_color where id_product = ?", array($id_insert));
            }

            $response['status'] = 200;
            $response['messages'][] = 'Lưu dữ liệu thành công';
            $response['link'] = "index.php?com=product&act=edit" . $strUrl . "&id=" . $id_insert;
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Lưu dữ liệu thất bại';
            $response['link'] = "index.php?com=product&act=list&page=" . $cur_Page . $strUrl;
        }
    }

    $message = json_encode($response);
    echo $message;
    return;
}
/* Delete man */
function deleteProduct()
{
    global $d, $strUrl, $func, $cur_Page;

    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from table_product where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("delete from table_product_color where id_product = ?", array($id));
            $d->rawQuery("delete from table_product_size where id_product = ?", array($id));
            $d->rawQuery("delete from table_product where id = ?", array($id));
            $d->rawQuery("delete from table_gallery where id_parent = ?", array($id));

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
            $row = $d->rawQueryOne("select id, photo from table_product where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("delete from table_product_color where id_product = ?", array($id));
                $d->rawQuery("delete from table_product_size where id_product = ?", array($id));
                $d->rawQuery("delete from table_product where id = ?", array($id));
                $d->rawQuery("delete from table_gallery where id_parent = ?", array($id));
            }
        }
        $response['status'] = 200;
        $response['messages'][] = 'Xóa dữ liệu thành công';
    } else {
        $response['status'] = 404;
        $response['messages'][] = 'Không nhận được dữ liệu';
    }

    $response['link'] = "index.php?com=product&act=list&page=" . $cur_Page . $strUrl;
    $message = json_encode($response);
    echo $message;
    return;
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
    $items = $d->rawQuery("select * from table_product_list where id > 0 $where order by id desc $limit", array());
    $sqlNum = "select count(*) as 'num' from table_product_list where id > 0 $where order by id desc";
    $count = $d->rawQueryOne($sqlNum, array());
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=list_list" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit list */
function editList()
{
    global $d, $func, $strUrl, $curPage, $item;

    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if (empty($id)) {
        $func->transferAdmin("Không nhận được dữ liệu", "index.php?com=product&act=list_list&page=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from table_product_list where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transferAdmin("Không có dữ liệu", "index.php?com=product&act=list_list&page=" . $curPage . $strUrl, false);
        }
    }
}
/* Save list */
function saveList()
{
    global $d, $strUrl, $func, $curPage;

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
            $response['link'] = "index.php?com=product&act=edit_list" . $strUrl . "&id=" . $id;
        } else {
            $response['link'] = "index.php?com=product&act=add_list" . $strUrl;
        }
        $message = json_encode($response);
        echo $message;
        return;
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);

        if ($d->update('table_product_list', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('table_product_list', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $response['status'] = 200;
            $response['messages'][] = 'Cập nhật dữ liệu thành công';
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Cập nhật dữ liệu bị lỗi';
        }
        $response['link'] = "index.php?com=product&act=edit_list" . $strUrl . "&id=" . $id;
    } else {
        $data['date_created'] = time();

        if ($d->insert('table_product_list', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('table_product_list', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $response['status'] = 200;
            $response['messages'][] = 'Lưu dữ liệu thành công';
            $response['link'] = "index.php?com=product&act=edit_list" . $strUrl . "&id=" . $id_insert;
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Lưu dữ liệu thất bại';
            $response['link'] = "index.php?com=product&act=list_list&page=" . $curPage . $strUrl;
        }
    }

    $message = json_encode($response);
    echo $message;
    return;
}
/* Delete list */
function deleteList()
{
    global $d, $strUrl, $func, $cur_Page;

    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from table_product_list where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("delete from table_product_list where id = ?", array($id));

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
            $row = $d->rawQueryOne("select id, photo from table_product_list where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("delete from table_product_list where id = ?", array($id));
            }
        }
        $response['status'] = 200;
        $response['messages'][] = 'Xóa dữ liệu thành công';
    } else {
        $response['status'] = 404;
        $response['messages'][] = 'Không nhận được dữ liệu';
    }

    $response['link'] = "index.php?com=product&act=list_list&page=" . $cur_Page . $strUrl;
    $message = json_encode($response);
    echo $message;
    return;
}

/* View cat */
function viewCats()
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
    $items = $d->rawQuery("select * from table_product_cat where id > 0 $where order by id desc $limit", array());
    $sqlNum = "select count(*) as 'num' from table_product_cat where id > 0 $where order by id desc";
    $count = $d->rawQueryOne($sqlNum, array());
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=list_cat" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit cat */
function editCat()
{
    global $d, $func, $strUrl, $curPage, $item;

    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if (empty($id)) {
        $func->transferAdmin("Không nhận được dữ liệu", "index.php?com=product&act=list_cat&page=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from table_product_cat where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transferAdmin("Không có dữ liệu", "index.php?com=product&act=list_cat&page=" . $curPage . $strUrl, false);
        }
    }
}
/* Save cat */
function saveCat()
{
    global $d, $strUrl, $func, $curPage;

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    $data = (!empty($_REQUEST['data'])) ? $_REQUEST['data'] : null;

    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->checkInput($value));

            if (strpos($column, 'id_list') !== false) {
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
            $response['link'] = "index.php?com=product&act=edit_cat" . $strUrl . "&id=" . $id;
        } else {
            $response['link'] = "index.php?com=product&act=add_cat" . $strUrl;
        }
        $message = json_encode($response);
        echo $message;
        return;
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);

        if ($d->update('table_product_cat', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('table_product_cat', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $response['status'] = 200;
            $response['messages'][] = 'Cập nhật dữ liệu thành công';
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Cập nhật dữ liệu bị lỗi';
        }
        $response['link'] = "index.php?com=product&act=edit_cat" . $strUrl . "&id=" . $id;
    } else {
        $data['date_created'] = time();

        if ($d->insert('table_product_cat', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('table_product_cat', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $response['status'] = 200;
            $response['messages'][] = 'Lưu dữ liệu thành công';
            $response['link'] = "index.php?com=product&act=edit_cat" . $strUrl . "&id=" . $id_insert;
        } else {
            $response['status'] = 404;
            $response['messages'][] = 'Lưu dữ liệu thất bại';
            $response['link'] = "index.php?com=product&act=list_cat&page=" . $curPage . $strUrl;
        }
    }

    $message = json_encode($response);
    echo $message;
    return;
}
/* Delete cat */
function deleteCat()
{
    global $d, $strUrl, $func, $cur_Page;

    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from table_product_cat where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("delete from table_product_cat where id = ?", array($id));

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
            $row = $d->rawQueryOne("select id, photo from table_product_cat where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("delete from table_product_cat where id = ?", array($id));
            }
        }
        $response['status'] = 200;
        $response['messages'][] = 'Xóa dữ liệu thành công';
    } else {
        $response['status'] = 404;
        $response['messages'][] = 'Không nhận được dữ liệu';
    }

    $response['link'] = "index.php?com=product&act=list_cat&page=" . $cur_Page . $strUrl;
    $message = json_encode($response);
    echo $message;
    return;
}

/* View size */
function viewSizes()
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
    $items = $d->rawQuery("select * from table_size where id > 0 $where order by id desc $limit", array());
    $sqlNum = "select count(*) as 'num' from table_size where id > 0 $where order by id desc";
    $count = $d->rawQueryOne($sqlNum, array());
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=list_size" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit size */
function editSize()
{
    global $d, $func;

    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    $item = $d->rawQueryOne("select * from table_size where id = ? limit 0,1", array($id));

    echo json_encode($item);
    return;
}
/* Save size */
function saveSize()
{
    global $d, $func;

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    $data = (!empty($_REQUEST['data'])) ? $_REQUEST['data'] : null;

    if ($data) {
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

    if (!empty($response)) {
        /* Errors */
        $response['status'] = 404;
        $message = json_encode($response);
        echo $message;
        return;
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);

        if ($d->update('table_size', $data)) {
            $response['messages'][] = 'Cập nhật dữ liệu thành công';
            $response['status'] = 200;
        } else {
            $response['messages'][] = 'Cập nhật dữ liệu bị lỗi';
            $response['status'] = 404;
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('table_size', $data)) {
            $id_insert = $d->getLastInsertId();

            $response['messages'][] = 'Lưu dữ liệu thành công';
            $response['status'] = 200;
        } else {
            $response['messages'][] = 'Lưu dữ liệu bị lỗi';
            $response['status'] = 404;
        }
    }

    $message = json_encode($response);
    echo $message;
    return;
}
/* Delete size */
function deleteSize()
{
    global $d, $strUrl, $func, $cur_Page;

    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id from table_size where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("delete from table_size where id = ?", array($id));

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
            $row = $d->rawQueryOne("select id from table_size where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("delete from table_size where id = ?", array($id));
            }
        }
        $response['status'] = 200;
        $response['messages'][] = 'Xóa dữ liệu thành công';
    } else {
        $response['status'] = 404;
        $response['messages'][] = 'Không nhận được dữ liệu';
    }

    $response['link'] = "index.php?com=product&act=list_size&page=" . $cur_Page . $strUrl;
    $message = json_encode($response);
    echo $message;
    return;
}


/* View color */
function viewColors()
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
    $items = $d->rawQuery("select * from table_color where id > 0 $where order by id desc $limit", array());
    $sqlNum = "select count(*) as 'num' from table_color where id > 0 $where order by id desc";
    $count = $d->rawQueryOne($sqlNum, array());
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=list_color" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit color */
function editColor()
{
    global $d, $func;

    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    $item = $d->rawQueryOne("select * from table_color where id = ? limit 0,1", array($id));

    echo json_encode($item);
    return;
}
/* Save color */
function saveColor()
{
    global $d, $func;

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
        $message = json_encode($response);
        echo $message;
        return;
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);

        if ($d->update('table_color', $data)) {
            $response['messages'][] = 'Cập nhật dữ liệu thành công';
            $response['status'] = 200;
        } else {
            $response['messages'][] = 'Cập nhật dữ liệu bị lỗi';
            $response['status'] = 404;
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('table_color', $data)) {
            $id_insert = $d->getLastInsertId();

            $response['messages'][] = 'Lưu dữ liệu thành công';
            $response['status'] = 200;
        } else {
            $response['messages'][] = 'Lưu dữ liệu bị lỗi';
            $response['status'] = 404;
        }
    }

    $message = json_encode($response);
    echo $message;
    return;
}
/* Delete color */
function deleteColor()
{
    global $d, $strUrl, $func, $cur_Page;

    $message = '';
    $response = array();
    $id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id from table_color where id = ? limit 0,1", array($id));
        if (!empty($row)) {
            $d->rawQuery("delete from table_color where id = ?", array($id));

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
            $row = $d->rawQueryOne("select id from table_color where id = ? limit 0,1", array($id));
            if (!empty($row)) {
                $d->rawQuery("delete from table_color where id = ?", array($id));
            }
        }
        $response['status'] = 200;
        $response['messages'][] = 'Xóa dữ liệu thành công';
    } else {
        $response['status'] = 404;
        $response['messages'][] = 'Không nhận được dữ liệu';
    }

    $response['link'] = "index.php?com=product&act=list_color&page=" . $cur_Page . $strUrl;
    $message = json_encode($response);
    echo $message;
    return;
}
