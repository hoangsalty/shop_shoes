<?php
include "config.php";

$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$listid = (!empty($_POST['listid'])) ? $func->checkInput($_POST['listid']) : '';
$cmd = (!empty($_POST['cmd'])) ? htmlspecialchars($_POST['cmd']) : '';

if ($cmd == 'delete' && $id > 0) {
    $row = $d->rawQueryOne("select photo from table_gallery where id = ? limit 0,1", array($id));

    $path = "../../upload/product/" . $row['photo'];

    unlink($path);

    $d->rawQuery("delete from table_gallery where id = ?", array($id));
} else if ($cmd == 'delete-all' && $listid != '') {
    $listid = explode(",", $listid);
    $cols = ["id", "photo"];
    $d->where('id', $listid, 'IN');
    $row = $d->get("table_gallery", null, $cols);

    for ($i = 0; $i < count($row); $i++) {
        $path = "../../upload/product/" . $row[$i]['photo'];

        unlink($path);

        $id = $row[$i]['id'];
        $d->rawQuery("delete from table_gallery where id = ?", array($id));
    }
}
