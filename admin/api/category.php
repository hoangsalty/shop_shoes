<?php
include "config.php";

if (!empty($_POST["id"])) {
    $table = (!empty($_POST["table"])) ? htmlspecialchars($_POST["table"]) : '';
    $id = (!empty($_POST["id"])) ? htmlspecialchars($_POST["id"]) : 0;
    $row = null;

    if ($id) {
        $row = $d->rawQuery("select name, id from $table where id_list = ? order by id desc", array($id));
    }

    $str = '<option value="0">Chọn danh mục</option>';
    if (!empty($row)) {
        foreach ($row as $v) {
            $str .= '<option value=' . $v["id"] . '>' . $v["name"] . '</option>';
        }
    }
} else {
    $str = '<option value="0">Chọn danh mục</option>';
}

echo $str;
