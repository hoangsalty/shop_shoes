<?php
$linkView = $configBase;
$linkMan = "index.php?com=product&act=man_color";

$status = array("hienthi" => "Hiển thị");
?>

<!-- Main content -->
<section class="content">
    <div class="d-flex card-header text-sm">
        <a class="btn btn-sm bg-gradient-primary text-white mr-2" type="button" data-bs-toggle="modal" data-bs-target="#popup_product_color" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="sources/product.php" data-act="delete_color" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
        <div class="form-inline form-search d-inline-block align-middle ml-auto">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="Tìm kiếm" aria-label="Tìm kiếm" value="<?= (isset($_GET['keyword'])) ? $_GET['keyword'] : '' ?>" onkeypress="doEnter(event,'keyword','<?= $linkMan ?>')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','<?= $linkMan ?>')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
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
                <th class="align-middle text-center" width="5%">STT</th>
                <th class="align-middle" style="width:30%">Tiêu đề</th>
                <th class="align-middle" style="width:30%">Màu</th>
                <?php foreach ($status as $key => $value) { ?>
                    <th class="align-middle text-center" width="120px"><?= $value ?></th>
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
                        <td class="align-middle">
                            <span class="text-dark text-break" title="<?= $items[$i]['name'] ?>"><?= $items[$i]['name'] ?></span>
                            <div class="tool-action mt-2 w-clear">
                                <a class="btn btn-info btn-sm mr-2" id="edit-color" data-id="<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>"><i class="far fa-edit mr-1"></i>Edit</a>
                                <a class="btn btn-danger btn-sm" id="delete-item" data-id="<?= $items[$i]['id'] ?>" data-url="sources/product.php" data-act="delete_color" title="<?= $items[$i]['name'] ?>"><i class="far fa-trash-alt mr-1"></i>Delete</a>
                            </div>
                        </td>
                        <td class="align-middle">
                            <span class="d-block w-100" style="border-radius:10px; height:40px; background-color: <?= $items[$i]['color'] ?>;" title="<?= $items[$i]['name'] ?>"></span>
                        </td>
                        <?php $status_array = (!empty($items[$i]['status'])) ? explode(',', $items[$i]['status']) : array(); ?>
                        <?php foreach ($status as $key => $value) { ?>
                            <td class="align-middle text-center">
                                <div class="custom-control custom-checkbox my-checkbox">
                                    <input type="checkbox" class="custom-control-input show-checkbox" id="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" data-table="table_color" data-id="<?= $items[$i]['id'] ?>" data-attr="<?= $key ?>" <?= (in_array($key, $status_array)) ? 'checked' : '' ?>>
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
        <div class="card-header text-sm pb-0"><?= $paging ?></div>
    <?php } ?>
</section>