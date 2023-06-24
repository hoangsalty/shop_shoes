<?php
$linkMan = "index.php?com=user&act=man";
$linkAdd = "index.php?com=user&act=add";
$linkEdit = "index.php?com=user&act=edit";
?>
<!-- Main content -->
<section class="content">
    <div class="d-flex card-header text-sm">
        <a class="btn btn-sm bg-gradient-primary text-white mr-2" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="sources/user.php" data-act="delete" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
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
            <h3 class="card-title">Danh sách tài khoản</h3>

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
                        <th class="align-middle text-center" width="10%">STT</th>
                        <th class="align-middle">Tài khoản</th>
                        <th class="align-middle">Họ tên</th>
                        <th class="align-middle">Email</th>
                        <th class="align-middle">Nhóm quyền</th>
                        <th class="align-middle text-center">Trạng thái</th>
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
                                    <a class="text-dark text-break" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['username'] ?>"><?= $items[$i]['username'] ?></a>
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['fullname'] ?>"><?= $items[$i]['fullname'] ?></a>
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['email'] ?>"><?= $items[$i]['email'] ?></a>
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $func->getPermissionName($items[$i]['permission']) ?>"><?= $func->getPermissionName($items[$i]['permission']) ?></a>
                                </td>
                                <td class="align-middle text-center">
                                    <?php if ($items[$i]['status'] == 'hoatdong') { ?>
                                        <span class="badge bg-success">Hoạt động</span>
                                    <?php } else if ($items[$i]['status'] == 'khoa') { ?>
                                        <span class="badge bg-danger">Khóa</span>
                                    <?php } else if ($items[$i]['status'] == 'kichhoat') { ?>
                                        <span class="badge bg-warning">Chưa kích hoạt</span>
                                    <?php } ?>
                                </td>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a class="btn btn-primary btn-sm mr-2" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-danger btn-sm" id="delete-item" data-id="<?= $items[$i]['id'] ?>" data-url="sources/user.php" data-act="delete" title="<?= $items[$i]['fullname'] ?>"><i class="far fa-trash-alt mr-1"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php if ($paging) { ?>
        <div class="card-header text-sm pb-0">
            <?= $paging ?>
        </div>
    <?php } ?>
</section>