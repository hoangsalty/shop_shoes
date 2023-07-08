<?php
$linkMan = "index.php?com=photo&act=man_photo&type=" . $type;
$linkAdd = "index.php?com=photo&act=add_photo&type=" . $type;
$linkEdit = "index.php?com=photo&act=edit_photo&type=" . $type;

$status = array("hienthi" => "Hiển thị");
?>
<!-- Main content -->
<section class="content">
    <div class="card-header text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="sources/photo.php" data-act="delete_photo" data-type="<?= $type ?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th class="align-middle" width="5%">
                    <div class="custom-control custom-checkbox my-checkbox">
                        <input type="checkbox" class="custom-control-input" id="selectall-checkbox">
                        <label for="selectall-checkbox" class="custom-control-label"></label>
                    </div>
                </th>
                <th class="align-middle text-center" width="10%">STT</th>
                <th class="align-middle text-center" width="8%">Hình</th>
                <th class="align-middle" style="width:20%">Tiêu đề</th>
                <?php if ($type != 'video') { ?>
                    <th class="align-middle">Link</th>
                <?php } ?>
                <?php if ($type == 'video') { ?>
                    <th class="align-middle">Link video</th>
                <?php } ?>
                <?php foreach ($status as $key => $value) { ?>
                    <th class="align-middle text-center"><?= $value ?></th>
                <?php } ?>
            </tr>
        </thead>
        <?php if (empty($items)) { ?>
            <tbody>
                <tr>
                    <td colspan="100" class="text-center">Không có dữ liệu</td>
                </tr>
            </tbody>
        <?php } else { ?>
            <tbody>
                <?php for ($i = 0; $i < count($items); $i++) { ?>
                    <tr>
                        <td class="align-middle">
                            <div class="custom-control custom-checkbox my-checkbox">
                                <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?= $items[$i]['id'] ?>" value="<?= $items[$i]['id'] ?>">
                                <label for="select-checkbox-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                            </div>
                        </td>
                        <td class="align-middle text-center">
                            <?= $i + 1 ?>
                        </td>
                        <td class="align-middle text-center">
                            <a href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>">
                                <?= $func->getImage(['class' => 'rounded img-preview', 'width' => 120, 'height' => 100, 'upload' => UPLOAD_PHOTO_L, 'image' => $items[$i]['photo']]) ?>
                            </a>
                        </td>
                        <td class="align-middle">
                            <a class="text-dark text-break" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>"><?= $items[$i]['name'] ?></a>
                            <div class="tool-action mt-2 w-clear">
                                <a class="btn btn-info btn-sm mr-2" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>"><i class="far fa-edit mr-1"></i>Edit</a>
                                <a class="btn btn-danger btn-sm" id="delete-item" data-id="<?= $items[$i]['id'] ?>" data-url="sources/photo.php" data-act="delete_photo" data-type="<?= $type ?>" title="<?= $items[$i]['name'] ?>"><i class="far fa-trash-alt mr-1"></i>Delete</a>
                            </div>
                        </td>

                        <?php if ($type != 'video') { ?>
                            <td class="align-middle"><?= $items[$i]['link'] ?></td>
                        <?php } ?>

                        <?php if ($type == 'video') { ?>
                            <td class="align-middle"><?= $items[$i]['link_video'] ?></td>
                        <?php } ?>

                        <?php $status_array = (!empty($items[$i]['status'])) ? explode(',', $items[$i]['status']) : array(); ?>
                        <?php foreach ($status as $key => $value) { ?>
                            <td class="align-middle text-center">
                                <div class="custom-control custom-checkbox my-checkbox">
                                    <input type="checkbox" class="custom-control-input show-checkbox" id="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" data-table="table_photo" data-id="<?= $items[$i]['id'] ?>" data-attr="<?= $key ?>" <?= (in_array($key, $status_array)) ? 'checked' : '' ?>>
                                    <label for="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                </div>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
    <?php if ($paging) { ?>
        <div class="card-header text-sm pb-0">
            <?= $paging ?>
        </div>
    <?php } ?>
</section>