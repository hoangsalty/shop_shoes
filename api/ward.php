<?php
include "config.php";

$district_id = (!empty($_POST['district_id'])) ? htmlspecialchars($_POST['district_id']) : 0;
$ward = $func->getWard($district_id);

if (!empty($ward)) { ?>
    <option value="0" selected disabled>Phường xã *</option>
    <?php foreach ($ward as $k => $v) {
        if ($v['DistrictID'] == $district_id) { ?>
            <option value="<?= $v['WardName'] ?>__<?= $v['WardCode'] ?>"><?= $v['WardName'] ?></option>
        <?php } ?>
    <?php }
} else { ?>
    <option value="0" selected disabled>Phường xã *</option>
<?php }
?>