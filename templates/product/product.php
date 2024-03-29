<div class="title-main"><span><?= (!empty($titleCate)) ? $titleCate : @$titleMain ?></span></div>
<div class="content-main">
    <?php if (!empty($tukhoa)) { ?>
        <div class="mb-3">Tìm thấy <b><?= $count['num'] ?> sản phẩm</b> với từ khóa là <b>"<?= $tukhoa ?>"</b></div>
    <?php } ?>
    <?php if (!empty($product)) { ?>
        <?php if (!empty($sort)) { ?>
            <div class="sort-select ">
                <p class="click-sort">Sắp xếp: <span class="sort-show"><?= $check ?></span></p>
                <div class="sort-select-main sort ">
                    <p>
                        <a href="<?= $func->getCurrentPageURL_Sort() ?>?sort=1" data-sort="1" class="<?= ($sort == 1 || $sort == '') ? 'check' : '' ?>"><i></i>Mới nhất</a>
                    </p>
                    <p>
                        <a href="<?= $func->getCurrentPageURL_Sort() ?>?sort=2" data-sort="2" class="<?= ($sort == 2) ? 'check' : '' ?>"><i></i>Giá cao nhất</a>
                    </p>
                    <p>
                        <a href="<?= $func->getCurrentPageURL_Sort() ?>?sort=3" data-sort="3" class="<?= ($sort == 3) ? 'check' : '' ?>"><i></i>Giá thấp nhất</a>
                    </p>
                </div>
            </div>
        <?php } ?>
        <?= $func->GetProducts($product) ?>
    <?php } else { ?>
        <div class="col-12">
            <div class="alert alert-warning" role="alert">
                <strong>Không tìm thấy kết quả</strong>
            </div>
        </div>
    <?php } ?>
    <div class="clear"></div>
    <div class="col-12">
        <div class="pagination-home"><?= (!empty($paging)) ? $paging : '' ?></div>
    </div>
</div>
<input type="hidden" name="link" class="link" value="<?= $func->getCurrentPageURL_Sort() ?>">