<?php
if (!defined('SOURCES')) die("Error");

switch ($act) {
    case "man":
        viewMans();
        $template = "comment/mans";
        break;
}

function viewMans()
{
    global $d, $func, $comment, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (!empty($id)) {
        $item = $d->rawQueryOne("select * from table_product where id = ? limit 0,1", array($id));
        $comment = new Comments($d, $func, $item['id'], true);
    } else {
        $func->transfer("Trang không tồn tại", "index.php", false);
    }
}