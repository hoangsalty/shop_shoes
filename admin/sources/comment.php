<?php
if (!defined('SOURCES')) die("Error");

switch ($act) {
    case "list":
        viewMans();
        $template = "comment/comments";
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
        header('HTTP/1.0 404 Not Found', true, 404);
        include("404.php");
        exit;
    }
}
