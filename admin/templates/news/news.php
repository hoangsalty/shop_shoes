<?php
$linkView = $configBase;
$linkMan = "index.php?com=news&act=list&type=" . $type;
$linkAdd = "index.php?com=news&act=add&type=" . $type;
$linkEdit = "index.php?com=news&act=edit&type=" . $type;

$status = array();
$name = '';
if ($type == 'tin-tuc') {
    $name = 'Tin tức';
    $status = array("noibat" => "Nổi bật", "hienthi" => "Hiển thị");
} else if ($type == 'hinh-thuc-thanh-toan') {
    $name = 'Hình thức thanh toán';
    $status = array("hienthi" => "Hiển thị");
}
?>
<!-- Main content -->
<section class="content">
    <div class="d-flex card-header text-sm">
        <a class="btn btn-sm bg-gradient-primary text-white mr-2" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="sources/news.php" data-act="delete" data-type="<?= $type ?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
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
    <div class="card card-primary card-outline text-sm">
        <div class="card-header">
            <h3 class="card-title">Danh sách <?= $name ?></h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">
                            <div class="custom-control custom-checkbox my-checkbox">
                                <input type="checkbox" class="custom-control-input" id="selectall-checkbox">
                                <label for="selectall-checkbox" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="align-middle text-center" width="75px">STT</th>
                        <?php if ($type != 'hinh-thuc-thanh-toan') { ?>
                            <th class="align-middle text-center" width="150px">Hình</th>
                        <?php } ?>
                        <th class="align-middle">Tiêu đề</th>
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
                                <?php if ($type != 'hinh-thuc-thanh-toan') { ?>
                                    <td class="align-middle">
                                        <a href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>">
                                            <?= $func->getImage(['class' => 'rounded img-preview', 'width' => 120, 'height' => 100, 'upload' => UPLOAD_NEWS_L, 'image' => $items[$i]['photo'], 'alt' => $items[$i]['name']]) ?>
                                        </a>
                                    </td>
                                <?php } ?>

                                <td class="align-middle">
                                    <a class="text-dark text-break" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>"><?= $items[$i]['name'] ?></a>
                                    <div class="tool-action mt-2 w-clear">
                                        <?php if ($type == 'tin-tuc') { ?>
                                            <a class="btn btn-primary btn-sm mr-2" href="<?= $linkView ?><?= $items[$i]['slug'] ?>" target="_blank" title="<?= $items[$i]['name'] ?>"><i class="far fa-eye mr-1"></i>View</a>
                                        <?php } ?>
                                        <a class="btn btn-info btn-sm mr-2" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>"><i class="far fa-edit mr-1"></i>Edit</a>
                                        <a class="btn btn-danger btn-sm" id="delete-item" data-id="<?= $items[$i]['id'] ?>" data-url="sources/news.php" data-act="delete" data-type="<?= $type ?>" title="<?= $items[$i]['name'] ?>"><i class="far fa-trash-alt mr-1"></i>Delete</a>
                                    </div>
                                </td>
                                <?php $status_array = (!empty($items[$i]['status'])) ? explode(',', $items[$i]['status']) : array(); ?>
                                <?php foreach ($status as $key => $value) { ?>
                                    <td class="align-middle text-center">
                                        <div class="custom-control custom-checkbox my-checkbox">
                                            <input type="checkbox" class="custom-control-input show-checkbox" id="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" data-table="table_news" data-id="<?= $items[$i]['id'] ?>" data-attr="<?= $key ?>" <?= (in_array($key, $status_array)) ? 'checked' : '' ?>>
                                            <label for="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                        </div>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php if ($paging) { ?>
        <div class="card-header text-sm pb-0"><?= $paging ?></div>
    <?php } ?>
</section>