<div class="footer">
    <div class="footer-article">
        <div class="wrap-content">

        </div>
    </div>
    <div class="footer-powered">
        <div class="wrap-content">
            <div class="footer__copyright">
                <div class="row">
                    <div class="copyright col-md-6">Copyright © 2023 CKC. Design by CKC</div>
                </div>
            </div>
        </div>
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
        <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'zl.png', 'alt' => 'Zalo']) ?></i>
    </a>
    <a class="btn-phone btn-frame" href="tel:<?= preg_replace('/[^0-9]/', '', $optsetting['hotline']); ?>">
        <div class="animated infinite zoomIn kenit-alo-circle"></div>
        <div class="animated infinite pulse kenit-alo-circle-fill"></div>
        <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'hl.png', 'alt' => 'Hotline']) ?></i>
    </a>
</div>