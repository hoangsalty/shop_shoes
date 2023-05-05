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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-title text-center">
                    <h4>Login</h4>
                </div>
                <div class="d-flex flex-column text-center">
                    <form class="validation-user" id="form-user" novalidate method="post" action="" enctype="multipart/form-data">
                        <div class="login_response"></div>

                        <div class="input-group input-user mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control text-sm" id="username" name="username" placeholder="Tài khoản" required>
                            <div class="invalid-feedback">Vui lòng nhập tên tài khoản</div>
                        </div>

                        <div class="input-group input-user mb-4">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-lock"></i></div>
                            </div>
                            <input type="password" class="form-control text-sm" id="password" name="password" placeholder="Mật khẩu" required>
                            <div class="invalid-feedback">Vui lòng nhập mật khẩu</div>
                        </div>

                        <div class="button-user">
                            <input type="submit" class="btn btn-info btn-block btn-round" name="login-account" value="Đăng nhập">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <div class="signup-section">Bạn chưa có tài khoản? <a href="account/dang-ky" class="text-info"> Đăng ký ngay !</a>.</div>
            </div>
        </div>
    </div>