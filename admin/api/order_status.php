<?php
include "config.php";

if (!empty($_POST['id'])) {
    $table = (!empty($_POST['table'])) ? htmlspecialchars($_POST['table']) : '';
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $newstatus = (!empty($_POST['newstatus'])) ? htmlspecialchars($_POST['newstatus']) : '';

    $data = array();
    $data['order_status'] = (!empty($newstatus)) ? $newstatus : "";
    $d->where('id', $id);
    $d->update($table, $data);
}
