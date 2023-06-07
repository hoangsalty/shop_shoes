<?php
$linkMan = "index.php?com=comment";
?>

<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Quản lý bình luận - <strong class="text-uppercase"><?= $item['name'] ?></strong></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-danger mr-1" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        <a class="btn btn-sm bg-gradient-primary mr-1" href="<?= $configBase . $item['slug'] ?>" target="_blank" title="<?= $item['name'] ?>"><i class="far fa-eye mr-1"></i>Xem chi tiết</a>
    </div>

    <div class="row">
        <div class="col-xl-3">
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Đánh Giá Trung Bình</h3>
                </div>
                <div class="card-body">
                    <div class="comment-avg-point mb-4">
                        <div class="text-center">
                            <div class="comment-point"><strong><?= $comment->avgPoint() ?>/5</strong></div>
                            <div class="comment-star">
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span style="width: <?= $comment->avgStar() ?>%">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </span>
                            </div>
                            <div class="comment-count"><a>(<?= $comment->total ?> nhận xét)</a></div>
                        </div>
                    </div>
                    <div class="comment-progress-percent">
                        <div class="comment-progress rate-5">
                            <span class="progress-num">5</span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(5) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(5) ?>%</span>
                        </div>
                        <div class="comment-progress rate-4">
                            <span class="progress-num">4</span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(4) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(4) ?>%</span>
                        </div>
                        <div class="comment-progress rate-3">
                            <span class="progress-num">3</span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(3) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(3) ?>%</span>
                        </div>
                        <div class="comment-progress rate-2">
                            <span class="progress-num">2</span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(2) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(2) ?>%</span>
                        </div>
                        <div class="comment-progress rate-1">
                            <span class="progress-num">1</span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(1) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(1) ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Danh sách bình luận</h3>
                </div>
                <div class="card-body comment-manager">
                    <?php if (!empty($comment->lists)) { ?>
                        <div class="comment-lists">
                            <div class="comment-load">
                                <?php foreach ($comment->lists as $v_lists) {
                                    $params = array();
                                    $params['id_variant'] = $item['id'];
                                    $params['lists'] = $v_lists;
                                    $params['lists']['photo'] = $comment->photo($v_lists['id']);
                                    $poster = $comment->poster($v_lists['id_user']);
                                ?>

                                    <div class="comment-item form-row">
                                        <div class="comment-item-poster col-2">
                                            <div class="comment-item-letter">
                                                <?php if (!empty($poster)) { ?>
                                                    <?= $func->getImage(['class' => '', 'width' => 65, 'height' => 65, 'upload' => UPLOAD_USER_L, 'image' => $poster['photo'], 'alt' => $item['name']]) ?>
                                                <?php } else { ?>
                                                    <?= $comment->subName($params['lists']['fullname']) ?>
                                                <?php } ?>
                                            </div>
                                            <div class="comment-item-name"><?= $params['lists']['fullname'] ?></div>
                                            <div class="comment-item-posttime"><?= $comment->timeAgo($params['lists']['date_created']) ?></div>
                                        </div>
                                        <div class="comment-item-information col-10">
                                            <div class="comment-item-rating mb-3">
                                                <div class="comment-item-star comment-star mb-0">
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <span style="width: <?= $comment->scoreStar($params['lists']['star']) ?>%;">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                    </span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div class="comment-item-title"><?= (strpos($params['lists']['status'], 'new-admin') !== false) ? '<strong class="comment-new bg-danger rounded text-white small ml-2 px-2 py-1">Mới</strong>' : '' ?></div>
                                                    
                                                    <div class="comment-action">
                                                        <a class="btn btn-sm <?= (strpos($params['lists']['status'], 'hienthi') !== false) ? 'btn-warning' : 'btn-primary' ?> btn-status-comment mr-1" href="javascript:void(0)" data-id="<?= $params['lists']['id'] ?>" data-new-sibling="comment-item-rating" data-status="hienthi"><?= (strpos($params['lists']['status'], 'hienthi') !== false) ? 'Bỏ duyệt' : 'Duyệt' ?></a>
                                                        <a class="btn btn-sm btn-danger btn-delete-comment" href="javascript:void(0)" data-id="<?= $params['lists']['id'] ?>" data-class="comment-item" data-parents="comment-lists">Xóa</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="comment-item-content mb-2"><?= $func->decodeHtmlChars($params['lists']['content']) ?></div>


                                            <?php if ((!empty($params['lists']['photo']))) { ?>
                                                <div class="flex gap-4">
                                                    <?php if (!empty($params['lists']['photo'])) {
                                                        foreach ($params['lists']['photo'] as $k_photo => $v_photo) { ?>
                                                            <a class="transition" data-fancybox="comment_gallery_<?= $params['lists']['id'] ?>" href="<?= UPLOAD_PHOTO_L . $v_photo['photo'] ?>" data-caption="<?= $item['name'] ?>">
                                                                <?= $func->getImage(['class' => '', 'width' => 70, 'height' => 70, 'upload' => UPLOAD_PHOTO_L, 'image' => $v_photo['photo'], 'alt' => $item['name']]) ?>
                                                            </a>
                                                    <?php }
                                                    } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>