<?php
include "config.php";

$id_district = (!empty($_POST['id_district'])) ? htmlspecialchars($_POST['id_district']) : 0;
$ward = $d->rawQuery("select name, id from table_ward where id_district = ? order by id asc", array($id_district));

if (!empty($ward)) { ?>
    <option value="0">Chọn danh mục</option>
    <?php foreach ($ward as $k => $v) { ?>
        <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
    <?php }
} else { ?>
    <option value="0">Chọn danh mục</option>
<?php }
?>