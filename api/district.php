<?php
include "config.php";

$id_city = (!empty($_POST['id_city'])) ? htmlspecialchars($_POST['id_city']) : 0;
$district = $d->rawQuery("select name, id from table_district where id_city = ? order by id asc", array($id_city));

if (!empty($district)) { ?>
    <option value="0" selected disabled>Quận huyện *</option>
    <?php foreach ($district as $k => $v) { ?>
        <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
    <?php }
} else { ?>
    <option value="0" selected disabled>Quận huyện *</option>
<?php }
?>