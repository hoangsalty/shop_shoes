<?php
include "config.php";

$comment = new Comments($d, $func);
echo $comment->add();
