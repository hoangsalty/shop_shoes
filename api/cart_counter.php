<?php
include "config.php";

$cmd = (!empty($_POST['cmd'])) ? htmlspecialchars($_POST['cmd']) : '';
$oldValue = (!empty($_POST['oldValue'])) ? htmlspecialchars($_POST['oldValue']) : 0;
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

if ($cmd == 'plus') {
    $newValue = $oldValue + 1;
    $quantityDB = $d->rawQueryOne("select quantity from table_product where id = ? limit 0,1", array($id));
    if (!empty($quantityDB) && $newValue > $quantityDB['quantity']) {
        $newValue = $quantityDB['quantity'];
    }

    $data = array('quantity' => $newValue);
    echo json_encode($data);
} else if ($cmd == 'minus' && $oldValue > 1) {
    $newValue = $oldValue - 1;
    $data = array('quantity' => $newValue);
    echo json_encode($data);
}
