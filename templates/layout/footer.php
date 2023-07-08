<div class="footer">
    <div class="footer-article">
        <div class="wrap-content">
            <div class="row">
                <div class="footer-news col-lg-5 col-md-5 col-12">
                    <h2 class="footer-title"><?= $footer['name'] ?></h2>
                    <div class="footer-info"><?= htmlspecialchars_decode($footer['content']) ?></div>
                </div>
                <div class="footer-news col-lg-3 col-md-3 col-12">
                    <h2 class="footer-title">Chính sách</h2>
                    <ul class="footer-ul">
                        <li>
                            <a href="">
                                Chính sách 1
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Chính sách 2
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Chính sách 3
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Chính sách 4
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="footer-news col-lg-4 col-md-4 col-12">
                    <h2 class="footer-title">Fanpage facebook</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-powered">
        <div class="wrap-content">
            <div class="copyright text-center">Copyright © 2023 CKC. Design by CKC</div>
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
        <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'zl.png']) ?></i>
    </a>
    <a class="btn-phone btn-frame" href="tel:<?= preg_replace('/[^0-9]/', '', $optsetting['hotline']); ?>">
        <div class="animated infinite zoomIn kenit-alo-circle"></div>
        <div class="animated infinite pulse kenit-alo-circle-fill"></div>
        <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'hl.png']) ?></i>
    </a>
</div>