<?php
include "config.php";

/* Xử lý params */
$flag = true;
$params = (!empty($_POST['params'])) ? $_POST['params'] : null;
if ($params) parse_str($params, $params);
$id = (!empty($params['id'])) ? $params['id'] : 0;
$com = (!empty($params['com'])) ? $params['com'] : '';
$numb = (!empty($_POST['numb'])) ? (int)$_POST['numb'] : 0;
$data = array('success' => true, 'msg' => 'Upload thành công');

/* Xử lý $_FILE - Path image */
$myFile = (!empty($_FILES['files'])) ? $_FILES['files'] : null;
$_FILES['file'] = array('name' => $myFile['name'][0], 'type' => $myFile['type'][0], 'tmp_name' => $myFile['tmp_name'][0], 'error' => $myFile['error'][0], 'size' => $myFile['size'][0]);
$file_name = $func->uploadName($_FILES['file']['name']);

/* Xử lý lưu image */
$data_file = array();

$data_file['numb'] = 0;
$data_file['name'] = "";
$data_file['id_parent'] = $id;
$data_file['status'] = 'hienthi';
$data_file['date_created'] = time();
$max_numb = $d->rawQueryOne("select max(numb) as max_numb from table_gallery where id_parent = ?", array($id));
$data_file['numb'] = $max_numb['max_numb'] + 1;

if ($d->insert('table_gallery', $data_file)) {
    $id_insert = $d->getLastInsertId();

    if ($func->hasFile("file")) {
        $photoUpdate = array();

        if ($photo = $func->uploadImage("file", '../' . UPLOAD_PRODUCT, $file_name)) {
            $photoUpdate['photo'] = $photo;
            $d->where('id', $id_insert);
            $d->update('table_gallery', $photoUpdate);
            unset($photoUpdate);
        }
    }
} else {
    $flag = false;
}

if (!$flag) {
    $data = array('success' => false, 'msg' => 'Upload thất bại');
}

echo json_encode($data);
