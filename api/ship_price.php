<?php
include "config.php";

$district_id = (!empty($_POST['district_id'])) ? htmlspecialchars($_POST['district_id']) : 0;
$ward_id = (!empty($_POST['ward_id'])) ? htmlspecialchars($_POST['ward_id']) : 0;
$ship_price = $func->getGHNShipPrice($district_id, $ward_id);

echo $ship_price;
