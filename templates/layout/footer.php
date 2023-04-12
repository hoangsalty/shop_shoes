<div class="footer">
    <div class="footer-article">
        <div class="wrap-content">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="./index.html"><img src="assets/images/logo.png" alt=""></a>
                        </div>
                        <ul>
                            <li>Địa chỉ: <?= $optsetting['address'] ?></li>
                            <li>Hotline: <?= $optsetting['hotline'] ?></li>
                            <li>Email: <?= $optsetting['email'] ?></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                    <div class="footer__widget">
                        <h6>Useful Links</h6>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">About Our Shop</a></li>
                            <li><a href="#">Secure Shopping</a></li>
                            <li><a href="#">Delivery infomation</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Our Sitemap</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Who We Are</a></li>
                            <li><a href="#">Our Services</a></li>
                            <li><a href="#">Projects</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Innovation</a></li>
                            <li><a href="#">Testimonials</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="footer__newsletter">
                        <h2 class="footer-title">Đăng ký nhận tin</h2>
                        <p class="newsletter-slogan">Get E-mail updates about our latest shop and special offers.</p>
                        <form class="validation-newsletter" novalidate method="post" action="" enctype="multipart/form-data">
                            <div class="newsletter-input">
                                <input type="email" class="form-control text-sm" id="email-newsletter" name="dataNewsletter[email]" placeholder="Nhập email" required />
                            </div>
                            <div class="newsletter-button">
                                <input type="submit" class="btn btn-sm btn-danger w-100" value="Gửi" disabled>
                                <input type="hidden" name="submit-newsletter" value="1">
                                <input type="hidden" name="recaptcha_response_newsletter" id="recaptchaResponseNewsletter">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-powered">
        <div class="wrap-content">
            <div class="footer__copyright">
                <div class="row">
                    <div class="copyright col-md-6">Copyright © 2023 CKC. Design by CKC</div>
                    <div class="payment col-md-6"><img src="assets/images/payment-item.png" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</div>

<a class="btn-zalo btn-frame text-decoration-none" target="_blank" href="https://zalo.me/<?= preg_replace('/[^0-9]/', '', $optsetting['zalo']); ?>">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'zl.png', 'alt' => 'Zalo']) ?></i>
</a>
<a class="btn-phone btn-frame text-decoration-none" href="tel:<?= preg_replace('/[^0-9]/', '', $optsetting['hotline']); ?>">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'hl.png', 'alt' => 'Hotline']) ?></i>
</a>