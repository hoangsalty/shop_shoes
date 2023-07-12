<div class="footer">
    <div class="footer-article">
        <div class="wrap-content">
            <div class="row">
                <div class="footer-news col-lg-5 col-md-12 col-12">
                    <h2 class="footer-title"><?= $footer['name'] ?></h2>
                    <div class="footer-info"><?= htmlspecialchars_decode($footer['content']) ?></div>
                </div>
                <div class="footer-news col-lg-3 col-md-6 col-12">
                    <h2 class="footer-title">Chính sách</h2>
                    <ul class="footer-ul">
                        <?php foreach ($policy as $v) { ?>
                            <li>
                                <a href="<?= $v['slug'] ?>" title="<?= $v['name'] ?>"><?= $v['name'] ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="footer-news col-lg-4 col-md-5 col-12">
                    <h2 class="footer-title">Fanpage facebook</h2>
                    <div class="fb-page" data-href="<?= $optsetting['fanpage'] ?>" data-tabs="timeline" data-width="500" data-height="300" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                        <div class="fb-xfbml-parse-ignore">
                            <blockquote cite="<?= $optsetting['fanpage'] ?>">
                                <a href="<?= $optsetting['fanpage'] ?>">Facebook</a>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-powered">
        <div class="wrap-content">
            <div class="copyright text-center">Copyright © 2023 CKC. Design by CKC</div>
        </div>
    </div>
    <div class="footer-map">
        <?= $func->decodeHtmlChars($optsetting['googlemap']) ?>
    </div>
</div>

<?php if ($com != 'gio-hang') { ?>
    <a class="popup_cart cart-fixed" title="Giỏ hàng">
        <i class="fas fa-shopping-bag"></i>
        <span class="count-cart"><?= (!empty($_SESSION['cart'])) ? count($_SESSION['cart']) : 0 ?></span>
    </a>
<?php } ?>

<div class="wrap_network">
    <a class="btn-zalo btn-frame" target="_blank" href="https://zalo.me/<?= preg_replace('/[^0-9]/', '', $optsetting['zalo']); ?>">
        <div class="animated infinite zoomIn kenit-alo-circle"></div>
        <div class="animated infinite pulse kenit-alo-circle-fill"></div>
        <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'zl.png']) ?></i>
    </a>
    <a class="btn-phone btn-frame" href="tel:<?= preg_replace('/[^0-9]/', '', $optsetting['hotline']); ?>">
        <div class="animated infinite zoomIn kenit-alo-circle"></div>
        <div class="animated infinite pulse kenit-alo-circle-fill"></div>
        <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'hl.png']) ?></i>
    </a>
</div>

<div id="fb-root"></div>

<div class="progress-wrap cursor-pointer">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>