<?php
include "config.php";

$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$listid = (!empty($_POST['listid'])) ? $func->checkInput($_POST['listid']) : '';
$cmd = (!empty($_POST['cmd'])) ? htmlspecialchars($_POST['cmd']) : '';
$table = (!empty($_POST['table'])) ? htmlspecialchars($_POST['table']) : '';


if ($cmd == 'delete' && $id > 0) {
    $row = $d->rawQueryOne("select photo from table_$table where id = ? limit 0,1", array($id));
    $path = "../../upload/product/" . $row['photo'];
    $d->rawQuery("delete from table_$table where id = ?", array($id));
} else if ($cmd == 'delete-all' && $listid != '') {
    $listid = array_map('intval', explode(',', $listid));
    $listid = implode("','", $listid);
    $row = $d->rawQuery("select id,photo from table_$table where id in ('" . $listid . "')");

    for ($i = 0; $i < count($row); $i++) {
        $path = "../../upload/product/" . $row[$i]['photo'];
        $id = $row[$i]['id'];
        $d->rawQuery("delete from table_$table where id = ?", array($id));
    }
}
