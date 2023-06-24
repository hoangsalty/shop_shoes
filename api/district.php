<?php
include "config.php";

$province_id = (!empty($_POST['province_id'])) ? htmlspecialchars($_POST['province_id']) : 0;
$district = $func->getDistrict($province_id);

if (!empty($district)) { ?>
    <option value="0" selected disabled>Quận huyện *</option>
    <?php foreach ($district as $k => $v) {
        if ($v['ProvinceID'] == $province_id) { ?>
            <option value="<?= $v['DistrictName'] ?>__<?= $v['DistrictID'] ?>"><?= $v['DistrictName'] ?></option>
        <?php } ?>
    <?php }
} else { ?>
    <option value="0" selected disabled>Quận huyện *</option>
<?php }
?>