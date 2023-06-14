<div class="title-main"><span><?= (!empty($titleCate)) ? $titleCate : @$titleMain ?></span></div>
<div class="content-main">
    <div class="row">
        <?php if (!empty($product)) { ?>
            <?= $func->GetProducts($product) ?>
        <?php } else { ?>
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    <strong>Không tìm thấy kết quả</strong>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="clear"></div>
    <div class="col-12">
        <div class="pagination-home"><?= (!empty($paging)) ? $paging : '' ?></div>
    </div>
</div>