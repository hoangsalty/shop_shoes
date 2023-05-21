<?php
include "config.php";

$type = (!empty($_POST['type'])) ? htmlspecialchars($_POST['type']) : 0;

$comment = new Comments($d, $func);
if ($type == 'status') {
    echo $comment->status();
} else if ($type == 'delete') {
    echo $comment->delete();
}
