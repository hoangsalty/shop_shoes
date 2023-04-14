<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="product__details__pic">
                <div class="product__details__pic__item">
                    <?= $func->getImage(['class' => 'w-100', 'width' => 540, 'height' => 400, 'upload' => UPLOAD_PRODUCT_L, 'image' => $rowDetail['photo'], 'alt' => $rowDetail['name']]) ?>
                </div>
                <div class="product__details__pic__slider owl-carousel">
                    <?php foreach ($rowDetailPhoto as $i => $v) { ?>
                        <?= $func->getImage(['class' => 'w-100', 'width' => 540, 'height' => 400, 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $rowDetail['name']]) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="product__details__text">
                <h3>Vetgetable’s Package</h3>
                <div class="product__details__price">$50.00</div>
                <p>Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Vestibulum ac diam sit amet quam
                    vehicula elementum sed sit amet dui. Sed porttitor lectus nibh. Vestibulum ac diam sit amet
                    quam vehicula elementum sed sit amet dui. Proin eget tortor risus.</p>
                <div class="product__details__quantity">
                    <div class="quantity">
                        <div class="pro-qty">
                            <input type="text" value="1">
                        </div>
                    </div>
                </div>
                <a href="#" class="primary-btn">ADD TO CARD</a>
                <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                <ul>
                    <li><b>Availability</b> <span>In Stock</span></li>
                    <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                    <li><b>Weight</b> <span>0.5 kg</span></li>
                    <li><b>Share on</b>
                        <div class="share">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="product__details__tab">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab">Mô tả sản phẩm</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab">Thông tin sản phẩm</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab">Đánh giá</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <div class="product__details__tab__desc">
                            <h6>Products Infomation</h6>
                            <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus. Vivamus
                                suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam sit amet quam
                                vehicula elementum sed sit amet dui. Donec rutrum congue leo eget malesuada.
                                Vivamus suscipit tortor eget felis porttitor volutpat. Curabitur arcu erat,
                                accumsan id imperdiet et, porttitor at sem. Praesent sapien massa, convallis a
                                pellentesque nec, egestas non nisi. Vestibulum ac diam sit amet quam vehicula
                                elementum sed sit amet dui. Vestibulum ante ipsum primis in faucibus orci luctus
                                et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam
                                vel, ullamcorper sit amet ligula. Proin eget tortor risus.</p>
                            <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed
                                porttitor lectus nibh. Vestibulum ac diam sit amet quam vehicula elementum
                                sed sit amet dui. Proin eget tortor risus.</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                        <div class="product__details__tab__desc">
                            <h6>Products Infomation</h6>
                            <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus. Vivamus
                                suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam sit amet quam
                                vehicula elementum sed sit amet dui. Donec rutrum congue leo eget malesuada.
                                Vivamus suscipit tortor eget felis porttitor volutpat. Curabitur arcu erat,
                                accumsan id imperdiet et, porttitor at sem. Praesent sapien massa, convallis a
                                pellentesque nec, egestas non nisi. Vestibulum ac diam sit amet quam vehicula
                                elementum sed sit amet dui. Vestibulum ante ipsum primis in faucibus orci luctus
                                et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam
                                vel, ullamcorper sit amet ligula. Proin eget tortor risus.</p>
                            <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed
                                porttitor lectus nibh. Vestibulum ac diam sit amet quam vehicula elementum
                                sed sit amet dui. Proin eget tortor risus.</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                        <div class="product__details__tab__desc">
                            <h6>Products Infomation</h6>
                            <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus. Vivamus
                                suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam sit amet quam
                                vehicula elementum sed sit amet dui. Donec rutrum congue leo eget malesuada.
                                Vivamus suscipit tortor eget felis porttitor volutpat. Curabitur arcu erat,
                                accumsan id imperdiet et, porttitor at sem. Praesent sapien massa, convallis a
                                pellentesque nec, egestas non nisi. Vestibulum ac diam sit amet quam vehicula
                                elementum sed sit amet dui. Vestibulum ante ipsum primis in faucibus orci luctus
                                et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam
                                vel, ullamcorper sit amet ligula. Proin eget tortor risus.</p>
                            <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed
                                porttitor lectus nibh. Vestibulum ac diam sit amet quam vehicula elementum
                                sed sit amet dui. Proin eget tortor risus.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>