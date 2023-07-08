<?php
$linkView = $configBase;
$linkList = "index.php?com=product&act=list";
$linkAdd = "index.php?com=product&act=add";
$linkEdit = "index.php?com=product&act=edit";
$linkComment = "index.php?com=comment&act=list";

$status = array("noibat" => "Nổi bật", "hienthi" => "Hiển thị");
?>

<!-- Main content -->
<section class="content">
    <div class="d-flex card-header text-sm">
        <a class="btn btn-sm bg-gradient-primary text-white mr-2" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="sources/product.php" data-act="delete" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
        <div class="form-inline form-search d-inline-block align-middle ml-auto">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="Tìm kiếm" aria-label="Tìm kiếm" value="<?= (isset($_GET['keyword'])) ? $_GET['keyword'] : '' ?>" onkeypress="doEnter(event,'keyword','<?= $linkList ?>')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','<?= $linkList ?>')">
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
                <th class="align-middle text-center" width="75px">STT</th>
                <th class="align-middle text-center" width="150px">Hình</th>
                <th class="align-middle">Tiêu đề</th>
                <th class="align-middle">Giá</th>
                <th class="align-middle">Giá mới</th>
                <th class="align-middle">Số lượng</th>
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
                <?php for ($i = 0; $i < count($items); $i++) {
                    $linkID = "";
                    if ($items[$i]['id_list']) $linkID .= "&id_list=" . $items[$i]['id_list'];
                    if ($items[$i]['id_cat']) $linkID .= "&id_cat=" . $items[$i]['id_cat']; ?>
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
                            <a href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>">
                                <?= $func->getImage(['class' => 'rounded img-preview', 'width' => 120, 'height' => 100, 'upload' => UPLOAD_PRODUCT_L, 'image' => $items[$i]['photo']]) ?>
                            </a>
                        </td>
                        <td class="align-middle">
                            <a class="text-dark text-break" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>"><?= $items[$i]['name'] ?></a>
                            <div class="tool-action mt-2 w-clear">
                                <?php
                                $items[$i]['totalComment'] = $comment->totalByID($items[$i]['id'], true);
                                $items[$i]['newComment'] = $comment->newPost($items[$i]['id'], 'new-admin');
                                ?>
                                <a class="btn btn-primary btn-sm mr-2" href="<?= $linkComment ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>"><i class="fas fa-comments mr-1"></i>(<?= $items[$i]['totalComment'] ?>) Comment <?= (!empty($items[$i]['newComment'])) ? '<span class="badge badge-danger align-top">' . $items[$i]['newComment'] . '</span>' : '' ?></a>
                                <a class="btn btn-primary btn-sm mr-2" href="<?= $linkView ?><?= $items[$i]['slug'] ?>" target="_blank" title="<?= $items[$i]['name'] ?>"><i class="far fa-eye mr-1"></i>View</a>
                                <a class="btn btn-info btn-sm mr-2" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>"><i class="far fa-edit mr-1"></i>Edit</a>
                                <a class="btn btn-danger btn-sm" id="delete-item" data-id="<?= $items[$i]['id'] ?>" data-url="sources/product.php" data-act="delete" title="<?= $items[$i]['name'] ?>"><i class="far fa-trash-alt mr-1"></i>Delete</a>
                            </div>
                        </td>
                        <td class="align-middle">
                            <a class="text-dark text-break" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $func->formatMoney($items[$i]['regular_price']) ?>"><?= $func->formatMoney($items[$i]['regular_price']) ?></a>
                        </td>
                        <td class="align-middle">
                            <a class="text-dark text-break" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $func->formatMoney($items[$i]['sale_price']) ?>"><?= $func->formatMoney($items[$i]['sale_price']) ?></a>
                        </td>
                        <td class="align-middle">
                            <a class="text-dark text-break" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['quantity'] ?>"><?= $items[$i]['quantity'] ?></a>
                        </td>
                        <?php $status_array = (!empty($items[$i]['status'])) ? explode(',', $items[$i]['status']) : array(); ?> <?php foreach ($status as $key => $value) { ?> <td class="align-middle text-center">
                                <div class="custom-control custom-checkbox my-checkbox">
                                    <input type="checkbox" class="custom-control-input show-checkbox" id="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" data-table="table_product" data-id="<?= $items[$i]['id'] ?>" data-attr="<?= $key ?>" <?= (in_array($key, $status_array)) ? 'checked' : '' ?>>
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