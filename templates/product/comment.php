<div class="comment-page">
    <div class="comment-statistic mb-4">
        <div class="card">
            <div class="card-header text-uppercase"><strong>Đánh giá sản phẩm</strong></div>
            <div class="card-body commentColor">
                <div class="row align-items-center">
                    <div class="col-sm-6 col-lg-4">
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
                    <div class="col-sm-6 col-lg-4">
                        <div class="comment-progress rate-5">
                            <span class="progress-num">5 <i class="fas fa-star"></i></span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(5) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(5) ?>%</span>
                        </div>
                        <div class="comment-progress rate-4">
                            <span class="progress-num">4 <i class="fas fa-star"></i></span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(4) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(4) ?>%</span>
                        </div>
                        <div class="comment-progress rate-3">
                            <span class="progress-num">3 <i class="fas fa-star"></i></span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(3) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(3) ?>%</span>
                        </div>
                        <div class="comment-progress rate-2">
                            <span class="progress-num">2 <i class="fas fa-star"></i></span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(2) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(2) ?>%</span>
                        </div>
                        <div class="comment-progress rate-1">
                            <span class="progress-num">1 <i class="fas fa-star"></i></span>
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
    </div>

    <?php if (!empty($comment->lists)) { ?>
        <div class="comment-lists mb-4">
            <div class="card">
                <div class="card-header text-uppercase"><strong>Các bình luận khác</strong></div>
                <div class="card-body">
                    <div class="comment-load">
                        <?php foreach ($comment->lists as $v_lists) {
                            $params = array();
                            $params['id_variant'] = $rowDetail['id'];
                            $params['lists'] = $v_lists;
                            $params['lists']['photo'] = $comment->photo($v_lists['id']);
                            $poster = $comment->poster($v_lists['id_user']);
                        ?>

                            <div class="comment-item form-row">
                                <div class="comment-item-poster col-2">
                                    <div class="comment-item-letter">
                                        <?php if (!empty($poster)) { ?>
                                            <?= $func->getImage(['class' => '', 'width' => 65, 'height' => 65, 'upload' => UPLOAD_USER_L, 'image' => $poster['photo']]) ?>
                                        <?php } else { ?>
                                            <?= $comment->subName($params['lists']['fullname']) ?>
                                        <?php } ?>
                                    </div>
                                    <div class="comment-item-name"><?= $params['lists']['fullname'] ?></div>
                                    <div class="comment-item-posttime"><?= $comment->timeAgo($params['lists']['date_created']) ?></div>
                                </div>
                                <div class="comment-item-information col-10">
                                    <div class="comment-item-rating mb-2 w-clear">
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
                                    </div>

                                    <div class="comment-item-content mb-2"><?= $func->decodeHtmlChars($params['lists']['content']) ?></div>

                                    <?php if ((!empty($params['lists']['photo']))) { ?>
                                        <div class="flex gap-4">
                                            <?php if (!empty($params['lists']['photo'])) {
                                                foreach ($params['lists']['photo'] as $k_photo => $v_photo) { ?>
                                                    <a class="transition" data-fancybox="comment_gallery_<?= $params['lists']['id'] ?>" href="<?= UPLOAD_PHOTO_L . $v_photo['photo'] ?>" data-caption="<?= $rowDetail['name'] ?>">
                                                        <?= $func->getImage(['class' => '', 'width' => 70, 'height' => 70, 'upload' => UPLOAD_PHOTO_L, 'image' => $v_photo['photo']]) ?>
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
            </div>
        </div>
    <?php } ?>

    <?php if ((!empty($_SESSION['account']) && $_SESSION['account']['status'] != 'khoa')) { ?>
        <div class="comment-write" id="comment-write">
            <div class="card">
                <div class="card-header text-uppercase"><strong>Gửi nhận xét của bạn</strong></div>
                <div class="card-body">
                    <form id="form-comment" action="" method="post" enctype="multipart/form-data">
                        <div class="response-review"></div>

                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label>1. Đánh giá của bạn về sản phẩm này:</label>
                                    <div class="review-rating-star">
                                        <div class="review-rating-star-icon">
                                            <i class="fa fa-star star-empty" data-value="1"></i>
                                            <i class="fa fa-star star-empty" data-value="2"></i>
                                            <i class="fa fa-star star-empty" data-value="3"></i>
                                            <i class="fa fa-star star-empty" data-value="4"></i>
                                            <i class="fa fa-star star-empty" data-value="5"></i>
                                        </div>
                                        <input type="number" class="review-rating-star-input hidden" name="dataReview[star]" id="review-star" data-min="1" data-max="5">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="review-content">2. Viết nhận xét của bạn vào bên dưới:</label>
                                    <textarea class="form-control text-sm" name="dataReview[content]" id="review-content" placeholder="Nhận xét của bạn về sản phẩm này" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group review-preview">
                                    <div class="row">
                                        <div class="col-4">
                                            <?= $func->getImage(['class' => '', 'width' => 150, 'height' => 150, 'upload' => UPLOAD_PRODUCT_L, 'image' => $rowDetail['photo']]) ?>
                                        </div>
                                        <div class="col-8">
                                            <h6 class="text-uppercase"><?= $rowDetail['name'] ?></h6>
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
                                            <div class="comment-count mb-2"><strong>(<?= $comment->total ?> nhận xét)</strong></div>
                                            <div class="text-split mb-0"><?= $func->decodeHtmlChars($rowDetail['desc']) ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><strong>Hình ảnh: (Tối đa 3 hình)</strong></label>
                                    <div class="review-file-uploader">
                                        <input type="file" id="review-file-photo" name="review-file-photo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-warning text-capitalize py-2 px-3"><strong>Gửi nhận xét</strong></button>
                        <input type="hidden" name="dataReview[id_parent]" value="<?= $rowDetail['id'] ?>">
                        <input type="hidden" name="dataReview[id_user]" value="<?= $_SESSION['account']['id'] ?>">
                        <input type="hidden" name="dataReview[fullname]" value="<?= $_SESSION['account']['fullname'] ?>">
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</div>