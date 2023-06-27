<div class="modal fade" id="popup-cart" tabindex="-1" role="dialog" aria-labelledby="popup-cart-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="popup-cart-label">Giỏ hàng của bạn</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="popup-login" tabindex="-1" role="dialog" aria-labelledby="popup-login-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="contain">
                    <div class="login">
                        <form class="validation-form" id="form-user-login" novalidate method="post" action="" enctype="multipart/form-data">
                            <h2>Đăng nhập</h2>

                            <div class="login_response"></div>

                            <div class="input-group input-user">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-user"></i></div>
                                </div>
                                <input type="text" class="form-control text-sm" id="username" name="username" placeholder="Tài khoản" required>
                            </div>

                            <div class="input-group input-user">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                </div>
                                <input type="password" class="form-control text-sm" id="password" name="password" placeholder="Mật khẩu" required>
                            </div>

                            <div class="mor">
                                <a class="btn_forgot">Quên mật khẩu?</a>
                            </div>

                            <div class="button-user">
                                <input type="submit" class="log" name="login-account" value="Đăng nhập">
                            </div>
                        </form>
                    </div>

                    <div class="login_image">
                        <h2>Chưa có tài khoản? Hãy đăng ký để mở khóa các tính năng tuyệt vời!</h2>
                        <button class="btn_signup">Đăng ký</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="popup-register" tabindex="-1" role="dialog" aria-labelledby="popup-register-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="contain">
                    <form class="validation-form" id="form-user-register" novalidate method="post" action="" enctype="multipart/form-data">
                        <h2>Đăng ký</h2>

                        <div class="register_response"></div>

                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa-regular fa-signature"></i></div>
                            </div>
                            <input type="text" class="form-control text-sm" id="fullname" name="fullname" placeholder="Họ và tên" required>
                        </div>

                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control text-sm" id="username" name="username" placeholder="Tài khoản" required>
                        </div>

                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-lock"></i></div>
                            </div>
                            <input type="password" class="form-control text-sm" id="password" name="password" placeholder="Mật khẩu" required>
                        </div>

                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa-regular fa-calendar-days"></i></div>
                            </div>
                            <input type="text" class="form-control text-sm birth-date" id="birthday" name="birthday" placeholder="Chọn ngày sinh" required autocomplete="off">
                        </div>

                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                            </div>
                            <input type="email" class="form-control text-sm" id="email" name="email" placeholder="Email" required>
                        </div>

                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-phone-square"></i></div>
                            </div>
                            <input type="number" class="form-control text-sm" id="phone" name="phone" placeholder="Số điện thoại" required>
                        </div>

                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-map"></i></div>
                            </div>
                            <input type="text" class="form-control text-sm" id="address" name="address" placeholder="Địa chỉ" required>
                        </div>

                        <div class="button-user">
                            <input type="submit" class="log" name="register-account" value="Đăng ký">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="popup-forgot" tabindex="-1" role="dialog" aria-labelledby="popup-forgot-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="contain">
                    <form class="validation-form" id="form-user-forgot" novalidate method="post" action="" enctype="multipart/form-data">
                        <h2>Quên mật khẩu</h2>

                        <div class="register_response"></div>

                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                            </div>
                            <input type="email" class="form-control text-sm" id="email" name="email" placeholder="Email" required>
                        </div>

                        <div class="button-user">
                            <input type="submit" class="log" name="forgotpassword-account" value="Lấy lại mật khẩu">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>